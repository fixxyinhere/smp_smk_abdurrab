<?php
// File: app/Views/items/index.php (Updated with Import Feature)
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <?php if (session()->get('role') !== 'user'): ?>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="/items/create">
                            <i class="fas fa-edit me-2"></i>Tambah Manual
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/items/import">
                            <i class="fas fa-file-excel me-2 text-success"></i>Import dari Excel
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="/items/download-template">
                            <i class="fas fa-download me-2 text-info"></i>Download Template Excel
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Stats -->
<?php
$totalItems = count($items);
$goodCondition = count(array_filter($items, function ($item) {
    return $item['condition_status'] === 'baik';
}));
$damagedCondition = count(array_filter($items, function ($item) {
    return $item['condition_status'] === 'rusak';
}));
$lostCondition = count(array_filter($items, function ($item) {
    return $item['condition_status'] === 'hilang';
}));
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h5 class="card-title text-primary">Total Barang</h5>
                <h3 class="text-primary"><?= $totalItems ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h5 class="card-title text-success">Kondisi Baik</h5>
                <h3 class="text-success"><?= $goodCondition ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">Kondisi Rusak</h5>
                <h3 class="text-warning"><?= $damagedCondition ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">Hilang</h5>
                <h3 class="text-danger"><?= $lostCondition ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Import Info Card -->
<?php if (session()->get('role') !== 'user'): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-file-excel me-2"></i>Import Data dari Excel
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="text-info">Cara Import Data Barang:</h6>
                            <ol class="small mb-0">
                                <li>Download template Excel terlebih dahulu</li>
                                <li>Isi data barang sesuai format yang disediakan</li>
                                <li>Pastikan kategori sudah ada di sistem</li>
                                <li>Upload file Excel yang sudah diisi</li>
                            </ol>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="/items/download-template" class="btn btn-info btn-sm me-2">
                                <i class="fas fa-download me-1"></i>Download Template
                            </a>
                            <a href="/items/import" class="btn btn-success btn-sm">
                                <i class="fas fa-upload me-1"></i>Import Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['code'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['category_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>
                                <?php if ($item['condition_status'] === 'baik'): ?>
                                    <span class="badge bg-success">Baik</span>
                                <?php elseif ($item['condition_status'] === 'rusak'): ?>
                                    <span class="badge bg-warning">Rusak</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Hilang</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $item['location'] ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/items/show/<?= $item['id'] ?>" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (session()->get('role') !== 'user'): ?>
                                        <a href="/items/edit/<?= $item['id'] ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/items/delete/<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .dropdown-menu {
        min-width: 220px;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .card-header {
        font-weight: 500;
    }

    .border-primary {
        border-left: 4px solid #0d6efd !important;
    }

    .border-success {
        border-left: 4px solid #198754 !important;
    }

    .border-warning {
        border-left: 4px solid #ffc107 !important;
    }

    .border-danger {
        border-left: 4px solid #dc3545 !important;
    }

    .border-info {
        border-left: 4px solid #0dcaf0 !important;
    }
</style>

<?php $this->endSection(); ?>