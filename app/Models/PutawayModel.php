<?php

namespace App\Models;

use CodeIgniter\Model;

class PutawayModel extends Model
{
    protected $table = 'tbl_putaway';
    protected $primaryKey = 'putaway_id';
    protected $allowedFields = [
        'gr_id',
        'delivery_number',
        'putaway_date',
        'status',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
