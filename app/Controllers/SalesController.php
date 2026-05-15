<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\EggTypeModel;

class SalesController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // 1. Sales Summary (Completed Orders)
        $data['totalSales'] = $db->table('orders')
                                 ->where('status', 'Completed')
                                 ->selectSum('total_amount')
                                 ->get()->getRow()->total_amount ?? 0;
                                 
        $data['totalOrders'] = $db->table('orders')
                                  ->where('status', 'Completed')
                                  ->countAllResults();

        // 2. Sales by Egg Type
        $data['salesByType'] = $db->table('order_items')
                                  ->select('egg_types.name, SUM(order_items.quantity) as total_qty, SUM(order_items.quantity * order_items.price_at_order) as total_revenue')
                                  ->join('egg_types', 'egg_types.id = order_items.egg_type_id')
                                  ->join('orders', 'orders.id = order_items.order_id')
                                  ->where('orders.status', 'Completed')
                                  ->groupBy('egg_types.id')
                                  ->orderBy('total_revenue', 'DESC')
                                  ->get()->getResultArray();

        // 3. Inventory Loss Summary
        $data['totalLosses'] = $db->table('inventory_losses')
                                  ->selectSum('quantity_lost')
                                  ->get()->getRow()->quantity_lost ?? 0;
                                  
        $data['lossesByReason'] = $db->table('inventory_losses')
                                     ->select('reason, SUM(quantity_lost) as total_qty')
                                     ->groupBy('reason')
                                     ->get()->getResultArray();

        // 4. Daily Sales Trend (Last 7 days)
        $data['dailySales'] = $db->table('orders')
                                 ->select('DATE(created_at) as date, SUM(total_amount) as amount')
                                 ->where('status', 'Completed')
                                 ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
                                 ->groupBy('DATE(created_at)')
                                 ->orderBy('date', 'ASC')
                                 ->get()->getResultArray();

        return view('admin/sales_inventory', $data);
    }
}
