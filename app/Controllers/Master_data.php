<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\SAFGModel;
use App\Models\ProdModel;


class Master_data extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;
    protected $SAFGModel;
    protected $ProdModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
        $this->SAFGModel = new SAFGModel();
        $this->ProdModel = new ProdModel();
    }

    private function _json_response($status, $message, $is_validation = false)
    {
        return $this->response->setJSON([
            'status' => $status,
            'message' => $message,
            'is_validation' => $is_validation,
            // 'csrfHash' => csrf_hash()
        ]);
    }

    public function empty_post($key, $default = null)
    {
        $value = $this->request->getPost($key);
        return (isset($value) && trim($value) !== '') ? $value : $default;
    }

    public function mst_user()
    {
        return view('master_data/mst_user', [
            'title' => 'User Managment',
        ]);
    }

    public function mst_material()
    {
        return view('master_data/mst_material', [
            'title' => 'Material',
        ]);
    }

    public function mst_location()
    {
        return view('master_data/mst_location', [
            'title' => 'Storage',
        ]);
    }

    public function mst_stock()
    {
        return view('master_data/mst_stock', [
            'title' => 'Stock',
        ]);
    }

    public function mst_safg_bom()
    {
        return view('master_data/mst_safg_bom', [
            'title' => 'SAFG Bom',
        ]);
    }

    public function mst_prod()
    {
        return view('master_data/mst_prod', [
            'title' => 'Master Production',
        ]);
    }


    public function user_table()
    {
        $users = $this->MstUser->withIdentities()
            ->withGroups()
            ->withPermissions()
            ->findAll();
        // echo "<pre>";
        // print_r($users); 
        // echo "</pre>";
        // exit;

        $data = [
            'item' => $users
        ];
        return view('master_data/partial/user_table', $data);
    }

    public function material_table()
    {
        $item = $this->MaterialModel->get_active_material_table();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/material_table', $data);
    }

    public function location_table()
    {
        $item = $this->LocationModel->get_active_location_table();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/location_table', $data);
    }

    public function stock_table()
    {
        $item = $this->StockModel->findAll();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/stock_table', $data);
    }

    public function safg_table()
    {
        $item = $this->SAFGModel
            ->select('safg_number, safg_desc, plant_code, line_code, cell_name')
            ->groupBy('safg_number, safg_desc')
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/safg_table', $data);
    }

    public function safg_material_table()
    {
        $safg_number = $this->request->getGet('safg_number');

        $item = $this->SAFGModel
            ->select('
        mst_safg_bom.*, 
        mst_material.material_desc, 
        mst_material.uom, 
        (mst_safg_bom.qty * mst_material.price) AS price
    ', false)
            ->join('mst_material', 'mst_material.material_number = mst_safg_bom.material_number', 'left')
            ->where('mst_safg_bom.safg_number', $safg_number)
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/safg_material_table', $data);
    }

    public function prod_table()
    {
        $item = $this->ProdModel->findAll();
        $data = [
            'item' => $item
        ];
        return view('master_data/partial/prod_table', $data);
    }

    private function updateUserGroup($userId, $newGroup)
    {
        $users = auth()->getProvider();
        $user  = $users->findById($userId);

        if (!$user) {
            return false;
        }

        foreach ($user->getGroups() as $oldGroup) {
            $user->removeGroup($oldGroup);
        }

        if ($newGroup) {
            $user->addGroup($newGroup);
        }

        return true;
    }

    public function create_user()
    {
        if ($this->request->is('post')) {

            $validation = \Config\Services::validation();
            if (!$validation->run($this->request->getPost(), 'create_user')) {
                return $this->_json_response(false, implode(', ', $validation->getErrors()));
            }

            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $level = $this->request->getPost('level');

            $user_data = new User([
                'username' => $username,
                'email' =>  $email,
                'password' => $password,
            ]);

            try {
                if ($this->MstUser->save($user_data)) {
                    $id = $this->MstUser->getInsertID();
                    $this->updateUserGroup($id, $level);
                    return $this->_json_response(true, 'User created successfully');
                } else {
                    $errors = $this->MstUser->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_user()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');

            $validation = \Config\Services::validation();
            $data = $this->request->getPost();
            $data['id'] = $id;
            if (! $validation->run($data, 'edits_user')) {
                return $this->_json_response(false, implode(', ', $validation->getErrors()));
            }

            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $level = $this->request->getPost('level');

            $user_data = $this->MstUser->findById($id);
            $user_data->fill(
                [
                    'username' => $username,
                    'email' => $email,
                ]
            );

            try {
                if ($this->MstUser->save($user_data)) {
                    $this->updateUserGroup($id, $level);
                    return $this->_json_response(true, 'User updated successfully');
                } else {
                    $errors = $this->MstUser->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_user()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');

            try {
                if ($this->MstUser->delete($id, true)) {
                    return $this->_json_response(true, 'User deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete User');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function create_location()
    {
        if ($this->request->is('post')) {
            $storage_type = $this->request->getPost('storage_type');
            $rack = $this->request->getPost('rack');
            $bin = $this->request->getPost('bin');

            if ($this->LocationModel->check_dupli($storage_type, $rack, $bin)) {
                return $this->_json_response(
                    false,
                    'Another location with the same Storage Type, Rack, and Bin already exists.'
                );
            }

            $data = [
                'storage_type' => $storage_type,
                'rack' => $rack,
                'bin' => $bin,
                'capacity' => $this->empty_post('capacity', 0),
                'material_type_allowed' => $this->empty_post('material_type_allowed', null),
                'priority' => $this->empty_post('priority', 0),
                'is_active' => $this->empty_post('is_active', 1),
            ];
            try {
                if ($this->LocationModel->insert($data)) {
                    return $this->_json_response(true, 'Location created successfully');
                } else {
                    $errors = $this->LocationModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_location()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            $storage_type = $this->request->getPost('storage_type');
            $rack = $this->request->getPost('rack');
            $bin = $this->request->getPost('bin');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }

            if ($this->LocationModel->check_dupli($storage_type, $rack, $bin, $id)) {
                return $this->_json_response(
                    false,
                    'Another location with the same Storage Type, Rack, and Bin already exists.'
                );
            }
            $data = [
                'storage_type' => $storage_type,
                'rack' => $rack,
                'bin' => $bin,
                'capacity' => $this->empty_post('capacity', 0),
                'material_type_allowed' => $this->empty_post('material_type_allowed', null),
                'priority' => $this->empty_post('priority', 0),
                'is_active' => $this->empty_post('is_active', 1),
            ];
            try {
                if ($this->LocationModel->update($id, $data)) {
                    return $this->_json_response(true, 'Location update successfully');
                } else {
                    $errors = $this->LocationModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_location()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }
            try {
                if ($this->LocationModel->delete($id)) {
                    return $this->_json_response(true, 'Location deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete location');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function create_material()
    {
        if ($this->request->is('post')) {
            $data = [
                'material_number' => $this->request->getPost('material_number'),
                'material_desc' => $this->empty_post('material_desc', null),
                'ms' => $this->empty_post('ms', null),
                'uom' => $this->request->getPost('uom'),
                'type' => $this->empty_post('type', null),
                'pgr' => $this->empty_post('pgr', null),
                'mrpc' => $this->empty_post('mrpc', null),
                'price' => $this->empty_post('price', 0),
                'currency' => $this->empty_post('currency', 'IDR'),
                'per' => $this->empty_post('per', null),
                'additional' => $this->empty_post('additional', null),
                'is_active' => $this->empty_post('is_active', 1),
            ];

            try {
                if ($this->MaterialModel->insert($data)) {
                    return $this->_json_response(true, 'Material created successfully');
                } else {
                    $errors = $this->MaterialModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_material()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }

            $data = [
                // 'material_number' => $this->request->getPost('material_number'),
                'material_desc' => $this->empty_post('material_desc', null),
                'ms' => $this->empty_post('ms', null),
                'uom' => $this->request->getPost('uom'),
                'type' => $this->empty_post('type', null),
                'pgr' => $this->empty_post('pgr', null),
                'mrpc' => $this->empty_post('mrpc', null),
                'price' => $this->empty_post('price', 0),
                'currency' => $this->empty_post('currency', 'IDR'),
                'per' => $this->empty_post('per', null),
                'additional' => $this->empty_post('additional', null),
                'is_active' => $this->empty_post('is_active', 1),
            ];

            try {
                if ($this->MaterialModel->update($id, $data)) {
                    return $this->_json_response(true, 'Material update successfully');
                } else {
                    $errors = $this->MaterialModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_material()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }
            try {
                if ($this->MaterialModel->delete($id)) {
                    return $this->_json_response(true, 'Material deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete material');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }


    public function create_safg()
    {
        if ($this->request->is('post')) {

            $safgNumber = $this->request->getPost('safg_number');

            $data = [
                'safg_number' => $safgNumber,
                'safg_desc' => $this->request->getPost('safg_desc'),
                'plant_code' => $this->request->getPost('plant_code'),
                'line_code' => $this->request->getPost('line_code'),
                'cell_name' => $this->request->getPost('cell_name'),
                'material_number' => $this->request->getPost('material_number'),
                'qty' => $this->request->getPost('qty'),
                'is_active' => $this->request->getPost('is_active'),
                'record_date' => date('Y-m-d H:i:s'),
            ];

            try {
                if ($this->SAFGModel->insert($data)) {
                    return $this->_json_response(true, 'SAFG created successfully.');
                } else {
                    $errors = $this->SAFGModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_safg()
    {
        if ($this->request->is('post')) {

            $safgNumber = $this->request->getPost('safg_number');
            if (empty($safgNumber)) {
                return $this->_json_response(false, 'Missing SAFG Number.');
            }

            $data = [
                'safg_desc' => $this->request->getPost('safg_desc'),
                'plant_code' => $this->request->getPost('plant_code'),
                'line_code' => $this->request->getPost('line_code'),
                'cell_name' => $this->request->getPost('cell_name'),
            ];

            try {
                if ($this->SAFGModel
                    ->where('safg_number', $safgNumber)
                    ->set($data)
                    ->update()
                ) {
                    return $this->_json_response(true, 'SAFG updated successfully.');
                } else {
                    $errors = $this->SAFGModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method.');
    }

    public function update_safg_material()
    {
        if ($this->request->is('post')) {

            $id = $this->request->getPost('id_bom');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing BOM ID.');
            }

            $data = [
                'material_number' => $this->request->getPost('material_number'),
                'qty' => $this->request->getPost('qty'),
                'is_active' => $this->request->getPost('is_active'),
            ];

            try {
                if ($this->SAFGModel->update($id, $data)) {
                    return $this->_json_response(true, 'Material updated successfully.');
                } else {
                    $errors = $this->SAFGModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_safg()
    {
        if ($this->request->is('post')) {
            $safg_number = $this->request->getPost('safg_number');

            if (empty($safg_number)) {
                return $this->_json_response(false, 'Missing SAFG Number.');
            }
            try {
                if ($this->SAFGModel
                    ->where('safg_number', $safg_number)
                    ->delete()
                ) {
                    return $this->_json_response(true, 'SAFG deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete SAFG');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_safg_material()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }
            try {
                if ($this->SAFGModel->delete($id)) {
                    return $this->_json_response(true, 'Material deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete Material');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function create_prod()
    {
        if ($this->request->is('post')) {

            $data = [
                'plant_code' => $this->request->getPost('plant_code'),
                'plant_name' => $this->request->getPost('plant_name'),
                'line_code' => $this->request->getPost('line_code'),
                'line_name' => $this->request->getPost('line_name'),
                'cell_name' => $this->request->getPost('cell_name'),
                'process_type' => $this->request->getPost('process_type'),
            ];

            try {
                if ($this->ProdModel->insert($data)) {
                    return $this->_json_response(true, 'Production Master created successfully.');
                } else {
                    $errors  = $this->ProdModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_prod()
    {
        if ($this->request->is('post')) {

            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing Production ID.');
            }

            $data = [
                'plant_code' => $this->request->getPost('plant_code'),
                'plant_name' => $this->request->getPost('plant_name'),
                'line_code' => $this->request->getPost('line_code'),
                'line_name' => $this->request->getPost('line_name'),
                'cell_name' => $this->request->getPost('cell_name'),
                'process_type' => $this->request->getPost('process_type'),
            ];

            try {
                if ($this->ProdModel->update($id, $data)) {
                    return $this->_json_response(true, 'Production Master updated successfully.');
                } else {
                    $errors  = $this->ProdModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_prod()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }

            try {
                if ($this->ProdModel->delete($id)) {
                    return $this->_json_response(true, 'Production Master deleted successfully.');
                } else {
                    return $this->_json_response(false, 'Failed to delete Production Master.');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }
}
