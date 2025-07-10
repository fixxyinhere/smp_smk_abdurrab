<?php
// File: app/Views/damage_reports/create.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporkan Kerusakan Barang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/damage-reports" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    Form Laporan Kerusakan
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Panduan:</strong> Lengkapi form di bawah ini untuk melaporkan kerusakan barang.
                    Sertakan foto jika memungkinkan untuk mempercepat proses verifikasi.
                </div>

                <form action="/damage-reports/store" method="post" enctype="multipart/form-data" id="damageReportForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="report_number" class="form-label">Nomor Laporan</label>
                                <input type="text" class="form-control" id="report_number" value="<?= $report_number ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="incident_date" class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="incident_date" name="incident_date" value="<?= old('incident_date') ?: date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="item_id" class="form-label">Barang yang Rusak <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="item_id" name="item_id" required>
                                    <option value="">Pilih Barang</option>
                                    <?php foreach ($items as $item): ?>
                                        <option value="<?= $item['id'] ?>" <?= old('item_id') == $item['id'] ? 'selected' : '' ?>>
                                            <?= $item['name'] ?> (<?= $item['code'] ?>) - <?= ucfirst($item['condition_status']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity_damaged" class="form-label">Jumlah Rusak <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity_damaged" name="quantity_damaged" value="<?= old('quantity_damaged') ?: 1 ?>" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="damage_type" class="form-label">Jenis Kerusakan <span class="text-danger">*</span></label>
                                <select class="form-select" id="damage_type" name="damage_type" required>
                                    <option value="">Pilih Jenis Kerusakan</option>
                                    <option value="rusak_ringan" <?= old('damage_type') == 'rusak_ringan' ? 'selected' : '' ?>>
                                        Rusak Ringan (masih bisa diperbaiki)
                                    </option>
                                    <option value="rusak_berat" <?= old('damage_type') == 'rusak_berat' ? 'selected' : '' ?>>
                                        Rusak Berat (perlu penggantian)
                                    </option>
                                    <option value="hilang" <?= old('damage_type') == 'hilang' ? 'selected' : '' ?>>
                                        Hilang
                                    </option>
                                    <option value="lainnya" <?= old('damage_type') == 'lainnya' ? 'selected' : '' ?>>
                                        Lainnya
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Prioritas</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>Rendah</option>
                                    <option value="medium" <?= old('priority') == 'medium' ? 'selected' : 'selected' ?>>Sedang</option>
                                    <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>Tinggi</option>
                                    <option value="urgent" <?= old('priority') == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="damage_location" class="form-label">Lokasi Kejadian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="damage_location" name="damage_location" value="<?= old('damage_location') ?>" placeholder="Contoh: Lab Komputer, Ruang Kelas A, Kantor TU" required>
                    </div>

                    <div class="mb-3">
                        <label for="damage_description" class="form-label">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="damage_description" name="damage_description" rows="4" placeholder="Jelaskan secara detail kondisi kerusakan, penyebab (jika diketahui), dan kronologi kejadian..." required><?= old('damage_description') ?></textarea>
                        <div class="form-text">Minimal 10 karakter. Semakin detail, semakin baik.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="estimated_cost" class="form-label">Perkiraan Biaya Perbaikan (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="estimated_cost" name="estimated_cost" value="<?= old('estimated_cost') ?>" min="0">
                                </div>
                                <div class="form-text">Kosongkan jika tidak tahu</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Foto Kerusakan (Opsional)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Format: JPG, PNG, GIF. Maksimal 5MB.</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Pastikan informasi yang diberikan akurat dan lengkap</li>
                            <li>Laporan akan diverifikasi oleh admin sebelum diproses</li>
                            <li>Anda akan mendapat notifikasi status melalui sistem</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                        </button>
                        <a href="/damage-reports" class="btn btn-secondary">Batal</a>
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
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari dan pilih barang...'
        });

        // Auto-adjust priority based on damage type
        $('#damage_type').change(function() {
            const damageType = $(this).val();
            const prioritySelect = $('#priority');

            switch (damageType) {
                case 'hilang':
                    prioritySelect.val('urgent');
                    break;
                case 'rusak_berat':
                    prioritySelect.val('high');
                    break;
                case 'rusak_ringan':
                    prioritySelect.val('medium');
                    break;
                default:
                    prioritySelect.val('medium');
            }
        });

        // Character counter for description
        $('#damage_description').on('input', function() {
            const current = $(this).val().length;
            const min = 10;

            if (current < min) {
                $(this).addClass('is-invalid');
                $(this).next('.form-text').text(`Minimal ${min} karakter. Saat ini: ${current} karakter.`);
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.form-text').text(`${current} karakter. Semakin detail, semakin baik.`);
            }
        });

        // Image preview
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview
                    $('#imagePreview').remove();

                    // Add new preview
                    const preview = `
                    <div id="imagePreview" class="mt-2">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px;">
                        <div class="text-muted small">Preview: ${file.name}</div>
                    </div>
                `;
                    $('#image').after(preview);
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        $('#damageReportForm').submit(function(e) {
            let isValid = true;

            // Check description length
            const description = $('#damage_description').val();
            if (description.length < 10) {
                alert('Deskripsi kerusakan minimal 10 karakter!');
                $('#damage_description').focus();
                isValid = false;
            }

            // Check if incident date is not in future
            const incidentDate = new Date($('#incident_date').val());
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (incidentDate > today) {
                alert('Tanggal kejadian tidak boleh di masa depan!');
                $('#incident_date').focus();
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<?php $this->endSection(); ?>