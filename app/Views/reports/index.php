<?php
// File: app/Views/reports/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan</h1>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-boxes fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Laporan Barang</h5>
                <p class="card-text">Laporan lengkap data barang, kondisi, dan lokasi</p>
                <a href="/reports/items" class="btn btn-primary">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-file-alt fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Laporan Permintaan</h5>
                <p class="card-text">Laporan data permintaan dan status persetujuan</p>
                <a href="/reports/requests" class="btn btn-success">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-handshake fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Laporan Pinjaman</h5>
                <p class="card-text">Laporan data pinjaman dan pengembalian barang</p>
                <a href="/reports/loans" class="btn btn-warning">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                </div>
                <h5 class="card-title">Laporan Kerusakan</h5>
                <p class="card-text">Laporan data kerusakan barang dan status perbaikan</p>
                <a href="/reports/damages" class="btn btn-danger">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <?php if (session()->get('role') === 'admin'): ?>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Laporan Pengguna</h5>
                    <p class="card-text">Laporan data pengguna dan aktivitas sistem</p>
                    <a href="/reports/users" class="btn btn-info">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>Export Laporan
                </h5>
            </div>
            <div class="card-body">
                <p>Download laporan dalam format CSV untuk analisis lebih lanjut:</p>
                <div class="btn-group" role="group">
                    <a href="/reports/export/items" class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Export Data Barang
                    </a>
                    <a href="/reports/export/requests" class="btn btn-outline-success">
                        <i class="fas fa-download me-2"></i>Export Data Permintaan
                    </a>
                    <a href="/reports/export/loans" class="btn btn-outline-warning">
                        <i class="fas fa-download me-2"></i>Export Data Pinjaman
                    </a>
                    <a href="/reports/export/damages" class="btn btn-outline-danger">
                        <i class="fas fa-download me-2"></i>Export Data Kerusakan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>