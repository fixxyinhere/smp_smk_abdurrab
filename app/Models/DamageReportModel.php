<?php
// File: app/Models/DamageReportModel.php
namespace App\Models;

use CodeIgniter\Model;

class DamageReportModel extends Model
{
    protected $table = 'damage_reports';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'report_number',
        'user_id',
        'item_id',
        'damage_type',
        'damage_description',    // ✅ Sesuai database
        'damage_location',       // ✅ Sesuai database
        'incident_date',
        'report_date',
        'quantity_damaged',
        'estimated_cost',
        'status',
        'verified_by',
        'verified_at',
        'admin_notes',
        'image_path',
        'priority'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'item_id' => 'required|integer',
        'damage_type' => 'required|in_list[rusak_ringan,rusak_berat,hilang,lainnya]',
        'damage_description' => 'required|min_length[10]',
        'incident_date' => 'required|valid_date',
        'report_date' => 'required|valid_date',
        'quantity_damaged' => 'required|integer|greater_than[0]'
    ];

    public function getAllReports()
    {
        return $this->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code, verifier.full_name as verifier_name')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left')
            ->join('users as verifier', 'verifier.id = damage_reports.verified_by', 'left')
            ->orderBy('damage_reports.created_at', 'DESC')
            ->findAll();
    }

    public function getReportsByUser($userId)
    {
        return $this->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code, verifier.full_name as verifier_name')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left')
            ->join('users as verifier', 'verifier.id = damage_reports.verified_by', 'left')
            ->where('damage_reports.user_id', $userId)
            ->orderBy('damage_reports.created_at', 'DESC')
            ->findAll();
    }

    public function getReportWithDetails($id)
    {
        return $this->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code, verifier.full_name as verifier_name')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left')
            ->join('users as verifier', 'verifier.id = damage_reports.verified_by', 'left')
            ->find($id);
    }

    public function generateReportNumber()
    {
        $lastReport = $this->orderBy('id', 'DESC')->first();
        if ($lastReport) {
            $lastNumber = intval(substr($lastReport['report_number'], 3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        return 'DMG' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function verifyReport($id, $verifiedBy, $status, $notes = null)
    {
        return $this->update($id, [
            'status' => $status,
            'verified_by' => $verifiedBy,
            'verified_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ]);
    }


    public function getDamageStats()
    {
        return [
            'total' => $this->countAllResults(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'verified' => $this->where('status', 'verified')->countAllResults(),
            'approved' => $this->where('status', 'approved')->countAllResults(),
            'rejected' => $this->where('status', 'rejected')->countAllResults(),
            'resolved' => $this->where('status', 'resolved')->countAllResults(),
            'fixed' => $this->where('status', 'fixed')->countAllResults(),
            'urgent' => $this->where('priority', 'urgent')->countAllResults()
        ];
    }

    public function getReportsByPriority($priority)
    {
        return $this->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left')
            ->where('damage_reports.priority', $priority)
            ->where('damage_reports.status !=', 'resolved') // Hanya yang belum resolved
            ->orderBy('damage_reports.created_at', 'DESC')
            ->findAll();
    }
    public function getRecentReports($limit = 10)
    {
        return $this->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left')
            ->orderBy('damage_reports.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
