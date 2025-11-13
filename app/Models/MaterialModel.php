<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'mst_material';
    protected $primaryKey = 'id_material';

    protected $allowedFields = [
        'material_number',
        'material_desc',
        'ms',
        'uom',
        'type',
        'pgr',
        'mrpc',
        'price',
        'currency',
        'per',
        'record_date',
        'additional',
        'is_active'
    ];
    protected $skipValidation = false;
    protected $validationRules = [
        'material_number' => 'required|safe_string',
        'material_desc' => 'permit_empty|safe_string',
        'uom' => 'required|safe_string',
        'price' => 'numeric',
        'currency' => 'max_length[10]',
        'is_active' => 'in_list[0,1]',
        'additional' => 'permit_empty|safe_string',
    ];
    protected $validationMessages = [
        'material_number' => [
            'required' => 'Material number is required',
            'safe_string' => 'Material number contains invalid characters'
        ],
        'material_desc' => [
            'safe_string' => 'Material Desc contains invalid characters'
        ],
        'uom' => [
            'safe_string' => 'UOM contains invalid characters'
        ],
        'additional' => [
            'safe_string' => 'Additional contains invalid characters'
        ],
    ];

    public function search_material_number($q = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('material_number, material_desc');
        $builder->where('is_active', 1);

        if (!empty($q)) {
            $builder->groupStart()
                ->like('material_number', $q)
                ->orLike('material_desc', $q)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function grTempMaterialNumberSelect($q = null, $username)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('material_number, material_desc');
        $builder->where('is_active', 1);
        $builder->whereNotIn('material_number', function ($sub) use ($username) {
            return $sub->select('material_number')
                ->from('tbl_gr_temp')
                ->where('username', $username);
        });
        if (!empty($q)) {
            $builder->groupStart()
                ->like('material_number', $q)
                ->orLike('material_desc', $q)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function material_detail($material_number)
    {
        return $this->select('material_number, material_desc, uom')
            ->where('material_number', $material_number)
            ->first();
    }

    public function get_active_material_table()
    {
        return $this->findAll();
    }
}
