<?php
// File: app/Models/LoanModel.php (FIXED getLoanStats method)
namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'loans';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'loan_number',
        'request_id',
        'user_id',
        'loan_date',
        'return_date',
        'actual_return_date',
        'status',
        'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllLoans()
    {
        return $this->select('loans.*, users.full_name as user_name, users.phone as user_phone, requests.request_number')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->join('requests', 'requests.id = loans.request_id', 'left')
            ->orderBy('loans.created_at', 'DESC')
            ->findAll();
    }

    public function getLoansByUser($userId)
    {
        return $this->select('loans.*, users.full_name as user_name, users.phone as user_phone, requests.request_number')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->join('requests', 'requests.id = loans.request_id', 'left')
            ->where('loans.user_id', $userId)
            ->orderBy('loans.created_at', 'DESC')
            ->findAll();
    }

    public function getLoanWithItems($id)
    {
        return $this->select('loans.*, users.full_name as user_name, users.phone as user_phone, requests.request_number')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->join('requests', 'requests.id = loans.request_id', 'left')
            ->find($id);
    }

    public function generateLoanNumber()
    {
        $lastLoan = $this->orderBy('id', 'DESC')->first();
        if ($lastLoan) {
            $lastNumber = intval(substr($lastLoan['loan_number'], 4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'LOAN' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function returnLoan($id, $actualReturnDate = null)
    {
        return $this->update($id, [
            'status' => 'returned',
            'actual_return_date' => $actualReturnDate ?: date('Y-m-d')
        ]);
    }

    public function getOverdueLoans()
    {
        return $this->select('loans.*, users.full_name as user_name, users.phone as user_phone')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->where('loans.return_date <', date('Y-m-d'))
            ->where('loans.status', 'active')
            ->findAll();
    }

    // FIXED METHOD - Specify table name for status column
    public function getLoanStats()
    {
        return [
            'active' => $this->where('loans.status', 'active')->countAllResults(),
            'returned' => $this->where('loans.status', 'returned')->countAllResults(),
            'overdue' => $this->where('loans.return_date <', date('Y-m-d'))->where('loans.status', 'active')->countAllResults(),
            'total' => $this->countAllResults()
        ];
    }
}
