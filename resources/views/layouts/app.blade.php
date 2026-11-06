<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $pageTitle = trim(View::yieldContent('title', 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso'));
        $ogTitle = View::hasSection('og_title') ? trim(View::yieldContent('og_title')) : $pageTitle;
        
        $ogDescription = View::hasSection('og_description') 
            ? trim(View::yieldContent('og_description')) 
            : 'Website Resmi Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso. Berita terkini, catatan santri, informasi pendaftaran (PSB), dan tausiyah.';
        $ogDescription = \Illuminate\Support\Str::limit(strip_tags($ogDescription), 160);

        $rawOgImage = View::hasSection('og_image') ? trim(View::yieldContent('og_image')) : asset('images/logo-ppns.png');
        if (!empty($rawOgImage) && !str_starts_with($rawOgImage, 'http://') && !str_starts_with($rawOgImage, 'https://')) {
            $ogImage = asset(ltrim($rawOgImage, '/'));
        } elseif (!empty($rawOgImage)) {
            $ogImage = $rawOgImage;
        } else {
            $ogImage = asset('images/logo-ppns.png');
        }

        $ogType = View::hasSection('og_type') ? trim(View::yieldContent('og_type')) : 'website';
        $ogAuthor = View::hasSection('og_author') ? trim(View::yieldContent('og_author')) : 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso';
        $currentCanonicalUrl = url()->current();

        $imageExt = strtolower(pathinfo(parse_url($ogImage, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
        $ogImageType = match($imageExt) {
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            default => 'image/jpeg',
        };
    @endphp

    <title>{{ $pageTitle }}</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="{{ $ogDescription }}">
    <meta name="keywords" content="Pondok Pesantren Nurussyam, Nurussyam Wringin Arak arak Bondowoso, Pesantren Bondowoso, PSB Nurussyam">
    <meta name="author" content="{{ $ogAuthor }}">
    <link rel="canonical" href="{{ $currentCanonicalUrl }}">

    <!-- Open Graph Protocol (WhatsApp, Facebook, LinkedIn, Telegram) -->
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="Pondok Pesantren Nurus Syam">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $currentCanonicalUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:secure_url" content="{{ $ogImage }}">
    <meta property="og:image:type" content="{{ $ogImageType }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $ogTitle }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <!-- Fallback Link Image untuk Crawler Aplikasi Pesan -->
    <link rel="image_src" href="{{ $ogImage }}">

    @yield('extra_meta')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-ppns.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('images/logo-ppns.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-ppns.png') }}?v=2">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/toast-notification.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}?v=2.3">
</head>
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
            <span class="preloader-tagline">Wringin &bull; Arak-arak &bull; Bondowoso</span>
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

    <!-- ======================================================================
         MOBILE HEADER BAR (EXACTLY MATCHING USER'S MOBILE SCREENSHOT)
         Dark top bar with Hamburger on left, Centered Brand, Search on right
         ====================================================================== -->
    <header class="mobile-header-bar">
        <button class="mobile-hdr-btn" id="openMobileSidebarBtn" aria-label="Buka Menu Navigasi">
            <i class="fa-solid fa-bars"></i>
        </button>

        <a href="{{ route('home') }}" class="mobile-hdr-brand" title="Beranda Pondok Pesantren Nurus Syam">
            <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurus Syam" class="mobile-hdr-logo">
            <div class="mobile-hdr-text">
                <span class="m-script">Pondok Pesantren</span>
                <span class="m-title">NURUS SYAM</span>
                <span class="m-sub">Wringin - Bondowoso</span>
            </div>
        </a>

        <button class="mobile-hdr-btn" id="openSearchBtnMobile" aria-label="Pencarian Artikel">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </header>

    <!-- ======================================================================
         DESKTOP TOP BAR (HIDDEN ON MOBILE)
         ====================================================================== -->
    <div class="top-bar-clean desktop-only">
        <div class="container top-bar-container">
            <div class="top-bar-date">
                <span id="liveRealtimeHeader">
                    <i class="fa-regular fa-calendar-days" style="color: var(--primary-green); margin-right: 4px;"></i>
                    <span id="liveRealtimeDate">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    <span style="margin: 0 6px; opacity: 0.4;">|</span>
                    <i class="fa-regular fa-clock" style="color: var(--primary-green); margin-right: 4px;"></i>
                    <span id="liveRealtimeClock">{{ \Carbon\Carbon::now()->format('H:i:s') }} WIB</span>
                </span>
            </div>

            <div class="top-bar-socials">
                <a href="https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f" target="_blank" rel="noopener noreferrer" title="Saluran WhatsApp" aria-label="Saluran WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="https://www.instagram.com/ppnurussyam_official" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@ppnurussyam_official" target="_blank" rel="noopener noreferrer" title="TikTok" aria-label="TikTok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://www.youtube.com/@ppnurussyamofficial" target="_blank" rel="noopener noreferrer" title="YouTube" aria-label="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- ======================================================================
         DESKTOP MAIN HEADER (HIDDEN ON MOBILE)
         ====================================================================== -->
    <header class="main-header desktop-only">
        <div class="container header-center-wrap">
            <a href="{{ route('home') }}" class="header-logo-link" title="Beranda Pondok Pesantren Nurus Syam">
                <img src="{{ asset('images/logo_header.png') }}" alt="Pondok Pesantren NURUS SYAM Wringin Bondowoso" class="main-logo-image">
            </a>
        </div>
    </header>

    <!-- ======================================================================
         DESKTOP NAVBAR (HIDDEN ON MOBILE)
         ====================================================================== -->
    <nav class="main-navbar desktop-only">
        <div class="container navbar-container">
            <ul class="navbar-menu desktop-nav-menu">
                <li class="navbar-item {{ request()->routeIs('home') && !request()->has('category') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="navbar-link">BERANDA</a>
                </li>
                
                <li class="navbar-item {{ request()->is('menu/sejarah*') || request()->is('menu/berdirinya*') || request()->is('menu/gagasan*') || request()->is('menu/kepemimpinan*') || request()->is('menu/biografi*') ? 'active' : '' }}">
                    <a href="{{ route('page.show', 'berdirinya-pesantren') }}" class="navbar-link">
                        SEJARAH <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu-item">
                            <a href="{{ route('page.show', 'berdirinya-pesantren') }}" class="dropdown-link dropdown-submenu-toggle">
                                <span>Nurus Syam</span>
                                <i class="fa-solid fa-angle-right submenu-arrow"></i>
                            </a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('page.show', 'berdirinya-pesantren') }}" class="dropdown-link">Berdirinya Pondok Pesantren Nurus Syam</a></li>
                                <li><a href="{{ route('page.show', 'gagasan-dan-cita-cita') }}" class="dropdown-link">Gagasan dan Cita-cita</a></li>
                                <li><a href="{{ route('page.show', 'kepemimpinan-generasi-pertama') }}" class="dropdown-link">Kepemimpinan Generasi Pertama</a></li>
                                <li><a href="{{ route('page.show', 'kepemimpinan-generasi-kedua') }}" class="dropdown-link">Kepemimpinan Generasi Kedua</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu-item">
                            <a href="{{ route('page.show', 'sejarah') }}" class="dropdown-link dropdown-submenu-toggle">
                                <span>Sejarah</span>
                                <i class="fa-solid fa-angle-right submenu-arrow"></i>
                            </a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('page.show', 'sejarah') }}" class="dropdown-link">Sejarah Umum</a></li>
                                <li><a href="{{ route('page.show', 'biografi-pendiri') }}" class="dropdown-link">Biografi Pendiri</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="navbar-item {{ request()->is('menu/pendiri*') || request()->is('menu/pengasuh*') || request()->is('menu/lembaga*') || request()->is('menu/motto*') || request()->is('menu/panca*') || request()->is('menu/madrasah*') || request()->is('menu/kegiatan*') || request()->is('menu/profil*') ? 'active' : '' }}">
                    <a href="{{ route('page.show', 'profil') }}" class="navbar-link">
                        PROFIL <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu-item">
                            <a href="{{ route('page.show', 'pendiri') }}" class="dropdown-link dropdown-submenu-toggle">
                                <span>Pendiri</span>
                                <i class="fa-solid fa-angle-right submenu-arrow"></i>
                            </a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('page.show', 'pendiri') }}" class="dropdown-link">KH. As'ari Afandi</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu-item">
                            <a href="{{ route('page.show', 'pengasuh-kh-sanusi-syam') }}" class="dropdown-link dropdown-submenu-toggle">
                                <span>Pengasuh</span>
                                <i class="fa-solid fa-angle-right submenu-arrow"></i>
                            </a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('page.show', 'pengasuh-kh-sanusi-syam') }}" class="dropdown-link">KH. Sanusi Syam (Pengasuh ke-2)</a></li>
                                <li><a href="{{ route('page.show', 'pengasuh-kh-abdul-malik-sanusi') }}" class="dropdown-link">KH. Abdul Malik Sanusi (Pengasuh ke-3)</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('page.show', 'lembaga') }}" class="dropdown-link">Lembaga</a>
                        </li>
                        <li>
                            <a href="{{ route('page.show', 'visi-misi') }}" class="dropdown-link">Visi Misi</a>
                        </li>
                        <li class="dropdown-submenu-item">
                            <a href="{{ route('page.show', 'madrasah-diniyah') }}" class="dropdown-link dropdown-submenu-toggle">
                                <span>Pendidikan</span>
                                <i class="fa-solid fa-angle-right submenu-arrow"></i>
                            </a>
                            <ul class="dropdown-submenu">
                                <li><a href="{{ route('page.show', 'madrasah-diniyah') }}" class="dropdown-link">Madrasah Diniyah</a></li>
                                <li><a href="{{ route('page.show', 'kegiatan-ekstrakurikuler') }}" class="dropdown-link">Kegiatan Ekstrakurikuler</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="navbar-item {{ request()->routeIs('pendaftaran*') || request()->is('menu/pendaftaran*') ? 'active' : '' }}">
                    <a href="{{ route('pendaftaran.info') }}" class="navbar-link">
                        PENDAFTARAN <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('pendaftaran.info') }}" class="dropdown-link">Informasi PSB {{ $psbSettings['psb_tahun_ajaran'] ?? '2026/2027' }}</a></li>
                        <li><a href="{{ route('pendaftaran.syarat') }}" class="dropdown-link">Syarat & Berkas</a></li>
                        @if(($psbSettings['psb_status'] ?? '1') == '1')
                            <li><a href="{{ route('pendaftaran') }}" class="dropdown-link">Formulir Pendaftaran Online</a></li>
                        @else
                            <li><a href="{{ route('pendaftaran') }}#cek-status" class="dropdown-link">Cek Status Pendaftaran</a></li>
                        @endif
                    </ul>
                </li>

                <li class="navbar-item {{ request()->get('category') == 'TERKINI' || request()->is('menu/terkini') ? 'active' : '' }}">
                    <a href="{{ route('category.show', 'terkini') }}" class="navbar-link">TERKINI</a>
                </li>

                <li class="navbar-item {{ request()->get('category') == 'CATATAN' || request()->is('menu/catatan') ? 'active' : '' }}">
                    <a href="{{ route('category.show', 'catatan') }}" class="navbar-link">CATATAN</a>
                </li>

                <li class="navbar-item {{ request()->is('menu/alumni') ? 'active' : '' }}">
                    <a href="{{ route('page.show', 'alumni') }}" class="navbar-link">ALUMNI</a>
                </li>

                <li class="navbar-item {{ request()->is('laziswaf*') || request()->is('donasi*') || request()->is('menu/laziswaf') ? 'active' : '' }}">
                    <a href="{{ route('laziswaf.index') }}" class="navbar-link">
                        LAZISWAF <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('laziswaf.index') }}" class="dropdown-link">Lembaga Amil Zakat</a></li>
                        <li><a href="{{ route('donasi.masjid') }}" class="dropdown-link">Donasi Masjid</a></li>
                        <li><a href="{{ route('donasi.pondok') }}" class="dropdown-link">Donasi Pondok</a></li>
                    </ul>
                </li>

                <li class="navbar-item {{ request()->is('menu/galeri') ? 'active' : '' }}">
                    <a href="{{ route('page.show', 'galeri') }}" class="navbar-link">GALERI</a>
                </li>

                <li class="navbar-item {{ request()->is('menu/mts-nurussyam*') || request()->is('menu/ma-nurussyam*') || request()->is('menu/sekolah*') ? 'active' : '' }}">
                    <a href="{{ route('page.show', 'sekolah') }}" class="navbar-link">
                        SEKOLAH <i class="fa-solid fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('page.show', 'mts-nurussyam') }}" class="dropdown-link">MTS NURUSSYAM</a></li>
                        <li><a href="{{ route('page.show', 'ma-nurussyam') }}" class="dropdown-link">MA NURUSSYAM</a></li>
                    </ul>
                </li>
            </ul>

            <button class="navbar-search-btn" id="openSearchBtn" title="Pencarian Situs" aria-label="Cari artikel">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </nav>

    <!-- ======================================================================
         MOBILE SIDEBAR OFFCANVAS DRAWER (OPENS VIA HAMBURGER ICON)
         ====================================================================== -->
    <div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>
    <aside class="mobile-sidebar-drawer" id="mobileSidebarDrawer" aria-label="Menu Navigasi Mobile">
        <div class="mobile-sidebar-header">
            <div class="mobile-sidebar-brand">
                <img src="{{ asset('images/logo-ppns.png') }}" alt="Logo Nurus Syam" class="mobile-sidebar-logo">
                <div class="mobile-sidebar-titles">
                    <strong>NURUS SYAM</strong>
                    <small>Wringin - Bondowoso</small>
                </div>
            </div>
            <button class="mobile-sidebar-close" id="closeMobileSidebarBtn" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="mobile-nav-list">
            <div class="mobile-nav-item">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') && !request()->has('category') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i>
                    <span>BERANDA</span>
                </a>
            </div>

            <!-- Sejarah Accordion -->
            <div class="mobile-nav-item has-accordion">
                <div class="mobile-nav-row">
                    <a href="{{ route('page.show', 'berdirinya-pesantren') }}" class="mobile-nav-link">
                        <i class="fa-solid fa-landmark"></i>
                        <span>SEJARAH</span>
                    </a>
                    <button class="mobile-accordion-toggle" aria-label="Buka Submenu">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="mobile-submenu-box">
                    <div class="mobile-submenu-heading">NURUS SYAM</div>
                    <a href="{{ route('page.show', 'berdirinya-pesantren') }}">Berdirinya Pondok Pesantren</a>
                    <a href="{{ route('page.show', 'gagasan-dan-cita-cita') }}">Gagasan dan Cita-cita</a>
                    <a href="{{ route('page.show', 'kepemimpinan-generasi-pertama') }}">Kepemimpinan Generasi Pertama</a>
                    <a href="{{ route('page.show', 'kepemimpinan-generasi-kedua') }}">Kepemimpinan Generasi Kedua</a>

                    <div class="mobile-submenu-heading" style="margin-top:8px;">SEJARAH</div>
                    <a href="{{ route('page.show', 'sejarah') }}">Sejarah Umum</a>
                    <a href="{{ route('page.show', 'biografi-pendiri') }}">Biografi Pendiri</a>
                </div>
            </div>

            <!-- Profil Accordion -->
            <div class="mobile-nav-item has-accordion">
                <div class="mobile-nav-row">
                    <a href="{{ route('page.show', 'profil') }}" class="mobile-nav-link">
                        <i class="fa-solid fa-mosque"></i>
                        <span>PROFIL</span>
                    </a>
                    <button class="mobile-accordion-toggle" aria-label="Buka Submenu">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="mobile-submenu-box">
                    <div class="mobile-submenu-heading">PENDIRI</div>
                    <a href="{{ route('page.show', 'pendiri') }}">KH. As'ari Afandi</a>

                    <div class="mobile-submenu-heading" style="margin-top:8px;">PENGASUH</div>
                    <a href="{{ route('page.show', 'pengasuh-kh-sanusi-syam') }}">KH. Sanusi Syam (Pengasuh ke-2)</a>
                    <a href="{{ route('page.show', 'pengasuh-kh-abdul-malik-sanusi') }}">KH. Abdul Malik Sanusi (Pengasuh ke-3)</a>

                    <div class="mobile-submenu-heading" style="margin-top:8px;">LEMBAGA</div>
                    <a href="{{ route('page.show', 'lembaga') }}">Lembaga Pesantren</a>

                    <div class="mobile-submenu-heading" style="margin-top:8px;">VISI MISI</div>
                    <a href="{{ route('page.show', 'visi-misi') }}">Visi Misi</a>

                    <div class="mobile-submenu-heading" style="margin-top:8px;">PENDIDIKAN</div>
                    <a href="{{ route('page.show', 'madrasah-diniyah') }}">Madrasah Diniyah</a>
                    <a href="{{ route('page.show', 'kegiatan-ekstrakurikuler') }}">Kegiatan Ekstrakurikuler</a>
                </div>
            </div>

            <!-- Pendaftaran Accordion -->
            <div class="mobile-nav-item has-accordion">
                <div class="mobile-nav-row">
                    <a href="{{ route('pendaftaran.info') }}" class="mobile-nav-link">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>PENDAFTARAN</span>
                    </a>
                    <button class="mobile-accordion-toggle" aria-label="Buka Submenu">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="mobile-submenu-box">
                    <a href="{{ route('pendaftaran.info') }}">Informasi PSB {{ $psbSettings['psb_tahun_ajaran'] ?? '2026/2027' }}</a>
                    <a href="{{ route('pendaftaran.syarat') }}">Syarat & Berkas</a>
                    @if(($psbSettings['psb_status'] ?? '1') == '1')
                        <a href="{{ route('pendaftaran') }}">Formulir Pendaftaran Online</a>
                    @else
                        <a href="{{ route('pendaftaran') }}#cek-status">Cek Status Pendaftaran</a>
                    @endif
                </div>
            </div>

            <div class="mobile-nav-item">
                <a href="{{ route('category.show', 'terkini') }}" class="mobile-nav-link">
                    <i class="fa-solid fa-bolt"></i>
                    <span>TERKINI</span>
                </a>
            </div>

            <div class="mobile-nav-item">
                <a href="{{ route('category.show', 'catatan') }}" class="mobile-nav-link">
                    <i class="fa-solid fa-book-open"></i>
                    <span>CATATAN</span>
                </a>
            </div>

            <div class="mobile-nav-item">
                <a href="{{ route('page.show', 'alumni') }}" class="mobile-nav-link">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>ALUMNI</span>
                </a>
            </div>

            <!-- Laziswaf Accordion -->
            <div class="mobile-nav-item has-accordion">
                <div class="mobile-nav-row">
                    <a href="{{ route('laziswaf.index') }}" class="mobile-nav-link">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                        <span>LAZISWAF</span>
                    </a>
                    <button class="mobile-accordion-toggle" aria-label="Buka Submenu">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="mobile-submenu-box">
                    <a href="{{ route('laziswaf.index') }}">Lembaga Amil Zakat</a>
                    <a href="{{ route('donasi.masjid') }}">Donasi Masjid</a>
                    <a href="{{ route('donasi.pondok') }}">Donasi Pondok</a>
                </div>
            </div>

            <div class="mobile-nav-item">
                <a href="{{ route('page.show', 'galeri') }}" class="mobile-nav-link">
                    <i class="fa-solid fa-images"></i>
                    <span>GALERI</span>
                </a>
            </div>

            <!-- Sekolah Accordion -->
            <div class="mobile-nav-item has-accordion">
                <div class="mobile-nav-row">
                    <a href="{{ route('page.show', 'sekolah') }}" class="mobile-nav-link">
                        <i class="fa-solid fa-school"></i>
                        <span>SEKOLAH</span>
                    </a>
                    <button class="mobile-accordion-toggle" aria-label="Buka Submenu">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                </div>
                <div class="mobile-submenu-box">
                    <a href="{{ route('page.show', 'mts-nurussyam') }}">MTS NURUSSYAM</a>
                    <a href="{{ route('page.show', 'ma-nurussyam') }}">MA NURUSSYAM</a>
                </div>
            </div>
        </nav>

        <div class="mobile-sidebar-footer">
            <a href="{{ route('pendaftaran') }}" class="mobile-sidebar-psb-btn">
                <i class="fa-solid fa-graduation-cap"></i> PSB 2026/2027 Daftar Online
            </a>

            <div class="mobile-sidebar-socials">
                <a href="https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f" target="_blank" rel="noopener noreferrer" title="Saluran WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="https://www.instagram.com/ppnurussyam_official" target="_blank" rel="noopener noreferrer" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.tiktok.com/@ppnurussyam_official" target="_blank" rel="noopener noreferrer" title="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                <a href="https://www.youtube.com/@ppnurussyamofficial" target="_blank" rel="noopener noreferrer" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>

            <div class="mobile-sidebar-contact">
                <p><i class="fa-solid fa-envelope"></i> admin@nurussyam.ponpes.id</p>
                <p><i class="fa-solid fa-location-dot"></i> Wringin - Bondowoso</p>
            </div>
        </div>
    </aside>

    <!-- MAIN BODY WRAPPER -->
    <main class="site-main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- ======================================================================
         SITE FOOTER (MATCHING USER'S DESKTOP & MOBILE REFERENCE SCREENSHOTS)
         - Desktop: 3 columns (Logo | ABOUT US | FOLLOW US)
         - Mobile: Clean, centered stack (Rata Tengah)
         ====================================================================== -->
    <footer class="site-footer">
        <div class="container footer-main-row">
            <!-- Col 1: Logo Pesantren (logo-2.png) -->
            <div class="footer-col-logo">
                <a href="{{ route('admin.dashboard') }}" class="footer-logo-link" title="Pondok Pesantren Nurussyam">
                    <img src="{{ asset('images/logo-2.png') }}" alt="Pondok Pesantren Nurussyam" class="footer-logo-main-img">
                </a>
            </div>

            <!-- Col 2: About Us -->
            <div class="footer-col-about">
                <h4 class="footer-heading-clean">ABOUT US</h4>
                <p class="footer-about-text">
                    Berikut adalah website resmi Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso, yang menyajikan beragam berita, informasi, catatan, dan tausiyah dari Pondok Pesantren Nurussyam untuk kalangan alumni, walisantri dan masyarakat.
                </p>
                <div class="footer-contact-line">
                    Contact us: <a href="mailto:admin@nurussyam.ponpes.id" class="footer-contact-email">admin@nurussyam.ponpes.id</a>
                </div>
            </div>

            <!-- Col 3: Follow Us -->
            <div class="footer-col-follow">
                <h4 class="footer-heading-clean">FOLLOW US</h4>
                <div class="footer-social-row">
                    <a href="https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f" target="_blank" rel="noopener noreferrer" class="footer-social-box" title="Saluran WhatsApp" aria-label="Saluran WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/ppnurussyam_official" target="_blank" rel="noopener noreferrer" class="footer-social-box" title="Instagram" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@ppnurussyam_official" target="_blank" rel="noopener noreferrer" class="footer-social-box" title="TikTok" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="https://www.youtube.com/@ppnurussyamofficial" target="_blank" rel="noopener noreferrer" class="footer-social-box" title="YouTube" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sub-footer Bar -->
        <div class="subfooter-bar">
            <div class="container subfooter-container">
                <div class="subfooter-links">
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('pendaftaran') }}">Pendaftaran</a>
                    <a href="{{ route('kontak') }}">Kontak</a>
                    <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 4px; opacity: 0.85;"><i class="fa-solid fa-lock" style="font-size: 0.72rem;"></i> Login Pengelola</a>
                </div>
                <div class="subfooter-copyright">
                    &copy; Copyright 2026 Pondok Pesantren Nurussyam
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button (Green square in bottom-right corner) -->
    <button id="backToTopBtn" class="back-to-top-btn" title="Kembali ke atas" aria-label="Kembali ke atas">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    <!-- SEARCH MODAL POPUP -->
    <div class="modal-overlay" id="searchModal">
        <div class="modal-card-box">
            <div class="modal-head-box">
                <strong style="color:var(--primary-green); font-size:1.1rem;">
                    <i class="fa-solid fa-magnifying-glass" style="margin-right:6px;"></i> Pencarian Situs Nurus Syam
                </strong>
                <button id="closeSearchBtn" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#64748b;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body-box">
                <input type="text" id="searchInput" class="search-field-input" placeholder="Ketik kata kunci artikel atau berita..." autocomplete="off">
                <div id="searchResults" style="margin-top:14px;">
                    <p style="color:#64748b; font-size:0.85rem; text-align:center; padding:15px;">
                        Ketik judul artikel atau berita untuk mencari...
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main JavaScript -->
    <script src="{{ asset('js/main.js') }}?v=2.5"></script>

    <!-- Toast Notification Engine & Session Flash Triggers -->
    <script>
        window.__INITIAL_TOASTS__ = [];
        @if(session('success'))
            window.__INITIAL_TOASTS__.push({
                title: 'Alhamdulillah Berhasil!',
                message: {!! json_encode(session('success')) !!},
                type: 'success',
                icon: 'ri-checkbox-circle-fill'
            });
        @endif
        @if(session('error'))
            window.__INITIAL_TOASTS__.push({
                title: 'Perhatian / Terjadi Kendala',
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
    <!-- Realtime Live Date & Clock Script -->
    <script>
        (function() {
            function updateRealtimeClock() {
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const monthName = months[now.getMonth()];
                const year = now.getFullYear();
                
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                const s = String(now.getSeconds()).padStart(2, '0');
                
                const dateEl = document.getElementById('liveRealtimeDate');
                const clockEl = document.getElementById('liveRealtimeClock');
                
                if (dateEl) {
                    dateEl.textContent = `${dayName}, ${date} ${monthName} ${year}`;
                }
                if (clockEl) {
                    clockEl.textContent = `${h}:${m}:${s} WIB`;
                }
            }
            setInterval(updateRealtimeClock, 1000);
            updateRealtimeClock();
        })();
    </script>
    <script src="{{ asset('js/toast-notification.js') }}?v=1.0"></script>
    <script src="{{ asset('js/preloader.js') }}?v=2.4"></script>
    @stack('scripts')
</body>
</html>
