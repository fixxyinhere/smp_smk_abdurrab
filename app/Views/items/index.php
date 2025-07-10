<?php
// File: app/Views/items/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <?php if (session()->get('role') !== 'user'): ?>
            <a href="/items/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Barang
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
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['code'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['category_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>
                                <?php if ($item['condition_status'] === 'baik'): ?>
                                    <span class="badge bg-success">Baik</span>
                                <?php elseif ($item['condition_status'] === 'rusak'): ?>
                                    <span class="badge bg-warning">Rusak</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Hilang</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $item['location'] ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="/items/show/<?= $item['id'] ?>" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (session()->get('role') !== 'user'): ?>
                                        <a href="/items/edit/<?= $item['id'] ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/items/delete/<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete">
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