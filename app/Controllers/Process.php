<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;


class Process extends BaseController
{
    protected $MstUser;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
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

    public function mst_user()
    {
        return view('master_data/mst_user', [
            'title' => 'User Managment',
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
                'email'    =>  $email,
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
}
