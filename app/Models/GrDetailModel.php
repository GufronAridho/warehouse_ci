<?php

namespace App\Models;

use CodeIgniter\Model;

class GrDetailModel extends Model
{
    protected $table = 'tbl_gr_detail';
    protected $primaryKey = 'gr_detail_id';

    protected $allowedFields = [
        'gr_id',
        'invoice_no',
        'delivery_number',
        'material_number',
        'qty_order',
        'qty_received',
        'qty_remaining',
        'uom',
        'shipment_id',
        'customer_po',
        'customer_po_line',
        'staging_location',
        'status',
        'scanned_by',
        'scanned_at',
        'validated_at'
    ];
}
