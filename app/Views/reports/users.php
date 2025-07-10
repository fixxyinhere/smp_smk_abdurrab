<?php
// File: app/Views/reports/users.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Pengguna</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
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
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= count($users) ?></h3>
                <p class="card-text">Total Pengguna</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?= $admin_count ?></h3>
                <p class="card-text">Admin</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= $kepsek_count ?></h3>
                <p class="card-text">Kepsek</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info"><?= $user_count ?></h3>
                <p class="card-text">User</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $active_count ?></h3>
                <p class="card-text">Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-secondary"><?= $inactive_count ?></h3>
                <p class="card-text">Tidak Aktif</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Semua Pengguna</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Terakhir Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['full_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php elseif ($user['role'] === 'kepsek'): ?>
                                    <span class="badge bg-warning">Kepsek</span>
                                <?php else: ?>
                                    <span class="badge bg-info">User</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($user['status'] === 'active'): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></td>
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