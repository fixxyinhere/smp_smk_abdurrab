<?php
// File: app/Views/reports/requests.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Permintaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/reports/export/requests" class="btn btn-success">
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

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter Laporan</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="/reports/requests">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $filters['start_date'] ?>">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $filters['end_date'] ?>">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $filters['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $filters['status'] === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="rejected" <?= $filters['status'] === 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $request_stats['total'] ?></h3>
                <p class="card-text">Total Permintaan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= $request_stats['pending'] ?></h3>
                <p class="card-text">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $request_stats['approved'] ?></h3>
                <p class="card-text">Disetujui</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?= $request_stats['rejected'] ?></h3>
                <p class="card-text">Ditolak</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Permintaan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No. Permintaan</th>
                        <th>Pemohon</th>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th>Disetujui Oleh</th>
                        <th>Tgl Disetujui</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?= $request['request_number'] ?></td>
                            <td><?= $request['user_name'] ?></td>
                            <td><?= date('d/m/Y', strtotime($request['request_date'])) ?></td>
                            <td><?= substr($request['purpose'], 0, 50) ?>...</td>
                            <td>
                                <?php if ($request['status'] === 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($request['status'] === 'approved'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $request['approver_name'] ?: '-' ?></td>
                            <td><?= $request['approved_at'] ? date('d/m/Y', strtotime($request['approved_at'])) : '-' ?></td>
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
        .navbar,
        .card:first-child {
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