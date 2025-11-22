<?php

namespace App\Models;

use CodeIgniter\Model;

class GrHeaderModel extends Model
{
    protected $table = 'tbl_gr_header';
    protected $primaryKey = 'gr_id';

    protected $allowedFields = [
        'invoice_no',
        'vendor',
        'gr_date',
        'lorry_date',
        'type',
        'status',
        'received_by',
        'record_date'
    ];

    protected $useTimestamps = false;

    protected $skipValidation = false;

    protected $validationRules = [
        'invoice_no'        => 'required|safe_string',
        'vendor'            => 'required|safe_string',
        'gr_date'           => 'required|valid_date[Y-m-d]',
        'lorry_date'         => 'required|valid_date[Y-m-d]',
        'type'              => 'required|safe_string',
        'status'            => 'required|safe_string',
        'received_by'       => 'required|safe_string',
    ];

    protected $validationMessages = [
        'invoice_no' => [
            'required' => 'Invoice number is required',
            'safe_string' => 'Invoice number contains invalid characters'
        ],
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
        'lory_date' => [
            'required' => 'Lorry date is required',
            'valid_date' => 'Lorry date must be a valid date (Y-m-d)'
        ],
        'type' => [
            'required' => 'Type is required',
            'safe_string' => 'Type contains invalid characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'safe_string' => 'Status contains invalid characters'
        ],
        'received_by' => [
            'required' => 'Received by is required',
            'safe_string' => 'Received by contains invalid characters'
        ]
    ];
}
