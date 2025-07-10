<?php
// File: app/Controllers/Reports.php
namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\RequestModel;
use App\Models\LoanModel;
use App\Models\UserModel;
use App\Models\DamageReportModel;

class Reports extends BaseController
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
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Laporan'
        ];

        return view('reports/index', $data);
    }

    public function items()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Laporan Data Barang',
            'items' => $this->itemModel->getAllItems(),
            'total_items' => $this->itemModel->countAllResults(),
            'good_condition' => $this->itemModel->where('condition_status', 'baik')->countAllResults(),
            'damaged_condition' => $this->itemModel->where('condition_status', 'rusak')->countAllResults(),
            'lost_condition' => $this->itemModel->where('condition_status', 'hilang')->countAllResults()
        ];

        return view('reports/items', $data);
    }

    public function requests()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');

        $builder = $this->requestModel->builder();
        $builder->select('requests.*, users.full_name as user_name, approver.full_name as approver_name')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->join('users as approver', 'approver.id = requests.approved_by', 'left');

        if ($startDate && $endDate) {
            $builder->where('requests.request_date >=', $startDate)
                ->where('requests.request_date <=', $endDate);
        }

        if ($status) {
            $builder->where('requests.status', $status);
        }

        $requests = $builder->orderBy('requests.created_at', 'DESC')->get()->getResultArray();

        $data = [
            'title' => 'Laporan Permintaan',
            'requests' => $requests,
            'request_stats' => $this->requestModel->getRequestStats(),
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status
            ]
        ];

        return view('reports/requests', $data);
    }

    public function loans()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');

        $builder = $this->loanModel->builder();
        $builder->select('loans.*, users.full_name as user_name, requests.request_number')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->join('requests', 'requests.id = loans.request_id', 'left');

        if ($startDate && $endDate) {
            $builder->where('loans.loan_date >=', $startDate)
                ->where('loans.loan_date <=', $endDate);
        }

        if ($status) {
            $builder->where('loans.status', $status);
        }

        $loans = $builder->orderBy('loans.created_at', 'DESC')->get()->getResultArray();

        $data = [
            'title' => 'Laporan Pinjaman',
            'loans' => $loans,
            'loan_stats' => $this->loanModel->getLoanStats(),
            'overdue_loans' => $this->loanModel->getOverdueLoans(),
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status
            ]
        ];

        return view('reports/loans', $data);
    }

    public function damages()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');

        $builder = $this->damageReportModel->builder();
        $builder->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code')
            ->join('users', 'users.id = damage_reports.user_id', 'left')
            ->join('items', 'items.id = damage_reports.item_id', 'left');

        if ($startDate && $endDate) {
            $builder->where('damage_reports.incident_date >=', $startDate)
                ->where('damage_reports.incident_date <=', $endDate);
        }

        if ($status) {
            $builder->where('damage_reports.status', $status);
        }

        if ($priority) {
            $builder->where('damage_reports.priority', $priority);
        }

        $damages = $builder->orderBy('damage_reports.created_at', 'DESC')->get()->getResultArray();

        $data = [
            'title' => 'Laporan Kerusakan',
            'damages' => $damages,
            'damage_stats' => $this->damageReportModel->getDamageStats(),
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'priority' => $priority
            ]
        ];

        return view('reports/damages', $data);
    }

    public function users()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Laporan Pengguna',
            'users' => $this->userModel->getAllUsers(),
            'admin_count' => $this->userModel->where('role', 'admin')->countAllResults(),
            'kepsek_count' => $this->userModel->where('role', 'kepsek')->countAllResults(),
            'user_count' => $this->userModel->where('role', 'user')->countAllResults(),
            'active_count' => $this->userModel->where('status', 'active')->countAllResults(),
            'inactive_count' => $this->userModel->where('status', 'inactive')->countAllResults()
        ];

        return view('reports/users', $data);
    }

    public function export($type)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        switch ($type) {
            case 'items':
                return $this->exportItems();
            case 'requests':
                return $this->exportRequests();
            case 'loans':
                return $this->exportLoans();
            case 'damages':
                return $this->exportDamages();
            default:
                return redirect()->to('/reports');
        }
    }

    private function exportItems()
    {
        $items = $this->itemModel->getAllItems();

        $filename = 'laporan_barang_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['Kode', 'Nama Barang', 'Kategori', 'Jumlah', 'Kondisi', 'Lokasi', 'Harga', 'Tanggal Beli']);

        // Data
        foreach ($items as $item) {
            fputcsv($output, [
                $item['code'],
                $item['name'],
                $item['category_name'],
                $item['quantity'],
                $item['condition_status'],
                $item['location'],
                $item['price'],
                $item['purchase_date']
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportRequests()
    {
        $requests = $this->requestModel->getAllRequests();

        $filename = 'laporan_permintaan_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['No. Permintaan', 'Pemohon', 'Tanggal', 'Tujuan', 'Status', 'Disetujui Oleh', 'Tanggal Disetujui']);

        // Data
        foreach ($requests as $request) {
            fputcsv($output, [
                $request['request_number'],
                $request['user_name'],
                $request['request_date'],
                $request['purpose'],
                $request['status'],
                $request['approver_name'],
                $request['approved_at']
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportLoans()
    {
        $loans = $this->loanModel->getAllLoans();

        $filename = 'laporan_pinjaman_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['No. Pinjaman', 'Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali', 'Tanggal Dikembalikan', 'Status']);

        // Data
        foreach ($loans as $loan) {
            fputcsv($output, [
                $loan['loan_number'],
                $loan['user_name'],
                $loan['loan_date'],
                $loan['return_date'],
                $loan['actual_return_date'],
                $loan['status']
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportDamages()
    {
        try {
            // Ambil data damage reports
            $builder = $this->damageReportModel->builder();
            $damages = $builder->select('damage_reports.*, users.full_name as user_name, items.name as item_name, items.code as item_code')
                ->join('users', 'users.id = damage_reports.user_id', 'left')
                ->join('items', 'items.id = damage_reports.item_id', 'left')
                ->orderBy('damage_reports.created_at', 'DESC')
                ->get()->getResultArray();

            // Debug: Uncomment untuk melihat data
            // echo "<pre>"; print_r($damages); echo "</pre>"; exit;

            $filename = 'laporan_kerusakan_' . date('Y-m-d') . '.csv';

            // Set headers untuk download
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');

            // Add BOM untuk Excel compatibility
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header CSV
            fputcsv($output, [
                'No. Laporan',
                'Kode Barang',
                'Nama Barang',
                'Pelapor',
                'Jenis Kerusakan',
                'Deskripsi',
                'Prioritas',
                'Status',
                'Tanggal Kejadian',
                'Tanggal Laporan',
                'Estimasi Biaya'
            ]);

            // Jika tidak ada data, tambah baris kosong dengan keterangan
            if (empty($damages)) {
                fputcsv($output, [
                    'Tidak ada data',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-'
                ]);
            } else {
                // Data rows
                foreach ($damages as $damage) {
                    fputcsv($output, [
                        $damage['report_number'] ?? 'N/A',
                        $damage['item_code'] ?? 'N/A',
                        $damage['item_name'] ?? 'N/A',
                        $damage['user_name'] ?? 'N/A',
                        ucfirst(str_replace('_', ' ', $damage['damage_type'] ?? 'N/A')),
                        $damage['damage_description'] ?? 'N/A', // PERBAIKAN: damage_description bukan description
                        ucfirst($damage['priority'] ?? 'N/A'),
                        ucfirst($damage['status'] ?? 'N/A'),
                        $damage['incident_date'] ?? 'N/A',
                        !empty($damage['created_at']) ? date('Y-m-d', strtotime($damage['created_at'])) : 'N/A',
                        !empty($damage['estimated_cost']) ? 'Rp ' . number_format($damage['estimated_cost'], 0, ',', '.') : 'Belum diestimasi'
                    ]);
                }
            }

            fclose($output);
            exit;
        } catch (\Exception $e) {
            // Log error
            log_message('error', 'Export damages failed: ' . $e->getMessage());

            // Set flash message dan redirect
            session()->setFlashdata('error', 'Gagal mengexport data: ' . $e->getMessage());
            return redirect()->to('/reports/damages');
        }
    }
}
