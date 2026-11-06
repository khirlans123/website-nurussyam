@extends('admin.layout')

@section('title', 'Dashboard Utama')
@section('page_title', 'Ringkasan Dashboard')

@push('styles')
<style>
    .dashboard-charts-grid {
        display: grid;
        grid-template-columns: 1.65fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .chart-tab-group {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 8px;
        gap: 2px;
    }

    .chart-tab-btn {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .chart-tab-btn.active {
        background: #ffffff;
        color: var(--adm-primary);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    @media (max-width: 992px) {
        .dashboard-charts-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- Executive Welcome Header -->
    <div class="page-head">
        <div class="page-head-info">
            <div class="page-head-badge">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Panel Kendali Resmi</span>
            </div>
            <h1 class="page-head-title">
                Selamat Datang, <strong>{{ auth()->user()->name }}</strong>
            </h1>
            <p class="page-head-subtitle">Panel kendali terpusat website resmi Pondok Pesantren Nurussyam Wringin Bondowoso.</p>
        </div>
        <div class="page-head-actions">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.students.index') }}" class="btn btn-primary" title="Data Santri Aktif">
                    <i class="fa-solid fa-users"></i>
                    <span>Data Santri</span>
                    @if($stats['accepted_registrations'] > 0)
                        <span class="btn-badge" style="background: rgba(255,255,255,0.25); color: #fff;">{{ $stats['accepted_registrations'] }}</span>
                    @endif
                </a>
            @endif
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Cek PSB</span>
                @if($stats['pending_registrations'] > 0)
                    <span class="btn-badge">{{ $stats['pending_registrations'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-secondary">
                <i class="fa-solid fa-plus"></i>
                <span>Tulis Berita</span>
            </a>
        </div>
    </div>

    <!-- ==============================================================
         STATS OVERVIEW CARDS (Responsive Grid)
         ============================================================== -->
    <div class="stats-grid">
        @if(auth()->user()->isAdmin())
            <!-- Card 1: Santri Aktif (Diterima) -->
            <a href="{{ route('admin.students.index') }}" class="stat-card" title="Kelola Data Santri Aktif">
                <div class="stat-icon stat-icon-emerald">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">Santri Aktif</span>
                    <span class="stat-value">{{ number_format($stats['accepted_registrations']) }}</span>
                    <span class="stat-subtext">
                        <span style="color: var(--adm-primary); font-weight: 700;">Resmi Diterima</span>
                        &bull; Santri Nurussyam
                    </span>
                </div>
            </a>
        @endif

        <!-- Card 2: Pendaftar PSB -->
        <a href="{{ route('admin.registrations.index') }}" class="stat-card" title="Kelola Pendaftaran Santri">
            <div class="stat-icon stat-icon-amber">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Pendaftar PSB</span>
                <span class="stat-value">{{ number_format($stats['total_registrations']) }}</span>
                <span class="stat-subtext">
                    @if($stats['pending_registrations'] > 0)
                        <span style="color: var(--adm-accent); font-weight: 700;">
                            <i class="fa-solid fa-clock"></i> {{ $stats['pending_registrations'] }} Menunggu
                        </span>
                    @else
                        <span>Semua terverifikasi</span>
                    @endif
                </span>
            </div>
        </a>

        <!-- Card 3: Berita / Artikel -->
        <a href="{{ route('admin.articles.index') }}" class="stat-card" title="Kelola Semua Berita">
            <div class="stat-icon stat-icon-blue">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Berita</span>
                <span class="stat-value">{{ number_format($stats['total_articles']) }}</span>
                <span class="stat-subtext">
                    <span style="color: #2563eb; font-weight: 700;">{{ $stats['published_articles'] }} Terbit</span>
                    &bull; {{ $stats['draft_articles'] }} Draft
                </span>
            </div>
        </a>

        @if(auth()->user()->isAdmin())
            <!-- Card 4: Donasi Laziswaf -->
            <a href="{{ route('admin.donations.index') }}" class="stat-card" title="Kelola LAZISWAF & Donasi">
                <div class="stat-icon stat-icon-emerald" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #047857;">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div class="stat-info">
                    <span class="stat-label">LAZISWAF</span>
                    <span class="stat-value">Rp {{ number_format($stats['verified_donations_amount'], 0, ',', '.') }}</span>
                    <span class="stat-subtext">
                        {{ $stats['total_donations'] }} Transaksi Masuk
                    </span>
                </div>
            </a>
        @endif

        <!-- Card 5: Kategori Berita -->
        <a href="{{ route('admin.categories.index') }}" class="stat-card" title="Kelola Kategori Berita">
            <div class="stat-icon stat-icon-purple">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Kategori Berita</span>
                <span class="stat-value">{{ $stats['total_categories'] }}</span>
                <span class="stat-subtext">
                    {{ number_format($stats['total_views']) }} Pembaca
                </span>
            </div>
        </a>
    </div>

    <!-- ==============================================================
         INTERACTIVE ANALYTICS & CHARTS SECTION
         ============================================================== -->
    <div class="dashboard-charts-grid">
        
        <!-- Chart 1: Tren Pendaftaran Santri (PSB) 6 Bulan -->
        <div class="adm-card chart-card" style="margin-bottom: 0; display: flex; flex-direction: column;">
            <div class="adm-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                <div>
                    <h2 class="adm-card-title" style="font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-chart-line" style="color: var(--adm-primary);"></i>
                        <span>Tren Pendaftaran Santri (PSB)</span>
                    </h2>
                    <p style="font-size: 0.78rem; color: var(--adm-text-muted); margin: 2px 0 0;">
                        Statistik formulir pendaftaran masuk &amp; santri diterima dalam 6 bulan terakhir
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <span class="badge badge-emerald" style="font-size: 0.72rem; padding: 3px 8px;">
                        <span class="badge-dot"></span> Real-time
                    </span>
                </div>
            </div>
            <div class="adm-card-body" style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="psbTrendChart"></canvas>
                </div>
                
                <!-- Summary mini stats under chart -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; text-align: center;">
                    <div>
                        <span style="font-size: 0.72rem; color: var(--adm-text-muted); display: block;">Total Pendaftar</span>
                        <strong style="font-size: 1.15rem; color: var(--adm-text-main);">{{ array_sum($chartData['registrations'] ?? []) }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.72rem; color: var(--adm-text-muted); display: block;">Santri Diterima</span>
                        <strong style="font-size: 1.15rem; color: var(--adm-primary);">{{ array_sum($chartData['accepted'] ?? []) }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.72rem; color: var(--adm-text-muted); display: block;">Tingkat Kelulusan</span>
                        @php
                            $total6 = array_sum($chartData['registrations'] ?? []);
                            $acc6 = array_sum($chartData['accepted'] ?? []);
                            $ratio = $total6 > 0 ? round(($acc6 / $total6) * 100) : 0;
                        @endphp
                        <strong style="font-size: 1.15rem; color: #2563eb;">{{ $ratio }}%</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Komposisi Pendaftar & Santri (Donut) -->
        <div class="adm-card chart-card" style="margin-bottom: 0; display: flex; flex-direction: column;">
            <div class="adm-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                <h2 class="adm-card-title" style="font-size: 1.05rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-pie" style="color: #6366f1;"></i>
                    <span>Distribusi Santri</span>
                </h2>
                
                <!-- Tab Switcher for Donut Chart -->
                <div class="chart-tab-group">
                    <button type="button" class="chart-tab-btn active" onclick="switchDonutChart('jenjang', this)">
                        Jenjang
                    </button>
                    <button type="button" class="chart-tab-btn" onclick="switchDonutChart('gender', this)">
                        Gender
                    </button>
                    <button type="button" class="chart-tab-btn" onclick="switchDonutChart('status', this)">
                        Status
                    </button>
                </div>
            </div>

            <div class="adm-card-body" style="padding: 1.25rem; flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="position: relative; height: 215px; width: 100%; display: flex; align-items: center; justify-content: center;">
                    <canvas id="psbDistributionChart"></canvas>
                    <!-- Center Text inside Doughnut -->
                    <div style="position: absolute; text-align: center; pointer-events: none;">
                        <span style="font-size: 0.7rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; display: block;" id="donutCenterLabel">TOTAL</span>
                        <strong style="font-size: 1.4rem; font-weight: 800; color: var(--adm-text-main); line-height: 1;" id="donutCenterValue">{{ $stats['total_registrations'] }}</strong>
                    </div>
                </div>

                <!-- Custom Clean Legend Box -->
                <div id="donutCustomLegend" style="margin-top: 14px; width: 100%; display: flex; flex-wrap: wrap; justify-content: center; gap: 8px 12px; font-size: 0.75rem; color: var(--adm-text-muted);">
                    <!-- Rendered via JS -->
                </div>
            </div>
        </div>

    </div>

    <!-- ==============================================================
         TWO-COLUMN DASHBOARD PANELS
         ============================================================== -->
    <div class="adm-grid-dashboard">
        
        <!-- Left Panel: Berita Terbaru -->
        <div class="adm-card" style="margin-bottom: 0;">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-newspaper"></i>
                    <span>Berita & Artikel Terbaru</span>
                </h2>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="adm-card-body" style="padding: 0;">
                <!-- Desktop Table View -->
                <div class="desktop-only-table table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul & Kategori</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentArticles as $art)
                                <tr>
                                    <td style="width: 70px;">
                                        <img src="{{ (str_starts_with($art->image, 'http') || str_starts_with($art->image, '/')) ? $art->image : asset($art->image) }}" alt="{{ $art->title }}" class="table-thumbnail">
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <a href="{{ route('admin.articles.edit', $art) }}" style="color: var(--adm-text-main);" title="{{ $art->title }}">
                                                {{ $art->title }}
                                            </a>
                                        </div>
                                        <div style="font-size: 0.74rem; color: var(--adm-text-muted); display: flex; align-items: center; gap: 0.5rem; margin-top: 0.2rem;">
                                            <span style="color: {{ $art->badge_color ?? 'var(--adm-primary)' }}; font-weight: 600;">{{ $art->category }}</span>
                                            &bull; <span>{{ $art->date ?? 'Baru saja' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($art->is_published)
                                            <span class="badge badge-emerald"><span class="badge-dot"></span> Terbit</span>
                                        @else
                                            <span class="badge badge-slate"><span class="badge-dot"></span> Draft</span>
                                        @endif
                                        @if($art->is_featured)
                                            <span class="badge badge-amber" style="margin-top: 3px; display: inline-block;">Utama</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 0.35rem;">
                                            <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="btn btn-secondary btn-icon" title="Lihat di Web">
                                                <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.75rem;"></i>
                                            </a>
                                            <a href="{{ route('admin.articles.edit', $art) }}" class="btn btn-primary btn-icon" title="Edit Berita">
                                                <i class="fa-solid fa-pen-to-square" style="font-size: 0.75rem;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--adm-text-muted);">
                                        Belum ada artikel. <a href="{{ route('admin.articles.create') }}" style="color: var(--adm-primary); font-weight: 600;">Tulis artikel pertama sekarang</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View -->
                <div class="mobile-dash-list">
                    @forelse($recentArticles as $art)
                        <div class="mobile-dash-item">
                            <img src="{{ (str_starts_with($art->image, 'http') || str_starts_with($art->image, '/')) ? $art->image : asset($art->image) }}" alt="{{ $art->title }}" class="mobile-dash-thumb">
                            <div class="mobile-dash-content">
                                <a href="{{ route('admin.articles.edit', $art) }}" class="mobile-dash-title">
                                    {{ $art->title }}
                                </a>
                                <div class="mobile-dash-meta">
                                    <span class="badge" style="background: {{ $art->badge_color ?? '#0f8528' }}20; color: {{ $art->badge_color ?? '#0f8528' }}; font-size: 0.7rem; padding: 0.15rem 0.45rem;">
                                        {{ $art->category }}
                                    </span>
                                    <span>{{ $art->date ?? 'Baru' }}</span>
                                    @if($art->is_published)
                                        <span class="badge badge-emerald" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">Terbit</span>
                                    @else
                                        <span class="badge badge-slate" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">Draft</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('admin.articles.edit', $art) }}" class="btn btn-secondary btn-icon" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                    @empty
                        <div style="padding: 1.5rem; text-align: center; color: var(--adm-text-muted); font-size: 0.85rem;">
                            Belum ada artikel berita.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Panel: Pendaftar Santri Baru Terkini -->
        <div class="adm-card" style="margin-bottom: 0;">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Pendaftaran Santri (PSB)</span>
                </h2>
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary btn-sm">
                    <span>Lihat Semua</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="adm-card-body" style="padding: 0;">
                <!-- Desktop Table View -->
                <div class="desktop-only-table table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>No. Reg & Santri</th>
                                <th>Jenjang</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRegistrations as $reg)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: var(--adm-text-main);">
                                            {{ $reg->nama_lengkap }}
                                        </div>
                                        <div style="font-size: 0.74rem; color: var(--adm-text-muted); display: flex; align-items: center; gap: 0.4rem; margin-top: 0.15rem;">
                                            <code>{{ $reg->no_pendaftaran }}</code>
                                            &bull;
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->no_wa) }}" target="_blank" style="color: #15803d; font-weight: 600;">
                                                <i class="fa-brands fa-whatsapp"></i> {{ $reg->no_wa }}
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-slate">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $reg->pilihan_jenjang) }}</span>
                                    </td>
                                    <td>
                                        @if($reg->status === 'Pending')
                                            <span class="badge badge-amber"><span class="badge-dot"></span> Pending</span>
                                        @elseif($reg->status === 'Diverifikasi')
                                            <span class="badge badge-blue"><span class="badge-dot"></span> Diverifikasi</span>
                                        @elseif($reg->status === 'Diterima')
                                            <span class="badge badge-emerald"><span class="badge-dot"></span> Diterima</span>
                                        @else
                                            <span class="badge badge-red"><span class="badge-dot"></span> {{ $reg->status }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-secondary btn-sm">
                                            <span>Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 2rem; color: var(--adm-text-muted);">
                                        Belum ada pendaftaran masuk dari website.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List View -->
                <div class="mobile-dash-list">
                    @forelse($recentRegistrations as $reg)
                        <div class="mobile-dash-item">
                            <div class="mobile-psb-avatar">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div class="mobile-dash-content">
                                <div class="mobile-dash-title" style="font-weight: 700;">
                                    {{ $reg->nama_lengkap }}
                                </div>
                                <div class="mobile-dash-meta">
                                    <code>{{ $reg->no_pendaftaran }}</code>
                                    <span class="badge badge-slate" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">
                                        {{ str_replace('Salafiyah', "Ma'had Nurussyam", $reg->pilihan_jenjang) }}
                                    </span>
                                    @if($reg->status === 'Pending')
                                        <span class="badge badge-amber" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">Pending</span>
                                    @elseif($reg->status === 'Diterima')
                                        <span class="badge badge-emerald" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">Diterima</span>
                                    @else
                                        <span class="badge badge-slate" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">{{ $reg->status }}</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-secondary btn-sm" style="flex-shrink: 0; padding: 0.45rem 0.65rem;">
                                <span>Detail</span>
                            </a>
                        </div>
                    @empty
                        <div style="padding: 1.5rem; text-align: center; color: var(--adm-text-muted); font-size: 0.85rem;">
                            Belum ada formulir santri baru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ==============================================================
         SANTRI RESMI DITERIMA TERKINI (DATA SANTRI AKTIF - ADMIN ONLY)
         ============================================================== -->
    @if(auth()->user()->isAdmin())
    <div class="adm-card" style="margin-top: 1.5rem; margin-bottom: 0;">
        <div class="adm-card-header">
            <h2 class="adm-card-title">
                <i class="fa-solid fa-id-card" style="color: var(--adm-primary);"></i>
                <span>Santri Resmi Diterima Terkini (Santri Aktif)</span>
            </h2>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah Santri</span>
                </a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
                    <span>Lihat Semua Santri</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table" style="min-width: 950px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 140px; white-space: nowrap;">No. Induk / Reg</th>
                            <th>Nama Santri</th>
                            <th style="width: 140px;">Jenjang</th>
                            <th>Kontak & WhatsApp</th>
                            <th>Asal Sekolah</th>
                            <th style="width: 140px; text-align: center;">Status</th>
                            <th style="text-align: right; width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $st)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $st->no_wa);
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;">
                                    <strong style="color: var(--adm-primary);">{{ $st->no_pendaftaran }}</strong>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        {{ $st->updated_at->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--adm-text-main);">
                                        <a href="{{ route('admin.students.show', $st) }}" style="color: var(--adm-text-main);">
                                            {{ $st->nama_lengkap }}
                                        </a>
                                    </div>
                                    <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        {{ $st->jenis_kelamin }} &bull; Wali: {{ $st->nama_wali }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-slate">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang) }}</span>
                                </td>
                                <td>
                                    <a href="https://wa.me/{{ $cleanWa }}" target="_blank" style="color: #15803d; font-weight: 600; font-size: 0.82rem;">
                                        <i class="fa-brands fa-whatsapp"></i> {{ $st->no_wa }}
                                    </a>
                                </td>
                                <td>
                                    <span style="font-size: 0.82rem; color: var(--adm-text-muted);">{{ $st->asal_sekolah ?? '-' }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="badge badge-emerald"><i class="fa-solid fa-circle-check"></i> Aktif</span>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <div class="table-actions-row">
                                        <a href="{{ route('admin.students.card', $st) }}" target="_blank" class="btn btn-secondary btn-sm" style="color: #1e40af; border-color: #bfdbfe;" title="Cetak Kartu Santri">
                                            <i class="fa-solid fa-id-card"></i>
                                            <span>Kartu</span>
                                        </a>
                                        <a href="{{ route('admin.students.show', $st) }}" class="btn btn-primary btn-sm" title="Lihat Profil">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Profil</span>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $st) }}" class="btn btn-secondary btn-icon" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2.5rem 1rem; color: var(--adm-text-muted);">
                                    Belum ada santri berstatus Diterima. Silakan setujui formulir di <a href="{{ route('admin.registrations.index') }}" style="color: var(--adm-primary); font-weight: 700;">Menu Pendaftaran PSB</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card List View -->
            <div class="mobile-dash-list">
                @forelse($recentStudents as $st)
                    <div class="mobile-dash-item">
                        <div class="mobile-psb-avatar" style="background: linear-gradient(135deg, #092a14, #0f8528); color: #fff;">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="mobile-dash-content">
                            <div class="mobile-dash-title" style="font-weight: 700;">
                                {{ $st->nama_lengkap }}
                            </div>
                            <div class="mobile-dash-meta">
                                <code>{{ $st->no_pendaftaran }}</code>
                                <span class="badge badge-slate" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang) }}</span>
                                <span class="badge badge-emerald" style="font-size: 0.7rem; padding: 0.15rem 0.45rem;">Diterima</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.35rem; flex-shrink: 0;">
                            <a href="{{ route('admin.students.card', $st) }}" target="_blank" class="btn btn-secondary btn-icon" title="Cetak Kartu">
                                <i class="fa-solid fa-id-card"></i>
                            </a>
                            <a href="{{ route('admin.students.show', $st) }}" class="btn btn-primary btn-sm" style="padding: 0.45rem 0.65rem;">
                                <span>Detail</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="padding: 1.5rem; text-align: center; color: var(--adm-text-muted); font-size: 0.85rem;">
                        Belum ada santri aktif diterima.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Shortcuts Banner -->
    <div class="adm-card" style="background: linear-gradient(135deg, #092a14, #0f8528); color: #ffffff; border: none; margin-top: 1.25rem;">
        <div class="adm-card-body" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.25rem; padding: 1.35rem 1.25rem;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.35rem;">
                    <i class="fa-solid fa-wand-magic-sparkles" style="color: #fde047; margin-right: 0.4rem;"></i>
                    Kelola Website Pesantren
                </h3>
                <p style="font-size: 0.82rem; color: #bbf7d0; max-width: 600px; line-height: 1.4;">
                    Unggah warta pondok, verifikasi santri baru PSB, perbarui rekening LAZISWAF, dan atur media sosial kapan saja.
                </p>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; width: 100%; max-width: 360px;">
                <a href="{{ route('admin.articles.create') }}" class="btn" style="flex: 1; background-color: #ffffff; color: #064e18; font-weight: 700; justify-content: center; font-size: 0.8rem; padding: 0.6rem 0.75rem;">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span>Tulis Warta</span>
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.settings.index') }}" class="btn" style="flex: 1; background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); justify-content: center; font-size: 0.8rem; padding: 0.6rem 0.75rem;">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Pengaturan</span>
                    </a>
                @else
                    <a href="{{ route('admin.registrations.index') }}" class="btn" style="flex: 1; background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); justify-content: center; font-size: 0.8rem; padding: 0.6rem 0.75rem;">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Cek PSB</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    (function () {
        const chartData = @json($chartData ?? []);
        
        // 1. TREN LINE / AREA CHART
        const trendCanvas = document.getElementById('psbTrendChart');
        if (trendCanvas && chartData.months) {
            const trendCtx = trendCanvas.getContext('2d');
            
            const greenGrad = trendCtx.createLinearGradient(0, 0, 0, 260);
            greenGrad.addColorStop(0, 'rgba(15, 133, 40, 0.28)');
            greenGrad.addColorStop(1, 'rgba(15, 133, 40, 0.01)');

            const blueGrad = trendCtx.createLinearGradient(0, 0, 0, 260);
            blueGrad.addColorStop(0, 'rgba(37, 99, 235, 0.20)');
            blueGrad.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: chartData.months,
                    datasets: [
                        {
                            label: 'Total Pendaftar',
                            data: chartData.registrations,
                            borderColor: '#0f8528',
                            backgroundColor: greenGrad,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0f8528',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Santri Diterima',
                            data: chartData.accepted,
                            borderColor: '#2563eb',
                            backgroundColor: blueGrad,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 11, weight: '600', family: 'Plus Jakarta Sans' },
                                color: '#475569'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8,
                            titleFont: { size: 12, weight: '700' },
                            bodyFont: { size: 12 },
                            callbacks: {
                                label: function(ctx) {
                                    return ` ${ctx.dataset.label}: ${ctx.raw} calon santri`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, family: 'Plus Jakarta Sans' },
                                color: '#64748b'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: { size: 11, family: 'Plus Jakarta Sans' },
                                color: '#64748b'
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        }
                    }
                }
            });
        }

        // 2. DOUGHNUT DISTRIBUTION CHART
        let donutChart = null;
        const donutConfigs = {
            jenjang: {
                labels: chartData.jenjang?.labels || ['MTs Nurussyam', 'MA Nurussyam', 'Tahfidz Al-Qur\'an', 'Madrasah Diniyah'],
                data: chartData.jenjang?.data || [0, 0, 0, 0],
                colors: ['#0f8528', '#2563eb', '#f59e0b', '#8b5cf6'],
                centerLabel: 'JENJANG'
            },
            gender: {
                labels: chartData.gender?.labels || ['Santri Putra', 'Santri Putri'],
                data: chartData.gender?.data || [0, 0],
                colors: ['#2563eb', '#db2777'],
                centerLabel: 'GENDER'
            },
            status: {
                labels: chartData.status?.labels || ['Diterima', 'Diverifikasi', 'Pending', 'Ditolak'],
                data: chartData.status?.data || [0, 0, 0, 0],
                colors: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                centerLabel: 'STATUS'
            }
        };

        window.switchDonutChart = function (type, btn) {
            document.querySelectorAll('.chart-tab-btn').forEach(b => b.classList.remove('active'));
            if (btn) btn.classList.add('active');

            const cfg = donutConfigs[type] || donutConfigs.jenjang;
            const total = cfg.data.reduce((a, b) => a + b, 0);

            const centerLbl = document.getElementById('donutCenterLabel');
            const centerVal = document.getElementById('donutCenterValue');
            if (centerLbl) centerLbl.textContent = cfg.label || cfg.centerLabel;
            if (centerVal) centerVal.textContent = total;

            // Render custom legend below chart
            const legendEl = document.getElementById('donutCustomLegend');
            if (legendEl) {
                legendEl.innerHTML = cfg.labels.map((lbl, idx) => {
                    const val = cfg.data[idx] || 0;
                    const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                    return `
                        <div style="display:inline-flex; align-items:center; gap:5px;">
                            <span style="width:8px; height:8px; border-radius:50%; background:${cfg.colors[idx]}; display:inline-block; flex-shrink:0;"></span>
                            <span>${lbl}: <strong style="color:#0f172a;">${val}</strong> <small style="color:#94a3b8;">(${pct}%)</small></span>
                        </div>
                    `;
                }).join('');
            }

            if (donutChart) {
                donutChart.data.labels = cfg.labels;
                donutChart.data.datasets[0].data = cfg.data;
                donutChart.data.datasets[0].backgroundColor = cfg.colors;
                donutChart.update();
                return;
            }

            const donutCanvas = document.getElementById('psbDistributionChart');
            if (donutCanvas) {
                const ctx = donutCanvas.getContext('2d');
                donutChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: cfg.labels,
                        datasets: [{
                            data: cfg.data,
                            backgroundColor: cfg.colors,
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        const val = context.raw || 0;
                                        const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                                        return ` ${context.label}: ${val} santri (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        };

        // Initialize Donut Chart with Jenjang tab
        switchDonutChart('jenjang');
    })();
</script>
@endpush
