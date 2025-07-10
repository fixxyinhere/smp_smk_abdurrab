<?php
// File: app/Views/loans/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $role === 'user' ? 'Pinjaman Saya' : 'Data Pinjaman' ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <?php if ($role !== 'user'): ?>
            <a href="/loans/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Buat Pinjaman
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No. Pinjaman</th>
                        <?php if ($role !== 'user'): ?>
                            <th>Peminjam</th>
                        <?php endif; ?>
                        <th>No. Permintaan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?= $loan['loan_number'] ?></td>
                            <?php if ($role !== 'user'): ?>
                                <td><?= $loan['user_name'] ?></td>
                            <?php endif; ?>
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
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/loans/show/<?= $loan['id'] ?>" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($loan['status'] === 'active' && $role !== 'user'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#returnModal<?= $loan['id'] ?>">
                                            <i class="fas fa-undo"></i> Kembalikan
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($loan['status'] === 'returned' && $role !== 'user'): ?>
                                        <a href="/loans/delete/<?= $loan['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <!-- Return Modal -->
                        <?php if ($loan['status'] === 'active' && $role !== 'user'): ?>
                            <div class="modal fade" id="returnModal<?= $loan['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
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
                                                <p>Pastikan untuk mengecek kondisi barang sebelum mengembalikan.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Kembalikan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>