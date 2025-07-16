<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Sarana Prasarana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-gradient-hover: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-primary: 0 8px 32px rgba(102, 126, 234, 0.3);
            --shadow-hover: 0 12px 40px rgba(102, 126, 234, 0.4);
            --shadow-form: 0 25px 50px rgba(0, 0, 0, 0.25);
            --border-radius: 16px;
            --border-radius-lg: 24px;
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

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
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-form);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            overflow: hidden;
            display: none;
        }

        .login-header {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .login-header h2 {
            color: white;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-size: 2.8rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.3rem;
            margin-bottom: 0;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            font-weight: 300;
        }

        .login-options {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .login-button {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 2px solid var(--glass-border);
            border-radius: var(--border-radius);
            padding: 1.8rem 3.5rem;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 380px;
            max-width: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.1);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .login-button:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            color: white;
            text-decoration: none;
        }

        .login-button:hover::before {
            left: 0;
        }

        .login-button:active {
            transform: translateY(-2px) scale(1.01);
        }

        .login-button i {
            margin-right: 0.75rem;
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }

        .login-button:hover i {
            transform: scale(1.1);
        }

        .login-form {
            display: none;
            margin-top: 2rem;
            padding: 3rem;
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-form);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            width: 100%;
            max-width: 450px;
            animation: slideInUp 0.6s ease-out;
        }

        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: var(--border-radius);
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            height: 65px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
        }

        .form-control:focus {
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1),
                0 8px 25px rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.15);
            color: white;
            outline: none;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-right: none;
            color: rgba(255, 255, 255, 0.8);
            border-radius: var(--border-radius) 0 0 var(--border-radius);
            padding: 1.25rem 1rem;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-submit {
            background: var(--primary-gradient);
            border: none;
            border-radius: var(--border-radius);
            padding: 1.25rem 2.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient-hover);
            transition: left 0.4s ease;
            z-index: -1;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .btn-submit:hover::before {
            left: 0;
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            padding: 0.9rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
        }

        .alert {
            background: rgba(248, 215, 218, 0.95);
            border: 1px solid rgba(245, 198, 203, 0.9);
            border-radius: var(--border-radius);
            backdrop-filter: blur(10px);
            animation: slideInDown 0.5s ease-out;
        }

        .background-credit {
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            background: var(--glass-bg);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            backdrop-filter: blur(20px);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            border: 1px solid var(--glass-border);
            font-weight: 500;
        }

        /* Loading Animation */
        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }

            .login-header {
                padding: 2rem 1rem 1rem;
                margin-bottom: 3rem;
            }

            .login-header h2 {
                font-size: 2.2rem;
            }

            .login-header p {
                font-size: 1.1rem;
            }

            .login-form {
                padding: 2rem;
                margin-top: 1.5rem;
            }

            .login-button {
                width: 100%;
                padding: 1.5rem 2.5rem;
                font-size: 1rem;
            }

            .form-control {
                padding: 1.1rem 1.25rem;
                height: 60px;
            }

            .background-credit {
                bottom: 10px;
                left: 10px;
                right: 10px;
                text-align: center;
                font-size: 0.8rem;
                padding: 0.75rem 1rem;
            }
        }

        /* Enhanced focus states */
        .login-button:focus,
        .btn-submit:focus,
        .btn-back:focus {
            outline: 2px solid rgba(255, 255, 255, 0.5);
            outline-offset: 2px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="background-credit">
        <i class="fas fa-graduation-cap me-2"></i>
        Selamat datang di Sistem Manajemen Sarana & Prasarana SMK Abdurrab
    </div>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Sistem Manajemen</h2>
                <p>Sarana dan Prasarana</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="login-options" id="loginOptions">
                <button class="login-button" onclick="showLoginForm('user')">
                    <i class="fas fa-user"></i>
                    <small> Login sebagai User </small>
                </button>

                <button class="login-button" onclick="showLoginForm('admin')">
                    <i class="fas fa-user-shield"></i>
                    <small>Login sebagai Admin/Kepsek </small>
                </button>
            </div>

            <div class="login-form" id="loginForm">
                <form action="/auth/login" method="post" id="loginFormElement">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        <button class="btn" type="button" onclick="togglePassword()" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,0.7); z-index: 10;">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            <span>Masuk</span>
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <button class="btn btn-back" onclick="hideLoginForm()">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoginForm(type) {
            document.getElementById('loginOptions').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';

            // Pre-fill placeholder based on type
            const usernameField = document.getElementById('username');
            if (type === 'user') {
                usernameField.placeholder = 'Masukkan username user';
            } else {
                usernameField.placeholder = 'Masukkan username admin/kepsek';
            }

            // Focus on username field
            setTimeout(() => {
                usernameField.focus();
            }, 300);
        }

        function hideLoginForm() {
            document.getElementById('loginOptions').style.display = 'flex';
            document.getElementById('loginForm').style.display = 'none';

            // Clear form
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';

            // Remove loading state
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.classList.remove('loading');
            submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i><span>Masuk</span>';
        }

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('loginFormElement').addEventListener('submit', function(e) {
            const submitBtn = document.querySelector('.btn-submit');
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = '<span>Memproses...</span>';
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            // ESC key to go back
            if (e.key === 'Escape') {
                const loginForm = document.getElementById('loginForm');
                if (loginForm.style.display === 'block') {
                    hideLoginForm();
                }
            }

            // Enter key on login buttons
            if (e.key === 'Enter' && e.target.classList.contains('login-button')) {
                e.target.click();
            }
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        }, 5000);

        // Add floating label effect
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Smooth scroll prevention for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent form submission on enter in text fields (except submit button)
            document.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && e.target.type !== 'submit' && e.target.tagName !== 'BUTTON') {
                    const form = e.target.closest('form');
                    if (form) {
                        const submitBtn = form.querySelector('[type="submit"]');
                        if (submitBtn && document.activeElement !== submitBtn) {
                            e.preventDefault();
                            submitBtn.click();
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>