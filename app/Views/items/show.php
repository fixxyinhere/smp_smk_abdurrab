<?php
// File: app/Views/items/show.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <?php if (session()->get('role') !== 'user'): ?>
                <a href="/items/edit/<?= $item['id'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
            <?php endif; ?>
            <a href="/items" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Gambar Barang</h5>
            </div>
            <div class="card-body text-center">
                <?php if ($item['image']): ?>
                    <img src="/uploads/items/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="img-fluid rounded">
                <?php else: ?>
                    <div class="text-muted">
                        <i class="fas fa-image fa-4x mb-3"></i>
                        <p>Tidak ada gambar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Barang</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><strong>Kode Barang</strong></td>
                        <td>: <?= $item['code'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Barang</strong></td>
                        <td>: <?= $item['name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>: <?= $item['category_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>: <?= $item['description'] ?: '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td>: <?= $item['quantity'] ?> unit</td>
                    </tr>
                    <tr>
                        <td><strong>Kondisi</strong></td>
                        <td>:
                            <?php if ($item['condition_status'] === 'baik'): ?>
                                <span class="badge bg-success">Baik</span>
                            <?php elseif ($item['condition_status'] === 'rusak'): ?>
                                <span class="badge bg-warning">Rusak</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Hilang</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi</strong></td>
                        <td>: <?= $item['location'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Harga</strong></td>
                        <td>: Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pembelian</strong></td>
                        <td>: <?= $item['purchase_date'] ? date('d/m/Y', strtotime($item['purchase_date'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Oleh</strong></td>
                        <td>: <?= $item['created_by_name'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Dibuat</strong></td>
                        <td>: <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Diupdate</strong></td>
                        <td>: <?= date('d/m/Y H:i', strtotime($item['updated_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>