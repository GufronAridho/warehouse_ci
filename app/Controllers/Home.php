<?php

namespace App\Controllers;


class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }
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

    public function trial()
    {
        return view('home/trial', [
            'title' => 'Trial',
        ]);
    }

    public function index()
    {

        return view('home/index', [
            'title' => 'home',
        ]);
    }

    public function change_password()
    {
        return view('home/change_password', [
            'title' => 'Change Password',
        ]);
    }

    public function old_password(string $password): bool
    {
        $result = auth()->check([
            'email'    => auth()->user()->email,
            'password' => $password,
        ]);

        if (!$result->isOK()) {
            return false;
        }

        return true;
    }

    public function update_password()
    {
        if ($this->request->is('post')) {
            $user_id = auth()->id();

            $current_password = $this->request->getPost('current_password');
            $check_pass = $this->old_password($current_password);
            if (!$check_pass) {
                return $this->_json_response(false, 'Current password is incorrect');
            }
            $validation = \Config\Services::validation();
            if (!$validation->run($this->request->getPost(), 'change_pass')) {
                return $this->_json_response(false, implode(', ', $validation->getErrors()));
            }

            $new_password  = $this->request->getPost('password');
            $user_data = $this->MstUser->findById($user_id);
            $user_data->fill(
                [
                    'password' => $new_password,
                ]
            );
            try {
                if ($this->MstUser->save($user_data)) {
                    return $this->_json_response(true, 'Password changed successfully');
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

    public function test_csrf()
    {
        return $this->response->setJSON([
            'success' => true,
            'csrfHash' => csrf_hash()
        ]);
    }

    public function refresh_session()
    {
        session()->set('last_action', time());

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Session refreshed'
        ]);
    }
}
