<?php
// File: app/Views/damage_reports/show.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Laporan Kerusakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <?php if ($report['status'] === 'pending' && $role !== 'user'): ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal">
                    <i class="fas fa-check me-2"></i>Verifikasi
                </button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fas fa-thumbs-up me-2"></i>Setujui
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-2"></i>Tolak
                </button>
            <?php elseif ($report['status'] === 'verified' && $role !== 'user'): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fixedModal">
                    <i class="fas fa-wrench me-2"></i>Tandai Diperbaiki
                </button>
            <?php endif; ?>
            <a href="/damage-reports" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<!-- Status Alert -->
<div class="row mb-4">
    <div class="col-12">
        <?php
        $statusColors = [
            'pending' => 'warning',
            'verified' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
            'fixed' => 'success',
            'replaced' => 'primary'
        ];
        $statusTexts = [
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Telah Diverifikasi',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'fixed' => 'Telah Diperbaiki',
            'replaced' => 'Telah Diganti'
        ];
        ?>
        <div class="alert alert-<?= $statusColors[$report['status']] ?>">
            <h6 class="alert-heading">
                <i class="fas fa-info-circle me-2"></i>
                Status: <?= $statusTexts[$report['status']] ?>
            </h6>
            <?php if ($report['admin_notes']): ?>
                <hr>
                <p class="mb-0"><strong>Catatan Admin:</strong> <?= $report['admin_notes'] ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Information -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Laporan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nomor Laporan</strong></td>
                        <td>: <?= $report['report_number'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Pelapor</strong></td>
                        <td>: <?= $report['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Laporan</strong></td>
                        <td>: <?= date('d/m/Y', strtotime($report['report_date'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Kejadian</strong></td>
                        <td>: <?= date('d/m/Y', strtotime($report['incident_date'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Detail Kerusakan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Barang</strong></td>
                        <td>: <?= $report['item_name'] ?> (<?= $report['item_code'] ?>)</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kerusakan</strong></td>
                        <td>:
                            <?php
                            $damageTypes = [
                                'rusak_ringan' => ['Rusak Ringan', 'warning'],
                                'rusak_berat' => ['Rusak Berat', 'danger'],
                                'hilang' => ['Hilang', 'dark'],
                                'lainnya' => ['Lainnya', 'secondary']
                            ];
                            $type = $damageTypes[$report['damage_type']];
                            ?>
                            <span class="badge bg-<?= $type[1] ?>"><?= $type[0] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Rusak</strong></td>
                        <td>: <?= $report['quantity_damaged'] ?> unit</td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi Kejadian</strong></td>
                        <td>: <?= $report['damage_location'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Prioritas</strong></td>
                        <td>:
                            <?php
                            $priorities = [
                                'low' => ['Rendah', 'secondary'],
                                'medium' => ['Sedang', 'primary'],
                                'high' => ['Tinggi', 'warning'],
                                'urgent' => ['Urgent', 'danger']
                            ];
                            $priority = $priorities[$report['priority']];
                            ?>
                            <span class="badge bg-<?= $priority[1] ?>"><?= $priority[0] ?></span>
                        </td>
                    </tr>
                    <?php if ($report['estimated_cost'] > 0): ?>
                        <tr>
                            <td><strong>Perkiraan Biaya</strong></td>
                            <td>: Rp <?= number_format($report['estimated_cost'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endif; ?>
                </table>

                <div class="mt-3">
                    <strong>Deskripsi Kerusakan:</strong>
                    <div class="mt-2 p-3 bg-light rounded">
                        <?= nl2br(htmlspecialchars($report['damage_description'])) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Section -->
        <?php if ($report['image_path']): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Foto Kerusakan</h5>
                </div>
                <div class="card-body text-center">
                    <img src="/uploads/damage_reports/<?= $report['image_path'] ?>" alt="Foto Kerusakan" class="img-fluid rounded" style="max-height: 400px;">
                    <div class="mt-2">
                        <a href="/uploads/damage_reports/<?= $report['image_path'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Ukuran Penuh
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Timeline & Actions -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6>Laporan Dibuat</h6>
                            <p class="text-muted"><?= date('d/m/Y H:i', strtotime($report['created_at'])) ?></p>
                            <small>oleh <?= $report['user_name'] ?></small>
                        </div>
                    </div>

                    <?php if ($report['verified_at']): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-<?= $report['status'] === 'rejected' ? 'danger' : 'success' ?>"></div>
                            <div class="timeline-content">
                                <h6><?= $report['status'] === 'rejected' ? 'Ditolak' : 'Diverifikasi' ?></h6>
                                <p class="text-muted"><?= date('d/m/Y H:i', strtotime($report['verified_at'])) ?></p>
                                <small>oleh <?= $report['verifier_name'] ?></small>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($report['priority'] === 'urgent'): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="alert alert-danger mb-0">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Prioritas Urgent!</h6>
                        <p class="mb-0">Laporan ini memerlukan penanganan segera.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals for Admin Actions -->
<?php if ($role !== 'user'): ?>

    <!-- Verify Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/damage-reports/verify/<?= $report['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Verifikasi bahwa laporan ini telah diperiksa dan informasinya akurat.</p>
                        <input type="hidden" name="status" value="verified">
                        <div class="mb-3">
                            <label for="verify_notes" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="verify_notes" name="admin_notes" rows="3" placeholder="Catatan hasil verifikasi..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/damage-reports/verify/<?= $report['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Setujui laporan ini untuk dilanjutkan ke proses perbaikan/penggantian.</p>
                        <input type="hidden" name="status" value="approved">
                        <div class="mb-3">
                            <label for="approve_notes" class="form-label">Catatan Persetujuan</label>
                            <textarea class="form-control" id="approve_notes" name="admin_notes" rows="3" placeholder="Instruksi perbaikan atau catatan lainnya..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/damage-reports/verify/<?= $report['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Tolak laporan ini jika informasi tidak akurat atau tidak memerlukan tindakan.</p>
                        <input type="hidden" name="status" value="rejected">
                        <div class="mb-3">
                            <label for="reject_notes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reject_notes" name="admin_notes" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fixed Modal -->
    <div class="modal fade" id="fixedModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tandai Diperbaiki</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/damage-reports/verify/<?= $report['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Tandai bahwa kerusakan telah diperbaiki atau barang telah diganti.</p>
                        <input type="hidden" name="status" value="fixed">
                        <div class="mb-3">
                            <label for="fixed_notes" class="form-label">Catatan Perbaikan</label>
                            <textarea class="form-control" id="fixed_notes" name="admin_notes" rows="3" placeholder="Jelaskan apa yang telah dilakukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tandai Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif; ?>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -35px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .timeline-content h6 {
        margin-bottom: 5px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 6px;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
</style>

<?php $this->endSection(); ?>