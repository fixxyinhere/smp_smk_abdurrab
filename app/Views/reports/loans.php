<?php
// File: app/Views/reports/loans.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Pinjaman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/reports/export/loans" class="btn btn-success">
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
        <form method="GET" action="/reports/loans">
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
                        <option value="active" <?= $filters['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="returned" <?= $filters['status'] === 'returned' ? 'selected' : '' ?>>Dikembalikan</option>
                        <option value="overdue" <?= $filters['status'] === 'overdue' ? 'selected' : '' ?>>Terlambat</option>
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
                <h3 class="text-primary"><?= $loan_stats['total'] ?></h3>
                <p class="card-text">Total Pinjaman</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= $loan_stats['active'] ?></h3>
                <p class="card-text">Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $loan_stats['returned'] ?></h3>
                <p class="card-text">Dikembalikan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?= count($overdue_loans) ?></h3>
                <p class="card-text">Terlambat</p>
            </div>
        </div>
    </div>
</div>

<!-- Overdue Loans Alert -->
<?php if (!empty($overdue_loans)): ?>
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>Pinjaman Terlambat
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No. Pinjaman</th>
                            <th>Peminjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Hari Terlambat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdue_loans as $loan): ?>
                            <tr>
                                <td><?= $loan['loan_number'] ?></td>
                                <td><?= $loan['user_name'] ?></td>
                                <td><?= date('d/m/Y', strtotime($loan['return_date'])) ?></td>
                                <td>
                                    <?php
                                    $returnDate = new DateTime($loan['return_date']);
                                    $today = new DateTime();
                                    $diff = $today->diff($returnDate);
                                    echo $diff->days . ' hari';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Pinjaman</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No. Pinjaman</th>
                        <th>Peminjam</th>
                        <th>No. Permintaan</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Tgl Dikembalikan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?= $loan['loan_number'] ?></td>
                            <td><?= $loan['user_name'] ?></td>
                            <td><?= $loan['request_number'] ?: '-' ?></td>
                            <td><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($loan['return_date'])) ?></td>
                            <td><?= $loan['actual_return_date'] ? date('d/m/Y', strtotime($loan['actual_return_date'])) : '-' ?></td>
                            <td>
                                <?php if ($loan['status'] === 'active'): ?>
                                    <?php if ($loan['return_date'] < date('Y-m-d')): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Aktif</span>
                                    <?php endif; ?>
                                <?php elseif ($loan['status'] === 'returned'): ?>
                                    <span class="badge bg-success">Dikembalikan</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Overdue</span>
                                <?php endif; ?>
                            </td>
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