<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lupa Password - Pondok Pesantren Nurussyam</title>

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
            <span class="preloader-tagline">Pemulihan Akun Pengelola</span>
        </div>
    </div>

    <div class="login-card">
        <div class="login-card-header">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurussyam" class="login-logo">
            <h1 class="login-title">LUPA PASSWORD</h1>
            <p class="login-subtitle">Masukkan email terdaftar untuk menerima kode verifikasi</p>
        </div>

        <div class="login-card-body">
            @if(session('success'))
                <div class="adm-alert adm-alert-success" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-circle-check adm-alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('info'))
                <div class="adm-alert adm-alert-info" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-circle-info adm-alert-icon"></i>
                    <div>{{ session('info') }}</div>
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

            <form action="{{ route('admin.password.email') }}" method="POST" autocomplete="off" id="forgotForm">
                @csrf

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="email" class="form-label">Email Akun Pengelola</label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Contoh: admin@nurussyam.ponpes.id" required autofocus autocomplete="email">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    </div>
                    <small style="color: var(--adm-text-muted); font-size: 0.78rem; margin-top: 5px; display: block;">
                        <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i> Sistem akan mengirim 6-digit kode verifikasi ke email ini.
                    </small>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Kode Verifikasi</span>
                </button>
            </form>

            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--adm-border); display: flex; justify-content: space-between; align-items: center; font-size: 0.82rem;">
                <a href="{{ route('admin.login') }}" style="color: var(--adm-primary); font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Login</span>
                </a>
                <a href="{{ route('home') }}" style="color: var(--adm-text-muted); text-decoration: none;">
                    Ke Beranda Website
                </a>
            </div>
        </div>
    </div>

    <script>
        const forgotForm = document.getElementById('forgotForm');
        const submitBtn = document.getElementById('submitBtn');
        if (forgotForm && submitBtn) {
            forgotForm.addEventListener('submit', function () {
                if (forgotForm.checkValidity && !forgotForm.checkValidity()) return;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Mengirim Kode...</span>';
                forgotForm.submit();
            });
        }
    </script>
    <script src="{{ asset('js/preloader.js') }}?v=2.4"></script>
</body>
</html>

