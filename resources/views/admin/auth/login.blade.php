<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin - Pondok Pesantren Nurussyam</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ppns.png') }}?v=2">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}?v=2.3">
</head>
<body class="admin-login-body">

    <!-- ======================================================================
         LUXURY ISLAMIC PRELOADER ANIMATION (TRANSPARAN)
         ====================================================================== -->
    <div id="nurussyam-preloader" aria-hidden="true">
        <div class="preloader-ambient-glow"></div>

        <div class="preloader-emblem-wrap">
            <div class="preloader-ring-outer"></div>
            <div class="preloader-ring-inner"></div>
            <div class="preloader-logo-disc">
                @if(!empty($preloaderLogoB64))
                    <img src="data:image/webp;base64,{{ $preloaderLogoB64 }}" alt="Logo Nurussyam" class="preloader-logo-img" width="76" height="76" fetchpriority="high" decoding="sync">
                @else
                    <img src="{{ asset('images/logo-ppns-sm.png') }}" alt="Logo Nurussyam" class="preloader-logo-img" width="76" height="76" fetchpriority="high" decoding="sync">
                @endif
            </div>
        </div>

        <div class="preloader-brand">
            <span class="preloader-script-title">Pondok Pesantren</span>
            <h2 class="preloader-main-title">NURUS SYAM</h2>
            <span class="preloader-tagline">Panel Pengelola &bull; Administrator</span>
        </div>

        <div class="preloader-progress-track">
            <div class="preloader-progress-fill"></div>
        </div>

        <div class="preloader-status-text">
            <i class="fa-solid fa-circle-notch fa-spin"></i> <span>Memuat...</span>
        </div>
    </div>
    <script>
        (function(){
            try {
                var isReload = false;
                if (window.performance) {
                    var nav = performance.getEntriesByType('navigation');
                    if (nav && nav.length > 0) isReload = (nav[0].type === 'reload');
                    else if (performance.navigation) isReload = (performance.navigation.type === 1);
                }
                var isTransition = sessionStorage.getItem('ns_nav_active') === '1' || sessionStorage.getItem('ns_nav_transition') === '1';
                var isAuth = sessionStorage.getItem('ns_auth_active') === '1';
                var isFirst = !sessionStorage.getItem('ns_visited');
                if (isAuth || (!isTransition && (isReload || isFirst))) {
                    var el = document.getElementById('nurussyam-preloader');
                    if (el) {
                        el.classList.add('preloader-active');
                        var fill = el.querySelector('.preloader-progress-fill');
                        if (fill) fill.style.width = '35%';
                    }
                }
            } catch(e){}
        })();
    </script>

    <div class="login-card">
        <div class="login-card-header">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurussyam" class="login-logo">
            <h1 class="login-title">LOGIN PENGELOLA</h1>
            <p class="login-subtitle">Pondok Pesantren Nurussyam Wringin Bondowoso</p>
        </div>

        <div class="login-card-body">
            @if(session('success'))
                <div class="adm-alert adm-alert-success" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-circle-check adm-alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('warning'))
                <div class="adm-alert adm-alert-warning" style="margin-bottom: 1.25rem;">
                    <i class="fa-solid fa-triangle-exclamation adm-alert-icon"></i>
                    <div>{{ session('warning') }}</div>
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

            <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Pengelola</label>
                    <div class="input-group">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan alamat email pengelola" required autofocus autocomplete="off">
                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password admin" required autocomplete="new-password">
                        <button type="button" class="input-group-text" id="togglePasswordBtn" style="cursor: pointer; background: transparent; border: 1px solid var(--adm-border); border-left: none;">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: var(--adm-text-muted); cursor: pointer;">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                    <a href="{{ route('admin.password.request') }}" style="font-size: 0.82rem; color: var(--adm-primary); font-weight: 600; text-decoration: none;">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" id="loginSubmitBtn" class="btn btn-primary" style="width: 100%; padding: 0.75rem; font-size: 0.95rem;">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--adm-border); text-align: center;">
                <a href="{{ route('home') }}" style="font-size: 0.82rem; color: var(--adm-primary); font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Website Nurussyam</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        }

        const loginForm = document.querySelector('form[action*="login"]');
        const loginBtn = document.getElementById('loginSubmitBtn');
        if (loginForm && loginBtn) {
            loginForm.addEventListener('submit', function () {
                if (loginForm.checkValidity && !loginForm.checkValidity()) return;
                loginBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Memverifikasi Akun...</span>';
            });
        }
    </script>
    <script src="{{ asset('js/preloader.js') }}?v=2.4"></script>
</body>
</html>
