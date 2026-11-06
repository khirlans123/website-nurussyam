<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password - Pondok Pesantren Nurussyam</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ppns.png') }}?v=2">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1.1">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}?v=2.3">

    <style>
        .code-input {
            font-family: Consolas, 'Courier New', monospace !important;
            font-size: 1.5rem !important;
            letter-spacing: 8px !important;
            text-align: center !important;
            font-weight: 800 !important;
            color: #0f8528 !important;
            background-color: #f8fafc !important;
        }
        .code-input:focus {
            background-color: #ffffff !important;
            border-color: #0f8528 !important;
            box-shadow: 0 0 0 3px rgba(15, 133, 40, 0.15) !important;
        }
        .email-pill-box {
            background: #f1f5f9;
            border: 1px solid var(--adm-border);
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body class="admin-login-body">

    <!-- Preloader -->
    <div id="nurussyam-preloader" aria-hidden="true">
        <div class="preloader-ambient-glow"></div>
        <div class="preloader-emblem-wrap">
            <div class="preloader-ring-outer"></div>
            <div class="preloader-ring-inner"></div>
            <div class="preloader-logo-disc">
                <img src="{{ asset('images/logo-ppns-sm.png') }}" alt="Logo Nurussyam" class="preloader-logo-img" width="76" height="76">
            </div>
        </div>
        <div class="preloader-brand">
            <span class="preloader-script-title">Pondok Pesantren</span>
            <h2 class="preloader-main-title">NURUS SYAM</h2>
            <span class="preloader-tagline">Verifikasi Kode & Password Baru</span>
        </div>
    </div>

    <div class="login-card">
        <div class="login-card-header">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurussyam" class="login-logo">
            <h1 class="login-title">RESET PASSWORD</h1>
            <p class="login-subtitle">Masukkan kode 6 digit dari email & password baru</p>
        </div>

        <div class="login-card-body">
            @if(session('success'))
                <div class="adm-alert adm-alert-success" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-circle-check adm-alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('demo_code'))
                <div class="adm-alert adm-alert-info" style="margin-bottom: 1.25rem; background: #ecfdf5; border-color: #a7f3d0; color: #065f46;">
                    <i class="fa-solid fa-key adm-alert-icon" style="color: #059669;"></i>
                    <div>
                        <strong>Kode Verifikasi Anda:</strong>
                        <div style="font-family: monospace; font-size: 1.4rem; font-weight: 800; letter-spacing: 4px; margin-top: 4px; color: #047857;">
                            {{ session('demo_code') }}
                        </div>
                        <small style="color: #047857; font-size: 0.75rem;">(Kode di atas juga otomatis dikirim ke email)</small>
                    </div>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="adm-alert adm-alert-danger" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-circle-xmark adm-alert-icon"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="email-pill-box">
                <div style="display: flex; align-items: center; gap: 8px; overflow: hidden;">
                    <i class="fa-solid fa-envelope" style="color: var(--adm-primary);"></i>
                    <span style="font-weight: 600; color: #0f172a; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                        {{ $email }}
                    </span>
                </div>
                <a href="{{ route('admin.password.request') }}" style="font-size: 0.76rem; color: var(--adm-primary); text-decoration: none; font-weight: 600; white-space: nowrap;">
                    Ubah Email
                </a>
            </div>

            <form action="{{ route('admin.password.update') }}" method="POST" autocomplete="off" id="resetPasswordForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Input Kode 6 Digit -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="token" class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Kode Verifikasi (6 Digit)</span>
                        <span style="font-size: 0.72rem; color: #d97706; font-weight: 600;"><i class="fa-regular fa-clock"></i> 15 Menit</span>
                    </label>
                    <input type="text" id="token" name="token" value="{{ old('token', session('demo_code')) }}" class="form-control code-input @error('token') is-invalid @enderror" placeholder="••••••" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" required autofocus autocomplete="one-time-code">
                    <small style="color: var(--adm-text-muted); font-size: 0.76rem; margin-top: 4px; display: block; text-align: center;">
                        Cek kotak masuk atau folder spam email Anda.
                    </small>
                </div>

                <!-- Input Password Baru -->
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="password" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required autocomplete="new-password">
                        <button type="button" class="input-group-text" id="togglePassBtn" style="cursor: pointer; background: transparent; border: 1px solid var(--adm-border); border-left: none;">
                            <i class="fa-regular fa-eye" id="passEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Input Konfirmasi Password Baru -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="password_confirmation" class="form-label">Ulangi Password Baru</label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru" required autocomplete="new-password">
                        <button type="button" class="input-group-text" id="toggleConfirmBtn" style="cursor: pointer; background: transparent; border: 1px solid var(--adm-border); border-left: none;">
                            <i class="fa-regular fa-eye" id="confirmEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" id="savePasswordBtn" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                    <i class="fa-solid fa-lock-open"></i>
                    <span>Simpan Password Baru</span>
                </button>
            </form>

            <!-- Kirim Ulang Kode Option -->
            <div style="margin-top: 1.25rem; text-align: center;">
                <form action="{{ route('admin.password.email') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" style="background: none; border: none; font-size: 0.8rem; color: #64748b; cursor: pointer; text-decoration: underline; padding: 0;">
                        Tidak menerima kode? Kirim ulang kode ke email
                    </button>
                </form>
            </div>

            <div style="margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--adm-border); text-align: center; font-size: 0.82rem;">
                <a href="{{ route('admin.login') }}" style="color: var(--adm-primary); font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Halaman Login</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function setupToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!btn || !input || !icon) return;

            btn.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }

        setupToggle('togglePassBtn', 'password', 'passEyeIcon');
        setupToggle('toggleConfirmBtn', 'password_confirmation', 'confirmEyeIcon');

        // Only allow numbers for code input
        const tokenInput = document.getElementById('token');
        if (tokenInput) {
            tokenInput.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }

        const resetForm = document.getElementById('resetPasswordForm');
        const saveBtn = document.getElementById('savePasswordBtn');
        if (resetForm && saveBtn) {
            resetForm.addEventListener('submit', function () {
                if (resetForm.checkValidity && !resetForm.checkValidity()) return;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Menyimpan Password...</span>';
                resetForm.submit();
            });
        }
    </script>
    <script src="{{ asset('js/preloader.js') }}?v=2.4"></script>
</body>
</html>

