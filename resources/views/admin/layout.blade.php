<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Pondok Pesantren Nurussyam</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ppns.png') }}?v=2">

    <!-- Fonts: Plus Jakarta Sans & Dancing Script -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Admin Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=2.6">
    <link rel="stylesheet" href="{{ asset('css/toast-notification.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}?v=2.3">
    @stack('styles')
</head>
@php
    $totalSantriCount = \App\Models\Registration::where('status', 'Diterima')->count();
    $pendingPsbCount = \App\Models\Registration::where('status', 'Pending')->count();
    $pendingDonasiCount = \App\Models\Donation::where('status', 'Menunggu Konfirmasi')->count();
@endphp
<body>

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
            <i class="fa-solid fa-circle-notch fa-spin"></i> <span>Memuat Panel...</span>
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

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-wrapper">
        <!-- ==============================================================
             ADMIN SIDEBAR
             ============================================================== -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurussyam" class="sidebar-logo">
                <div class="sidebar-brand">
                    <span class="brand-title">PP. NURUSSYAM</span>
                    <span class="brand-subtitle">Panel Pengelola</span>
                </div>
                <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Menu">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                @if(auth()->user()->hasPermission('dashboard_view'))
                    <div class="nav-section-title">Menu Utama</div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                @endif

                @if(auth()->user()->hasAnyPermission('articles_view', 'articles_create', 'categories_manage'))
                    <div class="nav-section-title">Manajemen Berita</div>

                    @if(auth()->user()->hasPermission('articles_view'))
                        <a href="{{ route('admin.articles.index') }}" class="nav-item {{ request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.edit') ? 'active' : '' }}">
                            <i class="fa-solid fa-newspaper"></i>
                            <span>Daftar Berita</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('articles_create'))
                        <a href="{{ route('admin.articles.create') }}" class="nav-item {{ request()->routeIs('admin.articles.create') ? 'active' : '' }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Upload Berita Baru</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('categories_manage'))
                        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-folder-tree"></i>
                            <span>Kategori Berita</span>
                        </a>
                    @endif
                @endif

                @if(auth()->user()->hasAnyPermission('articles_view', 'articles_create'))
                    <div class="nav-section-title">Media & Dokumentasi</div>

                    <a href="{{ route('admin.galleries.index') }}" class="nav-item {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-images"></i>
                        <span>Galeri Kegiatan</span>
                    </a>
                @endif

                @if(auth()->user()->hasAnyPermission('students_manage', 'registrations_view', 'registrations_verify', 'registrations_approve'))
                    <div class="nav-section-title">Santri & PSB</div>

                    @if(auth()->user()->hasPermission('students_manage'))
                        <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-address-book"></i>
                            <span>Data Santri Aktif</span>
                            @if($totalSantriCount > 0)
                                <span class="badge badge-emerald">{{ $totalSantriCount }}</span>
                            @endif
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('registrations_view'))
                        <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-graduate"></i>
                            <span>Pendaftaran (PSB)</span>
                            @if($pendingPsbCount > 0)
                                <span class="badge badge-amber">{{ $pendingPsbCount }}</span>
                            @endif
                        </a>
                    @endif

                    @if(auth()->user()->hasAnyPermission('registrations_approve', 'registrations_verify'))
                        <a href="{{ route('admin.psb.settings') }}" class="nav-item {{ request()->routeIs('admin.psb.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Informasi & Gelombang PSB</span>
                            @if(($psbSettings['psb_status'] ?? '1') == '1')
                                <span class="badge badge-emerald" style="font-size: 0.68rem; padding: 2px 6px;">Buka</span>
                            @else
                                <span class="badge badge-rose" style="font-size: 0.68rem; padding: 2px 6px;">Tutup</span>
                            @endif
                        </a>
                    @endif
                @endif


                @if(auth()->user()->hasPermission('donations_manage'))
                    <div class="nav-section-title">Keuangan & Umat</div>

                    <a href="{{ route('admin.donations.index') }}" class="nav-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                        <span>LAZISWAF & Donasi</span>
                        @if($pendingDonasiCount > 0)
                            <span class="badge badge-blue">{{ $pendingDonasiCount }}</span>
                        @endif
                    </a>
                @endif

                @if(auth()->user()->hasAnyPermission('users_manage', 'logs_view', 'settings_manage'))
                    <div class="nav-section-title">Konfigurasi & Akses</div>

                    @if(auth()->user()->hasPermission('users_manage'))
                        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-gear"></i>
                            <span>Kelola Pengguna</span>
                        </a>

                        <a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Role & Hak Akses</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('logs_view'))
                        <a href="{{ route('admin.activity-logs.index') }}" class="nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Histori Aktivitas</span>
                        </a>
                    @endif

                    @if(auth()->user()->hasPermission('settings_manage'))
                        <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Pengaturan Website</span>
                        </a>
                    @endif
                @endif

                <div class="nav-section-title">Akun</div>

                <a href="{{ route('admin.profile') }}" class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Akun & Password</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="admin-user-pill">
                    <div class="admin-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="admin-meta">
                        <span class="admin-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="admin-role">{{ auth()->user()->role_label }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
                    @csrf
                    <button type="submit" class="btn-sidebar-logout" title="Logout dari Admin">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ==============================================================
             MAIN CONTENT WRAPPER
             ============================================================== -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Buka Menu" title="Menu Navigasi">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    
                    <!-- Mobile View Header Title -->
                    <div class="header-brand-mobile">
                        <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo PPNS" class="mobile-nav-logo">
                        <div class="header-page-title">@yield('page_title', 'Dashboard')</div>
                    </div>

                    <!-- Desktop Breadcrumb Box -->
                    <div class="breadcrumb-box">
                        <a href="{{ auth()->user()->hasPermission('dashboard_view') ? route('admin.dashboard') : (auth()->user()->hasPermission('articles_view') ? route('admin.articles.index') : route('admin.profile')) }}"><i class="fa-solid fa-house"></i></a>
                        <span class="separator">/</span>
                        <span class="current">@yield('page_title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="header-right">
                    <a href="{{ route('home') }}" target="_blank" class="btn-live-site" title="Buka website publik di tab baru">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span class="live-site-text">Web</span>
                    </a>
                </div>
            </header>

            <!-- Page Body Content -->
            <div class="admin-content">
                <!-- Flash Notification Messages -->
                @if(session('success'))
                    <div class="adm-alert adm-alert-success">
                        <i class="fa-solid fa-circle-check adm-alert-icon"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="adm-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="adm-alert adm-alert-danger">
                        <i class="fa-solid fa-circle-xmark adm-alert-icon"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="adm-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="adm-alert adm-alert-warning">
                        <i class="fa-solid fa-triangle-exclamation adm-alert-icon"></i>
                        <div>{{ session('warning') }}</div>
                        <button type="button" class="adm-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="adm-alert adm-alert-info">
                        <i class="fa-solid fa-circle-info adm-alert-icon"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="adm-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="adm-alert adm-alert-danger">
                        <i class="fa-solid fa-circle-xmark adm-alert-icon"></i>
                        <div>
                            <strong>Terjadi kesalahan input:</strong>
                            <ul style="margin-top: 0.35rem; padding-left: 1.25rem;">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="adm-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Bottom Navigation Bar (Fixed for Phones) -->
    <nav class="admin-bottom-nav" id="adminBottomNav" aria-label="Navigasi Cepat Mobile">
        @if(auth()->user()->hasPermission('dashboard_view'))
            <a href="{{ route('admin.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        @endif

        @if(auth()->user()->hasPermission('articles_view'))
            <a href="{{ route('admin.articles.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i>
                <span>Berita</span>
            </a>
        @elseif(auth()->user()->hasPermission('articles_create'))
            <a href="{{ route('admin.articles.create') }}" class="bottom-nav-item {{ request()->routeIs('admin.articles.create') ? 'active' : '' }}">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Tulis Baru</span>
            </a>
        @endif

        @if(auth()->user()->hasPermission('registrations_view'))
            <a href="{{ route('admin.registrations.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon-wrap">
                    <i class="fa-solid fa-user-graduate"></i>
                    @if($pendingPsbCount > 0)
                        <span class="bottom-nav-badge">{{ $pendingPsbCount }}</span>
                    @endif
                </div>
                <span>PSB</span>
            </a>
        @endif

        @if(auth()->user()->hasPermission('donations_manage'))
            <a href="{{ route('admin.donations.index') }}" class="bottom-nav-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                <div class="bottom-nav-icon-wrap">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    @if($pendingDonasiCount > 0)
                        <span class="bottom-nav-badge">{{ $pendingDonasiCount }}</span>
                    @endif
                </div>
                <span>Donasi</span>
            </a>
        @endif

        <a href="{{ route('admin.profile') }}" class="bottom-nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user-gear"></i>
            <span>Akun</span>
        </a>

        <button type="button" class="bottom-nav-item" id="bottomNavMenuBtn" aria-label="Buka Menu Lengkap">
            <i class="fa-solid fa-bars"></i>
            <span>Menu</span>
        </button>
    </nav>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile sidebar toggler
            const sidebarToggle = document.getElementById('sidebarToggle');
            const bottomNavMenuBtn = document.getElementById('bottomNavMenuBtn');
            const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function openSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.add('show');
                    overlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }
            if (bottomNavMenuBtn) {
                bottomNavMenuBtn.addEventListener('click', openSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
            if (sidebarCloseBtn) {
                sidebarCloseBtn.addEventListener('click', closeSidebar);
            }

            // Close on escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });
        });
    </script>

    <!-- Toast Notification Engine & Initial Flash Message Payload -->
    <script>
        window.__INITIAL_TOASTS__ = [];
        @if(session('success'))
            window.__INITIAL_TOASTS__.push({
                title: 'Berhasil!',
                message: {!! json_encode(session('success')) !!},
                type: 'success',
                icon: 'ri-checkbox-circle-fill'
            });
        @endif
        @if(session('error'))
            window.__INITIAL_TOASTS__.push({
                title: 'Perhatian / Gagal!',
                message: {!! json_encode(session('error')) !!},
                type: 'error',
                icon: 'ri-close-circle-fill'
            });
        @endif
        @if(session('warning'))
            window.__INITIAL_TOASTS__.push({
                title: 'Peringatan',
                message: {!! json_encode(session('warning')) !!},
                type: 'warning',
                icon: 'ri-alert-fill'
            });
        @endif
        @if(session('info'))
            window.__INITIAL_TOASTS__.push({
                title: 'Informasi',
                message: {!! json_encode(session('info')) !!},
                type: 'info',
                icon: 'ri-information-fill'
            });
        @endif
    </script>
    <script src="{{ asset('js/toast-notification.js') }}?v=1.0"></script>

    <!-- ==============================================================
         MODAL PERINGATAN INAKTIVITAS / IDLE SESSION TIMEOUT (15 MENIT)
         ============================================================== -->
    <div id="idleWarningModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); z-index: 9999999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: #ffffff; border-radius: 20px; max-width: 420px; width: 100%; padding: 28px 24px 24px; text-align: center; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.28); border: 1px solid rgba(226, 232, 240, 0.8);">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; box-shadow: 0 6px 16px rgba(217, 119, 6, 0.2);">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; font-family: 'Plus Jakarta Sans', sans-serif;">Sesi Hampir Berakhir</h3>
            <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5; margin: 0 0 22px 0;">
                Anda tidak melakukan aktivitas selama 14 menit. Sesi akan otomatis keluar dalam <strong id="idleCountdownText" style="color: #dc2626; font-size: 1.05rem;">60</strong> detik demi keamanan akun.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" id="stayLoggedInBtn" style="flex: 1; background: #15803d; color: #ffffff; border: none; padding: 11px 16px; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 0.92rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-shield-check"></i> Tetap Masuk
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="reason" value="idle">
                    <button type="submit" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 11px 16px; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 0.92rem;">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
    <form id="autoLogoutForm" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="reason" value="idle">
    </form>

    <!-- Auto-Logout on Inactivity Engine (15 Menit) -->
    <script>
        (function () {
            'use strict';

            const IDLE_TIMEOUT_MS = 15 * 60 * 1000; // 15 menit
            const WARNING_TIME_MS = 14 * 60 * 1000; // Peringatan di menit ke-14
            const COUNTDOWN_TOTAL = 60; // 60 detik hitung mundur

            let idleTimer = null;
            let warningTimer = null;
            let countdownInterval = null;
            let remainingSeconds = COUNTDOWN_TOTAL;
            let isWarningShown = false;

            const modal = document.getElementById('idleWarningModal');
            const countdownEl = document.getElementById('idleCountdownText');
            const stayBtn = document.getElementById('stayLoggedInBtn');
            const logoutForm = document.getElementById('autoLogoutForm');

            function resetTimer() {
                if (isWarningShown) return; // Jangan reset jika dialog countdown sudah muncul

                clearTimeout(warningTimer);
                clearTimeout(idleTimer);

                // Jadwalkan peringatan di menit ke-14
                warningTimer = setTimeout(showWarning, WARNING_TIME_MS);

                // Jadwalkan logout otomatis di menit ke-15
                idleTimer = setTimeout(performAutoLogout, IDLE_TIMEOUT_MS);
            }

            function showWarning() {
                isWarningShown = true;
                remainingSeconds = COUNTDOWN_TOTAL;
                if (countdownEl) countdownEl.textContent = remainingSeconds;
                if (modal) modal.style.display = 'flex';

                clearInterval(countdownInterval);
                countdownInterval = setInterval(function () {
                    remainingSeconds--;
                    if (countdownEl) countdownEl.textContent = remainingSeconds;

                    if (remainingSeconds <= 0) {
                        clearInterval(countdownInterval);
                        performAutoLogout();
                    }
                }, 1000);
            }

            function keepAlive() {
                isWarningShown = false;
                clearInterval(countdownInterval);
                if (modal) modal.style.display = 'none';

                // Ping server untuk memperbarui timestamp sesi aktif
                fetch('{{ route('admin.ping') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                }).catch(() => {});

                resetTimer();
            }

            function performAutoLogout() {
                clearInterval(countdownInterval);
                if (logoutForm) {
                    logoutForm.submit();
                } else {
                    window.location.href = '{{ route('admin.login') }}';
                }
            }

            if (stayBtn) {
                stayBtn.addEventListener('click', keepAlive);
            }

            // Dengarkan aktivitas pengguna untuk mereset timer
            const userEvents = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'];
            userEvents.forEach(function (evt) {
                window.addEventListener(evt, resetTimer, { passive: true });
            });

            // Mulai timer awal
            resetTimer();
        })();

        // Scroll Position Preservation di Admin Panel
        (function() {
            document.addEventListener('submit', function(e) {
                const f = e.target;
                if (!f || f.tagName !== 'FORM' || f.target === '_blank') return;
                try {
                    sessionStorage.setItem('ns_admin_scroll_y', String(window.scrollY));
                } catch(err) {}
            }, true);

            window.addEventListener('DOMContentLoaded', function() {
                try {
                    const savedY = sessionStorage.getItem('ns_admin_scroll_y');
                    if (savedY !== null) {
                        sessionStorage.removeItem('ns_admin_scroll_y');
                        const y = parseInt(savedY, 10);
                        if (!isNaN(y) && y > 0) {
                            window.scrollTo({ top: y, behavior: 'instant' });
                        }
                    }
                } catch(e) {}
            });
        })();
    </script>
    @stack('scripts')
    <script src="{{ asset('js/preloader.js') }}?v=2.4"></script>
</body>
</html>
