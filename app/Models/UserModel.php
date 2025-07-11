<?php
// File: app/Models/UserModel.php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'full_name', 'email', 'phone', 'role', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getAllUsers($role = null)
    {
        if ($role) {
            return $this->where('role', $role)->findAll();
        }
        return $this->findAll();
    }

    public function updateUserStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    // Method untuk mendapatkan user dengan informasi lengkap termasuk phone
    public function getUserWithPhone($id)
    {
        return $this->select('id, username, full_name, email, phone, role, status')->find($id);
    }

    // Method untuk mendapatkan semua user aktif dengan phone
    public function getActiveUsersWithPhone()
    {
        return $this->select('id, username, full_name, email, phone, role')
            ->where('status', 'active')
            ->findAll();
    }
}
