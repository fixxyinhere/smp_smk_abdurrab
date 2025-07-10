<?php
// File: app/Models/LoanItemModel.php
namespace App\Models;

use CodeIgniter\Model;

class LoanItemModel extends Model
{
    protected $table = 'loan_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'loan_id',
        'item_id',
        'quantity',
        'condition_before',
        'condition_after',
        'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getLoanItems($loanId)
    {
        return $this->select('loan_items.*, items.name as item_name, items.code as item_code')
            ->join('items', 'items.id = loan_items.item_id', 'left')
            ->where('loan_id', $loanId)
            ->findAll();
    }

    public function deleteByLoanId($loanId)
    {
        return $this->where('loan_id', $loanId)->delete();
    }
}
