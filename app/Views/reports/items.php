<?php
// File: app/Views/reports/items.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Data Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/reports/export/items" class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
        </div>
        <a href="/reports" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $total_items ?></h3>
                <p class="card-text">Total Barang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $good_condition ?></h3>
                <p class="card-text">Kondisi Baik</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= $damaged_condition ?></h3>
                <p class="card-text">Kondisi Rusak</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?= $lost_condition ?></h3>
                <p class="card-text">Hilang</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Semua Barang</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Tanggal Beli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($items as $item): ?>
                        <tr>
                            <td><?= $no++ ?></td>
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
                            <td><?= $item['purchase_date'] ? date('d/m/Y', strtotime($item['purchase_date'])) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {

        .btn-toolbar,
        .sidebar,
        .navbar {
            display: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .main {
            margin-left: 0 !important;
        }
    }
</style>

<?php $this->endSection(); ?>