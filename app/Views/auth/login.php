<?php
// File: app/Views/auth/login.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Sarana Prasarana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('<?= base_url('assets/images/login.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 500px;
            width: 100%;
            padding: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            display: none;
        }

        .login-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .login-header h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .login-body {
            padding: 2rem;
        }

        .login-options {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            align-items: center;
        }

        .login-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            padding: 1.5rem 3rem;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            cursor: pointer;
            display: block;
            text-align: center;
            width: 350px;
            max-width: 100%;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .login-button i {
            margin-right: 0.5rem;
        }

        .login-form {
            display: none;
            margin-top: 2rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
        }

        .btn-back {
            background: #6c757d;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .background-credit {
            position: fixed;
            bottom: 20px;
            left: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            background: rgba(0, 0, 0, 0.4);
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }

            .login-header {
                padding: 2rem 1rem 1rem;
            }

            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Sistem Manajemen</h2>
                <p>Sarana dan Prasarana</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: rgba(248, 215, 218, 0.9); border: 1px solid rgba(245, 198, 203, 0.9); border-radius: 12px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="login-options" id="loginOptions">
                <button class="login-button" onclick="showLoginForm('user')">
                    <i class="fas fa-user"></i>
                    Login sebagai user
                </button>

                <button class="login-button" onclick="showLoginForm('admin')">
                    <i class="fas fa-user-cog"></i>
                    Login sebagai admin/kepsek
                </button>
            </div>

            <div class="login-form" id="loginForm">
                <form action="/auth/login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <button class="btn btn-back" onclick="hideLoginForm()">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                </div>

                <!-- <div class="demo-accounts mt-3" style="background: rgba(248, 249, 250, 0.9); border-radius: 12px; padding: 1rem; font-size: 0.85rem;">
                    <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Akun Demo:</h6>
                    <small>
                        <strong>Admin:</strong> admin / password<br>
                        <strong>Kepsek:</strong> kepsek / password<br>
                        <strong>User:</strong> user / password
                    </small>
                </div> -->
            </div>
        </div>
    </div>

    <div class="background-credit">
        Selamat datang di Sistem Manajemen Sarana & Prasarana SMK Abdurrab
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoginForm(type) {
            document.getElementById('loginOptions').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';

            // Optional: You can pre-fill username based on type
            if (type === 'user') {
                document.getElementById('username').placeholder = 'Masukkan username user';
            } else {
                document.getElementById('username').placeholder = 'Masukkan username admin/kepsek';
            }
        }

        function hideLoginForm() {
            document.getElementById('loginOptions').style.display = 'flex';
            document.getElementById('loginForm').style.display = 'none';

            // Clear form
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        }
    </script>
</body>

</html>