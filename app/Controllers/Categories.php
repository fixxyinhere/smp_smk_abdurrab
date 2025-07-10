<?php
// File: app/Controllers/Categories.php
namespace App\Controllers;

use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Data Kategori',
            'categories' => $this->categoryModel->getCategoryWithItemCount()
        ];

        return view('categories/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Tambah Kategori'
        ];

        return view('categories/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'name' => 'required|min_length[3]|is_unique[categories.name]',
            'description' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->save($data)) {
            session()->setFlashdata('success', 'Kategori berhasil ditambahkan');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan kategori');
        }

        return redirect()->to('/categories');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];

        return view('categories/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $rules = [
            'name' => 'required|min_length[3]',
            'description' => 'required|min_length[10]'
        ];

        // Check if name is unique (exclude current category)
        if ($this->request->getPost('name') !== $category['name']) {
            $rules['name'] .= '|is_unique[categories.name]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($this->categoryModel->update($id, $data)) {
            session()->setFlashdata('success', 'Kategori berhasil diupdate');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate kategori');
        }

        return redirect()->to('/categories');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') === 'user') {
            return redirect()->to('/dashboard');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        if ($this->categoryModel->delete($id)) {
            session()->setFlashdata('success', 'Kategori berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kategori');
        }

        return redirect()->to('/categories');
    }
}
