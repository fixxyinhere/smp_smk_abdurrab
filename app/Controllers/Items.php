<?php
// File: app/Controllers/Items.php (Updated with Import Excel Feature)
namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\CategoryModel;

class Items extends BaseController
{
    protected $itemModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Data Barang',
            'items' => $this->itemModel->getAllItems()
        ];

        return view('items/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah Barang',
            'categories' => $this->categoryModel->getAllCategories(),
            'item_code' => $this->itemModel->generateItemCode()
        ];

        return view('items/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'code' => 'required|is_unique[items.code]',
            'name' => 'required|min_length[3]',
            'category_id' => 'required|integer',
            'quantity' => 'required|integer',
            'condition_status' => 'required|in_list[baik,rusak,hilang]',
            'location' => 'required',
            'price' => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'quantity' => $this->request->getPost('quantity'),
            'condition_status' => $this->request->getPost('condition_status'),
            'location' => $this->request->getPost('location'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'price' => $this->request->getPost('price'),
            'created_by' => session()->get('user_id')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/items', $newName);
            $data['image'] = $newName;
        }

        if ($this->itemModel->save($data)) {
            session()->setFlashdata('success', 'Data barang berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data barang');
        }

        return redirect()->to('/items');
    }

    // NEW: Import Excel functionality
    public function import()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Import Data Barang dari Excel',
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('items/import', $data);
    }

    public function processImport()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'excel_file' => [
                'rules' => 'uploaded[excel_file]|ext_in[excel_file,xlsx,xls]|max_size[excel_file,10240]',
                'errors' => [
                    'uploaded' => 'File Excel harus dipilih',
                    'ext_in' => 'File harus berformat Excel (.xlsx atau .xls)',
                    'max_size' => 'Ukuran file maksimal 10MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('excel_file');

        if (!$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid');
            return redirect()->back();
        }

        try {
            // Load PhpSpreadsheet library
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();

            // Remove header row
            array_shift($data);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            $db = \Config\Database::connect();
            $db->transStart();

            foreach ($data as $rowIndex => $row) {
                $rowNumber = $rowIndex + 2; // +2 karena index dimulai dari 0 dan ada header

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validate required fields
                if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                    $errors[] = "Baris {$rowNumber}: Kode, Nama, dan Kategori harus diisi";
                    $errorCount++;
                    continue;
                }

                // Find category by name
                $categoryName = trim($row[2]);
                $category = $this->categoryModel->where('name', $categoryName)->first();

                if (!$category) {
                    $errors[] = "Baris {$rowNumber}: Kategori '{$categoryName}' tidak ditemukan";
                    $errorCount++;
                    continue;
                }

                // Prepare item data
                $itemCode = trim($row[0]);
                $itemData = [
                    'code' => $itemCode,
                    'name' => trim($row[1]),
                    'category_id' => $category['id'],
                    'description' => isset($row[3]) ? trim($row[3]) : '',
                    'quantity' => isset($row[4]) && is_numeric($row[4]) ? (int)$row[4] : 1,
                    'condition_status' => isset($row[5]) && in_array(strtolower(trim($row[5])), ['baik', 'rusak', 'hilang'])
                        ? strtolower(trim($row[5])) : 'baik',
                    'location' => isset($row[6]) ? trim($row[6]) : 'Belum ditentukan',
                    'purchase_date' => isset($row[7]) && !empty($row[7]) ? date('Y-m-d', strtotime($row[7])) : null,
                    'price' => isset($row[8]) && is_numeric($row[8]) ? (float)$row[8] : 0,
                    'created_by' => session()->get('user_id')
                ];

                // Check if item code already exists
                if ($this->itemModel->where('code', $itemCode)->first()) {
                    $errors[] = "Baris {$rowNumber}: Kode barang '{$itemCode}' sudah ada";
                    $errorCount++;
                    continue;
                }

                // Insert item
                if ($this->itemModel->insert($itemData)) {
                    $successCount++;
                } else {
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data";
                    $errorCount++;
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('error', 'Gagal mengimpor data. Transaksi database gagal.');
                return redirect()->back();
            }

            // Create summary message
            $message = "Import selesai! Berhasil: {$successCount} data, Gagal: {$errorCount} data";

            if (!empty($errors)) {
                $message .= "\n\nDetail Error:\n" . implode("\n", array_slice($errors, 0, 10));
                if (count($errors) > 10) {
                    $message .= "\n... dan " . (count($errors) - 10) . " error lainnya";
                }
            }

            if ($successCount > 0) {
                session()->setFlashdata('success', $message);
            } else {
                session()->setFlashdata('error', $message);
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to('/items');
    }

    // NEW: Download template Excel
    public function downloadTemplate()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet->setTitle('Template Import Barang');

            // Set headers
            $headers = [
                'A1' => 'Kode Barang*',
                'B1' => 'Nama Barang*',
                'C1' => 'Kategori*',
                'D1' => 'Deskripsi',
                'E1' => 'Jumlah',
                'F1' => 'Kondisi',
                'G1' => 'Lokasi',
                'H1' => 'Tanggal Beli',
                'I1' => 'Harga'
            ];

            foreach ($headers as $cell => $value) {
                $worksheet->setCellValue($cell, $value);
            }

            // Style headers
            $headerStyle = [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => 'center']
            ];
            $worksheet->getStyle('A1:I1')->applyFromArray($headerStyle);

            // Add sample data
            $sampleData = [
                ['BRG0001', 'Laptop Asus X441BA', 'Elektronik', 'Laptop untuk administrasi', '2', 'baik', 'Ruang TU', '2023-01-15', '4500000']
            ];

            $row = 2;
            foreach ($sampleData as $data) {
                $col = 'A';
                foreach ($data as $value) {
                    $worksheet->setCellValue($col . $row, $value);
                    $col++;
                }
                $row++;
            }

            // Auto-size columns
            foreach (range('A', 'I') as $col) {
                $worksheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Add instructions
            $worksheet->setCellValue('A6', 'PETUNJUK PENGGUNAAN:');
            $worksheet->setCellValue('A7', '1. Kolom dengan tanda * wajib diisi');
            $worksheet->setCellValue('A8', '2. Kondisi: baik, rusak, atau hilang');
            $worksheet->setCellValue('A9', '3. Kategori harus sesuai dengan yang ada di sistem');
            $worksheet->setCellValue('A10', '4. Format tanggal: YYYY-MM-DD atau DD/MM/YYYY');
            $worksheet->setCellValue('A11', '5. Hapus data contoh sebelum mengimpor');

            $worksheet->getStyle('A6:A11')->getFont()->setBold(true);

            // Get categories for reference
            $categories = $this->categoryModel->getAllCategories();
            $worksheet->setCellValue('K1', 'Daftar Kategori:');
            $worksheet->getStyle('K1')->getFont()->setBold(true);

            $catRow = 2;
            foreach ($categories as $category) {
                $worksheet->setCellValue('K' . $catRow, $category['name']);
                $catRow++;
            }

            // Create Excel file
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

            $filename = 'template_import_barang_' . date('Y-m-d') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal membuat template: ' . $e->getMessage());
            return redirect()->to('/items');
        }
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $item = $this->itemModel->find($id);
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        $data = [
            'title' => 'Edit Barang',
            'item' => $item,
            'categories' => $this->categoryModel->getAllCategories()
        ];

        return view('items/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $item = $this->itemModel->find($id);
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        $rules = [
            'name' => 'required|min_length[3]',
            'category_id' => 'required|integer',
            'quantity' => 'required|integer',
            'condition_status' => 'required|in_list[baik,rusak,hilang]',
            'location' => 'required',
            'price' => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'quantity' => $this->request->getPost('quantity'),
            'condition_status' => $this->request->getPost('condition_status'),
            'location' => $this->request->getPost('location'),
            'purchase_date' => $this->request->getPost('purchase_date'),
            'price' => $this->request->getPost('price')
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image
            if ($item['image'] && file_exists('uploads/items/' . $item['image'])) {
                unlink('uploads/items/' . $item['image']);
            }

            $newName = $image->getRandomName();
            $image->move('uploads/items', $newName);
            $data['image'] = $newName;
        }

        if ($this->itemModel->update($id, $data)) {
            session()->setFlashdata('success', 'Data barang berhasil diupdate');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate data barang');
        }

        return redirect()->to('/items');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $item = $this->itemModel->find($id);
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        // Delete image file
        if ($item['image'] && file_exists('uploads/items/' . $item['image'])) {
            unlink('uploads/items/' . $item['image']);
        }

        if ($this->itemModel->delete($id)) {
            session()->setFlashdata('success', 'Data barang berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus data barang');
        }

        return redirect()->to('/items');
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $item = $this->itemModel->getItemById($id);
        if (!$item) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Item not found');
        }

        $data = [
            'title' => 'Detail Barang',
            'item' => $item
        ];

        return view('items/show', $data);
    }
}
