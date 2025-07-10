<?php
// File: app/Models/RequestModel.php
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
        return $this->select('requests.*, users.full_name as user_name, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->orderBy('requests.created_at', 'DESC')
            ->findAll();
    }

    public function getRequestsByUser($userId)
    {
        return $this->select('requests.*, users.full_name as user_name, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->where('requests.user_id', $userId)
            ->orderBy('requests.created_at', 'DESC')
            ->findAll();
    }

    public function getRequestWithItems($id)
    {
        return $this->select('requests.*, users.full_name as user_name, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left')
            ->find($id);
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
}
