<?php

namespace App\Models;

use CodeIgniter\Model;

class SAFGModel extends Model
{
    protected $table = 'mst_safg_bom';
    protected $primaryKey = 'id_bom';
    protected $allowedFields = [
        'safg_number',
        'safg_desc',
        'material_number',
        'qty',
        'plant',
        'cell_name',
        'record_date',
        'additional',
        'is_active'
    ];
    protected $skipValidation = false;
    protected $validationRules = [
        'safg_number' => 'required|safe_string',
        'safg_desc' => 'permit_empty|safe_string',
        'material_number' => 'required|safe_string',
        'plant' => 'required|safe_string',
        'cell_name' => 'required|safe_string',
        'additional' => 'permit_empty|safe_string',
        'is_active' => 'in_list[0,1]',
    ];
    protected $validationMessages = [
        'safg_number' => [
            'required' => 'SAFG Number is required.',
            'safe_string' => 'SAFG Number contains invalid characters.'
        ],
        'safg_desc' => [
            'safe_string' => 'SAFG Description contains invalid characters.'
        ],
        'material_number' => [
            'required' => 'Material Number is required.',
            'safe_string' => 'Material Number contains invalid characters.'
        ],
        'plant' => [
            'required' => 'Plant is required.',
            'safe_string' => 'Plant contains invalid characters.'
        ],
        'cell_name' => [
            'required' => 'Cell Name is required.',
            'safe_string' => 'Cell Name contains invalid characters.'
        ],
        'additional' => [
            'safe_string' => 'Additional information contains invalid characters.'
        ],
        'is_active' => [
            'in_list' => 'Status must be either Active (1) or Non Active (0).'
        ]
    ];
}
