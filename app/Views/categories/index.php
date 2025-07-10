<?php
// File: app/Views/categories/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Kategori</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/categories/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Barang</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $category['name'] ?></td>
                            <td><?= $category['description'] ?></td>
                            <td>
                                <span class="badge bg-info"><?= $category['item_count'] ?? 0 ?> item</span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($category['created_at'])) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/categories/edit/<?= $category['id'] ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/categories/delete/<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>