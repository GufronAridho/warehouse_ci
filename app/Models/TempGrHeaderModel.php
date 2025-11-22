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

    protected $useTimestamps = false;

    protected $validationRules = [
        'username' => 'required',
        'vendor'     => 'required',
        'gr_date'    => 'required|valid_date[Y-m-d]',
        'lorry_date' => 'required|valid_date[Y-m-d]',
        'type'       => 'required',
        // 'received_by' => 'required'
    ];
}
