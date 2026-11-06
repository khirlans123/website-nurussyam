@extends('admin.layout')

@section('title', 'Pengaturan Informasi & Gelombang PSB')
@section('page_title', 'Pengaturan PSB')

@push('styles')
<style>
    /* Responsive Styling for PSB Settings */
    .psb-grid-2col {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .psb-preview-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .psb-form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.25rem;
    }

    .hero-switch-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
    }

    .hero-switch-content-wrap {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
        flex: 1;
    }

    .psb-action-bar {
        background: #ffffff;
        border: 1px solid var(--adm-border);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1.5rem;
        margin-bottom: 2rem;
    }

    .psb-action-bar-buttons {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Tablet & Phone Screens (<= 768px) */
    @media (max-width: 768px) {
        .adm-card {
            overflow: hidden;
            max-width: 100% !important;
            box-sizing: border-box;
        }

        .adm-card-body {
            padding: 1rem 0.85rem !important;
            box-sizing: border-box;
        }

        .psb-grid-2col,
        .psb-preview-cards-grid,
        .psb-form-row {
            grid-template-columns: 1fr !important;
            gap: 0.85rem !important;
        }

        .page-head {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
            padding: 1rem 0.85rem;
        }

        .page-head-actions-wrap {
            width: 100% !important;
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 0.5rem !important;
        }

        .page-head-actions-wrap .btn {
            font-size: 0.78rem !important;
            padding: 0.55rem 0.5rem !important;
            justify-content: center !important;
            text-align: center !important;
            white-space: normal !important;
            line-height: 1.25 !important;
            box-sizing: border-box;
        }

        .page-head-actions-wrap .btn:last-child {
            grid-column: span 2 !important;
            padding: 0.7rem 0.75rem !important;
            font-weight: 800;
        }

        .hero-switch-box {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
        }

        .hero-switch-content-wrap {
            display: flex !important;
            align-items: flex-start !important;
            gap: 0.75rem !important;
            width: 100% !important;
            min-width: 0 !important;
        }

        .hero-switch-icon-wrap {
            width: 44px !important;
            height: 44px !important;
            font-size: 1.3rem !important;
            border-radius: 10px !important;
            margin-top: 2px !important;
            flex-shrink: 0 !important;
        }

        .hero-switch-box form,
        .hero-switch-box form button,
        .psb-hero-toggle-btn {
            width: 100% !important;
            justify-content: center !important;
            box-sizing: border-box !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.9rem !important;
        }

        .psb-hero-badge {
            white-space: normal !important;
            word-break: break-word !important;
            line-height: 1.3 !important;
            font-size: 0.75rem !important;
            padding: 3px 8px !important;
        }

        .psb-hero-title {
            font-size: 1.05rem !important;
            line-height: 1.35 !important;
            word-break: break-word !important;
        }

        .psb-hero-desc {
            font-size: 0.8rem !important;
            line-height: 1.45 !important;
            word-break: break-word !important;
        }

        .psb-action-bar {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 1rem 0.85rem !important;
            margin-top: 1rem !important;
            margin-bottom: calc(85px + env(safe-area-inset-bottom)) !important;
            box-sizing: border-box;
        }

        .psb-action-bar-info {
            text-align: center;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .psb-action-bar-buttons {
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 0.5rem !important;
        }

        .psb-action-bar-buttons .btn {
            width: 100% !important;
            justify-content: center !important;
            padding: 0.85rem 1rem !important;
            box-sizing: border-box !important;
            font-size: 0.92rem !important;
        }

        .adm-card-header {
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            padding: 0.85rem !important;
        }
    }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Pengaturan Informasi &amp; Gelombang PSB</span>
            </h1>
            <p class="page-head-subtitle">
                Atur status buka/tutup pendaftaran santri baru, tahun ajaran, jadwal Gelombang I &amp; II, dan kontak panitia secara real-time.
            </p>
        </div>
        <div class="page-head-actions-wrap">
            <a href="{{ route('pendaftaran.info') }}" target="_blank" class="btn btn-secondary" title="Buka Halaman Informasi Publik">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Info PSB Publik</span>
            </a>
            <a href="{{ route('pendaftaran') }}" target="_blank" class="btn btn-secondary" title="Buka Formulir Online">
                <i class="fa-solid fa-file-pen"></i>
                <span>Formulir Web</span>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-primary" title="Kelola Formulir Masuk">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Kelola Data Pendaftar</span>
            </a>
        </div>
    </div>

    <!-- Quick Status Hero Card: Master Switch PSB -->
    <div class="adm-card psb-master-hero-card" style="margin-bottom: 1.25rem; border-left: 5px solid {{ ($psb['psb_status'] ?? '1') == '1' ? 'var(--adm-primary)' : '#e11d48' }}; background: linear-gradient(135deg, #ffffff, {{ ($psb['psb_status'] ?? '1') == '1' ? 'rgba(240, 253, 244, 0.7)' : 'rgba(255, 241, 242, 0.7)' }}); overflow: hidden;">
        <div class="adm-card-body psb-master-hero-body" style="padding: 1.25rem 1.5rem;">
            <div class="hero-switch-box">
                <div class="hero-switch-content-wrap">
                    <div class="hero-switch-icon-wrap" style="width: 52px; height: 52px; border-radius: 12px; background: {{ ($psb['psb_status'] ?? '1') == '1' ? 'rgba(15, 133, 40, 0.15)' : 'rgba(225, 29, 72, 0.15)' }}; color: {{ ($psb['psb_status'] ?? '1') == '1' ? 'var(--adm-primary)' : '#e11d48' }}; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;">
                        <i class="fa-solid {{ ($psb['psb_status'] ?? '1') == '1' ? 'fa-bullhorn' : 'fa-lock' }}"></i>
                    </div>
                    <div style="min-width: 0; flex: 1;">
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 4px;">
                            <span class="badge {{ ($psb['psb_status'] ?? '1') == '1' ? 'badge-emerald' : 'badge-rose' }} psb-hero-badge">
                                {{ ($psb['psb_status'] ?? '1') == '1' ? '● PENDAFTARAN AKTIF' : '● PENDAFTARAN DITUTUP' }}
                            </span>
                            <span style="font-size: 0.82rem; color: var(--adm-text-muted); font-weight: 700;">
                                TA: <strong style="color: var(--adm-text-main);">{{ $psb['psb_tahun_ajaran'] ?? '2026/2027' }}</strong>
                            </span>
                        </div>
                        <h2 class="psb-hero-title" style="font-size: 1.15rem; font-weight: 800; color: var(--adm-text-main); margin: 4px 0; line-height: 1.35; word-break: break-word;">
                            {{ ($psb['psb_status'] ?? '1') == '1' ? 'Penerimaan Santri Baru Siap Menerima Pendaftaran' : 'Pendaftaran Formulir Online Ditutup Sementara' }}
                        </h2>
                        <p class="psb-hero-desc" style="font-size: 0.85rem; color: var(--adm-text-muted); margin: 0; line-height: 1.5; word-break: break-word;">
                            {{ ($psb['psb_status'] ?? '1') == '1' 
                                ? 'Formulir online aktif menerima calon santri. Anda dapat mengatur jadwal dan periode Gelombang I & Gelombang II di bawah.' 
                                : 'Formulir online dinonaktifkan di halaman publik, namun santri yang sudah terdaftar tetap bisa mengecek status verifikasi mereka.' }}
                        </p>
                    </div>
                </div>

                <!-- Tombol Cepat Toggle Status PSB -->
                <form action="{{ route('admin.psb.settings.toggle') }}" method="POST" style="margin: 0; width: auto;" class="hero-switch-form">
                    @csrf
                    <input type="hidden" name="target" value="psb_status">
                    <button type="submit" class="btn psb-hero-toggle-btn" style="background: {{ ($psb['psb_status'] ?? '1') == '1' ? '#dc2626' : 'var(--adm-primary)' }}; color: #ffffff; padding: 0.75rem 1.4rem; font-weight: 700; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid {{ ($psb['psb_status'] ?? '1') == '1' ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                        <span>{{ ($psb['psb_status'] ?? '1') == '1' ? 'Tutup / Nonaktifkan PSB' : 'Buka / Aktifkan PSB Sekarang' }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Gelombang Quick Preview Cards -->
    <div class="psb-preview-cards-grid">
        
        <!-- Gelombang 1 Card Summary -->
        <div class="adm-card" style="border-top: 4px solid {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#10b981' : '#94a3b8' }};">
            <div class="adm-card-body" style="padding: 1.15rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; gap: 8px; flex-wrap: wrap;">
                    <span class="badge {{ ($psb['psb_g1_active'] ?? '1') == '1' ? 'badge-emerald' : 'badge-secondary' }}" style="font-weight: 800; font-size: 0.75rem;">
                        {{ $psb['psb_g1_badge'] ?? 'GELOMBANG I' }}
                    </span>
                    <form action="{{ route('admin.psb.settings.toggle') }}" method="POST" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="target" value="psb_g1_active">
                        <button type="submit" class="btn btn-sm" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; font-weight: 700; background: {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#fef2f2; color:#dc2626; border:1px solid #fecaca;' : '#f0fdf4; color:#15803d; border:1px solid #bbf7d0;' }}">
                            {{ ($psb['psb_g1_active'] ?? '1') == '1' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 6px; word-break: break-word;">
                    {{ $psb['psb_g1_name'] ?? 'Gelombang Pertama' }}
                </h3>
                <div style="font-size: 0.85rem; color: var(--adm-text-muted); line-height: 1.75;">
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-regular fa-calendar" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Daftar:</strong> {{ $psb['psb_g1_dates'] ?? '-' }}</div>
                    </div>
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-solid fa-pen-to-square" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Tes:</strong> {{ $psb['psb_g1_test'] ?? '-' }}</div>
                    </div>
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-solid fa-bullhorn" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Pengumuman:</strong> {{ $psb['psb_g1_announcement'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gelombang 2 Card Summary -->
        <div class="adm-card" style="border-top: 4px solid {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#10b981' : '#94a3b8' }};">
            <div class="adm-card-body" style="padding: 1.15rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; gap: 8px; flex-wrap: wrap;">
                    <span class="badge {{ ($psb['psb_g2_active'] ?? '1') == '1' ? 'badge-emerald' : 'badge-secondary' }}" style="font-weight: 800; font-size: 0.75rem;">
                        {{ $psb['psb_g2_badge'] ?? 'GELOMBANG II' }}
                    </span>
                    <form action="{{ route('admin.psb.settings.toggle') }}" method="POST" style="margin: 0;">
                        @csrf
                        <input type="hidden" name="target" value="psb_g2_active">
                        <button type="submit" class="btn btn-sm" style="font-size: 0.75rem; padding: 4px 10px; border-radius: 6px; font-weight: 700; background: {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#fef2f2; color:#dc2626; border:1px solid #fecaca;' : '#f0fdf4; color:#15803d; border:1px solid #bbf7d0;' }}">
                            {{ ($psb['psb_g2_active'] ?? '1') == '1' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 6px; word-break: break-word;">
                    {{ $psb['psb_g2_name'] ?? 'Gelombang Kedua' }}
                </h3>
                <div style="font-size: 0.85rem; color: var(--adm-text-muted); line-height: 1.75;">
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-regular fa-calendar" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Daftar:</strong> {{ $psb['psb_g2_dates'] ?? '-' }}</div>
                    </div>
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-solid fa-pen-to-square" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Tes:</strong> {{ $psb['psb_g2_test'] ?? '-' }}</div>
                    </div>
                    <div style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fa-solid fa-bullhorn" style="width: 16px; color: var(--adm-primary); margin-top:4px; flex-shrink:0;"></i> 
                        <div><strong>Pengumuman:</strong> {{ $psb['psb_g2_announcement'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- MAIN FORM PENGATURAN PSB -->
    <form action="{{ route('admin.psb.settings.update') }}" method="POST">
        @csrf

        <!-- SECTION 1: INFORMASI UMUM & TAHUN AJARAN -->
        <div class="adm-card" style="margin-bottom: 1.5rem;">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-sliders" style="color: var(--adm-primary);"></i>
                    <span>Informasi Umum & Tahun Ajaran PSB</span>
                </h2>
            </div>
            <div class="adm-card-body">
                
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <strong style="color: var(--adm-text-main); font-size: 0.95rem; display: block;">Aktifkan Pendaftaran Santri Baru (Master Switch)</strong>
                        <span style="font-size: 0.82rem; color: var(--adm-text-muted);">Jika dinonaktifkan, formulir pendaftaran online akan ditutup di seluruh website.</span>
                    </div>
                    <label style="position: relative; display: inline-flex; align-items: center; cursor: pointer; gap: 10px;">
                        <input type="checkbox" name="psb_status" value="1" {{ ($psb['psb_status'] ?? '1') == '1' ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: var(--adm-primary); cursor: pointer;">
                        <span style="font-weight: 700; font-size: 0.9rem; color: {{ ($psb['psb_status'] ?? '1') == '1' ? 'var(--adm-primary)' : '#dc2626' }};">
                            {{ ($psb['psb_status'] ?? '1') == '1' ? 'PSB Aktif (Dibuka)' : 'PSB Ditutup (Nonaktif)' }}
                        </span>
                    </label>
                </div>

                <div class="psb-form-row">
                    <div class="form-group">
                        <label for="psb_tahun_ajaran" class="form-label">
                            <strong>Tahun Ajaran PSB *</strong>
                            <small style="color: var(--adm-primary); font-weight: normal; display: block;">(Contoh: 2026/2027 atau 2027/2028)</small>
                        </label>
                        <input type="text" id="psb_tahun_ajaran" name="psb_tahun_ajaran" value="{{ old('psb_tahun_ajaran', $psb['psb_tahun_ajaran'] ?? '2026/2027') }}" class="form-control" placeholder="Contoh: 2026/2027" required style="font-weight: 800; font-size: 1.05rem; letter-spacing: 0.5px;">
                    </div>

                    <div class="form-group">
                        <label for="psb_title" class="form-label">Judul Halaman Informasi PSB *</label>
                        <input type="text" id="psb_title" name="psb_title" value="{{ old('psb_title', $psb['psb_title'] ?? 'Informasi Penerimaan Santri Baru (PSB)') }}" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="psb_subtitle" class="form-label">Sub-Judul / Nama Lembaga</label>
                    <input type="text" id="psb_subtitle" name="psb_subtitle" value="{{ old('psb_subtitle', $psb['psb_subtitle'] ?? 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso') }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="psb_intro_text" class="form-label">Teks Pengantar / Sambutan PSB</label>
                    <textarea id="psb_intro_text" name="psb_intro_text" rows="3" class="form-control" placeholder="Deskripsi pengantar singkat di bagian atas halaman informasi...">{{ old('psb_intro_text', $psb['psb_intro_text'] ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="psb_banner_notice" class="form-label">
                        <i class="fa-solid fa-triangle-exclamation" style="color: #f59e0b;"></i>
                        <span>Pengumuman Khusus / Banner Peringatan Darurat (Opsional)</span>
                        <small style="color: var(--adm-text-muted); font-weight: normal; display: block;">(Kosongkan jika tidak ada pengumuman darurat)</small>
                    </label>
                    <input type="text" id="psb_banner_notice" name="psb_banner_notice" value="{{ old('psb_banner_notice', $psb['psb_banner_notice'] ?? '') }}" class="form-control" placeholder="Contoh: Pendaftaran Gelombang I tersisa 15 kuota lagi. Segera amankan berkas calon santri Anda!">
                </div>

            </div>
        </div>

        <!-- SECTION 2: PENGATURAN GELOMBANG I & GELOMBANG II -->
        <div class="psb-grid-2col">
            
            <!-- FORM GELOMBANG 1 -->
            <div class="adm-card" style="border: 2px solid {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#86efac' : '#cbd5e1' }};">
                <div class="adm-card-header" style="background: {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#f0fdf4' : '#f8fafc' }}; display: flex; align-items: center; justify-content: space-between;">
                    <h2 class="adm-card-title" style="color: {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#166534' : '#475569' }}; margin: 0; font-size: 1rem;">
                        <i class="fa-solid fa-calendar-day"></i>
                        <span>Gelombang 1</span>
                    </h2>
                    <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" name="psb_g1_active" value="1" {{ ($psb['psb_g1_active'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--adm-primary); cursor: pointer;">
                        <span style="font-weight: 700; font-size: 0.85rem; color: {{ ($psb['psb_g1_active'] ?? '1') == '1' ? '#15803d' : '#64748b' }};">
                            {{ ($psb['psb_g1_active'] ?? '1') == '1' ? 'Aktif (Buka)' : 'Nonaktif' }}
                        </span>
                    </label>
                </div>
                <div class="adm-card-body">
                    
                    <div class="psb-form-row">
                        <div class="form-group">
                            <label for="psb_g1_name" class="form-label">Nama Gelombang</label>
                            <input type="text" id="psb_g1_name" name="psb_g1_name" value="{{ old('psb_g1_name', $psb['psb_g1_name'] ?? 'Gelombang Pertama') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="psb_g1_badge" class="form-label">Badge Label</label>
                            <input type="text" id="psb_g1_badge" name="psb_g1_badge" value="{{ old('psb_g1_badge', $psb['psb_g1_badge'] ?? 'GELOMBANG I') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="psb_g1_dates" class="form-label">
                            <i class="fa-regular fa-calendar" style="color: var(--adm-primary);"></i>
                            <span>Periode Tanggal Pendaftaran</span>
                        </label>
                        <input type="text" id="psb_g1_dates" name="psb_g1_dates" value="{{ old('psb_g1_dates', $psb['psb_g1_dates'] ?? '01 Januari – 31 Maret 2026') }}" class="form-control" placeholder="Contoh: 01 Januari – 31 Maret 2026">
                    </div>

                    <div class="form-group">
                        <label for="psb_g1_test" class="form-label">
                            <i class="fa-solid fa-pen-to-square" style="color: var(--adm-primary);"></i>
                            <span>Jadwal Tes Pemetaan & Observasi</span>
                        </label>
                        <input type="text" id="psb_g1_test" name="psb_g1_test" value="{{ old('psb_g1_test', $psb['psb_g1_test'] ?? 'Setiap Hari Ahad') }}" class="form-control" placeholder="Contoh: Setiap Hari Ahad">
                    </div>

                    <div class="form-group">
                        <label for="psb_g1_announcement" class="form-label">
                            <i class="fa-solid fa-bullhorn" style="color: var(--adm-primary);"></i>
                            <span>Tanggal Pengumuman Hasil</span>
                        </label>
                        <input type="text" id="psb_g1_announcement" name="psb_g1_announcement" value="{{ old('psb_g1_announcement', $psb['psb_g1_announcement'] ?? '05 April 2026') }}" class="form-control" placeholder="Contoh: 05 April 2026">
                    </div>

                    <div class="form-group">
                        <label for="psb_g1_notes" class="form-label">Keterangan / Catatan Gelombang 1</label>
                        <input type="text" id="psb_g1_notes" name="psb_g1_notes" value="{{ old('psb_g1_notes', $psb['psb_g1_notes'] ?? 'Pendaftaran online & offline dibuka setiap hari kerja.') }}" class="form-control" placeholder="Opsional">
                    </div>

                </div>
            </div>

            <!-- FORM GELOMBANG 2 -->
            <div class="adm-card" style="border: 2px solid {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#86efac' : '#cbd5e1' }};">
                <div class="adm-card-header" style="background: {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#f0fdf4' : '#f8fafc' }}; display: flex; align-items: center; justify-content: space-between;">
                    <h2 class="adm-card-title" style="color: {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#166534' : '#475569' }}; margin: 0; font-size: 1rem;">
                        <i class="fa-solid fa-calendar-day"></i>
                        <span>Gelombang 2</span>
                    </h2>
                    <label style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                        <input type="checkbox" name="psb_g2_active" value="1" {{ ($psb['psb_g2_active'] ?? '1') == '1' ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--adm-primary); cursor: pointer;">
                        <span style="font-weight: 700; font-size: 0.85rem; color: {{ ($psb['psb_g2_active'] ?? '1') == '1' ? '#15803d' : '#64748b' }};">
                            {{ ($psb['psb_g2_active'] ?? '1') == '1' ? 'Aktif (Buka)' : 'Nonaktif' }}
                        </span>
                    </label>
                </div>
                <div class="adm-card-body">
                    
                    <div class="psb-form-row">
                        <div class="form-group">
                            <label for="psb_g2_name" class="form-label">Nama Gelombang</label>
                            <input type="text" id="psb_g2_name" name="psb_g2_name" value="{{ old('psb_g2_name', $psb['psb_g2_name'] ?? 'Gelombang Kedua') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="psb_g2_badge" class="form-label">Badge Label</label>
                            <input type="text" id="psb_g2_badge" name="psb_g2_badge" value="{{ old('psb_g2_badge', $psb['psb_g2_badge'] ?? 'GELOMBANG II') }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="psb_g2_dates" class="form-label">
                            <i class="fa-regular fa-calendar" style="color: var(--adm-primary);"></i>
                            <span>Periode Tanggal Pendaftaran</span>
                        </label>
                        <input type="text" id="psb_g2_dates" name="psb_g2_dates" value="{{ old('psb_g2_dates', $psb['psb_g2_dates'] ?? '01 April – 30 Juni 2026') }}" class="form-control" placeholder="Contoh: 01 April – 30 Juni 2026">
                    </div>

                    <div class="form-group">
                        <label for="psb_g2_test" class="form-label">
                            <i class="fa-solid fa-pen-to-square" style="color: var(--adm-primary);"></i>
                            <span>Jadwal Tes Pemetaan & Observasi</span>
                        </label>
                        <input type="text" id="psb_g2_test" name="psb_g2_test" value="{{ old('psb_g2_test', $psb['psb_g2_test'] ?? 'Menyesuaikan Jadwal') }}" class="form-control" placeholder="Contoh: Menyesuaikan Jadwal">
                    </div>

                    <div class="form-group">
                        <label for="psb_g2_announcement" class="form-label">
                            <i class="fa-solid fa-bullhorn" style="color: var(--adm-primary);"></i>
                            <span>Tanggal Pengumuman Hasil</span>
                        </label>
                        <input type="text" id="psb_g2_announcement" name="psb_g2_announcement" value="{{ old('psb_g2_announcement', $psb['psb_g2_announcement'] ?? '05 Juli 2026') }}" class="form-control" placeholder="Contoh: 05 Juli 2026">
                    </div>

                    <div class="form-group">
                        <label for="psb_g2_notes" class="form-label">Keterangan / Catatan Gelombang 2</label>
                        <input type="text" id="psb_g2_notes" name="psb_g2_notes" value="{{ old('psb_g2_notes', $psb['psb_g2_notes'] ?? 'Dibuka jika kuota asrama dan kelas santri masih tersedia.') }}" class="form-control" placeholder="Opsional">
                    </div>

                </div>
            </div>

        </div>

        <!-- SECTION 3: CATATAN KUOTA & KONTAK LAYANAN -->
        <div class="adm-card" style="margin-bottom: 1.5rem;">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-headset" style="color: var(--adm-primary);"></i>
                    <span>Catatan Kuota & Kontak Layanan PSB</span>
                </h2>
            </div>
            <div class="adm-card-body">
                
                <div class="form-group">
                    <label for="psb_quota_notes" class="form-label">Catatan Kuota Pendaftaran (Muncul di Bawah Gelombang)</label>
                    <textarea id="psb_quota_notes" name="psb_quota_notes" rows="2" class="form-control">{{ old('psb_quota_notes', $psb['psb_quota_notes'] ?? 'Catatan: Pendaftaran dapat ditutup sewaktu-waktu apabila kuota asrama dan kelas telah terpenuhi. Calon santri disarankan mendaftar pada Gelombang Pertama.') }}</textarea>
                </div>

                <div class="psb-form-row">
                    <div class="form-group">
                        <label for="psb_contact_wa" class="form-label">
                            <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                            <span>Nomor WhatsApp Panitia PSB</span>
                        </label>
                        <input type="text" id="psb_contact_wa" name="psb_contact_wa" value="{{ old('psb_contact_wa', $psb['psb_contact_wa'] ?? '+62 812-3456-7890') }}" class="form-control" placeholder="+62 812-xxxx-xxxx">
                    </div>

                    <div class="form-group">
                        <label for="psb_contact_phone" class="form-label">
                            <i class="fa-solid fa-phone" style="color: var(--adm-primary);"></i>
                            <span>Nomor Call Center / Telepon</span>
                        </label>
                        <input type="text" id="psb_contact_phone" name="psb_contact_phone" value="{{ old('psb_contact_phone', $psb['psb_contact_phone'] ?? '+62 812-3456-7890') }}" class="form-control" placeholder="+62 812-xxxx-xxxx">
                    </div>

                    <div class="form-group">
                        <label for="psb_service_hours" class="form-label">
                            <i class="fa-regular fa-clock" style="color: var(--adm-primary);"></i>
                            <span>Jam Pelayanan Sekretariat</span>
                        </label>
                        <input type="text" id="psb_service_hours" name="psb_service_hours" value="{{ old('psb_service_hours', $psb['psb_service_hours'] ?? 'Setiap Hari (08.00 - 15.00 WIB)') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="psb_contact_address" class="form-label">Alamat Sekretariat Panitia PSB</label>
                    <input type="text" id="psb_contact_address" name="psb_contact_address" value="{{ old('psb_contact_address', $psb['psb_contact_address'] ?? 'Wringin Arak arak, Kab. Bondowoso, Jawa Timur') }}" class="form-control">
                </div>

            </div>
        </div>

        <!-- ACTION FOOTER BAR (RESPONSIF & BEBAS OVERLAP MOBILE) -->
        <div class="psb-action-bar">
            <div class="psb-action-bar-info" style="font-size: 0.88rem; color: var(--adm-text-muted);">
                <i class="fa-solid fa-circle-check" style="color: var(--adm-primary);"></i>
                <span>Perubahan akan langsung terlihat di halaman publik secara instan.</span>
            </div>
            <div class="psb-action-bar-buttons">
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.8rem; font-weight: 800; font-size: 0.95rem; box-shadow: 0 4px 12px rgba(15, 133, 40, 0.25);">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Pengaturan Informasi PSB</span>
                </button>
            </div>
        </div>

    </form>
@endsection
