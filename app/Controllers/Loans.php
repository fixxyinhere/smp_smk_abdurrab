<?php
// File: app/Controllers/Loans.php
namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\LoanItemModel;
use App\Models\RequestModel;
use App\Models\RequestItemModel;
use App\Models\ItemModel;
use App\Models\userModel;

class Loans extends BaseController
{
    protected $loanModel;
    protected $loanItemModel;
    protected $requestModel;
    protected $requestItemModel;
    protected $itemModel;
    protected $userModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->loanItemModel = new LoanItemModel();
        $this->requestModel = new RequestModel();
        $this->requestItemModel = new RequestItemModel();
        $this->itemModel = new ItemModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $role = session()->get('role');
        $userId = session()->get('user_id');

        if ($role === 'user') {
            $loans = $this->loanModel->getLoansByUser($userId);
        } else {
            $loans = $this->loanModel->getAllLoans();
        }

        $data = [
            'title' => 'Data Pinjaman',
            'loans' => $loans,
            'role' => $role
        ];

        return view('loans/index', $data);
    }

    public function create($requestId = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Buat Pinjaman',
            'loan_number' => $this->loanModel->generateLoanNumber(),
            'items' => $this->itemModel->getAvailableItems(),
            'users' => $this->userModel->where('role', 'user')->where('status', 'active')->findAll() // Add this line
        ];

        if ($requestId) {
            $request = $this->requestModel->find($requestId);
            if ($request && $request['status'] === 'approved') {
                $data['request'] = $this->requestModel->getRequestWithItems($requestId);
                $data['request_items'] = $this->requestItemModel->getRequestItems($requestId);
            }
        }

        return view('loans/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'user_id' => 'required|integer',
            'loan_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'items' => 'required',
            'quantities' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert loan
            $loanData = [
                'loan_number' => $this->loanModel->generateLoanNumber(),
                'request_id' => $this->request->getPost('request_id') ?: null,
                'user_id' => $this->request->getPost('user_id'),
                'loan_date' => $this->request->getPost('loan_date'),
                'return_date' => $this->request->getPost('return_date'),
                'status' => 'active',
                'notes' => $this->request->getPost('notes')
            ];

            $loanId = $this->loanModel->insert($loanData);

            // Insert loan items
            $items = $this->request->getPost('items');
            $quantities = $this->request->getPost('quantities');
            $conditions = $this->request->getPost('conditions');

            foreach ($items as $index => $itemId) {
                if (!empty($itemId) && !empty($quantities[$index])) {
                    $loanItemData = [
                        'loan_id' => $loanId,
                        'item_id' => $itemId,
                        'quantity' => $quantities[$index],
                        'condition_before' => $conditions[$index] ?? 'baik',
                        'notes' => $this->request->getPost('item_notes')[$index] ?? null
                    ];
                    $this->loanItemModel->insert($loanItemData);

                    // Update item quantity
                    $item = $this->itemModel->find($itemId);
                    $newQuantity = $item['quantity'] - $quantities[$index];
                    $this->itemModel->updateItemQuantity($itemId, $newQuantity);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('error', 'Gagal membuat pinjaman');
            } else {
                session()->setFlashdata('success', 'Pinjaman berhasil dibuat');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/loans');
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $loan = $this->loanModel->getLoanWithItems($id);
        if (!$loan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Loan not found');
        }

        // Check authorization
        $role = session()->get('role');
        $userId = session()->get('user_id');
        if ($role === 'user' && $loan['user_id'] != $userId) {
            return redirect()->to('/loans');
        }

        $loanItems = $this->loanItemModel->getLoanItems($id);

        $data = [
            'title' => 'Detail Pinjaman',
            'loan' => $loan,
            'loan_items' => $loanItems,
            'role' => $role
        ];

        return view('loans/show', $data);
    }

    public function return($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $loan = $this->loanModel->find($id);
        if (!$loan || $loan['status'] !== 'active') {
            session()->setFlashdata('error', 'Pinjaman tidak ditemukan atau sudah dikembalikan');
            return redirect()->to('/loans');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Return loan
            $actualReturnDate = $this->request->getPost('actual_return_date') ?: date('Y-m-d');
            $this->loanModel->returnLoan($id, $actualReturnDate);

            // Update loan items condition
            $loanItems = $this->loanItemModel->getLoanItems($id);
            $conditionsAfter = $this->request->getPost('conditions_after');

            foreach ($loanItems as $index => $loanItem) {
                $updateData = [
                    'condition_after' => $conditionsAfter[$index] ?? 'baik'
                ];
                $this->loanItemModel->update($loanItem['id'], $updateData);

                // Return item quantity
                $item = $this->itemModel->find($loanItem['item_id']);
                $newQuantity = $item['quantity'] + $loanItem['quantity'];
                $this->itemModel->updateItemQuantity($loanItem['item_id'], $newQuantity);

                // Update item condition if damaged
                if ($conditionsAfter[$index] === 'rusak') {
                    $this->itemModel->update($loanItem['item_id'], ['condition_status' => 'rusak']);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('error', 'Gagal mengembalikan pinjaman');
            } else {
                session()->setFlashdata('success', 'Pinjaman berhasil dikembalikan');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/loans/show/' . $id);
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $loan = $this->loanModel->find($id);
        if (!$loan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Loan not found');
        }

        // Only allow deletion of returned loans
        if ($loan['status'] === 'active') {
            session()->setFlashdata('error', 'Pinjaman yang masih aktif tidak dapat dihapus');
            return redirect()->to('/loans');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete loan items first
            $this->loanItemModel->deleteByLoanId($id);

            // Delete loan
            $this->loanModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('error', 'Gagal menghapus pinjaman');
            } else {
                session()->setFlashdata('success', 'Pinjaman berhasil dihapus');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/loans');
    }
}
