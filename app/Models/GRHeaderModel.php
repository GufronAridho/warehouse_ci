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
}
