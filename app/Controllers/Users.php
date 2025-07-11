<?php
// File: app/Controllers/Users.php
namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Data Pengguna',
            'users' => $this->userModel->getAllUsers()
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah Pengguna'
        ];

        return view('users/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'full_name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'role' => 'required|in_list[admin,kepsek,user]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'role' => $this->request->getPost('role'),
            'status' => 'active'
        ];

        if ($this->userModel->save($data)) {
            session()->setFlashdata('success', 'Pengguna berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan pengguna');
        }

        return redirect()->to('/users');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user' => $user
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $rules = [
            'full_name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'role' => 'required|in_list[admin,kepsek,user]',
            'status' => 'required|in_list[active,inactive]'
        ];

        // Check if email is unique (exclude current user)
        if ($this->request->getPost('email') !== $user['email']) {
            $rules['email'] .= '|is_unique[users.email]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];

        // Update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($this->userModel->update($id, $data)) {
            session()->setFlashdata('success', 'Pengguna berhasil diupdate');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate pengguna');
        }

        return redirect()->to('/users');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        // Prevent deleting current user
        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Tidak dapat menghapus pengguna yang sedang login');
            return redirect()->to('/users');
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'Pengguna berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus pengguna');
        }

        return redirect()->to('/users');
    }
}
