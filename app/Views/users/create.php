<?php
// File: app/Views/users/create.php
$this->extend('layout/template');
$this->section('content');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Pengguna</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/users" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="/users/store" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="081234567890" required>
                                <small class="form-text text-muted">Format: 081234567890 (tanpa tanda +62)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="kepsek" <?= old('role') == 'kepsek' ? 'selected' : '' ?>>Kepala Sekolah</option>
                                    <option value="user" <?= old('role') == 'user' ? 'selected' : '' ?>>User</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                        <a href="/users" class="btn btn-secondary">Batal</a>
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
        // Phone number formatting
        $('#phone').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Remove non-digits

            // Ensure it starts with 08 if user types 8
            if (value.length > 0 && value.charAt(0) === '8') {
                value = '0' + value;
            }

            $(this).val(value);
        });

        // Validate phone number on form submit
        $('form').submit(function(e) {
            const phone = $('#phone').val();

            if (phone.length < 10 || phone.length > 15) {
                e.preventDefault();
                alert('Nomor HP harus antara 10-15 digit');
                $('#phone').focus();
                return false;
            }

            if (!phone.match(/^0[8-9][0-9]+$/)) {
                e.preventDefault();
                alert('Nomor HP harus dimulai dengan 08 atau 09');
                $('#phone').focus();
                return false;
            }
        });
    });
</script>
<?php $this->endSection(); ?>