<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table = 'tbl_stock';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'material_number',
        'location_id',
        'rack',
        'bin',
        'batch',
        'qty',
        'last_updated'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'last_updated';
    protected $updatedField  = 'last_updated';
    protected $skipValidation = false;
    protected $validationRules = [
        'material_number' => 'required|safe_string',
        'location_id' => 'required|safe_string',
        'rack' => 'permit_empty|safe_string',
        'bin' => 'permit_empty|safe_string',
        'batch' => 'permit_empty|safe_string',
        'qty' => 'required|decimal'
    ];
    protected $validationMessages = [
        'material_number' => [
            'required' => 'Material number is required',
            'safe_string' => 'Material number contains invalid characters'
        ],
        'location_id' => [
            'required' => 'Location ID is required',
            'safe_string' => 'Location ID contains invalid characters'
        ],
        'rack' => [
            'safe_string' => 'Rack contains invalid characters'
        ],
        'bin' => [
            'safe_string' => 'Bin contains invalid characters'
        ],
        'qty' => [
            'required' => 'Quantity is required',
            'decimal' => 'Quantity must be a valid number'
        ]
    ];

    public function update_stock(
        $material_number,
        $qty,
        $location_id,
        $rack,
        $bin
    ) {
        $exist = $this->where([
            'material_number' => $material_number,
            'location_id' => $location_id,
            'rack' => $rack,
            'bin' => $bin
        ])->first();
        if ($exist) {
            $add_qty = (float)$exist['qty'] + (float)$qty;
            $this->update($exist['id'], [
                'qty' => $add_qty,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->insert([
                'material_number' => $material_number,
                'location_id' => $location_id,
                'rack' => $rack,
                'bin' => $bin,
                'qty' => $qty,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function deduct_stock(
        $material_number,
        $qty,
        $location_id,
        $rack,
        $bin
    ) {
        $exist = $this->where([
            'material_number' => $material_number,
            'location_id' => $location_id,
            'rack' => $rack,
            'bin' => $bin
        ])->first();

        if (!$exist) {
            return false;
        }

        $new_qty = (float)$exist['qty'] - (float)$qty;
        if ($new_qty < 0) {
            $new_qty = 0;
        }

        $this->update($exist['id'], [
            'qty' => $new_qty,
            'last_updated' => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}
