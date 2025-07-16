<?php
// File: app/Views/items/import.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Import Data Barang dari Excel</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/items" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-excel me-2 text-success"></i>
                    Upload File Excel
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>Petunjuk Import:
                    </h6>
                    <ol class="mb-0">
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data sesuai format yang sudah disediakan</li>
                        <li>Pastikan semua kategori sudah ada di sistem</li>
                        <li>Upload file Excel yang sudah diisi</li>
                        <li>Sistem akan memvalidasi dan mengimpor data secara otomatis</li>
                    </ol>
                </div>

                <form action="/items/process-import" method="post" enctype="multipart/form-data" id="importForm">
                    <div class="mb-4">
                        <label for="excel_file" class="form-label">
                            <strong>Pilih File Excel <span class="text-danger">*</span></strong>
                        </label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file"
                            accept=".xlsx,.xls" required>
                        <div class="form-text">
                            Format yang didukung: .xlsx, .xls (Maksimal 10MB)
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirm_backup" required>
                            <label class="form-check-label" for="confirm_backup">
                                <strong>Saya telah membackup data dan memahami proses import ini</strong>
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success" id="importBtn">
                            <i class="fas fa-upload me-2"></i>Import Data
                        </button>
                        <a href="/items" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Template Download Card -->
        <div class="card border-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>Download Template
                </h6>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-file-excel fa-3x text-success mb-3"></i>
                <p class="card-text">Download template Excel untuk memudahkan proses import data barang.</p>
                <a href="/items/download-template" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download Template
                </a>
            </div>
        </div>

        <!-- Format Guide Card -->
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Format Data Excel
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>Kolom A:</strong></td>
                        <td>Kode Barang*</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom B:</strong></td>
                        <td>Nama Barang*</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom C:</strong></td>
                        <td>Kategori*</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom D:</strong></td>
                        <td>Deskripsi</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom E:</strong></td>
                        <td>Jumlah</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom F:</strong></td>
                        <td>Kondisi</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom G:</strong></td>
                        <td>Lokasi</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom H:</strong></td>
                        <td>Tanggal Beli</td>
                    </tr>
                    <tr>
                        <td><strong>Kolom I:</strong></td>
                        <td>Harga</td>
                    </tr>
                </table>
                <small class="text-muted">
                    <strong>*</strong> = Kolom wajib diisi
                </small>
            </div>
        </div>

        <!-- Categories Reference -->
        <div class="card border-warning mt-4">
            <div class="card-header bg-warning text-dark">
                <h6 class="card-title mb-0">
                    <i class="fas fa-tags me-2"></i>Daftar Kategori
                </h6>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-2">Pastikan kategori yang digunakan sesuai dengan daftar di bawah:</p>
                <div class="list-group list-group-flush">
                    <?php foreach ($categories as $category): ?>
                        <div class="list-group-item px-0 py-1">
                            <span class="badge bg-secondary me-2"><?= $category['id'] ?></span>
                            <?= $category['name'] ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="card border-danger mt-4">
            <div class="card-header bg-danger text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Catatan Penting
                </h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Kode barang harus unik (tidak boleh sama)</li>
                    <li>Kondisi harus: <code>baik</code>, <code>rusak</code>, atau <code>hilang</code></li>
                    <li>Format tanggal: YYYY-MM-DD atau DD/MM/YYYY</li>
                    <li>Harga harus berupa angka (tanpa titik/koma)</li>
                    <li>Jika import gagal, periksa format data</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
        // File validation
        $('#excel_file').change(function() {
            const file = this.files[0];
            const fileInput = $(this);
            const allowedTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                'application/vnd.ms-excel' // .xls
            ];

            if (file) {
                // Check file type
                if (!allowedTypes.includes(file.type)) {
                    alert('File harus berformat Excel (.xlsx atau .xls)');
                    fileInput.val('');
                    return;
                }

                // Check file size (10MB = 10 * 1024 * 1024 bytes)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    fileInput.val('');
                    return;
                }

                // Show file info
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                fileInput.next('.form-text').html(
                    `File dipilih: <strong>${file.name}</strong> (${fileSize} MB)`
                );
            }
        });

        // Form submission with loading state
        $('#importForm').submit(function(e) {
            const file = $('#excel_file')[0].files[0];
            const checkbox = $('#confirm_backup').is(':checked');

            if (!file) {
                e.preventDefault();
                alert('Silakan pilih file Excel terlebih dahulu');
                return;
            }

            if (!checkbox) {
                e.preventDefault();
                alert('Silakan centang konfirmasi terlebih dahulu');
                return;
            }

            // Show loading state
            const btn = $('#importBtn');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sedang mengimpor...').prop('disabled', true);

            // Show progress message
            $('<div class="alert alert-info mt-3" id="progressAlert">' +
                '<i class="fas fa-clock me-2"></i>Sedang memproses file Excel, mohon tunggu...' +
                '</div>').insertAfter('#importForm');

            // Note: Don't prevent default submission, let it proceed normally
            // The loading state will be maintained until page redirect
        });

        // Download template with loading state
        $('a[href="/items/download-template"]').click(function() {
            const btn = $(this);
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Preparing...').addClass('disabled');

            setTimeout(function() {
                btn.html(originalText).removeClass('disabled');
            }, 3000);
        });

        // Auto-hide alerts after 10 seconds
        setTimeout(function() {
            $('.alert').not('#progressAlert').fadeOut('slow');
        }, 10000);
    });
</script>
<?php $this->endSection(); ?>