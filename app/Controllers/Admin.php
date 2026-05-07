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

        return view('admin/inventory', $data);
    }
}
