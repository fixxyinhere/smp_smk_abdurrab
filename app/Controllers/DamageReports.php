<?php
// File: app/Controllers/DamageReports.php
namespace App\Controllers;

use App\Models\DamageReportModel;
use App\Models\ItemModel;

class DamageReports extends BaseController
{
    protected $damageReportModel;
    protected $itemModel;

    public function __construct()
    {
        $this->damageReportModel = new DamageReportModel();
        $this->itemModel = new ItemModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'user') {
            $reports = $this->damageReportModel->getReportsByUser($userId);
        } else {
            $reports = $this->damageReportModel->getAllReports();
        }

        $data = [
            'title' => $role === 'user' ? 'Laporan Kerusakan Saya' : 'Data Laporan Kerusakan',
            'reports' => $reports ?: [],
            'role' => $role
        ];

        return view('damage_reports/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Laporkan Kerusakan',
            'items' => $this->itemModel->findAll(),
            'report_number' => $this->damageReportModel->generateReportNumber()
        ];

        return view('damage_reports/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $rules = [
            'item_id' => 'required|integer',
            'damage_type' => 'required|in_list[rusak_ringan,rusak_berat,hilang,lainnya]',
            'damage_description' => 'required|min_length[10]',
            'damage_location' => 'required',
            'incident_date' => 'required|valid_date',
            'quantity_damaged' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'report_number' => $this->damageReportModel->generateReportNumber(),
            'user_id' => session()->get('user_id'),
            'item_id' => $this->request->getPost('item_id'),
            'damage_type' => $this->request->getPost('damage_type'),
            'damage_description' => $this->request->getPost('damage_description'),
            'damage_location' => $this->request->getPost('damage_location'),
            'incident_date' => $this->request->getPost('incident_date'),
            'report_date' => date('Y-m-d'),
            'quantity_damaged' => $this->request->getPost('quantity_damaged'),
            'estimated_cost' => $this->request->getPost('estimated_cost') ?: 0,
            'priority' => $this->request->getPost('priority') ?: 'medium',
            'status' => 'pending'
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/damage_reports', $newName);
            $data['image_path'] = $newName;
        }

        if ($this->damageReportModel->save($data)) {
            session()->setFlashdata('success', 'Laporan kerusakan berhasil dikirim dengan nomor: ' . $data['report_number']);
        } else {
            session()->setFlashdata('error', 'Gagal mengirim laporan kerusakan');
        }

        return redirect()->to('/damage-reports');
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $report = $this->damageReportModel->getReportWithDetails($id);
        if (!$report) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Report not found');
        }

        // Check authorization
        $role = session()->get('role');
        $userId = session()->get('user_id');
        if ($role === 'user' && $report['user_id'] != $userId) {
            return redirect()->to('/damage-reports');
        }

        $data = [
            'title' => 'Detail Laporan Kerusakan',
            'report' => $report,
            'role' => $role
        ];

        return view('damage_reports/show', $data);
    }

    public function verify($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('admin_notes');

        if ($this->damageReportModel->verifyReport($id, session()->get('user_id'), $status, $notes)) {
            session()->setFlashdata('success', 'Status laporan berhasil diupdate');

            // Update item condition if approved
            if ($status === 'approved') {
                $report = $this->damageReportModel->find($id);
                if ($report['damage_type'] === 'rusak_berat' || $report['damage_type'] === 'hilang') {
                    $this->itemModel->update($report['item_id'], ['condition_status' => 'rusak']);
                }
            }
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate status laporan');
        }

        return redirect()->to('/damage-reports/show/' . $id);
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $report = $this->damageReportModel->find($id);
        if (!$report) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Report not found');
        }

        // Check authorization
        $role = session()->get('role');
        $userId = session()->get('user_id');
        if ($role === 'user' && $report['user_id'] != $userId) {
            return redirect()->to('/damage-reports');
        }

        // Only allow deletion of pending reports
        if ($report['status'] !== 'pending') {
            session()->setFlashdata('error', 'Hanya laporan yang berstatus pending yang dapat dihapus');
            return redirect()->to('/damage-reports');
        }

        // Delete image file if exists
        if ($report['image_path'] && file_exists('uploads/damage_reports/' . $report['image_path'])) {
            unlink('uploads/damage_reports/' . $report['image_path']);
        }

        if ($this->damageReportModel->delete($id)) {
            session()->setFlashdata('success', 'Laporan kerusakan berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus laporan kerusakan');
        }

        return redirect()->to('/damage-reports');
    }
}
