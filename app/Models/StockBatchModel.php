<?php

namespace App\Models;

use CodeIgniter\Model;

class StockBatchModel extends Model
{
    protected $table            = 'stock_batches';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'batch_id', 'egg_type_id', 'quantity_added', 
        'quantity_remaining', 'laid_date', 'expiry_date', 'supplier_name'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get batches that are nearing expiry (within 3 days)
     */
    public function getNearExpiry()
    {
        return $this->where('expiry_date <=', date('Y-m-d', strtotime('+3 days')))
                    ->where('quantity_remaining >', 0)
                    ->findAll();
    }
}
