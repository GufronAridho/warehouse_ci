<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'mst_location';
    protected $primaryKey = 'location_id';

    protected $allowedFields = [
        'storage_type',
        'rack',
        'bin',
        'capacity',
        'material_type_allowed',
        'ms_allowed',
        'priority',
        'is_active'
    ];
    protected $skipValidation = false;
    protected $validationRules = [
        'storage_type' => 'required|safe_string',
        'rack' => 'required|safe_string',
        'bin' => 'required|safe_string',
        'capacity' => 'numeric',
        'material_type_allowed' => 'permit_empty|safe_string',
        'is_active' => 'in_list[0,1]'
    ];
    protected $validationMessages = [
        'storage_type' => [
            'required' => 'Storage type is required',
            'safe_string' => 'Storage type contains invalid characters'
        ],
        'rack' => [
            'required' => 'Rack is required',
            'safe_string' => 'Rack contains invalid characters'
        ],
        'bin' => [
            'required' => 'Bin is required',
            'safe_string' => 'Bin contains invalid characters'
        ],
        'material_type_allowed' => [
            'safe_string' => 'Material type contains invalid characters'
        ]
    ];

    public function search_storage_type($q = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('storage_type');
        $builder->where('is_active', 1);

        if (!empty($q)) {
            $builder->like('storage_type', $q);
        }

        return $builder->get()->getResult();
    }

    public function search_rack($q = null, $storage_type = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('rack');
        $builder->where('is_active', 1);

        if (!empty($storage_type)) {
            $builder->where('storage_type', $storage_type);
        }

        if (!empty($q)) {
            $builder->like('rack', $q);
        }

        return $builder->get()->getResult();
    }

    public function search_bin($q = null, $storage_type = null, $rack = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('bin');
        $builder->where('is_active', 1);

        if (!empty($storage_type)) {
            $builder->where('storage_type', $storage_type);
        }

        if (!empty($rack)) {
            $builder->where('rack', $rack);
        }

        if (!empty($q)) {
            $builder->like('bin', $q);
        }

        return $builder->get()->getResult();
    }

    public function get_active_location_table()
    {
        return $this->findAll();
    }

    public function check_dupli($storage_type, $rack, $bin, $id = null)
    {
        $builder = $this->where('storage_type', $storage_type)
            ->where('rack', $rack)
            ->where('bin', $bin);
        if ($id !== null) {
            $builder = $builder->where('location_id !=', $id);
        }
        return $builder->first();
    }
}
