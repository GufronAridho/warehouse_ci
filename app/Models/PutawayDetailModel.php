<?php

namespace App\Models;

use CodeIgniter\Model;

class PutawayDetailModel extends Model
{
    protected $table = 'tbl_putaway_detail';
    protected $primaryKey = 'putaway_detail_id';
    protected $allowedFields = [
        // 'putaway_id',
        'gr_detail_id',
        'material_number',
        'from_location',
        'to_location',
        'to_rack',
        'to_bin',
        'qty',
        'uom',
        'status',
        'transfer_by',
        'transfer_at',
        'stored_by',
        'stored_at',
    ];
}
