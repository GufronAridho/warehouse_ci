<?php

namespace App\Models;

use CodeIgniter\Model;

class PickingHeaderModel extends Model
{
    protected $table = 'tbl_picking_header';
    protected $primaryKey = 'picking_id';

    protected $allowedFields = [
        'order_number',
        'sa_fg',
        'order_quantity',
        'plant_code',
        'line_code',
        'cell_name',
        'picking_date',
        'status',
        'remarks',
        'created_by',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $beforeInsert = ['autoGenerateOrderNumber'];
    protected function autoGenerateOrderNumber(array $data)
    {
        if (!isset($data['data']['order_number']) || empty($data['data']['order_number'])) {
            $data['data']['order_number'] = $this->generateOrderNumber();
        }

        return $data;
    }
    public function generateOrderNumber()
    {
        $prefix = 'PO-' . date('Ymd');

        $last = $this
            ->like('order_number', $prefix)
            ->orderBy('picking_id', 'DESC')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last['order_number'], -4);
            $next = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $next = "0001";
        }

        return $prefix . "-" . $next;
    }
}
