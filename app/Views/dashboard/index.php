<?php
// File: app/Views/dashboard/index.php (Modern Clean Design)
$this->extend('layout/template');
$this->section('content');
?>

<div class="dashboard-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle text-muted">Selamat datang di sistem manajemen sarana prasarana</p>
        </div>
        <div class="dashboard-badge">
            <span class="badge bg-gradient-primary px-3 py-2">
                <i class="fas fa-user me-2"></i><?= ucfirst($role) ?>
            </span>
        </div>
    </div>
</div>

<?php if ($role === 'admin' || $role === 'kepsek'): ?>
    <!-- Statistics Cards for Admin/Kepsek -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card-modern primary">
                <div class="stats-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number"><?= $stats['total_items'] ?></div>
                    <div class="stats-label">Total Barang</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card-modern success">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number"><?= $stats['total_users'] ?></div>
                    <div class="stats-label">Total User</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-arrow-up text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card-modern warning">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number"><?= $stats['request_stats']['pending'] ?></div>
                    <div class="stats-label">Permintaan Pending</div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-exclamation-circle text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card-modern danger">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-content">
                    <div class="stats-number"><?= isset($stats['damage_stats']['total']) ? $stats['damage_stats']['total'] : 0 ?></div>
                    <div class="stats-label">Laporan Kerusakan</div>
                    <div class="stats-detail">
                        Pending: <?= isset($stats['damage_stats']['pending']) ? $stats['damage_stats']['pending'] : 0 ?> |
                        Urgent: <?= isset($stats['damage_stats']['urgent']) ? $stats['damage_stats']['urgent'] : 0 ?>
                    </div>
                </div>
                <div class="stats-trend">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="activity-card">
                <div class="activity-header">
                    <div class="activity-icon bg-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h5 class="activity-title">Permintaan Terbaru</h5>
                </div>
                <div class="activity-content">
                    <?php if (!empty($recent_requests)): ?>
                        <div class="activity-list">
                            <?php foreach (array_slice($recent_requests, 0, 5) as $request): ?>
                                <div class="activity-item">
                                    <div class="activity-item-info">
                                        <div class="activity-item-title"><?= $request['request_number'] ?></div>
                                        <div class="activity-item-subtitle"><?= $request['user_name'] ?></div>
                                    </div>
                                    <div class="activity-item-status">
                                        <?php if ($request['status'] === 'pending'): ?>
                                            <span class="status-badge warning">Pending</span>
                                        <?php elseif ($request['status'] === 'approved'): ?>
                                            <span class="status-badge success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="status-badge danger">Ditolak</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="activity-footer">
                            <a href="/requests" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada permintaan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="activity-card">
                <div class="activity-header">
                    <div class="activity-icon bg-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 class="activity-title">Laporan Kerusakan</h5>
                </div>
                <div class="activity-content">
                    <?php if (!empty($recent_damage_reports)): ?>
                        <div class="activity-list">
                            <?php foreach ($recent_damage_reports as $damage): ?>
                                <div class="activity-item">
                                    <div class="activity-item-info">
                                        <div class="activity-item-title"><?= $damage['report_number'] ?></div>
                                        <div class="activity-item-subtitle"><?= substr($damage['item_name'], 0, 20) ?><?= strlen($damage['item_name']) > 20 ? '...' : '' ?></div>
                                    </div>
                                    <div class="activity-item-status">
                                        <?php
                                        $priorities = [
                                            'low' => ['secondary', 'L'],
                                            'medium' => ['primary', 'M'],
                                            'high' => ['warning', 'H'],
                                            'urgent' => ['danger', 'U']
                                        ];
                                        $priority = $priorities[$damage['priority']];
                                        ?>
                                        <span class="status-badge <?= $priority[0] ?> me-2"><?= $priority[1] ?></span>
                                        <?php if ($damage['status'] === 'pending'): ?>
                                            <span class="status-badge warning">Pending</span>
                                        <?php elseif ($damage['status'] === 'verified'): ?>
                                            <span class="status-badge info">Verified</span>
                                        <?php elseif ($damage['status'] === 'approved'): ?>
                                            <span class="status-badge success">Approved</span>
                                        <?php else: ?>
                                            <span class="status-badge secondary"><?= ucfirst($damage['status']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="activity-footer">
                            <a href="/damage-reports" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-shield-alt fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada laporan kerusakan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="activity-card">
                <div class="activity-header">
                    <div class="activity-icon bg-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 class="activity-title">Pinjaman Terlambat</h5>
                </div>
                <div class="activity-content">
                    <?php if (!empty($overdue_loans)): ?>
                        <div class="activity-list">
                            <?php foreach ($overdue_loans as $loan): ?>
                                <div class="activity-item">
                                    <div class="activity-item-info">
                                        <div class="activity-item-title"><?= $loan['loan_number'] ?></div>
                                        <div class="activity-item-subtitle"><?= $loan['user_name'] ?></div>
                                    </div>
                                    <div class="activity-item-status">
                                        <span class="status-badge danger">
                                            <?php
                                            $returnDate = new DateTime($loan['return_date']);
                                            $today = new DateTime();
                                            $diff = $today->diff($returnDate);
                                            echo $diff->days . ' hari';
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="activity-footer">
                            <a href="/loans" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                            <p class="text-muted">Tidak ada pinjaman terlambat</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Urgent Damage Reports Alert -->
    <?php if (!empty($urgent_damages)): ?>
        <div class="row mt-5">
            <div class="col-12">
                <div class="urgent-alert">
                    <div class="urgent-alert-header">
                        <div class="urgent-alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="urgent-alert-content">
                            <h5 class="urgent-alert-title">Laporan Kerusakan Urgent</h5>
                            <p class="urgent-alert-subtitle">Butuh penanganan segera!</p>
                        </div>
                    </div>
                    <div class="urgent-alert-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No. Laporan</th>
                                        <th>Barang</th>
                                        <th>Pelapor</th>
                                        <th>Jenis Kerusakan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($urgent_damages as $urgent): ?>
                                        <tr>
                                            <td><strong><?= $urgent['report_number'] ?></strong></td>
                                            <td><?= $urgent['item_name'] ?></td>
                                            <td><?= $urgent['user_name'] ?></td>
                                            <td><?= ucfirst(str_replace('_', ' ', $urgent['damage_type'])) ?></td>
                                            <td><?= date('d/m/Y', strtotime($urgent['incident_date'])) ?></td>
                                            <td>
                                                <a href="/damage-reports/show/<?= $urgent['id'] ?>" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-eye me-1"></i>Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php else: ?>
    <!-- User Dashboard -->
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-icon bg-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h5 class="user-card-title">Permintaan Saya</h5>
                </div>
                <div class="user-card-content">
                    <?php if (!empty($my_requests)): ?>
                        <div class="user-activity-list">
                            <?php foreach (array_slice($my_requests, 0, 5) as $request): ?>
                                <div class="user-activity-item">
                                    <div class="user-activity-info">
                                        <div class="user-activity-title"><?= $request['request_number'] ?></div>
                                        <div class="user-activity-date"><?= date('d/m/Y', strtotime($request['request_date'])) ?></div>
                                    </div>
                                    <div class="user-activity-status">
                                        <?php if ($request['status'] === 'pending'): ?>
                                            <span class="status-badge warning">Pending</span>
                                        <?php elseif ($request['status'] === 'approved'): ?>
                                            <span class="status-badge success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="status-badge danger">Ditolak</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="user-card-footer">
                            <a href="/requests" class="btn btn-primary btn-sm me-2">
                                <i class="fas fa-list me-1"></i>Lihat Semua
                            </a>
                            <a href="/requests/create" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Buat Baru
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="user-empty-state">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Belum ada permintaan</p>
                            <a href="/requests/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Buat Permintaan Pertama
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-icon bg-success">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h5 class="user-card-title">Pinjaman Saya</h5>
                </div>
                <div class="user-card-content">
                    <?php if (!empty($my_loans)): ?>
                        <div class="user-activity-list">
                            <?php foreach (array_slice($my_loans, 0, 5) as $loan): ?>
                                <div class="user-activity-item">
                                    <div class="user-activity-info">
                                        <div class="user-activity-title"><?= $loan['loan_number'] ?></div>
                                        <div class="user-activity-date"><?= date('d/m/Y', strtotime($loan['return_date'])) ?></div>
                                    </div>
                                    <div class="user-activity-status">
                                        <?php if ($loan['status'] === 'active'): ?>
                                            <?php if ($loan['return_date'] < date('Y-m-d')): ?>
                                                <span class="status-badge danger">Terlambat</span>
                                            <?php else: ?>
                                                <span class="status-badge primary">Aktif</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="status-badge success">Dikembalikan</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="user-card-footer">
                            <a href="/loans" class="btn btn-success btn-sm">
                                <i class="fas fa-list me-1"></i>Lihat Semua
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="user-empty-state">
                            <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada pinjaman</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-card-icon bg-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 class="user-card-title">Laporan Kerusakan Saya</h5>
                </div>
                <div class="user-card-content">
                    <?php if (!empty($my_damage_reports)): ?>
                        <div class="user-activity-list">
                            <?php foreach (array_slice($my_damage_reports, 0, 5) as $damage): ?>
                                <div class="user-activity-item">
                                    <div class="user-activity-info">
                                        <div class="user-activity-title"><?= $damage['report_number'] ?></div>
                                        <div class="user-activity-date"><?= substr($damage['item_name'], 0, 20) ?><?= strlen($damage['item_name']) > 20 ? '...' : '' ?></div>
                                    </div>
                                    <div class="user-activity-status">
                                        <?php if ($damage['status'] === 'pending'): ?>
                                            <span class="status-badge warning">Pending</span>
                                        <?php elseif ($damage['status'] === 'verified'): ?>
                                            <span class="status-badge info">Verified</span>
                                        <?php elseif ($damage['status'] === 'approved'): ?>
                                            <span class="status-badge success">Approved</span>
                                        <?php else: ?>
                                            <span class="status-badge secondary"><?= ucfirst($damage['status']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="user-card-footer">
                            <a href="/damage-reports" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-list me-1"></i>Lihat Semua
                            </a>
                            <a href="/damage-reports/create" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-plus me-1"></i>Laporkan Kerusakan
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="user-empty-state">
                            <i class="fas fa-shield-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Belum ada laporan kerusakan</p>
                            <a href="/damage-reports/create" class="btn btn-warning">
                                <i class="fas fa-plus me-2"></i>Laporkan Kerusakan
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $this->endSection(); ?>