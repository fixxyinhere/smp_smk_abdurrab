<?php
// File: app/Views/reports/damages.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Kerusakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-2"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="/reports/export/damages/csv">
                            <i class="fas fa-file-csv me-2 text-success"></i>Export CSV
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/reports/export/damages/pdf" target="_blank">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>Export PDF
                        </a>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print
            </button>
        </div>
        <a href="/reports" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
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

<!-- Urgent Reports Alert -->
<?php
$urgentReports = array_filter($damages, function ($damage) {
    return $damage['priority'] === 'urgent' && $damage['status'] !== 'resolved';
});
?>
<?php if (!empty($urgentReports)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <h5 class="alert-heading mb-1">⚠️ PERHATIAN: Laporan Prioritas Urgent!</h5>
                <p class="mb-1">Terdapat <strong><?= count($urgentReports) ?> laporan</strong> dengan prioritas urgent yang membutuhkan penanganan segera:</p>
                <ul class="mb-2">
                    <?php foreach (array_slice($urgentReports, 0, 3) as $urgent): ?>
                        <li><strong><?= $urgent['report_number'] ?></strong> - <?= $urgent['item_name'] ?> (<?= ucfirst($urgent['damage_type']) ?>)</li>
                    <?php endforeach; ?>
                    <?php if (count($urgentReports) > 3): ?>
                        <li><em>Dan <?= count($urgentReports) - 3 ?> laporan urgent lainnya...</em></li>
                    <?php endif; ?>
                </ul>
                <a href="/reports/export/damages/pdf" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="fas fa-file-pdf me-1"></i>Cetak Laporan Lengkap
                </a>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

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

<!-- Export Information Card -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Informasi Export
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">
                            <i class="fas fa-file-csv me-2"></i>Export CSV
                        </h6>
                        <ul class="small mb-0">
                            <li>Format data untuk analisis di Excel/Google Sheets</li>
                            <li>Berisi semua field data lengkap</li>
                            <li>Dapat di-filter dan di-sort sesuai kebutuhan</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">
                            <i class="fas fa-file-pdf me-2"></i>Export PDF
                        </h6>
                        <ul class="small mb-0">
                            <li>Format laporan profesional siap print</li>
                            <li>Dilengkapi header sekolah dan statistik</li>
                            <li>Cocok untuk presentasi dan arsip resmi</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-3 p-2 bg-light rounded">
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1"></i>
                        <strong>Tip:</strong> Gunakan filter sebelum export untuk mendapatkan data yang lebih spesifik sesuai kebutuhan laporan Anda.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        .btn-toolbar,
        .sidebar,
        .navbar,
        .card:first-child,
        .card:last-child,
        .row:last-child {
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

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    .dropdown-menu {
        min-width: 180px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    $(document).ready(function() {
        // Add loading state to export buttons
        $('a[href*="/export/"]').click(function() {
            var btn = $(this);
            var originalText = btn.html();

            if (btn.attr('href').includes('pdf')) {
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Generating PDF...');

                // Show info message for PDF
                setTimeout(function() {
                    showNotification('PDF sedang dibuat, jendela baru akan terbuka...', 'info');
                }, 500);
            } else {
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Generating CSV...');
            }

            btn.addClass('disabled');

            setTimeout(function() {
                btn.html(originalText);
                btn.removeClass('disabled');

                if (!btn.attr('href').includes('pdf')) {
                    showNotification('Export CSV berhasil!', 'success');
                }
            }, 2000);
        });

        // Auto-close urgent alert after 10 seconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 10000);

        // Highlight urgent priority rows
        $('tbody tr').each(function() {
            var urgentBadge = $(this).find('.badge.bg-danger');
            if (urgentBadge.length > 0 && urgentBadge.text().includes('Urgent')) {
                $(this).addClass('table-warning');
                $(this).find('td:first').prepend('<i class="fas fa-exclamation-triangle text-danger me-1" title="Prioritas Urgent"></i>');
            }
        });
    });

    function showNotification(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle';

        var notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

        $('body').append(notification);

        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 4000);
    }
</script>

<?php $this->endSection(); ?>