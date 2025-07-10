<?php
// File: app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] === 'active') {
                $sessionData = [
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('error', 'Akun Anda tidak aktif');
            }
        } else {
            session()->setFlashdata('error', 'Username atau password salah');
        }

        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
