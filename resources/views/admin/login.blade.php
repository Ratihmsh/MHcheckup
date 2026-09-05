<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Ariva Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1a56db 50%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #1a56db, #1e40af);
            padding: 32px 36px 28px;
            text-align: center;
        }

        .login-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.8rem;
        }

        .login-body { padding: 32px 36px; }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            padding: 11px 14px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.88rem;
            color: #374151;
            margin-bottom: 6px;
        }

        .btn-login {
            background: linear-gradient(135deg, #1a56db, #1e40af);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            padding: 12px;
            font-size: 1rem;
            width: 100%;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26,86,219,0.3);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            background: #f8fafc;
            color: #64748b;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        .input-group .form-control:focus {
            border-left: none;
        }

        .toggle-password {
            border-radius: 0 10px 10px 0 !important;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            background: #f8fafc;
            color: #64748b;
            cursor: pointer;
        }
        .toggle-password:hover { background: #e2e8f0; }
    </style>
</head>
<body>

<div class="login-card">

    {{-- HEADER --}}
    <div class="login-header">
        <div class="login-icon">
            <i class="bi bi-shield-lock-fill text-white"></i>
        </div>
        <h5 class="text-white fw-bold mb-1">Panel Admin</h5>
        <p class="text-white-50 small mb-0">Biro Psikologi Ariva Consulta</p>
    </div>

    {{-- BODY --}}
    <div class="login-body">

        @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4" style="font-size:0.88rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger rounded-3 mb-4" style="font-size:0.88rem;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            {{-- EMAIL --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" name="email" class="form-control"
                        placeholder="admin@ariva.com"
                        value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            {{-- PASSWORD --}}
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="password" id="passwordInput"
                        class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn toggle-password"
                        onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            {{-- SUBMIT --}}
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Dashboard
            </button>

        </form>

        <div class="text-center mt-4">
            <a href="{{ route('biodata') }}" class="text-secondary small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Halaman Tes
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
</body>
</html>
