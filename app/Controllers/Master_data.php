<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;

class Master_data extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
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
            'title' => 'Location',
        ]);
    }

    public function mst_stock()
    {
        return view('master_data/mst_stock', [
            'title' => 'Stock',
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
}
