<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        
        // 1. Total Dozens in Stock
        $totalEggs = $db->table('stock_batches')->selectSum('quantity_remaining')->get()->getRow()->quantity_remaining ?? 0;
        $data['totalDozens'] = floor($totalEggs / 12);
        
        // 2. Orders Pending Today
        $data['pendingOrders'] = $db->table('orders')
                                    ->where('status', 'Pending')
                                    ->where('created_at >=', date('Y-m-d 00:00:00'))
                                    ->countAllResults();
        
        // 3. Revenue (Current Month)
        $data['monthlyRevenue'] = $db->table('orders')
                                     ->selectSum('total_amount')
                                     ->where('status', 'Completed')
                                     ->where('created_at >=', date('Y-m-01 00:00:00'))
                                     ->get()->getRow()->total_amount ?? 0;

        // 4. Expiry Notifications (batches expiring in 48 hours)
        $data['expiryAlerts'] = $db->table('stock_batches')
                                   ->where('expiry_date <=', date('Y-m-d', strtotime('+2 days')))
                                   ->where('quantity_remaining >', 0)
                                   ->countAllResults();

        // 5. Low Stock Alerts (Sum of stock vs threshold)
        $data['lowStockItems'] = $db->table('egg_types')
                                    ->select('egg_types.name, egg_types.low_stock_threshold, SUM(stock_batches.quantity_remaining) as current_stock')
                                    ->join('stock_batches', 'stock_batches.egg_type_id = egg_types.id', 'left')
                                    ->groupBy('egg_types.id')
                                    ->having('current_stock < egg_types.low_stock_threshold OR current_stock IS NULL')
                                    ->get()->getResultArray();

        // 6. Recent Activity (Latest 5 orders)
        $data['recentOrders'] = $db->table('orders')
                                   ->select('orders.*, users.username')
                                   ->join('users', 'users.id = orders.user_id')
                                   ->orderBy('orders.created_at', 'DESC')
                                   ->limit(5)
                                   ->get()->getResultArray();

        return view('home', $data);
    }
}
