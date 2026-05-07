<?php

namespace App\Controllers;

use App\Models\EggTypeModel;
use App\Models\StockBatchModel;

class Admin extends BaseController
{
    public function stockIntake()
    {
        $eggTypeModel = new EggTypeModel();
        $data['eggTypes'] = $eggTypeModel->findAll();

        return view('admin/stock_intake', $data);
    }

    public function addStock()
    {
        $rules = [
            'batch_id' => 'required|is_unique[stock_batches.batch_id]',
            'egg_type_id' => 'required',
            'quantity' => 'required|numeric',
            'laid_date' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $stockBatchModel = new StockBatchModel();
        
        $laidDate = $this->request->getPost('laid_date');
        // Simple expiry logic: 30 days from laid date
        $expiryDate = date('Y-m-d', strtotime($laidDate . ' + 30 days'));

        $stockBatchModel->save([
            'batch_id' => $this->request->getPost('batch_id'),
            'egg_type_id' => $this->request->getPost('egg_type_id'),
            'quantity_added' => $this->request->getPost('quantity'),
            'quantity_remaining' => $this->request->getPost('quantity'),
            'laid_date' => $laidDate,
            'expiry_date' => $expiryDate,
            'supplier_name' => $this->request->getPost('supplier_name'),
        ]);

        return redirect()->to('/admin/inventory')->with('message', 'Stock batch added successfully!');
    }

    public function inventory()
    {
        $stockBatchModel = new StockBatchModel();
        $eggTypeModel = new EggTypeModel();

        $data['batches'] = $stockBatchModel->select('stock_batches.*, egg_types.name as egg_name')
                                           ->join('egg_types', 'egg_types.id = stock_batches.egg_type_id')
                                           ->orderBy('expiry_date', 'ASC')
                                           ->findAll();
        
        $data['nearExpiry'] = $stockBatchModel->getNearExpiry();
        $data['eggTypes'] = $eggTypeModel->findAll();

        return view('admin/inventory', $data);
    }

    public function logWaste()
    {
        $stockBatchId = $this->request->getPost('stock_batch_id');
        $quantityLost = $this->request->getPost('quantity_lost');
        $reason = $this->request->getPost('reason');

        $stockBatchModel = new StockBatchModel();
        $batch = $stockBatchModel->find($stockBatchId);

        if (!$batch || $batch['quantity_remaining'] < $quantityLost) {
            return redirect()->back()->with('error', 'Invalid batch or quantity.');
        }

        // Update batch remaining quantity
        $stockBatchModel->update($stockBatchId, [
            'quantity_remaining' => $batch['quantity_remaining'] - $quantityLost
        ]);

        // Log to losses table
        $db = \Config\Database::connect();
        $db->table('inventory_losses')->insert([
            'stock_batch_id' => $stockBatchId,
            'quantity_lost' => $quantityLost,
            'reason' => $reason,
            'notes' => $this->request->getPost('notes'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('message', 'Waste logged successfully.');
    }

    public function orders()
    {
        $orderModel = new \App\Models\OrderModel();
        
        $status = $this->request->getGet('status');
        $payment_status = $this->request->getGet('payment_status');
        $date = $this->request->getGet('date');

        $query = $orderModel->select('orders.*, users.username')
                            ->join('users', 'users.id = orders.user_id');

        if ($status) {
            $query->where('orders.status', $status);
        }
        if ($payment_status) {
            $query->where('orders.payment_status', $payment_status);
        }
        if ($date) {
            $query->where('DATE(orders.created_at)', $date);
        }

        $data['orders'] = $query->orderBy('orders.created_at', 'DESC')->findAll();
        
        // Pass current filters back to view
        $data['filters'] = [
            'status' => $status,
            'payment_status' => $payment_status,
            'date' => $date
        ];

        return view('admin/orders', $data);
    }

    public function updateOrderStatus()
    {
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');

        $orderModel = new \App\Models\OrderModel();
        $db = \Config\Database::connect();
        
        $updateData = ['status' => $status];

        // 1. Logic for Picking (Suggest FIFO Batch)
        if ($status == 'Picking') {
            $items = $db->table('order_items')->where('order_id', $orderId)->get()->getResultArray();
            foreach ($items as $item) {
                // Find oldest batch with stock for this egg type
                $batch = $db->table('stock_batches')
                            ->where('egg_type_id', $item['egg_type_id'])
                            ->where('quantity_remaining >', 0)
                            ->orderBy('laid_date', 'ASC')
                            ->get()->getRowArray();
                
                if ($batch) {
                    $db->table('order_items')->where('id', $item['id'])->update(['suggested_batch_id' => $batch['id']]);
                }
            }
        }

        // 2. Logic for Packing (Quality Check)
        if ($status == 'Packing') {
            $updateData['quality_checked'] = 1;
        }

        // 3. Logic for Delivery Assignment
        if ($status == 'Out for Delivery') {
            $updateData['rider_name'] = $this->request->getPost('rider_name') ?: 'Standard Rider';
            $updateData['tracking_link'] = 'http://track-egg.com/' . uniqid();
            // Simulation: Send Email/SMS
            // mail($customer_email, "Order Out for Delivery", "Track here: " . $updateData['tracking_link']);
        }

        // 4. Logic for Completion (Deduct Stock)
        if ($status == 'Completed') {
            $items = $db->table('order_items')->where('order_id', $orderId)->get()->getResultArray();
            foreach ($items as $item) {
                if ($item['suggested_batch_id']) {
                    $db->table('stock_batches')
                       ->where('id', $item['suggested_batch_id'])
                       ->decrement('quantity_remaining', $item['quantity']);
                }
            }
            $updateData['payment_status'] = 'Paid';
        }

        $orderModel->update($orderId, $updateData);

        return redirect()->back()->with('message', 'Order stage updated to ' . $status);
    }
}
