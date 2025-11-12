<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class TestShield extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = auth()->getProvider();
    }

    public function index()
    {
        $auth = auth()->user();

        if ($auth === null) {
            return view('test_shield/test_shield_not_logged_in');
        } else {
            $isAdmin = $auth->inGroup('admin');  // Simple group check (no permissions needed)

            $data = [
                'user' => $auth,
                'isAdmin' => $isAdmin,
            ];
            return view('test_shield/test_shield_logged_in', $data);
        }
    }

    public function manageUsers()
    {
        $auth = auth()->user();
        if ($auth === null || !$auth->inGroup('admin')) {
            return redirect()->to('/test-shield')->with('error', 'Access denied: Admins only.');
        }

        // Get all users from Shield provider
        $users = $this->users->findAll();

        $data = [
            'users'       => $users,
            'currentUser' => $auth,
        ];
        return view('test_shield/admin_manage_users', $data);
    }

    public function editUser($userId = null)
    {
        $auth = auth()->user();
        if ($auth === null || !$auth->inGroup('admin')) {
            return redirect()->to('/test-shield')->with('error', 'Access denied: Admins only.');
        }

        $user = $this->users->findById($userId);
        if (! $user) {
            return redirect()->to('/test-shield/manage')->with('error', 'User not found.');
        }

        if ($this->request->is(type: 'post')) {
            $user->fill([
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
            ]);

            if ($this->users->save($user)) {
                $newGroup = $this->request->getPost('group');
                $this->updateUserGroup($userId, $newGroup);

                return redirect()->to('/test-shield/manage')
                    ->with('message', 'User updated successfully!');
            } else {
                $data['errors'] = $this->users->errors();
            }
        }

        $data = [
            'user'   => $user,
            'groups' => ['user', 'admin'],
        ];
        return view('test_shield/admin_edit_user', $data);
    }


    public function deleteUser($userId = null)
    {
        $auth = auth()->user();
        if ($auth === null || !$auth->inGroup('admin')) {
            return redirect()->to('/test-shield')->with('error', 'Access denied: Admins only.');
        }

        if ($userId == $auth->id) {
            return redirect()->to('/test-shield/manage')->with('error', "Can't delete yourself!");
        }

        $user = $this->users->findById($userId);

        if ($user && $this->users->delete($user->id, true)) {
            return redirect()->to('/test-shield/manage')->with('message', 'User deleted successfully!');
        } else {
            return redirect()->to('/test-shield/manage')->with('error', 'Failed to delete user.');
        }
    }

    private function updateUserGroup($userId, $newGroup)
    {
        $users = auth()->getProvider();
        $user  = $users->findById($userId);

        if (!$user) {
            return false; // user not found
        }

        // Remove old groups
        foreach ($user->getGroups() as $oldGroup) {
            $user->removeGroup($oldGroup);
        }

        // Add new group (if provided)
        if ($newGroup) {
            $user->addGroup($newGroup);
        }

        return true;
    }


    public function logout()
    {
        auth()->logout();
        return redirect()->to('/test-shield')->with('message', 'Logged out successfully!');
    }
}
