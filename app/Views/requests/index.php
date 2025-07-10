<?php
// File: app/Views/requests/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $role === 'user' ? 'Permintaan Saya' : 'Data Permintaan' ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/requests/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat Permintaan
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No. Permintaan</th>
                        <?php if ($role !== 'user'): ?>
                            <th>Pemohon</th>
                        <?php endif; ?>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <?php if ($role !== 'user'): ?>
                            <th>Disetujui Oleh</th>
                        <?php endif; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?= $request['request_number'] ?></td>
                            <?php if ($role !== 'user'): ?>
                                <td><?= $request['user_name'] ?></td>
                            <?php endif; ?>
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
                            <?php if ($role !== 'user'): ?>
                                <td><?= $request['approver_name'] ?: '-' ?></td>
                            <?php endif; ?>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/requests/show/<?= $request['id'] ?>" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($request['status'] === 'pending' && ($role === 'user' && $request['user_id'] == session()->get('user_id'))): ?>
                                        <a href="/requests/delete/<?= $request['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($request['status'] === 'approved' && $role !== 'user'): ?>
                                        <a href="/loans/create/<?= $request['id'] ?>" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-handshake"></i> Pinjamkan
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>