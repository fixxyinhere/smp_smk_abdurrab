<?php
// File: app/Views/loans/show.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Pinjaman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <?php if ($loan['status'] === 'active' && $role !== 'user'): ?>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal">
                    <i class="fas fa-undo me-2"></i>Kembalikan
                </button>
            <?php endif; ?>
            <a href="/loans" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pinjaman</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Nomor Pinjaman</strong></td>
                        <td>: <?= $loan['loan_number'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Permintaan</strong></td>
                        <td>: <?= $loan['request_number'] ?: '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Peminjam</strong></td>
                        <td>: <?= $loan['user_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pinjam</strong></td>
                        <td>: <?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Kembali</strong></td>
                        <td>: <?= date('d/m/Y', strtotime($loan['return_date'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Dikembalikan</strong></td>
                        <td>: <?= $loan['actual_return_date'] ? date('d/m/Y', strtotime($loan['actual_return_date'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>:
                            <?php if ($loan['status'] === 'active'): ?>
                                <?php if ($loan['return_date'] < date('Y-m-d')): ?>
                                    <span class="badge bg-danger">Terlambat</span>
                                    <?php
                                    $returnDate = new DateTime($loan['return_date']);
                                    $today = new DateTime();
                                    $diff = $today->diff($returnDate);
                                    echo " ({$diff->days} hari terlambat)";
                                    ?>
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
                    <?php if ($loan['notes']): ?>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>: <?= $loan['notes'] ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Timeline Pinjaman</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6>Pinjaman Dibuat</h6>
                            <p class="text-muted"><?= date('d/m/Y H:i', strtotime($loan['created_at'])) ?></p>
                        </div>
                    </div>

                    <?php if ($loan['status'] === 'returned'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>Barang Dikembalikan</h6>
                                <p class="text-muted"><?= date('d/m/Y', strtotime($loan['actual_return_date'])) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($loan['status'] === 'active' && $loan['return_date'] < date('Y-m-d')): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="alert alert-danger mb-0">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Peringatan!</h6>
                        <p class="mb-0">Pinjaman ini sudah melewati batas waktu pengembalian.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Daftar Barang yang Dipinjam</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Kondisi Sebelum</th>
                                <th>Kondisi Sesudah</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loan_items as $item): ?>
                                <tr>
                                    <td><?= $item['item_code'] ?></td>
                                    <td><?= $item['item_name'] ?></td>
                                    <td><?= $item['quantity'] ?> unit</td>
                                    <td>
                                        <span class="badge bg-<?= $item['condition_before'] === 'baik' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($item['condition_before']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($item['condition_after']): ?>
                                            <span class="badge bg-<?= $item['condition_after'] === 'baik' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($item['condition_after']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">Belum dikembalikan</span>
                                        <?php endif; ?>
                                    </td>
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

<!-- Return Modal -->
<?php if ($loan['status'] === 'active' && $role !== 'user'): ?>
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kembalikan Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/loans/return/<?= $loan['id'] ?>" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="actual_return_date" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" name="actual_return_date" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <h6>Kondisi Barang Saat Dikembalikan:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Kondisi Sebelum</th>
                                        <th>Kondisi Sesudah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($loan_items as $index => $item): ?>
                                        <tr>
                                            <td><?= $item['item_name'] ?> (<?= $item['quantity'] ?> unit)</td>
                                            <td>
                                                <span class="badge bg-<?= $item['condition_before'] === 'baik' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($item['condition_before']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm" name="conditions_after[]" required>
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak">Rusak</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Kembalikan Pinjaman</button>
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