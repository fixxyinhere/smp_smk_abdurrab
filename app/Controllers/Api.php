<?php
// File: app/Controllers/Api.php
namespace App\Controllers;

class Api extends BaseController
{
    public function getUsers()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $userModel = new \App\Models\UserModel();
        $users = $userModel->where('role', 'user')->where('status', 'active')->findAll();

        return $this->response->setJSON($users);
    }

    public function getAvailableItems()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $itemModel = new \App\Models\ItemModel();
        $items = $itemModel->getAvailableItems();

        return $this->response->setJSON($items);
    }
}
