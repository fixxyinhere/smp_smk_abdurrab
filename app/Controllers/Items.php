<?php
// File: app/Controllers/Items.php
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
