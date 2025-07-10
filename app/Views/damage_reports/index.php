<?php
// File: app/Views/damage_reports/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/damage-reports/create" class="btn btn-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>Laporkan Kerusakan
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>No. Laporan</th>
                        <?php if ($role !== 'user'): ?>
                            <th>Pelapor</th>
                        <?php endif; ?>
                        <th>Barang</th>
                        <th>Jenis Kerusakan</th>
                        <th>Lokasi</th>
                        <th>Tanggal Kejadian</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $report['report_number'] ?></td>
                            <?php if ($role !== 'user'): ?>
                                <td><?= $report['user_name'] ?></td>
                            <?php endif; ?>
                            <td>
                                <strong><?= $report['item_name'] ?></strong><br>
                                <small class="text-muted"><?= $report['item_code'] ?></small>
                            </td>
                            <td>
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
                            <td><?= $report['damage_location'] ?></td>
                            <td><?= date('d/m/Y', strtotime($report['incident_date'])) ?></td>
                            <td>
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
                            <td>
                                <?php
                                $statuses = [
                                    'pending' => ['Pending', 'warning'],
                                    'verified' => ['Diverifikasi', 'info'],
                                    'approved' => ['Disetujui', 'success'],
                                    'rejected' => ['Ditolak', 'danger'],
                                    'fixed' => ['Diperbaiki', 'success'],
                                    'replaced' => ['Diganti', 'primary']
                                ];
                                $status = $statuses[$report['status']];
                                ?>
                                <span class="badge bg-<?= $status[1] ?>"><?= $status[0] ?></span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/damage-reports/show/<?= $report['id'] ?>" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($report['status'] === 'pending' && ($role === 'user' && $report['user_id'] == session()->get('user_id'))): ?>
                                        <a href="/damage-reports/delete/<?= $report['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
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