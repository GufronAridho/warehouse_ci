<?php

namespace App\Models;

use CodeIgniter\Model;

class PutawayHeaderModel extends Model
{
    protected $table = 'tbl_putaway';
    protected $primaryKey = 'putaway_id';
    protected $allowedFields = [
        'gr_id',
        'delivery_number',
        'putaway_date',
        'status',
        'transfer_by',
        'transfer_at',
        'completed_at'
    ];
}
