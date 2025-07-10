<?php
// File: app/Models/CategoryModel.php
namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function getCategoryWithItemCount()
    {
        return $this->select('categories.*, COUNT(items.id) as item_count')
            ->join('items', 'items.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->findAll();
    }
}
