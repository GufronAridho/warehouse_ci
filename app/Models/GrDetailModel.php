<?php

namespace App\Models;

use CodeIgniter\Model;

class GrDetailModel extends Model
{
    protected $table = 'tbl_gr_detail';
    protected $primaryKey = 'gr_detail_id';
    protected $allowedFields = [
        'delivery_number',
        'material_number',
        'qty_received',
        'qty_order',
        'qty_remaining',
        'uom',
        'staging_location',
        'status'
    ];
    // protected $skipValidation = false;
    // protected $validationRules = [
    //     'delivery_number' => 'required|safe_string',
    //     'material_number' => 'required|safe_string',
    //     'qty_received' => 'required|decimal|greater_than[0]',
    //     'qty_order' => 'permit_empty|decimal',
    //     'qty_remaining' => 'permit_empty|decimal',
    //     'uom' => 'required|safe_string',
    //     'staging_location' => 'permit_empty|safe_string',
    //     'status' => 'required'
    // ];
    // protected $validationMessages = [
    //     'delivery_number' => [
    //         'required' => 'Delivery number is required',
    //         'safe_string' => 'Delivery number contains invalid characters'
    //     ],
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
    //     'qty_remaining' => [
    //         'decimal' => 'Remaining quantity must be a number'
    //     ],
    //     'uom' => [
    //         'required' => 'UOM is required',
    //         'safe_string' => 'UOM contains invalid characters'
    //     ],
    //     'staging_location' => [
    //         'safe_string' => 'Staging location contains invalid characters'
    //     ],
    //     'status' => [
    //         'required' => 'Status is required',
    //     ]
    // ];
}
