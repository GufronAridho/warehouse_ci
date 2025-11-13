<?php

namespace App\Models;

use CodeIgniter\Model;

class GrTempModel extends Model
{
    protected $table = 'tbl_gr_temp';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'material_number',
        'qty_received',
        'qty_order',
        'uom',
    ];
    protected $skipValidation = false;
    protected $validationRules = [
        'material_number' => 'required|safe_string',
        'qty_received' => 'required|decimal|greater_than[0]',
        'qty_order' => 'permit_empty|decimal',
        'uom' => 'required|safe_string',
        'username' => 'required'
    ];
    protected $validationMessages = [
        'material_number' => [
            'required' => 'Material number is required',
            'safe_string' => 'Material number contains invalid characters'
        ],
        'qty_received' => [
            'required' => 'Received quantity is required',
            'decimal' => 'Received quantity must be a number',
            'greater_than' => 'Received quantity must be greater than zero.'
        ],
        'qty_order' => [
            'decimal' => 'Order quantity must be a number'
        ],
        'uom' => [
            'required' => 'UOM is required',
            'safe_string' => 'UOM contains invalid characters'
        ],
        'username' => [
            'required' => 'Username is required',
        ]
    ];

    public function save_detail($delivery_number, $username, $staging_location)
    {
        $item = $this->where('username', $username)->findAll();
        $data = [];
        foreach ($item as $i) {
            $data[] = [
                'delivery_number' => $delivery_number,
                'material_number' => $i['material_number'],
                'qty_order' => $i['qty_order'],
                'qty_received' => $i['qty_received'],
                // 'qty_remaining' => max($i['qty_order'] - $i['qty_received'], 0),
                'qty_remaining' => $i['qty_received'],
                'uom' => $i['uom'],
                'status' => 'OPEN',
                'staging_location' => $staging_location,
            ];
        }
        $GrDetailModel = new \App\Models\GrDetailModel();
        $GrDetailModel->insertBatch($data);
        $this->where('username', $username)->delete();
        return true;
    }
}
