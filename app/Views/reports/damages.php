<?php
// File: app/Views/reports/damages.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Kerusakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/reports/export/damages" class="btn btn-outline-danger">
                <i class="fas fa-download me-2"></i>Export CSV
            </a>
            <a href="/reports" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <h5 class="card-title text-danger">Total Laporan</h5>
                <h3 class="text-danger"><?= isset($damage_stats['total']) ? $damage_stats['total'] : count($damages) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h5 class="card-title text-warning">Pending</h5>
                <h3 class="text-warning"><?= isset($damage_stats['pending']) ? $damage_stats['pending'] : 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-info">
            <div class="card-body">
                <h5 class="card-title text-info">Verified</h5>
                <h3 class="text-info"><?= isset($damage_stats['verified']) ? $damage_stats['verified'] : 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h5 class="card-title text-success">Resolved</h5>
                <h3 class="text-success"><?= isset($damage_stats['resolved']) ? $damage_stats['resolved'] : 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-filter me-2"></i>Filter Laporan
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="/reports/damages">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="<?= $filters['start_date'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="<?= $filters['end_date'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="verified" <?= ($filters['status'] ?? '') === 'verified' ? 'selected' : '' ?>>Verified</option>
                            <option value="approved" <?= ($filters['status'] ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            <option value="resolved" <?= ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioritas</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="">Semua Prioritas</option>
                            <option value="low" <?= ($filters['priority'] ?? '') === 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="medium" <?= ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="high" <?= ($filters['priority'] ?? '') === 'high' ? 'selected' : '' ?>>High</option>
                            <option value="urgent" <?= ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' ?>>Urgent</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="/reports/damages" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i>Data Laporan Kerusakan
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($damages)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>No. Laporan</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Pelapor</th>
                            <th>Jenis Kerusakan</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Tanggal Kejadian</th>
                            <th>Est. Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($damages as $damage): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $damage['report_number'] ?></strong></td>
                                <td><?= $damage['item_code'] ?></td>
                                <td><?= $damage['item_name'] ?></td>
                                <td><?= $damage['user_name'] ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= ucfirst(str_replace('_', ' ', $damage['damage_type'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $priorities = [
                                        'low' => ['secondary', 'Low'],
                                        'medium' => ['primary', 'Medium'],
                                        'high' => ['warning', 'High'],
                                        'urgent' => ['danger', 'Urgent']
                                    ];
                                    $priority = $priorities[$damage['priority']];
                                    ?>
                                    <span class="badge bg-<?= $priority[0] ?>"><?= $priority[1] ?></span>
                                </td>
                                <td>
                                    <?php if ($damage['status'] === 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($damage['status'] === 'verified'): ?>
                                        <span class="badge bg-info">Verified</span>
                                    <?php elseif ($damage['status'] === 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif ($damage['status'] === 'rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php elseif ($damage['status'] === 'resolved'): ?>
                                        <span class="badge bg-success">Resolved</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= ucfirst($damage['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($damage['incident_date'])) ?></td>
                                <td>
                                    <?php if (!empty($damage['estimated_cost'])): ?>
                                        Rp <?= number_format($damage['estimated_cost'], 0, ',', '.') ?>
                                    <?php else: ?>
                                        <span class="text-muted">Belum diestimasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/damage-reports/show/<?= $damage['id'] ?>"
                                            class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Information -->
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            Menampilkan <?= count($damages) ?> laporan kerusakan
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            Total estimasi biaya:
                            <?php
                            $totalCost = 0;
                            foreach ($damages as $damage) {
                                if (!empty($damage['estimated_cost'])) {
                                    $totalCost += $damage['estimated_cost'];
                                }
                            }
                            ?>
                            <strong>Rp <?= number_format($totalCost, 0, ',', '.') ?></strong>
                        </small>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada laporan kerusakan</h5>
                <p class="text-muted">Belum ada data laporan kerusakan dengan filter yang dipilih.</p>
                <a href="/reports/damages" class="btn btn-primary">Reset Filter</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Priority Information -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Keterangan Prioritas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <span class="badge bg-secondary me-2">Low</span>
                        Tidak mengganggu operasional
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-primary me-2">Medium</span>
                        Sedikit mengganggu operasional
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-warning me-2">High</span>
                        Mengganggu operasional normal
                    </div>
                    <div class="col-md-3">
                        <span class="badge bg-danger me-2">Urgent</span>
                        Butuh penanganan segera
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>