<?php

namespace App\Models;

use CodeIgniter\Model;

class GrHeaderModel extends Model
{
    protected $table = 'tbl_gr_header';
    protected $primaryKey = 'gr_id';
    protected $allowedFields = [
        'delivery_number',
        'vendor',
        'gr_date',
        'status',
        'received_by',
        'record_date',
    ];
    protected $skipValidation = false;
    protected $validationRules = [
        'delivery_number' => 'required|safe_string',
        'vendor' => 'required|safe_string',
        'gr_date' => 'required|valid_date[Y-m-d]',
        'status' => 'required',
        'received_by' => 'required'
    ];
    protected $validationMessages = [
        'delivery_number' => [
            'required' => 'Delivery number is required',
            'safe_string' => 'Delivery number contains invalid characters'
        ],
        'vendor' => [
            'required' => 'Vendor is required',
            'safe_string' => 'Vendor contains invalid characters'
        ],
        'gr_date' => [
            'required' => 'GR date is required',
            'valid_date' => 'GR date must be a valid date (Y-m-d)'
        ],
        'status' => [
            'required' => 'Status is required',
        ],
        'received_by' => [
            'required' => 'Received by is required',
            'safe_string' => 'Received by contains invalid characters'
        ]
    ];
}
