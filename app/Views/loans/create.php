<?php
// File: app/Views/loans/create.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Pinjaman</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/loans" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="/loans/store" method="post" id="loanForm">
                    <?php if (isset($request)): ?>
                        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Pinjaman dari Permintaan</h6>
                            <p class="mb-0">Nomor Permintaan: <strong><?= $request['request_number'] ?></strong></p>
                            <p class="mb-0">Pemohon: <strong><?= $request['user_name'] ?></strong></p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="loan_number" class="form-label">Nomor Pinjaman</label>
                                <input type="text" class="form-control" id="loan_number" value="<?= $loan_number ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="loan_date" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="loan_date" name="loan_date" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="return_date" class="form-label">Tanggal Kembali <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="return_date" name="return_date" required>
                            </div>
                        </div>
                    </div>

                    <?php if (!isset($request)): ?>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Peminjam <span class="text-danger">*</span></label>
                            <select class="form-select select2" id="user_id" name="user_id" required>
                                <option value="">Pilih Peminjam</option>
                                <?php if (isset($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>">
                                            <?= $user['full_name'] ?> (<?= $user['username'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="user_id" value="<?= $request['user_id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><?= old('notes') ?></textarea>
                    </div>

                    <hr>

                    <h5>Daftar Barang yang Dipinjamkan</h5>

                    <?php if (isset($request_items)): ?>
                        <!-- From Request -->
                        <?php foreach ($request_items as $index => $item): ?>
                            <div class="item-row mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Barang</label>
                                        <input type="hidden" name="items[]" value="<?= $item['item_id'] ?>">
                                        <input type="text" class="form-control" value="<?= $item['item_name'] ?> (<?= $item['item_code'] ?>)" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Jumlah</label>
                                        <input type="hidden" name="quantities[]" value="<?= $item['quantity'] ?>">
                                        <input type="text" class="form-control" value="<?= $item['quantity'] ?>" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Kondisi Sebelum</label>
                                        <select class="form-select" name="conditions[]" required>
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Catatan</label>
                                        <input type="text" class="form-control" name="item_notes[]" value="<?= $item['notes'] ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <!-- Manual Input -->
                        <div id="itemsContainer">
                            <div class="item-row mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Barang <span class="text-danger">*</span></label>
                                        <select class="form-select select2" name="items[]" required>
                                            <option value="">Pilih Barang</option>
                                            <?php foreach ($items as $item): ?>
                                                <option value="<?= $item['id'] ?>" data-quantity="<?= $item['quantity'] ?>">
                                                    <?= $item['name'] ?> (<?= $item['code'] ?>) - Tersedia: <?= $item['quantity'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="quantities[]" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Kondisi</label>
                                        <select class="form-select" name="conditions[]" required>
                                            <option value="baik">Baik</option>
                                            <option value="rusak">Rusak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Catatan</label>
                                        <input type="text" class="form-control" name="item_notes[]">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-outline-danger remove-item" disabled>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="addItem">
                                <i class="fas fa-plus me-2"></i>Tambah Barang
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-handshake me-2"></i>Buat Pinjaman
                        </button>
                        <a href="/loans" class="btn btn-secondary">Batal</a>
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
        // Set minimum return date (tomorrow)
        $('#return_date').attr('min', new Date(new Date().getTime() + 24 * 60 * 60 * 1000).toISOString().split('T')[0]);

        <?php if (!isset($request_items)): ?>
            // Add new item row
            $('#addItem').click(function() {
                const newRow = $('.item-row:first').clone();
                newRow.find('select').val('').trigger('change');
                newRow.find('input').val('');
                newRow.find('.remove-item').prop('disabled', false);
                $('#itemsContainer').append(newRow);

                // Reinitialize select2 for new row
                newRow.find('.select2').select2({
                    theme: 'bootstrap-5'
                });

                updateRemoveButtons();
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                $(this).closest('.item-row').remove();
                updateRemoveButtons();
            });

            // Update remove buttons
            function updateRemoveButtons() {
                const rows = $('.item-row');
                if (rows.length === 1) {
                    rows.find('.remove-item').prop('disabled', true);
                } else {
                    rows.find('.remove-item').prop('disabled', false);
                }
            }

            // Validate quantity against available stock
            $(document).on('change', 'select[name="items[]"]', function() {
                const selectedOption = $(this).find(':selected');
                const maxQuantity = selectedOption.data('quantity');
                const quantityInput = $(this).closest('.row').find('input[name="quantities[]"]');

                if (maxQuantity) {
                    quantityInput.attr('max', maxQuantity);
                    quantityInput.attr('placeholder', `Max: ${maxQuantity}`);
                }
            });
        <?php endif; ?>
    });
</script>
<?php $this->endSection(); ?>