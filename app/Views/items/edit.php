<?php
// File: app/Views/items/edit.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/items" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/items/update/<?= $item['id'] ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="code" value="<?= $item['code'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= $item['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                            <?= $category['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $item['name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= $item['description'] ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $item['quantity'] ?>" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="condition_status" class="form-label">Kondisi <span class="text-danger">*</span></label>
                                <select class="form-select" id="condition_status" name="condition_status" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="baik" <?= $item['condition_status'] == 'baik' ? 'selected' : '' ?>>Baik</option>
                                    <option value="rusak" <?= $item['condition_status'] == 'rusak' ? 'selected' : '' ?>>Rusak</option>
                                    <option value="hilang" <?= $item['condition_status'] == 'hilang' ? 'selected' : '' ?>>Hilang</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= $item['price'] ?>" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="<?= $item['location'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?= $item['purchase_date'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Barang</label>
                        <?php if ($item['image']): ?>
                            <div class="mb-2">
                                <img src="/uploads/items/<?= $item['image'] ?>" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <a href="/items" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>