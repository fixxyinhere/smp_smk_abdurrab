<?php
// File: app/Models/RequestModel.php (FIXED VERSION)
namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
    protected $table = 'requests';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'request_number',
        'user_id',
        'request_date',
        'purpose',
        'status',
        'approved_by',
        'approved_at',
        'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllRequests()
    {
        $requests = $this->select('requests.*, users.full_name as user_name, users.phone as user_phone, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->orderBy('requests.created_at', 'DESC')
            ->findAll();

        // Add is_loaned flag manually
        foreach ($requests as &$request) {
            $request['is_loaned'] = $this->isRequestLoaned($request['id']);
        }

        return $requests;
    }

    public function getRequestsByUser($userId)
    {
        $requests = $this->select('requests.*, users.full_name as user_name, users.phone as user_phone, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->where('requests.user_id', $userId)
            ->orderBy('requests.created_at', 'DESC')
            ->findAll();

        // Add is_loaned flag manually
        foreach ($requests as &$request) {
            $request['is_loaned'] = $this->isRequestLoaned($request['id']);
        }

        return $requests;
    }

    public function getRequestWithItems($id)
    {
        $request = $this->select('requests.*, users.full_name as user_name, users.phone as user_phone, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->find($id);

        if ($request) {
            $request['is_loaned'] = $this->isRequestLoaned($request['id']);
        }

        return $request;
    }

    public function generateRequestNumber()
    {
        $lastRequest = $this->orderBy('id', 'DESC')->first();
        if ($lastRequest) {
            $lastNumber = intval(substr($lastRequest['request_number'], 3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'REQ' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function approveRequest($id, $approvedBy, $notes = null)
    {
        return $this->update($id, [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s'),
            'notes' => $notes
        ]);
    }

    public function rejectRequest($id, $approvedBy, $notes = null)
    {
        return $this->update($id, [
            'status' => 'rejected',
            'approved_by' => $approvedBy,
            'approved_at' => date('Y-m-d H:i:s'),
            'notes' => $notes
        ]);
    }

    public function getRequestStats()
    {
        return [
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults(),
            'total' => $this->countAllResults()
        ];
    }

    // Method untuk mengecek apakah request sudah dijadikan pinjaman
    public function isRequestLoaned($requestId)
    {
        $db = \Config\Database::connect();
        $result = $db->table('loans')
            ->where('request_id', $requestId)
            ->countAllResults();

        return $result > 0;
    }

    // Method untuk mendapatkan approved requests yang belum dijadikan pinjaman
    public function getApprovedRequestsNotLoaned()
    {
        $db = \Config\Database::connect();

        // Get all approved requests
        $approvedRequests = $this->select('requests.*, users.full_name as user_name, users.phone as user_phone')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->where('requests.status', 'approved')
            ->findAll();

        // Filter out those that already have loans
        $notLoanedRequests = [];
        foreach ($approvedRequests as $request) {
            if (!$this->isRequestLoaned($request['id'])) {
                $notLoanedRequests[] = $request;
            }
        }

        return $notLoanedRequests;
    }
}
