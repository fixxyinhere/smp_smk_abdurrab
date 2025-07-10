<?php
// File: app/Models/ItemModel.php
namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code',
        'name',
        'category_id',
        'description',
        'quantity',
        'condition_status',
        'location',
        'purchase_date',
        'price',
        'image',
        'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllItems()
    {
        return $this->select('items.*, categories.name as category_name, users.full_name as created_by_name')
            ->join('categories', 'categories.id = items.category_id', 'left')
            ->join('users', 'users.id = items.created_by', 'left')
            ->findAll();
    }

    public function getItemById($id)
    {
        return $this->select('items.*, categories.name as category_name, users.full_name as created_by_name')
            ->join('categories', 'categories.id = items.category_id', 'left')
            ->join('users', 'users.id = items.created_by', 'left')
            ->find($id);
    }

    public function getItemsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)->findAll();
    }

    public function getAvailableItems()
    {
        return $this->where('quantity >', 0)
            ->where('condition_status', 'baik')
            ->findAll();
    }

    public function generateItemCode()
    {
        $lastItem = $this->orderBy('id', 'DESC')->first();
        if ($lastItem) {
            $lastNumber = intval(substr($lastItem['code'], 3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'BRG' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function updateItemQuantity($id, $quantity)
    {
        return $this->update($id, ['quantity' => $quantity]);
    }
}
