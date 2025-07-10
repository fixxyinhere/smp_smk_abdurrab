<?php
// File: app/Controllers/Dashboard.php (Updated)
namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\RequestModel;
use App\Models\LoanModel;
use App\Models\UserModel;
use App\Models\DamageReportModel;

class Dashboard extends BaseController
{
    protected $itemModel;
    protected $requestModel;
    protected $loanModel;
    protected $userModel;
    protected $damageReportModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->requestModel = new RequestModel();
        $this->loanModel = new LoanModel();
        $this->userModel = new UserModel();
        $this->damageReportModel = new DamageReportModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $userId = session()->get('user_id');

        $data = [
            'title' => 'Dashboard',
            'role' => $role
        ];

        // Statistics berdasarkan role
        if ($role === 'admin' || $role === 'kepsek') {
            $data['stats'] = [
                'total_items' => $this->itemModel->countAllResults(),
                'total_users' => $this->userModel->where('role', 'user')->countAllResults(),
                'request_stats' => $this->requestModel->getRequestStats(),
                'loan_stats' => $this->loanModel->getLoanStats(),
                'damage_stats' => $this->damageReportModel->getDamageStats() // TAMBAHAN INI
            ];

            $data['recent_requests'] = $this->requestModel->getAllRequests() ?: [];
            $data['recent_damage_reports'] = $this->damageReportModel->getRecentReports(5) ?: []; // TAMBAHAN INI
            $data['urgent_damages'] = $this->damageReportModel->getReportsByPriority('urgent') ?: []; // TAMBAHAN INI
            $data['overdue_loans'] = $this->loanModel->getOverdueLoans() ?: [];
        } else {
            $data['my_requests'] = $this->requestModel->getRequestsByUser($userId) ?: [];
            $data['my_loans'] = $this->loanModel->getLoansByUser($userId) ?: [];
            $data['my_damage_reports'] = $this->damageReportModel->getReportsByUser($userId) ?: [];
        }

        return view('dashboard/index', $data);
    }
}
