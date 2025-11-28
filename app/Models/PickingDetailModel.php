<?php

namespace App\Models;

use CodeIgniter\Model;

class PickingDetailModel extends Model
{
    protected $table = 'tbl_picking_detail';
    protected $primaryKey = 'picking_detail_id';

    protected $allowedFields = [
        'picking_id',
        'material_number',
        'material_desc',
        'uom',
        'location_id',
        'rack',
        'bin',
        'qty_required',
        'qty_available',
        'qty_picked',
        'status',
        'picked_by'
    ];

    protected $useTimestamps = false;

    public function getByPickingOrder($pickingId)
    {
        return $this->where('picking_item_id', $pickingId)->findAll();
    }
}
