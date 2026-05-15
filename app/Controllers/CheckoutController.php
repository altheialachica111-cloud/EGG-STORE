<?php

namespace App\Controllers;

use App\Models\EggTypeModel;
use App\Models\OrderModel;
use CodeIgniter\Controller;

class CheckoutController extends BaseController
{
    public function index()
    {
        $eggTypeModel = new EggTypeModel();
        $data['eggTypes'] = $eggTypeModel->findAll();
        
        // Simulating stock availability check for each egg type
        $db = \Config\Database::connect();
        foreach ($data['eggTypes'] as &$type) {
            $stock = $db->table('stock_batches')
                        ->selectSum('quantity_remaining')
                        ->where('egg_type_id', $type['id'])
                        ->get()->getRow()->quantity_remaining ?? 0;
            $type['stock'] = $stock;
            // Set a default price for simulation
            $type['price'] = 10.00; // $10 per dozen
        }

        return view('store/index', $data);
    }

    public function addToCart()
    {
        $id = $this->request->getPost('egg_type_id');
        $qty = $this->request->getPost('quantity');
        
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        if (isset($cart[$id])) {
            $cart[$id] += $qty;
        } else {
            $cart[$id] = $qty;
        }
        
        $session->set('cart', $cart);
        return redirect()->back()->with('message', 'Added to cart!');
    }

    public function cart()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $eggTypeModel = new EggTypeModel();
        
        $data['items'] = [];
        $data['total'] = 0;
        
        foreach ($cart as $id => $qty) {
            $type = $eggTypeModel->find($id);
            if ($type) {
                $price = 10.00; // Fixed price for now
                $subtotal = $price * $qty;
                $data['items'][] = [
                    'id' => $id,
                    'name' => $type['name'],
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
                $data['total'] += $subtotal;
            }
        }
        
        return view('store/cart', $data);
    }

    public function checkout()
    {
        $session = session();
        $cart = $session->get('cart');
        
        if (empty($cart)) {
            return redirect()->to('/store')->with('error', 'Your cart is empty.');
        }
        
        $eggTypeModel = new EggTypeModel();
        $total = 0;
        foreach ($cart as $id => $qty) {
            $total += 10.00 * $qty;
        }
        
        $data['total'] = $total;
        return view('store/checkout', $data);
    }

    public function process()
    {
        $session = session();
        $cart = $session->get('cart');
        $userId = auth()->id();
        
        if (empty($cart)) {
            return redirect()->to('/store')->with('error', 'Cart expired.');
        }
        
        $db = \Config\Database::connect();
        $db->transStart();
        
        $total = 0;
        foreach ($cart as $id => $qty) {
            $total += 10.00 * $qty;
        }
        
        // 1. Create Order
        $orderModel = new OrderModel();
        $cashAmount = $this->request->getPost('cash_amount');
        $orderId = $orderModel->insert([
            'user_id' => $userId,
            'total_amount' => $total,
            'status' => 'Pending',
            'payment_method' => $this->request->getPost('payment_method'),
            'payment_status' => 'Paid' // Marking as paid since we take cash now
        ]);

        // Store receipt data in session
        $session->setFlashdata('receipt', [
            'order_id' => $orderId,
            'total' => $total,
            'cash' => $cashAmount,
            'change' => $cashAmount - $total,
            'items' => $cart
        ]);
        
        // 2. Create Order Items and Deduct Stock (FIFO)
        foreach ($cart as $id => $qty) {
            $remainingToDeduct = $qty;

            // Find batches for this egg type, ordered by laid_date (FIFO)
            $batches = $db->table('stock_batches')
                          ->where('egg_type_id', $id)
                          ->where('quantity_remaining >', 0)
                          ->orderBy('laid_date', 'ASC')
                          ->get()->getResultArray();

            foreach ($batches as $batch) {
                if ($remainingToDeduct <= 0) break;

                $deduction = min($remainingToDeduct, $batch['quantity_remaining']);
                
                // Deduct from batch
                $db->table('stock_batches')
                   ->where('id', $batch['id'])
                   ->decrement('quantity_remaining', $deduction);

                // Create Order Item record
                $db->table('order_items')->insert([
                    'order_id' => $orderId,
                    'egg_type_id' => $id,
                    'quantity' => $deduction,
                    'price_at_order' => 10.00,
                    'suggested_batch_id' => $batch['id']
                ]);

                $remainingToDeduct -= $deduction;
            }

            // Optional: Handle case where not enough stock was found
            if ($remainingToDeduct > 0) {
                // In a real scenario, you'd throw an exception or rollback
                // For now, we assume stock was validated before checkout
            }
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Order processing failed.');
        }
        
        $session->remove('cart');
        return redirect()->to('/store/success')->with('message', 'Order placed successfully!');
    }

    public function success()
    {
        return view('store/success');
    }

    public function clearCart()
    {
        session()->remove('cart');
        return redirect()->to('/store');
    }
}
