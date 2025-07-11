<?php
// File: app/Views/reports/index.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan</h1>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-boxes fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Laporan Barang</h5>
                <p class="card-text">Laporan lengkap data barang, kondisi, dan lokasi</p>
                <div class="btn-group-vertical gap-2">
                    <a href="/reports/items" class="btn btn-primary">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                    <div class="btn-group" role="group">
                        <a href="/reports/export/items/csv" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-csv me-1"></i>CSV
                        </a>
                        <a href="/reports/export/items/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i><br>PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-file-alt fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Laporan Permintaan</h5>
                <p class="card-text">Laporan data permintaan dan status persetujuan</p>
                <div class="btn-group-vertical gap-2">
                    <a href="/reports/requests" class="btn btn-success">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                    <div class="btn-group" role="group">
                        <a href="/reports/export/requests/csv" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-csv me-1"></i>CSV
                        </a>
                        <a href="/reports/export/requests/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i><br>PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-handshake fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Laporan Pinjaman</h5>
                <p class="card-text">Laporan data pinjaman dan pengembalian barang</p>
                <div class="btn-group-vertical gap-2">
                    <a href="/reports/loans" class="btn btn-warning">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                    <div class="btn-group" role="group">
                        <a href="/reports/export/loans/csv" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-csv me-1"></i>CSV
                        </a>
                        <a href="/reports/export/loans/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i><br>PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                </div>
                <h5 class="card-title">Laporan Kerusakan</h5>
                <p class="card-text">Laporan data kerusakan barang dan status perbaikan</p>
                <div class="btn-group-vertical gap-2">
                    <a href="/reports/damages" class="btn btn-danger">
                        <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                    </a>
                    <div class="btn-group" role="group">
                        <a href="/reports/export/damages/csv" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-csv me-1"></i>CSV
                        </a>
                        <a href="/reports/export/damages/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i><br>PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (session()->get('role') === 'admin'): ?>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Laporan Pengguna</h5>
                    <p class="card-text">Laporan data pengguna dan aktivitas sistem</p>
                    <div class="btn-group-vertical gap-2">
                        <a href="/reports/users" class="btn btn-info">
                            <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                        </a>
                        <div class="btn-group" role="group">
                            <a href="/reports/export/users/csv" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-file-csv me-1"></i>CSV
                            </a>
                            <a href="/reports/export/users/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-file-pdf me-1"></i><br>PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Professional PDF Info Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-pdf me-2"></i>Export Laporan Profesional
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-primary">Format PDF Profesional</h6>
                        <p class="mb-3">Dapatkan laporan dalam format PDF dengan desain profesional yang mencakup:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Header sekolah resmi</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Statistik lengkap</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Tabel data terstruktur</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Tanda tangan digital</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Ringkasan eksekutif</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Grafik dan chart</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Watermark keamanan</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Auto-print ready</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="bg-light p-4 rounded">
                            <i class="fas fa-award fa-3x text-warning mb-3"></i>
                            <h6 class="text-primary">Standar Profesional</h6>
                            <p class="small text-muted">Format PDF siap untuk presentasi kepada kepala sekolah, dinas pendidikan, atau stakeholder lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Export Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>Quick Export
                </h5>
            </div>
            <div class="card-body">
                <p>Download semua laporan sekaligus dalam format yang Anda butuhkan:</p>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success">
                            <i class="fas fa-file-csv me-2"></i>Format CSV (Excel Compatible)
                        </h6>
                        <div class="btn-group flex-wrap" role="group">
                            <a href="/reports/export/items/csv" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-boxes me-1"></i>Data Barang
                            </a>
                            <a href="/reports/export/requests/csv" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-file-alt me-1"></i>Permintaan
                            </a>
                            <a href="/reports/export/loans/csv" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-handshake me-1"></i>Pinjaman
                            </a>
                            <a href="/reports/export/damages/csv" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-exclamation-triangle me-1"></i>Kerusakan
                            </a>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <a href="/reports/export/users/csv" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-users me-1"></i>Pengguna
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger">
                            <i class="fas fa-file-pdf me-2"></i>Format PDF (Professional Report)
                        </h6>
                        <div class="btn-group flex-wrap" role="group">
                            <a href="/reports/export/items/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-boxes me-1"></i>Data Barang
                            </a>
                            <a href="/reports/export/requests/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-file-alt me-1"></i>Permintaan
                            </a>
                            <a href="/reports/export/loans/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-handshake me-1"></i>Pinjaman
                            </a>
                            <a href="/reports/export/damages/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="fas fa-exclamation-triangle me-1"></i>Kerusakan
                            </a>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <a href="/reports/export/users/pdf" class="btn btn-outline-danger btn-sm" target="_blank">
                                    <i class="fas fa-users me-1"></i>Pengguna
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3 mb-0">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div class="col-md-11">
                            <h6 class="alert-heading mb-1">Tips Export:</h6>
                            <ul class="mb-0 small">
                                <li><strong>CSV:</strong> Cocok untuk analisis data di Excel atau Google Sheets</li>
                                <li><strong>PDF:</strong> Ideal untuk presentasi, arsip, atau laporan resmi</li>
                                <li><strong>Klik tombol PDF:</strong> Akan membuka tab baru dengan opsi print otomatis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group-vertical .btn-group {
        width: 100%;
    }

    .btn-group .btn-sm {
        flex: 1;
    }

    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn-sm {
            margin-bottom: 5px;
            border-radius: 0.375rem !important;
        }
    }

    .card-body .btn-group-vertical .btn {
        margin-bottom: 8px;
    }

    .card-body .btn-group-vertical .btn-group {
        margin-bottom: 0;
    }
</style>

<script>
    $(document).ready(function() {
        // Add loading state to export buttons
        $('a[href*="/export/"]').click(function() {
            var btn = $(this);
            var originalText = btn.html();

            if (btn.attr('href').includes('pdf')) {
                btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Generating PDF...');
            } else {
                btn.html('<i class="fas fa-spinner fa-spin me-1"></i>Generating CSV...');
            }

            btn.addClass('disabled');

            setTimeout(function() {
                btn.html(originalText);
                btn.removeClass('disabled');
            }, 3000);
        });

        // Show success message after export
        setTimeout(function() {
            if (document.referrer.includes('/export/')) {
                showNotification('Export berhasil!', 'success');
            }
        }, 1000);
    });

    function showNotification(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

        var notification = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

        $('body').append(notification);

        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    }
</script>

<?php $this->endSection(); ?>