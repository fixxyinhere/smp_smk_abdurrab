<?php
// File: app/Controllers/Requests.php
namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\RequestItemModel;
use App\Models\ItemModel;

class Requests extends BaseController
{
    protected $requestModel;
    protected $requestItemModel;
    protected $itemModel;

    public function __construct()
    {
        $this->requestModel = new RequestModel();
        $this->requestItemModel = new RequestItemModel();
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
            $requests = $this->requestModel->getRequestsByUser($userId);
        } else {
            $requests = $this->requestModel->getAllRequests();
        }

        $data = [
            'title' => 'Data Permintaan',
            'requests' => $requests,
            'role' => $role
        ];

        return view('requests/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Buat Permintaan',
            'items' => $this->itemModel->getAvailableItems(),
            'request_number' => $this->requestModel->generateRequestNumber()
        ];

        return view('requests/create', $data);
    }


    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        // DEBUG: Log all POST data
        $postData = $this->request->getPost();
        log_message('debug', 'POST Data received: ' . json_encode($postData));

        // DEBUG: Log session data
        log_message('debug', 'User ID from session: ' . session()->get('user_id'));
        log_message('debug', 'User role from session: ' . session()->get('role'));

        // Simplified validation rules
        $rules = [
            'request_date' => 'required',
            'purpose' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            session()->setFlashdata('error', 'Mohon lengkapi semua field yang diperlukan');
            return redirect()->back()->withInput();
        }

        // Get and validate form data
        $items = $this->request->getPost('items');
        $quantities = $this->request->getPost('quantities');
        $notes = $this->request->getPost('notes');

        // DEBUG: Log items data
        log_message('debug', 'Items: ' . json_encode($items));
        log_message('debug', 'Quantities: ' . json_encode($quantities));
        log_message('debug', 'Notes: ' . json_encode($notes));

        // Check if items are provided
        if (empty($items) || empty($quantities)) {
            log_message('debug', 'Items or quantities empty');
            session()->setFlashdata('error', 'Mohon pilih minimal satu barang');
            return redirect()->back()->withInput();
        }

        // Process valid items
        $validItems = [];
        foreach ($items as $index => $itemId) {
            log_message('debug', "Processing item $index: itemId=$itemId, quantity=" . ($quantities[$index] ?? 'empty'));

            if (!empty($itemId) && !empty($quantities[$index]) && $quantities[$index] > 0) {
                $validItems[] = [
                    'item_id' => (int) $itemId,
                    'quantity' => (int) $quantities[$index],
                    'notes' => $notes[$index] ?? null
                ];
            }
        }

        log_message('debug', 'Valid items: ' . json_encode($validItems));

        if (empty($validItems)) {
            log_message('debug', 'No valid items found');
            session()->setFlashdata('error', 'Mohon pilih minimal satu barang dengan jumlah yang valid');
            return redirect()->back()->withInput();
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Prepare request data
            $requestData = [
                'request_number' => $this->requestModel->generateRequestNumber(),
                'user_id' => (int) session()->get('user_id'),
                'request_date' => $this->request->getPost('request_date'),
                'purpose' => $this->request->getPost('purpose'),
                'status' => 'pending'
            ];

            log_message('debug', 'Request data to insert: ' . json_encode($requestData));

            // Insert request
            $requestId = $this->requestModel->insert($requestData);

            log_message('debug', 'Request inserted with ID: ' . $requestId);

            if (!$requestId) {
                $requestErrors = $this->requestModel->errors();
                log_message('error', 'Request insert failed: ' . json_encode($requestErrors));
                throw new \Exception('Gagal menyimpan data permintaan ke database: ' . implode(', ', $requestErrors));
            }

            // Insert request items using the new method
            foreach ($validItems as $item) {
                $requestItemData = [
                    'request_id' => (int) $requestId,
                    'item_id' => (int) $item['item_id'],
                    'quantity' => (int) $item['quantity'],
                    'notes' => $item['notes']
                ];

                log_message('debug', 'Inserting request item: ' . json_encode($requestItemData));

                // Use the new insertRequestItem method
                $result = $this->requestItemModel->insertRequestItem($requestItemData);

                if (!$result) {
                    $errors = $this->requestItemModel->errors();
                    log_message('error', 'Request item insert failed: ' . json_encode($errors));
                    throw new \Exception('Gagal menyimpan item permintaan: ' . (empty($errors) ? 'Unknown error' : implode(', ', $errors)));
                }

                log_message('debug', 'Request item inserted successfully with ID: ' . $result);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaksi database gagal');
            }

            log_message('debug', 'Request creation successful');
            session()->setFlashdata('success', 'Permintaan berhasil dibuat dengan nomor: ' . $requestData['request_number']);
            return redirect()->to('/requests');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Request creation error: ' . $e->getMessage());

            // Provide more specific error message
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'Duplicate entry') !== false) {
                $errorMessage = 'Nomor permintaan sudah ada, silakan coba lagi';
            } elseif (strpos($errorMessage, 'foreign key constraint') !== false) {
                $errorMessage = 'Data barang tidak valid, silakan pilih barang yang tersedia';
            }

            session()->setFlashdata('error', 'Gagal membuat permintaan: ' . $errorMessage);
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $request = $this->requestModel->getRequestWithItems($id);
        if (!$request) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Request not found');
        }

        // Check authorization
        $role = session()->get('role');
        $userId = session()->get('user_id');
        if ($role === 'user' && $request['user_id'] != $userId) {
            return redirect()->to('/requests');
        }

        $requestItems = $this->requestItemModel->getRequestItems($id);

        $data = [
            'title' => 'Detail Permintaan',
            'request' => $request,
            'request_items' => $requestItems,
            'role' => $role
        ];

        return view('requests/show', $data);
    }

    public function approve($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $notes = $this->request->getPost('notes');

        if ($this->requestModel->approveRequest($id, session()->get('user_id'), $notes)) {
            session()->setFlashdata('success', 'Permintaan berhasil disetujui');
        } else {
            session()->setFlashdata('error', 'Gagal menyetujui permintaan');
        }

        return redirect()->to('/requests/show/' . $id);
    }

    public function reject($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $notes = $this->request->getPost('notes');

        if ($this->requestModel->rejectRequest($id, session()->get('user_id'), $notes)) {
            session()->setFlashdata('success', 'Permintaan berhasil ditolak');
        } else {
            session()->setFlashdata('error', 'Gagal menolak permintaan');
        }

        return redirect()->to('/requests/show/' . $id);
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $request = $this->requestModel->find($id);
        if (!$request) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Request not found');
        }

        // Check authorization
        $role = session()->get('role');
        $userId = session()->get('user_id');
        if ($role === 'user' && $request['user_id'] != $userId) {
            return redirect()->to('/requests');
        }

        // Only allow deletion of pending requests
        if ($request['status'] !== 'pending') {
            session()->setFlashdata('error', 'Hanya permintaan yang berstatus pending yang dapat dihapus');
            return redirect()->to('/requests');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete request items first
            $this->requestItemModel->deleteByRequestId($id);

            // Delete request
            $this->requestModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('error', 'Gagal menghapus permintaan');
            } else {
                session()->setFlashdata('success', 'Permintaan berhasil dihapus');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->to('/requests');
    }
}
