@extends('layouts.app')

@php
    $ta = $psb['psb_tahun_ajaran'] ?? ($psbSettings['psb_tahun_ajaran'] ?? '2026/2027');
    $isPsbOpen = ($psb['psb_status'] ?? ($psbSettings['psb_status'] ?? '1')) == '1';
    $isG1Open = ($psb['psb_g1_active'] ?? '1') == '1';
    $isG2Open = ($psb['psb_g2_active'] ?? '1') == '1';
    $cleanWa = preg_replace('/[^0-9]/', '', $psb['psb_contact_wa'] ?? '081234567890');
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
@endphp

@section('title', 'Informasi Penerimaan Santri Baru (PSB) ' . $ta . ' - Pondok Pesantren Nurussyam')

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="bc-sep">›</span>
            <a href="{{ route('pendaftaran.info') }}">Pendaftaran</a>
            <span class="bc-sep">›</span>
            <span class="breadcrumb-current">Informasi PSB {{ $ta }}</span>
        </nav>

        <div class="info-page-card">
            
            <div style="border-bottom:2px solid var(--primary-green); padding-bottom:14px; margin-bottom:24px;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px; flex-wrap:wrap;">
                    <span class="badge-overlay badge-terkini" style="display:inline-block;">
                        PENERIMAAN SANTRI BARU (PSB) T.A {{ $ta }}
                    </span>
                    @if($isPsbOpen)
                        <span style="background:#10b981; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:999px; display:inline-flex; align-items:center; gap:5px;">
                            <span style="width:7px; height:7px; border-radius:50%; background:#fff; display:inline-block;"></span> PENDAFTARAN DIBUKA
                        </span>
                    @else
                        <span style="background:#e11d48; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:999px; display:inline-flex; align-items:center; gap:5px;">
                            <span style="width:7px; height:7px; border-radius:50%; background:#fff; display:inline-block;"></span> PENDAFTARAN DITUTUP
                        </span>
                    @endif
                </div>

                <h1 class="article-title-heading">
                    {{ $psb['psb_title'] ?? 'Informasi Penerimaan Santri Baru (PSB)' }}
                </h1>
                <p style="color:#64748b; font-size:0.92rem; margin-top:6px;">
                    {{ $psb['psb_subtitle'] ?? 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso' }}
                </p>
            </div>

            <!-- Banner Peringatan Darurat / Khusus jika ada -->
            @if(!empty($psb['psb_banner_notice']))
                <div style="background:#fffbeb; border:1.5px solid #fcd34d; border-radius:8px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 6px rgba(245,158,11,0.08);">
                    <i class="fa-solid fa-bullhorn" style="font-size:1.35rem; color:#d97706; flex-shrink:0;"></i>
                    <div style="font-size:0.92rem; color:#92400e; font-weight:600; line-height:1.6;">
                        {{ $psb['psb_banner_notice'] }}
                    </div>
                </div>
            @endif

            <!-- Banner jika PSB Ditutup / Nonaktif -->
            @if(!$isPsbOpen)
                <div style="background:#fff1f2; border:1.5px solid #fecdd3; border-radius:8px; padding:18px 20px; margin-bottom:24px; display:flex; align-items:flex-start; gap:14px; box-shadow:0 2px 8px rgba(225,29,72,0.08);">
                    <div style="width:40px; height:40px; border-radius:50%; background:#ffe4e6; color:#e11d48; display:flex; align-items:center; justify-content:center; font-size:1.25rem; flex-shrink:0;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <h4 style="font-size:1.05rem; font-weight:800; color:#9f1239; margin:0 0 4px;">
                            Pendaftaran Santri Baru Periode Ini Sedang Ditutup
                        </h4>
                        <p style="font-size:0.9rem; color:#be123c; margin:0; line-height:1.6;">
                            Formulir online saat ini belum dibuka atau telah berakhir untuk Tahun Ajaran {{ $ta }}. Calon santri yang sudah pernah mendaftar sebelumnya tetap dapat mengecek status penerimaan melalui tombol <strong>Cek Status Pendaftaran</strong> di bawah. Untuk informasi pembukaan periode berikutnya, silakan hubungi kontak panitia.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Tombol Navigasi Pintas ke Syarat & Form -->
            <div style="display:flex; gap:12px; margin-bottom:28px; flex-wrap:wrap;">
                <a href="{{ route('pendaftaran.syarat') }}" style="background:#0f172a; color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:0.2s;">
                    <i class="fa-solid fa-clipboard-list" style="color:#86efac;"></i> Lihat Syarat & Berkas
                </a>

                @if($isPsbOpen)
                    <a href="{{ route('pendaftaran') }}" style="background:var(--primary-green); color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 2px 8px rgba(15,133,40,0.3); transition:0.2s;">
                        <i class="fa-solid fa-file-pen"></i> Isi Formulir Online
                    </a>
                @else
                    <a href="https://wa.me/{{ $cleanWa }}?text={{ rawurlencode('Assalamu\'alaikum Panitia PSB Nurussyam, saya ingin bertanya jadwal pembukaan pendaftaran santri baru.') }}" target="_blank" style="background:#e11d48; color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-lock"></i> Pendaftaran Sedang Ditutup (Hubungi Panitia)
                    </a>
                @endif

                <a href="{{ route('pendaftaran') }}#cek-status" style="background:#f1f5f9; color:#334155; border:1px solid #cbd5e1; padding:11px 18px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cek Status Pendaftaran
                </a>
            </div>

            <!-- Pengantar Informasi -->
            <div style="line-height:1.85; color:#334155; font-size:1.02rem; margin-bottom:28px;">
                <p style="margin-bottom:16px;">
                    {!! nl2br(e($psb['psb_intro_text'] ?? '')) !!}
                </p>
            </div>

            <!-- Jadwal Gelombang Pendaftaran -->
            @if($isPsbOpen && ($isG1Open || $isG2Open))
                <div id="jadwal-gelombang" style="margin-bottom:32px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px;">
                        <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin:0; display:flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-calendar-days" style="color:var(--primary-green);"></i> Jadwal & Periode Gelombang Pendaftaran
                        </h3>
                        <span style="font-size:0.82rem; font-weight:700; color:#15803d; background:#dcfce7; border:1px solid #86efac; padding:4px 12px; border-radius:999px;">
                            Tahun Ajaran {{ $ta }}
                        </span>
                    </div>
                    
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:18px;">
                        
                        <!-- KARTU GELOMBANG 1 (Hanya ditampilkan jika diaktifkan di admin) -->
                        @if($isG1Open)
                            <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:10px; padding:20px; box-shadow:0 4px 12px rgba(16,185,129,0.08); display:flex; flex-direction:column; justify-content:space-between;">
                                <div>
                                    <div style="margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid #bbf7d0;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:8px;">
                                            <span style="background:#15803d; color:#ffffff; font-size:0.72rem; font-weight:800; padding:2px 8px; border-radius:4px; letter-spacing:0.5px; text-transform:uppercase;">
                                                {{ $psb['psb_g1_badge'] ?? 'GELOMBANG I' }}
                                            </span>
                                            <span style="background:#dcfce7; color:#166534; border:1px solid #86efac; font-size:0.72rem; font-weight:800; padding:2px 8px; border-radius:999px; display:inline-flex; align-items:center; gap:4px;">
                                                <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#16a34a;"></span> BUKA
                                            </span>
                                        </div>

                                        <h4 style="font-size:1.2rem; font-weight:800; color:#064e18; margin:0; line-height:1.35;">
                                            {{ $psb['psb_g1_name'] ?? 'Gelombang Pertama' }}
                                        </h4>
                                    </div>

                                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:9px; font-size:0.92rem; color:#166534;">
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-regular fa-clock" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Pendaftaran:</strong> {{ $psb['psb_g1_dates'] ?? '-' }}</span>
                                        </li>
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-solid fa-pen-to-square" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Tes Pemetaan:</strong> {{ $psb['psb_g1_test'] ?? '-' }}</span>
                                        </li>
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-solid fa-bullhorn" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Pengumuman:</strong> {{ $psb['psb_g1_announcement'] ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>

                                @if(!empty($psb['psb_g1_notes']))
                                    <div style="margin-top:14px; padding:8px 12px; background:rgba(255,255,255,0.7); border:1px dashed #86efac; border-radius:6px; font-size:0.84rem; color:#15803d; display:flex; align-items:flex-start; gap:6px;">
                                        <i class="fa-solid fa-circle-info" style="margin-top:2px; flex-shrink:0;"></i>
                                        <span>{{ $psb['psb_g1_notes'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- KARTU GELOMBANG 2 (Hanya ditampilkan jika diaktifkan di admin) -->
                        @if($isG2Open)
                            <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:10px; padding:20px; box-shadow:0 4px 12px rgba(16,185,129,0.08); display:flex; flex-direction:column; justify-content:space-between;">
                                <div>
                                    <div style="margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid #bbf7d0;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:8px;">
                                            <span style="background:#15803d; color:#ffffff; font-size:0.72rem; font-weight:800; padding:2px 8px; border-radius:4px; letter-spacing:0.5px; text-transform:uppercase;">
                                                {{ $psb['psb_g2_badge'] ?? 'GELOMBANG II' }}
                                            </span>
                                            <span style="background:#dcfce7; color:#166534; border:1px solid #86efac; font-size:0.72rem; font-weight:800; padding:2px 8px; border-radius:999px; display:inline-flex; align-items:center; gap:4px;">
                                                <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#16a34a;"></span> BUKA
                                            </span>
                                        </div>

                                        <h4 style="font-size:1.2rem; font-weight:800; color:#064e18; margin:0; line-height:1.35;">
                                            {{ $psb['psb_g2_name'] ?? 'Gelombang Kedua' }}
                                        </h4>
                                    </div>

                                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:9px; font-size:0.92rem; color:#166534;">
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-regular fa-clock" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Pendaftaran:</strong> {{ $psb['psb_g2_dates'] ?? '-' }}</span>
                                        </li>
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-solid fa-pen-to-square" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Tes Pemetaan:</strong> {{ $psb['psb_g2_test'] ?? '-' }}</span>
                                        </li>
                                        <li style="display:flex; align-items:center; gap:8px;">
                                            <i class="fa-solid fa-bullhorn" style="width:18px; color:var(--primary-green); flex-shrink:0; text-align:center;"></i> 
                                            <span><strong style="color:#0f172a;">Pengumuman:</strong> {{ $psb['psb_g2_announcement'] ?? '-' }}</span>
                                        </li>
                                    </ul>
                                </div>

                                @if(!empty($psb['psb_g2_notes']))
                                    <div style="margin-top:14px; padding:8px 12px; background:rgba(255,255,255,0.7); border:1px dashed #86efac; border-radius:6px; font-size:0.84rem; color:#15803d; display:flex; align-items:flex-start; gap:6px;">
                                        <i class="fa-solid fa-circle-info" style="margin-top:2px; flex-shrink:0;"></i>
                                        <span>{{ $psb['psb_g2_notes'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if(!empty($psb['psb_quota_notes']))
                        <div style="margin-top:16px; background:#fffbeb; border-left:4px solid #f59e0b; padding:12px 18px; border-radius:0 8px 8px 0; font-size:0.9rem; color:#92400e; display:flex; align-items:flex-start; gap:8px;">
                            <i class="fa-solid fa-circle-info" style="margin-top:3px; flex-shrink:0;"></i>
                            <div><strong>Catatan Kuota:</strong> {{ $psb['psb_quota_notes'] }}</div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Pilihan Jenjang Pendidikan -->
            <div style="margin-bottom:32px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-graduation-cap" style="color:var(--primary-green);"></i> Jenjang Pendidikan yang Dibuka
                </h3>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
                    <div style="border:1px solid #e2e8f0; border-radius:8px; padding:18px; background:#ffffff; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <i class="fa-solid fa-school" style="font-size:1.4rem; color:var(--primary-green);"></i>
                            <h4 style="font-size:1.05rem; font-weight:800; color:#0f172a; margin:0;">MTs Nurussyam</h4>
                        </div>
                        <p style="font-size:0.88rem; color:#64748b; line-height:1.6; margin:0;">
                            Pendidikan formal setingkat SMP terakreditasi Kemenag RI dengan penguatan tahfidz, bahasa Arab dasar, sains, dan kitab turats.
                        </p>
                    </div>

                    <div style="border:1px solid #e2e8f0; border-radius:8px; padding:18px; background:#ffffff; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <i class="fa-solid fa-building-columns" style="font-size:1.4rem; color:var(--primary-green);"></i>
                            <h4 style="font-size:1.05rem; font-weight:800; color:#0f172a; margin:0;">MA Nurussyam</h4>
                        </div>
                        <p style="font-size:0.88rem; color:#64748b; line-height:1.6; margin:0;">
                            Pendidikan formal setingkat SMA dengan pilihan peminatan Keagamaan (PK), IPA, dan IPS serta bimbingan persiapan masuk PTN dan beasiswa Al-Azhar Kairo.
                        </p>
                    </div>

                    <div style="border:1px solid #e2e8f0; border-radius:8px; padding:18px; background:#ffffff; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <i class="fa-solid fa-book-quran" style="font-size:1.4rem; color:var(--primary-green);"></i>
                            <h4 style="font-size:1.05rem; font-weight:800; color:#0f172a; margin:0;">Program Tahfidz Al-Qur'an</h4>
                        </div>
                        <p style="font-size:0.88rem; color:#64748b; line-height:1.6; margin:0;">
                            Program intensif pembinaan hafalan Al-Qur'an 30 Juz bersanad muttashil dengan metode ziyadah dan muroja'ah mutqin.
                        </p>
                    </div>

                    <div style="border:1px solid #e2e8f0; border-radius:8px; padding:18px; background:#ffffff; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <i class="fa-solid fa-book-open" style="font-size:1.4rem; color:var(--primary-green);"></i>
                            <h4 style="font-size:1.05rem; font-weight:800; color:#0f172a; margin:0;">Madrasah Diniyah (Ma'had Nurussyam)</h4>
                        </div>
                        <p style="font-size:0.88rem; color:#64748b; line-height:1.6; margin:0;">
                            Kajian kitab kuning berjenjang (Ula, Wustha, Ulya) mengkaji fan fiqih, ushul fiqih, nahwu-shorof, tauhid, tasawuf, dan hadits.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alur Pendaftaran -->
            <div style="margin-bottom:32px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-route" style="color:var(--primary-green);"></i> Alur Pendaftaran Santri Baru
                </h3>

                <div style="display:flex; flex-direction:column; gap:14px;">
                    <div style="display:flex; gap:14px; align-items:flex-start; background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:8px;">
                        <span style="width:36px; height:36px; border-radius:50%; background:var(--primary-green); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">1</span>
                        <div>
                            <strong style="color:#0f172a; font-size:1rem; display:block; margin-bottom:4px;">Pengisian Formulir Pendaftaran</strong>
                            <span style="font-size:0.9rem; color:#475569; line-height:1.6;">Calon santri mengisi data lengkap melalui formulir online di website ini atau datang langsung ke sekretariat PSB di pondok pesantren.</span>
                        </div>
                    </div>

                    <div style="display:flex; gap:14px; align-items:flex-start; background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:8px;">
                        <span style="width:36px; height:36px; border-radius:50%; background:var(--primary-green); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">2</span>
                        <div>
                            <strong style="color:#0f172a; font-size:1rem; display:block; margin-bottom:4px;">Penyerahan & Verifikasi Berkas Administrasi</strong>
                            <span style="font-size:0.9rem; color:#475569; line-height:1.6;">Menyerahkan berkas fisik (fotokopi ijazah, KK, akta, pas foto, dll.) ke panitia PSB sesuai dengan ketentuan map yang ditentukan.</span>
                        </div>
                    </div>

                    <div style="display:flex; gap:14px; align-items:flex-start; background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:8px;">
                        <span style="width:36px; height:36px; border-radius:50%; background:var(--primary-green); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">3</span>
                        <div>
                            <strong style="color:#0f172a; font-size:1rem; display:block; margin-bottom:4px;">Ujian Seleksi & Observasi Minat Bakat</strong>
                            <span style="font-size:0.9rem; color:#475569; line-height:1.6;">Mengikuti tes pemetaan baca Al-Qur'an, praktik ibadah shalat, serta wawancara motivasi santri dan wali santri.</span>
                        </div>
                    </div>

                    <div style="display:flex; gap:14px; align-items:flex-start; background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:8px;">
                        <span style="width:36px; height:36px; border-radius:50%; background:var(--primary-green); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; flex-shrink:0;">4</span>
                        <div>
                            <strong style="color:#0f172a; font-size:1rem; display:block; margin-bottom:4px;">Pengumuman & Daftar Ulang (Sowan Pengasuh)</strong>
                            <span style="font-size:0.9rem; color:#475569; line-height:1.6;">Setelah dinyatakan diterima oleh panitia/admin, calon santri melakukan daftar ulang dan prosesi sowan ta'aruf bersama pengasuh pondok.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak Sekretariat PSB -->
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:22px; margin-bottom:28px;">
                <h4 style="font-size:1.15rem; font-weight:800; color:#166534; margin:0 0 12px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-headset"></i> Layanan Konsultasi & Sekretariat PSB
                </h4>
                <p style="font-size:0.92rem; color:#14532d; line-height:1.7; margin-bottom:14px;">
                    Apabila Bapak/Ibu wali santri membutuhkan bantuan atau memiliki pertanyaan seputar pendaftaran santri baru, silakan menghubungi panitia kami:
                </p>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; font-size:0.92rem; color:#166534;">
                    <div>
                        <i class="fa-solid fa-location-dot" style="width:20px;"></i> 
                        {{ $psb['psb_contact_address'] ?? 'Wringin Arak arak, Kab. Bondowoso, Jawa Timur' }}
                    </div>
                    <div>
                        <i class="fa-solid fa-phone" style="width:20px;"></i> 
                        Call Center: {{ $psb['psb_contact_phone'] ?? '+62 812-3456-7890' }}
                    </div>
                    <div>
                        <i class="fa-brands fa-whatsapp" style="width:20px; color:#16a34a;"></i> 
                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" style="color:#166534; font-weight:700; text-decoration:underline;">
                            WhatsApp PSB: {{ $psb['psb_contact_wa'] ?? '+62 812-3456-7890' }}
                        </a>
                    </div>
                    <div>
                        <i class="fa-regular fa-clock" style="width:20px;"></i> 
                        Pelayanan: {{ $psb['psb_service_hours'] ?? 'Setiap Hari (08.00 - 15.00 WIB)' }}
                    </div>
                </div>
            </div>

            <!-- CTA Menuju Syarat & Form -->
            <div style="text-align:center; padding:24px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px;">
                <h4 style="font-size:1.1rem; font-weight:700; color:#1e293b; margin-bottom:8px;">
                    {{ $isPsbOpen ? 'Sudah Siap Mendaftar?' : 'Informasi Pendaftaran Santri Baru' }}
                </h4>
                <p style="font-size:0.9rem; color:#64748b; margin-bottom:16px;">
                    {{ $isPsbOpen ? 'Pastikan Anda telah memeriksa berkas yang dibutuhkan sebelum mengisi formulir online.' : 'Pendaftaran santri baru sedang ditutup atau belum dibuka. Silakan cek syarat berkas atau hubungi panitia.' }}
                </p>
                <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                    <a href="{{ route('pendaftaran.syarat') }}" style="background:#0f172a; color:#fff; padding:10px 20px; border-radius:6px; font-weight:700; font-size:0.9rem; text-decoration:none;">
                        Cek Syarat & Berkas
                    </a>
                    @if($isPsbOpen)
                        <a href="{{ route('pendaftaran') }}" style="background:var(--primary-green); color:#fff; padding:10px 22px; border-radius:6px; font-weight:700; font-size:0.9rem; text-decoration:none;">
                            Buka Formulir Online
                        </a>
                    @else
                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" style="background:#25d366; color:#fff; padding:10px 22px; border-radius:6px; font-weight:700; font-size:0.9rem; text-decoration:none;">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi Panitia PSB
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>


    <!-- SIDEBAR KANAN -->
    <aside class="sidebar-wrapper">
        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text"><i class="fa-solid fa-share-nodes"></i> Sosial Media</h3>
            </div>
            <div class="widget-content">
                <div class="social-grid-2x2">
                    <a href="{{ $social_stats['whatsapp']['url'] ?? $social_stats['facebook']['url'] ?? 'https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f' }}" target="_blank" class="social-button btn-whatsapp" title="Saluran WhatsApp Resmi">
                        <div class="soc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['whatsapp']['raw_count'] ?? $social_stats['facebook']['raw_count'] ?? 1250 }}">0</span><span class="soc-label">{{ $social_stats['whatsapp']['label'] ?? 'Saluran WA' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['instagram']['url'] }}" target="_blank" class="social-button btn-instagram" title="Instagram">
                        <div class="soc-icon"><i class="fa-brands fa-instagram"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['instagram']['raw_count'] ?? 266 }}">0</span><span class="soc-label">{{ $social_stats['instagram']['label'] ?? 'Followers' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['tiktok']['url'] ?? 'https://www.tiktok.com/@ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-button btn-tiktok" title="TikTok">
                        <div class="soc-icon"><i class="fa-brands fa-tiktok"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['tiktok']['raw_count'] ?? 1364 }}">0</span><span class="soc-label">{{ $social_stats['tiktok']['label'] ?? 'Followers' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['youtube']['url'] }}" target="_blank" class="social-button btn-youtube" title="YouTube">
                        <div class="soc-icon"><i class="fa-brands fa-youtube"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['youtube']['raw_count'] ?? 500 }}">0</span><span class="soc-label">{{ $social_stats['youtube']['label'] ?? 'Subscribers' }}</span></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text"><i class="fa-solid fa-bolt"></i> Berita Terkini</h3>
            </div>
            <div class="widget-content" style="padding-top:12px;">
                <div class="news-vertical-list">
                    @foreach($sidebar_news as $news)
                        <div class="news-vert-item">
                            <a href="{{ route('article.show', $news['slug']) }}" class="news-vert-thumb">
                                <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" loading="lazy" decoding="async">
                            </a>
                            <div class="news-vert-body">
                                <span class="news-vert-date">{{ $news['date'] }}</span>
                                <h4 class="news-vert-title">
                                    <a href="{{ route('article.show', $news['slug']) }}">{{ $news['title'] }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection
