<?php
// File: app/Views/requests/create.php (SIMPLIFIED VERSION)
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Permintaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/requests" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <!-- Debug Info -->
                <div class="alert alert-info">
                    <small>
                        Debug: Request Number = <?= $request_number ?> |
                        Available Items = <?= count($items) ?> |
                        User ID = <?= session()->get('user_id') ?>
                    </small>
                </div>

                <form action="<?= base_url('requests/store') ?>" method="post" id="requestForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="request_number" class="form-label">Nomor Permintaan</label>
                                <input type="text" class="form-control" id="request_number" value="<?= $request_number ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="request_date" class="form-label">Tanggal Permintaan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="request_date" name="request_date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label">Tujuan Permintaan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Jelaskan tujuan permintaan barang..." required><?= old('purpose') ?></textarea>
                    </div>

                    <hr>

                    <h5>Daftar Barang yang Diminta</h5>

                    <?php if (empty($items)): ?>
                        <div class="alert alert-warning">
                            <strong>Peringatan:</strong> Tidak ada barang yang tersedia.
                            <a href="/items" class="btn btn-sm btn-primary">Lihat Data Barang</a>
                        </div>
                    <?php else: ?>

                        <!-- Item 1 (Required) -->
                        <div class="item-row mb-3 border p-3 rounded">
                            <h6>Barang 1 <span class="text-danger">*</span></h6>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Pilih Barang</label>
                                    <select class="form-select" name="items[]" required>
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($items as $item): ?>
                                            <option value="<?= $item['id'] ?>">
                                                <?= $item['name'] ?> (<?= $item['code'] ?>) - Tersedia: <?= $item['quantity'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="quantities[]" min="1" max="10" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Catatan (Opsional)</label>
                                    <input type="text" class="form-control" name="notes[]" placeholder="Catatan tambahan">
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 (Optional) -->
                        <div class="item-row mb-3 border p-3 rounded bg-light">
                            <h6>Barang 2 <small class="text-muted">(Opsional)</small></h6>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Pilih Barang</label>
                                    <select class="form-select" name="items[]">
                                        <option value="">Pilih Barang (Opsional)</option>
                                        <?php foreach ($items as $item): ?>
                                            <option value="<?= $item['id'] ?>">
                                                <?= $item['name'] ?> (<?= $item['code'] ?>) - Tersedia: <?= $item['quantity'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="quantities[]" min="1" max="10">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Catatan</label>
                                    <input type="text" class="form-control" name="notes[]" placeholder="Catatan tambahan">
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 (Optional) -->
                        <div class="item-row mb-3 border p-3 rounded bg-light">
                            <h6>Barang 3 <small class="text-muted">(Opsional)</small></h6>
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Pilih Barang</label>
                                    <select class="form-select" name="items[]">
                                        <option value="">Pilih Barang (Opsional)</option>
                                        <?php foreach ($items as $item): ?>
                                            <option value="<?= $item['id'] ?>">
                                                <?= $item['name'] ?> (<?= $item['code'] ?>) - Tersedia: <?= $item['quantity'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="quantities[]" min="1" max="10">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Catatan</label>
                                    <input type="text" class="form-control" name="notes[]" placeholder="Catatan tambahan">
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                        </button>
                        <a href="/requests" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // Simple form validation
        $('#requestForm').submit(function(e) {
            let hasValidItem = false;

            // Check if at least one item is selected with quantity
            $('select[name="items[]"]').each(function(index) {
                const itemValue = $(this).val();
                const quantityValue = $('input[name="quantities[]"]').eq(index).val();

                if (itemValue && quantityValue && quantityValue > 0) {
                    hasValidItem = true;
                    return false; // break loop
                }
            });

            if (!hasValidItem) {
                e.preventDefault();
                alert('Mohon pilih minimal satu barang dengan jumlah yang valid!');
                return false;
            }

            return true;
        });

        // Auto-fill quantity when item selected
        $('select[name="items[]"]').change(function() {
            const index = $('select[name="items[]"]').index(this);
            const quantityInput = $('input[name="quantities[]"]').eq(index);

            if ($(this).val() && !quantityInput.val()) {
                quantityInput.val(1); // Default quantity
            }
        });
    });
</script>
<?php $this->endSection(); ?>