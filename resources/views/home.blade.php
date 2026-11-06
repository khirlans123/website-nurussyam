@extends('layouts.app')

@section('title', 'Pondok Pesantren Nurus Syam - Halaman Utama')

@section('content')
<div class="layout-grid">

    <!-- ======================================================================
         KONTEN UTAMA (KIRI)
         ====================================================================== -->
    <div class="content-left">

        <!-- BARIS PERTAMA: 3 KARTU BESAR DENGAN OVERLAY (PERSIS SEPERTI BAITULARQOM.ID) -->
        <section class="featured-fullbleed-wrapper">
            <div class="featured-three-grid">
                @foreach($featured_articles as $article)
                    <a href="{{ route('article.show', $article['slug']) }}" class="featured-card">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="featured-card-img" loading="lazy">
                        
                        <div class="featured-card-overlay">
                            <span class="badge-overlay" style="background-color: {{ $article['badge_color'] ?? '#0284c7' }};">
                                {{ $article['category'] }}
                            </span>
                            
                            <h2 class="featured-card-title">
                                {{ $article['title'] }}
                            </h2>

                            <div class="featured-card-meta">
                                <strong>{{ $article['author'] }}</strong>
                                <span>-</span>
                                <span>{{ $article['date'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- ==================================================================
             SECTION 1: BERITA TERBARU (MATCHING SCREENSHOT 1)
             - Dark badge header + Category tabs (All, Alumni, Catatan, Featured, Galeri, Laziswaf)
             - 1 Lead post left + 4 compact items right
             ================================================================== -->
        <section class="mag-section" id="berita-terbaru">
            <div class="mag-header-bar theme-dark">
                <span class="mag-header-badge">Berita Terbaru</span>
                <div class="mag-header-tabs">
                    <a href="{{ route('home') }}" class="mag-tab-link active">All</a>
                    <a href="{{ route('page.show', 'alumni') }}" class="mag-tab-link">Alumni</a>
                    <a href="{{ route('category.show', 'catatan') }}" class="mag-tab-link">Catatan</a>
                    <a href="#featured" class="mag-tab-link">Featured</a>
                    <a href="{{ route('page.show', 'galeri') }}" class="mag-tab-link">Galeri</a>
                    <a href="{{ route('laziswaf.index') }}" class="mag-tab-link">Laziswaf</a>
                </div>
            </div>

            <div class="mag-grid-lead-stack">
                <!-- Lead Article (Left) -->
                @php $lead1 = $berita_terbaru['lead']; @endphp
                <div class="mag-lead-card">
                    <a href="{{ route('article.show', $lead1['slug']) }}" class="mag-lead-thumb">
                        <img src="{{ $lead1['image'] }}" alt="{{ $lead1['title'] }}" loading="lazy">
                    </a>
                    <h3 class="mag-lead-title">
                        <a href="{{ route('article.show', $lead1['slug']) }}">{{ $lead1['title'] }}</a>
                    </h3>
                    <div class="mag-meta-row">
                        <span class="mag-meta-author">{{ $lead1['author'] }}</span>
                        <span>-</span>
                        <span>{{ $lead1['date'] }}</span>
                        @if(!empty($lead1['activity_time']))
                            <span style="color: var(--primary-green); font-weight: 600;"><i class="fa-regular fa-clock" style="margin-right: 3px;"></i>{{ $lead1['activity_time'] }}</span>
                        @endif
                        <span style="margin-left: 8px; font-size: 0.8rem; color: #64748b;" title="Jumlah Pembaca"><i class="fa-regular fa-eye"></i> {{ number_format($lead1['views_count'] ?? 0) }}</span>
                    </div>
                    <p class="mag-lead-summary">
                        {{ $lead1['summary'] }}
                    </p>
                </div>

                <!-- 4 Stacked Articles (Right) -->
                <div class="mag-list-stack">
                    @foreach($berita_terbaru['items'] as $item)
                        <a href="{{ route('article.show', $item['slug']) }}" class="mag-list-item">
                            <div class="mag-list-thumb">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                            </div>
                            <div class="mag-list-info">
                                <h4 class="mag-list-title">{{ $item['title'] }}</h4>
                                <span class="mag-list-date">{{ $item['date'] }} @if(!empty($item['activity_time'])) • <i class="fa-regular fa-clock"></i> {{ $item['activity_time'] }} @endif</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ==================================================================
             SECTION 2: CATATAN (MATCHING SCREENSHOT 2)
             - Blue badge header + underline
             - 2 Columns: Each with 1 medium card + 2 small items below
             ================================================================== -->
        <!-- ==================================================================
             SECTION 2: CATATAN (LAYOUT SAMA SEPERTI KABAR ALUMNI)
             - Blue badge header + underline
             - 1 Lead card di kiri + Stack artikel kecil di kanan
             - Responsif di HP (otomatis bertumpuk rapi)
             ================================================================== -->
        @if(!empty($catatan_section['lead']))
        <section class="mag-section" id="catatan">
            <div class="mag-header-bar theme-blue">
                <a href="{{ route('category.show', 'catatan') }}" class="mag-header-badge">Catatan</a>
            </div>

            <div class="mag-grid-lead-stack">
                <!-- Lead Article (Left) -->
                @php $cLead = $catatan_section['lead']; @endphp
                <div class="mag-lead-card theme-green-title">
                    <a href="{{ route('article.show', $cLead['slug']) }}" class="mag-lead-thumb">
                        <img src="{{ $cLead['image'] }}" alt="{{ $cLead['title'] }}" loading="lazy">
                    </a>
                    <h3 class="mag-lead-title">
                        <a href="{{ route('article.show', $cLead['slug']) }}">{{ $cLead['title'] }}</a>
                    </h3>
                    <div class="mag-meta-row">
                        <span class="mag-meta-author">{{ $cLead['author'] }}</span>
                        <span>-</span>
                        <span>{{ $cLead['date'] }}</span>
                        @if(!empty($cLead['activity_time']))
                            <span style="color: var(--primary-green); font-weight: 600;"><i class="fa-regular fa-clock"></i> {{ $cLead['activity_time'] }}</span>
                        @endif
                    </div>
                    <p class="mag-lead-summary">
                        {{ $cLead['summary'] }}
                    </p>
                </div>

                <!-- Stacked Articles (Right) -->
                @if(!empty($catatan_section['items']) && count($catatan_section['items']) > 0)
                <div class="mag-list-stack">
                    @foreach($catatan_section['items'] as $item)
                        <a href="{{ route('article.show', $item['slug']) }}" class="mag-list-item">
                            <div class="mag-list-thumb">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                            </div>
                            <div class="mag-list-info">
                                <h4 class="mag-list-title">{{ $item['title'] }}</h4>
                                <span class="mag-list-date">{{ $item['date'] }} @if(!empty($item['activity_time'])) • <i class="fa-regular fa-clock"></i> {{ $item['activity_time'] }} @endif</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- ==================================================================
             SECTION 3: KABAR ALUMNI (MATCHING SCREENSHOT 3)
             - Dark badge header + underline
             - 1 Lead post left (green title) + 4 compact items right
             ================================================================== -->
        <section class="mag-section" id="kabar-alumni">
            <div class="mag-header-bar theme-dark">
                <a href="{{ route('page.show', 'alumni') }}" class="mag-header-badge">Kabar Alumni</a>
            </div>

            <div class="mag-grid-lead-stack">
                <!-- Lead Article (Left) -->
                @php $aLead = $alumni_section['lead']; @endphp
                <div class="mag-lead-card theme-green-title">
                    <a href="{{ route('article.show', $aLead['slug']) }}" class="mag-lead-thumb">
                        <img src="{{ $aLead['image'] }}" alt="{{ $aLead['title'] }}" loading="lazy">
                    </a>
                    <h3 class="mag-lead-title">
                        <a href="{{ route('article.show', $aLead['slug']) }}">{{ $aLead['title'] }}</a>
                    </h3>
                    <div class="mag-meta-row">
                        <span class="mag-meta-author">{{ $aLead['author'] }}</span>
                        <span>-</span>
                        <span>{{ $aLead['date'] }}</span>
                        @if(!empty($aLead['activity_time']))
                            <span style="color: var(--primary-green); font-weight: 600;"><i class="fa-regular fa-clock"></i> {{ $aLead['activity_time'] }}</span>
                        @endif
                    </div>
                    <p class="mag-lead-summary">
                        {{ $aLead['summary'] }}
                    </p>
                </div>

                <!-- 4 Stacked Articles (Right) -->
                <div class="mag-list-stack">
                    @foreach($alumni_section['items'] as $item)
                        <a href="{{ route('article.show', $item['slug']) }}" class="mag-list-item">
                            <div class="mag-list-thumb">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                            </div>
                            <div class="mag-list-info">
                                <h4 class="mag-list-title">{{ $item['title'] }}</h4>
                                <span class="mag-list-date">{{ $item['date'] }} @if(!empty($item['activity_time'])) • <i class="fa-regular fa-clock"></i> {{ $item['activity_time'] }} @endif</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ==================================================================
             SECTION 4: LAZISWAF & DONASI (LANGSUNG DONASI & PENJELASAN PERUNTUKAN)
             - Tanpa artikel berita, fokus langsung ke penjelasan dan rekening donasi
             ================================================================== -->
        <section class="mag-section" id="laziswaf">
            <div class="mag-header-bar theme-orange" style="display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('laziswaf.index') }}" class="mag-header-badge">Laziswaf & Donasi</a>
                <div class="mag-header-tabs">
                    <a href="{{ route('laziswaf.index') }}" class="mag-tab-link">Lembaga Zakat</a>
                    <a href="{{ route('donasi.masjid') }}" class="mag-tab-link">Donasi Masjid</a>
                    <a href="{{ route('donasi.pondok') }}" class="mag-tab-link">Donasi Pondok</a>
                </div>
            </div>

            <!-- Penjelasan Ringkas & 3 Kartu Program Donasi Langsung -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 8px 8px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.03);">
                
                <p style="color:#475569; font-size:0.95rem; line-height:1.7; margin-bottom:18px;">
                    Salurkan amal jariyah, zakat, infaq, dan sedekah Anda langsung ke rekening resmi Pondok Pesantren Nurussyam Wringin Arak-arak Bondowoso. Seluruh amanah dikelola secara transparan dan tepat sasaran sesuai peruntukan program di bawah ini:
                </p>

                <!-- 3 Kolom Program: Donasi Masjid, Donasi Pondok, Lembaga Amil Zakat -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px; margin-bottom:22px;">
                    
                    <!-- Program 1: Donasi Masjid -->
                    <div style="background:#f8fafc; border:1.5px solid #bbf7d0; border-top:4px solid var(--primary-green); border-radius:8px; padding:18px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                <div style="width:36px; height:36px; border-radius:8px; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:1.15rem;">
                                    <i class="fa-solid fa-mosque"></i>
                                </div>
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#0f172a;">Donasi Masjid</h4>
                            </div>
                            <strong style="display:block; font-size:0.8rem; color:#15803d; text-transform:uppercase; margin-bottom:6px;">Untuk Apa Donasi Ini?</strong>
                            <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0 0 14px;">
                                Infaq jariyah untuk pemeliharaan rutin sarana ibadah, pengadaan karpet saf shalat santri, perawatan sound system adzan & pengajian kitab kuning, serta kelancaran air wudhu.
                            </p>
                        </div>
                        <a href="{{ route('donasi.masjid') }}" style="background:var(--primary-green); color:#fff; text-align:center; padding:9px 16px; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                            <i class="fa-solid fa-hand-holding-heart"></i> Donasi Masjid Sekarang <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                    </div>

                    <!-- Program 2: Donasi Pondok -->
                    <div style="background:#f8fafc; border:1.5px solid #bfdbfe; border-top:4px solid #1d4ed8; border-radius:8px; padding:18px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                <div style="width:36px; height:36px; border-radius:8px; background:#eff6ff; color:#1d4ed8; display:flex; align-items:center; justify-content:center; font-size:1.15rem;">
                                    <i class="fa-solid fa-school"></i>
                                </div>
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#1e3a8a;">Donasi Pondok</h4>
                            </div>
                            <strong style="display:block; font-size:0.8rem; color:#1d4ed8; text-transform:uppercase; margin-bottom:6px;">Untuk Apa Donasi Ini?</strong>
                            <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0 0 14px;">
                                Bantuan pembangunan dan peremajaan gedung asrama santri, beasiswa makan harian santri yatim & dhuafa, penyediaan kitab kuning salafiyah, dan sarana belajar Madrasah Diniyah.
                            </p>
                        </div>
                        <a href="{{ route('donasi.pondok') }}" style="background:#1d4ed8; color:#fff; text-align:center; padding:9px 16px; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                            <i class="fa-solid fa-graduation-cap"></i> Donasi Pondok Sekarang <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                    </div>

                    <!-- Program 3: LAZISWAF (Zakat & Infaq) -->
                    <div style="background:#f8fafc; border:1.5px solid #fed7aa; border-top:4px solid #ea580c; border-radius:8px; padding:18px; display:flex; flex-direction:column; justify-content:space-between;">
                        <div>
                            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                                <div style="width:36px; height:36px; border-radius:8px; background:#fff7ed; color:#ea580c; display:flex; align-items:center; justify-content:center; font-size:1.15rem;">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                </div>
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#9a3412;">Lembaga Amil Zakat</h4>
                            </div>
                            <strong style="display:block; font-size:0.8rem; color:#ea580c; text-transform:uppercase; margin-bottom:6px;">Untuk Apa Donasi Ini?</strong>
                            <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0 0 14px;">
                                Penyaluran amanah Zakat Mal (harta & profesi), Zakat Fitrah, Fidyah, Infaq, dan Sedekah Subuh secara syar'i langsung kepada 8 asnaf serta santri pra-sejahtera fii sabilillah.
                            </p>
                        </div>
                        <a href="{{ route('laziswaf.index') }}" style="background:#ea580c; color:#fff; text-align:center; padding:9px 16px; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                            <i class="fa-solid fa-hands-praying"></i> Salurkan ZISWAF Sekarang <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                    </div>

                </div>

                <!-- Informasi Bank Tersedia & WhatsApp Panitia (Tanpa Nomor Rekening di Awal) -->
                <div class="laziswaf-donasi-box" style="margin-top:0;">
                    <div class="laziswaf-donasi-header">
                        <i class="fa-solid fa-building-columns" style="font-size:1.15rem;"></i>
                        <span>Penyaluran Donasi Melalui Bank yang Tersedia</span>
                    </div>
                    
                    <div style="padding:16px 18px;">
                        <p style="font-size:0.86rem; color:#78350f; margin:0 0 12px; line-height:1.6;">
                            Donasi dan zakat dapat disalurkan melalui transfer ke rekening bank resmi mitra pondok pesantren berikut:
                        </p>

                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
                            <span style="background:#ffffff; border:1px solid #cbd5e1; color:#1e293b; font-size:0.82rem; font-weight:700; padding:6px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-check" style="color:#1d4ed8;"></i> Bank Mandiri
                            </span>
                            <span style="background:#ffffff; border:1px solid #86efac; color:#166534; font-size:0.82rem; font-weight:700; padding:6px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-check" style="color:#15803d;"></i> Bank Syariah Indonesia (BSI)
                            </span>
                            <span style="background:#ffffff; border:1px solid #bae6fd; color:#0369a1; font-size:0.82rem; font-weight:700; padding:6px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-check" style="color:#0284c7;"></i> Bank BRI
                            </span>
                            <span style="background:#ffffff; border:1px solid #fed7aa; color:#c2410c; font-size:0.82rem; font-weight:700; padding:6px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-check" style="color:#ea580c;"></i> Bank BNI
                            </span>
                            <span style="background:#ffffff; border:1px solid #e2e8f0; color:#475569; font-size:0.82rem; font-weight:700; padding:6px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-check" style="color:#64748b;"></i> Tunai Langsung
                            </span>
                        </div>

                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; border-top:1px dashed #fed7aa; padding-top:12px;">
                            <span style="font-size:0.83rem; color:#92400e; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-circle-info" style="color:#ea580c;"></i> Nomor rekening resmi akan otomatis muncul saat Anda memilih bank pada formulir program donasi.
                            </span>
                            <a href="{{ $laziswaf_section['donasi']['wa_confirm'] }}" target="_blank" rel="noopener noreferrer" class="laziswaf-donasi-btn" style="margin-top:0;">
                                <i class="fa-brands fa-whatsapp" style="font-size:1.1rem;"></i>
                                <span>Konfirmasi via WhatsApp Panitia</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>

    <!-- ======================================================================
         SIDEBAR KANAN (SOSIAL MEDIA & BERITA TERKINI)
         ====================================================================== -->
    <aside class="sidebar-wrapper">

        <!-- WIDGET 1: SOSIAL MEDIA (PERSIS SEPERTI INSTRUKSI) -->
        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text">
                    <i class="fa-solid fa-share-nodes"></i>
                    Sosial Media
                </h3>
            </div>
            <div class="widget-content">
                <div class="social-grid-2x2">
                    <!-- WhatsApp Channel -->
                    <a href="{{ $social_stats['whatsapp']['url'] ?? $social_stats['facebook']['url'] ?? 'https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f' }}" target="_blank" rel="noopener noreferrer" class="social-button btn-whatsapp" title="Saluran WhatsApp Resmi">
                        <div class="soc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="soc-info">
                            <span class="soc-count" data-target="{{ $social_stats['whatsapp']['raw_count'] ?? $social_stats['facebook']['raw_count'] ?? 1250 }}">0</span>
                            <span class="soc-label">{{ $social_stats['whatsapp']['label'] ?? 'Saluran WA' }}</span>
                        </div>
                    </a>

                    <!-- Instagram -->
                    <a href="{{ $social_stats['instagram']['url'] }}" target="_blank" rel="noopener noreferrer" class="social-button btn-instagram" title="Instagram">
                        <div class="soc-icon"><i class="fa-brands fa-instagram"></i></div>
                        <div class="soc-info">
                            <span class="soc-count" data-target="{{ $social_stats['instagram']['raw_count'] ?? 266 }}">0</span>
                            <span class="soc-label">{{ $social_stats['instagram']['label'] ?? 'Followers' }}</span>
                        </div>
                    </a>

                    <!-- TikTok -->
                    <a href="{{ $social_stats['tiktok']['url'] ?? 'https://www.tiktok.com/@ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-button btn-tiktok" title="TikTok">
                        <div class="soc-icon"><i class="fa-brands fa-tiktok"></i></div>
                        <div class="soc-info">
                            <span class="soc-count" data-target="{{ $social_stats['tiktok']['raw_count'] ?? 1364 }}">0</span>
                            <span class="soc-label">{{ $social_stats['tiktok']['label'] ?? 'Followers' }}</span>
                        </div>
                    </a>

                    <!-- YouTube -->
                    <a href="{{ $social_stats['youtube']['url'] }}" target="_blank" rel="noopener noreferrer" class="social-button btn-youtube" title="YouTube">
                        <div class="soc-icon"><i class="fa-brands fa-youtube"></i></div>
                        <div class="soc-info">
                            <span class="soc-count" data-target="{{ $social_stats['youtube']['raw_count'] ?? 500 }}">0</span>
                            <span class="soc-label">{{ $social_stats['youtube']['label'] ?? 'Subscribers' }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- WIDGET 2: BERITA TERKINI (VERTICALLY STACKED ARTICLES) -->
        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text">
                    <i class="fa-solid fa-bolt"></i>
                    Berita Terkini
                </h3>
            </div>
            <div class="widget-content" style="padding-top:12px;">
                <div class="news-vertical-list">
                    @foreach($sidebar_news as $news)
                        <div class="news-vert-item">
                            <a href="{{ route('article.show', $news['slug']) }}" class="news-vert-thumb">
                                <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" loading="lazy">
                            </a>
                            <div class="news-vert-body">
                                <span class="news-vert-date">
                                    <i class="fa-regular fa-calendar-days" style="color:var(--primary-green); margin-right:3px;"></i>
                                    {{ $news['date'] }}
                                </span>
                                <h4 class="news-vert-title">
                                    <a href="{{ route('article.show', $news['slug']) }}">
                                        {{ $news['title'] }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- WIDGET 3: BANNER INFO PENDAFTARAN SANTRI BARU (PSB) -->
        <div class="psb-promo-widget">
            <span class="psb-promo-badge">PENERIMAAN SANTRI BARU</span>
            <h3 class="psb-promo-title">PSB 2026/2027 Telah Dibuka</h3>
            <p class="psb-promo-desc">
                Pondok Pesantren Nurus Syam membuka pendaftaran santri baru untuk jenjang MTs, MA, dan Program Unggulan Tahfidz Al-Qur'an.
            </p>
            <a href="{{ route('pendaftaran') }}" class="psb-promo-btn">
                <span>Daftar Online Sekarang</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </aside>

</div>
@endsection

