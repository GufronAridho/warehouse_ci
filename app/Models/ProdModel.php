<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdModel extends Model
{
    protected $table  = 'mst_prod';
    protected $primaryKey = 'id';

    protected $allowedFields  = [
        'plant_code',
        'plant_name',
        'line_code',
        'line_name',
        'cell_name',
        'process_type'
    ];

    protected $skipValidation = false;

    protected $validationRules  = [
        'plant_code' => 'required|safe_string',
        'plant_name' => 'required|safe_string',
        'line_code' => 'required|safe_string',
        'line_name' => 'required|safe_string',
        'cell_name' => 'required|safe_string',
        'process_type' => 'required|safe_string',
    ];

    protected $validationMessages = [
        'plant_code' => [
            'required' => 'Plant Code is required.',
            'safe_string' => 'Plant Code contains invalid characters.'
        ],
        'plant_name' => [
            'required' => 'Plant Name is required.',
            'safe_string' => 'Plant Name contains invalid characters.'
        ],
        'line_code' => [
            'required' => 'Line Code is required.',
            'safe_string' => 'Line Code contains invalid characters.'
        ],
        'line_name' => [
            'required' => 'Line Name is required.',
            'safe_string' => 'Line Name contains invalid characters.'
        ],
        'cell_name' => [
            'required' => 'Cell Name is required.',
            'safe_string' => 'Cell Name contains invalid characters.'
        ],
        'process_type' => [
            'required' => 'Process Type is required.',
            'safe_string' => 'Process Type contains invalid characters.'
        ],
    ];


    public function search_plant($q = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('plant_code, plant_name');

        if (!empty($q)) {
            $builder->groupStart()
                ->like('plant_code', $q)
                ->orLike('plant_name', $q)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function search_line($q = null, $plant_code = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('line_code, line_name');

        if (!empty($plant_code)) {
            $builder->where('plant_code', $plant_code);
        }

        if (!empty($q)) {
            $builder->groupStart()
                ->like('line_code', $q)
                ->orLike('line_name', $q)
                ->groupEnd();
        }

        return $builder->get()->getResult();
    }

    public function search_cell($q = null, $plant_code = null, $line_code = null)
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('cell_name');

        if (!empty($plant_code)) {
            $builder->where('plant_code', $plant_code);
        }

        if (!empty($line_code)) {
            $builder->where('line_code', $line_code);
        }

        if (!empty($q)) {
            $builder->like('cell_name', $q);
        }

        return $builder->get()->getResult();
    }
}
