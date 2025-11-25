<?php

namespace App\Models;

use CodeIgniter\Model;

class TempGrDetailModel extends Model
{
    protected $table = 'tbl_temp_gr_detail';
    protected $primaryKey = 'temp_detail_id';

    protected $allowedFields = [
        'temp_id',
        'delivery_number',
        'material_number',
        'qty_order',
        'qty_received',
        // 'qty_remaining',
        'uom',
        'shipment_id',
        'customer_po',
        'customer_po_line',
        // 'status',
        'scanned_by',
        'scanned_at',
        'validated_at'
    ];

    // protected $validationRules = [
    //     'temp_id'         => 'required|integer',
    //     'delivery_number' => 'required|safe_string',
    //     'material_number' => 'required|safe_string',
    //     'qty_order'       => 'permit_empty|decimal',
    //     'qty_received'    => 'permit_empty|decimal',
    //     'qty_remaining'   => 'permit_empty|decimal',
    //     'uom'             => 'required|alpha_numeric_punct'
    // ];
    // protected $skipValidation = false;
    // protected $validationRules = [
    //     'material_number' => 'required|safe_string',
    //     'qty_received' => 'required|decimal|greater_than[0]',
    //     'qty_order' => 'permit_empty|decimal',
    //     'uom' => 'required|safe_string',
    //     'username' => 'required'
    // ];
    // protected $validationMessages = [
    //     'material_number' => [
    //         'required' => 'Material number is required',
    //         'safe_string' => 'Material number contains invalid characters'
    //     ],
    //     'qty_received' => [
    //         'required' => 'Received quantity is required',
    //         'decimal' => 'Received quantity must be a number',
    //         'greater_than' => 'Received quantity must be greater than zero.'
    //     ],
    //     'qty_order' => [
    //         'decimal' => 'Order quantity must be a number'
    //     ],
    //     'uom' => [
    //         'required' => 'UOM is required',
    //         'safe_string' => 'UOM contains invalid characters'
    //     ],
    //     'username' => [
    //         'required' => 'Username is required',
    //     ]
    // ];
    // public function save_detail($delivery_number, $staging_location, $gr_id)
    // {
    //     $item = $this->where('delivery_number', $delivery_number)->findAll();
    //     $data = [];
    //     foreach ($item as $i) {
    //         $data[] = [
    //             'gr_id' => $gr_id,
    //             'delivery_number' => $delivery_number,
    //             'material_number' => $i['material_number'],
    //             'qty_order' => $i['qty_order'],
    //             'qty_received' => $i['qty_received'],
    //             // 'qty_remaining' => max($i['qty_order'] - $i['qty_received'], 0),
    //             'qty_remaining' => $i['qty_received'],
    //             'uom' => $i['uom'],
    //             'status' => 'RECEIVED',
    //             'staging_location' => $staging_location,
    //         ];
    //     }
    //     $GrDetailModel = new \App\Models\GrDetailModel();
    //     $GrDetailModel->insertBatch($data);
    //     $this->where('delivery_number', $delivery_number)->delete();
    //     return true;
    // }
}
