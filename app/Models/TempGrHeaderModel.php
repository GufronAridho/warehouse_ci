<?php

namespace App\Models;

use CodeIgniter\Model;

class TempGrHeaderModel extends Model
{
    protected $table = 'tbl_temp_gr_header';
    protected $primaryKey = 'temp_id';

    protected $allowedFields = [
        'username',
        'invoice_no',
        'vendor',
        'gr_date',
        'lorry_date',
        'type',
        'record_date'
    ];

    protected $skipValidation = false;

    protected $validationRules = [
        'username' => 'required',
        'invoice_no' => 'required|is_unique[tbl_gr_header.invoice_no]',
        'vendor' => 'required',
        'gr_date' => 'required|valid_date[Y-m-d]',
        'lorry_date' => 'required|valid_date[Y-m-d]',
        'type' => 'required',
        // 'received_by' => 'required'
    ];

    protected $validationMessages = [
        'invoice_no' => [
            'required' => 'Invoice number is required.',
            'is_unique' => 'Invoice number must be unique. This one already exists.'
        ],
        'username' => [
            'required' => 'Username is required.'
        ],
        'vendor' => [
            'required' => 'Vendor is required.'
        ],
        'gr_date' => [
            'required' => 'GR Date is required.',
            'valid_date' => 'GR Date must be a valid date (Y-m-d).'
        ],
        'lorry_date' => [
            'required' => 'Lorry Date is required.',
            'valid_date' => 'Lorry Date must be a valid date (Y-m-d).'
        ],
        'type' => [
            'required' => 'Type is required.'
        ]
    ];
}
