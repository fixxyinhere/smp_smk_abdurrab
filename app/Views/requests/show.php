<?php
// File: app/Views/requests/show.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Permintaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <?php if ($request['status'] === 'pending' && $role !== 'user'): ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                    <i class="fas fa-check me-2"></i>Setujui
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-2"></i>Tolak
                </button>
            <?php endif; ?>
            <a href="/requests" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Permintaan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nomor Permintaan</strong></td>
                        <td>: <?= $request['request_number'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Pemohon</strong></td>
                        <td>: <?= $request['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Permintaan</strong></td>
                        <td>: <?= date('d/m/Y', strtotime($request['request_date'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tujuan</strong></td>
                        <td>: <?= $request['purpose'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:
                            <?php if ($request['status'] === 'pending'): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif ($request['status'] === 'approved'): ?>
                                <span class="badge bg-success">Disetujui</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ($request['approved_by']): ?>
                        <tr>
                            <td><strong>Disetujui Oleh</strong></td>
                            <td>: <?= $request['approver_name'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Disetujui</strong></td>
                            <td>: <?= date('d/m/Y H:i', strtotime($request['approved_at'])) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($request['notes']): ?>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>: <?= $request['notes'] ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

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
                            <h6>Permintaan Dibuat</h6>
                            <p class="text-muted"><?= date('d/m/Y H:i', strtotime($request['created_at'])) ?></p>
                        </div>
                    </div>

                    <?php if ($request['status'] !== 'pending'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker <?= $request['status'] === 'approved' ? 'bg-success' : 'bg-danger' ?>"></div>
                            <div class="timeline-content">
                                <h6><?= $request['status'] === 'approved' ? 'Disetujui' : 'Ditolak' ?></h6>
                                <p class="text-muted"><?= date('d/m/Y H:i', strtotime($request['approved_at'])) ?></p>
                                <small>oleh <?= $request['approver_name'] ?></small>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Barang yang Diminta</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Diminta</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($request_items as $item): ?>
                                <tr>
                                    <td><?= $item['item_code'] ?></td>
                                    <td><?= $item['item_name'] ?></td>
                                    <td><?= $item['quantity'] ?> unit</td>
                                    <td><?= $item['notes'] ?: '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<?php if ($request['status'] === 'pending' && $role !== 'user'): ?>
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/requests/approve/<?= $request['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menyetujui permintaan ini?</p>
                        <div class="mb-3">
                            <label for="approve_notes" class="form-label">Catatan (opsional)</label>
                            <textarea class="form-control" id="approve_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Setujui</button>
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
                    <h5 class="modal-title">Tolak Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/requests/reject/<?= $request['id'] ?>" method="post">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak permintaan ini?</p>
                        <div class="mb-3">
                            <label for="reject_notes" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reject_notes" name="notes" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
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