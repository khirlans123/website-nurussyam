@extends('layouts.app')

@section('title', 'Lembaga Amil Zakat & Wakaf (LAZISWAF) - Pondok Pesantren Nurussyam')

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="bc-sep">›</span>
            <span class="breadcrumb-current">LAZISWAF</span>
        </nav>

        <div class="info-page-card">
            
            <!-- Header Judul Program -->
            <div style="border-bottom:2px solid var(--primary-green); padding-bottom:14px; margin-bottom:22px;">
                <span class="badge-overlay badge-terkini" style="display:inline-block; margin-bottom:8px;">
                    LEMBAGA AMIL ZAKAT, INFAQ, SHADAQAH & WAKAF
                </span>
                <h1 class="article-title-heading" style="margin-bottom:6px;">
                    LAZISWAF Pondok Pesantren Nurussyam
                </h1>
                <p style="color:#64748b; font-size:0.95rem; margin:0;">
                    Penyaluran Amanah Zakat, Infaq, Sedekah, dan Wakaf Umat Islam Wringin Arak-arak Bondowoso
                </p>
            </div>

            <!-- Kutipan Dalil Perintah Mendoakan Muzakki / Donatur -->
            <div style="background:#f0fdf4; border-left:4px solid var(--primary-green); border-radius:0 8px 8px 0; padding:16px 20px; margin-bottom:24px;">
                <p style="font-style:italic; color:#166534; line-height:1.75; margin:0 0 6px; font-size:0.96rem;">
                    "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan menyucikan mereka dan berdoalah untuk mereka. Sesungguhnya doa kamu itu (menjadi) ketenteraman jiwa bagi mereka. Dan Allah Maha Mendengar lagi Maha Mengetahui."
                </p>
                <span style="font-size:0.84rem; color:#15803d; font-weight:700;">(QS. At-Taubah: 103)</span>
            </div>

            <!-- PENJELASAN: UNTUK APA DONASI & ZISWAF INI DISALURKAN? -->
            <div style="margin-bottom:28px;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:14px;">
                    <i class="fa-solid fa-circle-question" style="color:var(--primary-green); font-size:1.3rem;"></i>
                    <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin:0;">
                        Untuk Apa Dana Zakat, Infaq & Sedekah Ini Disalurkan?
                    </h3>
                </div>
                <p style="color:#475569; font-size:0.95rem; line-height:1.7; margin-bottom:16px;">
                    LAZISWAF Nurussyam mengelola dan mendistribusikan dana amanah dari para muzakki dan donatur secara syar'i, transparan, dan tepat sasaran untuk program-program berikut:
                </p>

                <!-- Grid 4 Kartu Peruntukan ZISWAF -->
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:14px;">
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-top:3px solid #16a34a; border-radius:8px; padding:16px;">
                        <div style="width:38px; height:38px; border-radius:8px; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:1.15rem; margin-bottom:10px;">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h4 style="font-size:1rem; font-weight:800; color:#0f172a; margin:0 0 6px;">Zakat Mal (Harta & Profesi)</h4>
                        <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0;">
                            Disalurkan kepada 8 golongan asnaf yang berhak, diprioritaskan bagi fakir miskin dhuafa serta santri pra-sejahtera penghafal Al-Qur'an (fii sabilillah).
                        </p>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-top:3px solid #0284c7; border-radius:8px; padding:16px;">
                        <div style="width:38px; height:38px; border-radius:8px; background:#e0f2fe; color:#0369a1; display:flex; align-items:center; justify-content:center; font-size:1.15rem; margin-bottom:10px;">
                            <i class="fa-solid fa-bowl-rice"></i>
                        </div>
                        <h4 style="font-size:1rem; font-weight:800; color:#0f172a; margin:0 0 6px;">Zakat Fitrah & Fidyah</h4>
                        <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0;">
                            Penyaluran beras makanan pokok berkualitas serta santunan fidyah harian bagi janda lansia dan warga kurang mampu di kawasan pedesaan sekitar pondok.
                        </p>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-top:3px solid #d97706; border-radius:8px; padding:16px;">
                        <div style="width:38px; height:38px; border-radius:8px; background:#fef3c7; color:#b45309; display:flex; align-items:center; justify-content:center; font-size:1.15rem; margin-bottom:10px;">
                            <i class="fa-solid fa-sun"></i>
                        </div>
                        <h4 style="font-size:1rem; font-weight:800; color:#0f172a; margin:0 0 6px;">Infaq & Sedekah Subuh</h4>
                        <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0;">
                            Bantuan konsumsi harian santri yatim, kebutuhan kesehatan, serta operasional pembinaan dakwah Islam dan kajian keagamaan santri Nurussyam.
                        </p>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-top:3px solid #7c3aed; border-radius:8px; padding:16px;">
                        <div style="width:38px; height:38px; border-radius:8px; background:#ede9fe; color:#6d28d9; display:flex; align-items:center; justify-content:center; font-size:1.15rem; margin-bottom:10px;">
                            <i class="fa-solid fa-book-quran"></i>
                        </div>
                        <h4 style="font-size:1rem; font-weight:800; color:#0f172a; margin:0 0 6px;">Wakaf Mushaf & Kitab Salaf</h4>
                        <p style="font-size:0.86rem; color:#64748b; line-height:1.6; margin:0;">
                            Penyediaan mushaf Al-Qur'an hafalan dan kitab-kitab kuning salafiyah yang dipelajari setiap hari oleh ratusan santri sebagai amal jariyah abadi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- INFORMASI BANK YANG TERSEDIA (TANPA MENAMPILKAN NOMOR REKENING DI AWAL) -->
            <div style="background:#f8fafc; border:1.5px solid #dcfce7; border-left:4px solid var(--primary-green); border-radius:8px; padding:18px 22px; margin-bottom:28px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <div style="width:40px; height:40px; border-radius:8px; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:1.25rem;">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h3 style="font-size:1.12rem; font-weight:800; color:#0f172a; margin:0;">
                            Penyaluran Donasi Melalui Bank yang Tersedia
                        </h3>
                        <p style="font-size:0.86rem; color:#64748b; margin:2px 0 0;">
                            Zakat, infaq, dan sedekah Anda dapat disalurkan melalui beberapa pilihan bank mitra resmi berikut:
                        </p>
                    </div>
                </div>

                <!-- Daftar Bank Mitra Tersedia (Tanpa Nomor Rekening) -->
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin:14px 0 10px;">
                    <span style="background:#ffffff; border:1px solid #86efac; color:#166534; font-size:0.84rem; font-weight:700; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check" style="color:#15803d; font-size:0.78rem;"></i> Bank Syariah Indonesia (BSI)
                    </span>
                    <span style="background:#ffffff; border:1px solid #cbd5e1; color:#1e293b; font-size:0.84rem; font-weight:700; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check" style="color:#0f172a; font-size:0.78rem;"></i> Bank Mandiri
                    </span>
                    <span style="background:#ffffff; border:1px solid #bae6fd; color:#0369a1; font-size:0.84rem; font-weight:700; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check" style="color:#0284c7; font-size:0.78rem;"></i> Bank BRI
                    </span>
                    <span style="background:#ffffff; border:1px solid #fed7aa; color:#c2410c; font-size:0.84rem; font-weight:700; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check" style="color:#ea580c; font-size:0.78rem;"></i> Bank BNI
                    </span>
                    <span style="background:#ffffff; border:1px solid #e2e8f0; color:#475569; font-size:0.84rem; font-weight:700; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-circle-check" style="color:#64748b; font-size:0.78rem;"></i> Tunai Langsung ke Kantor
                    </span>
                </div>

                <div style="font-size:0.84rem; color:#475569; display:flex; align-items:center; gap:8px; margin-top:8px;">
                    <i class="fa-solid fa-arrow-down" style="color:var(--primary-green);"></i>
                    <span>Nomor rekening tujuan transfer akan otomatis muncul saat Anda memilih bank pada formulir konfirmasi di bawah.</span>
                </div>
            </div>

            <!-- Notifikasi Sukses & Ucapan Terima Kasih Sesuai Amal Donasi -->
            @if(session('success_donation'))
                @php
                    $sDon = session('success_donation');
                    $ucapan = $sDon['ucapan'] ?? \App\Http\Controllers\HomeController::getUcapanTerimakasih($sDon['program'], $sDon['nama']);
                @endphp
                <div id="sukses-donasi" style="background:#f0fdf4; border:1.5px solid #86efac; border-left:5px solid #10b981; border-radius:10px; padding:16px 20px; margin-bottom:24px; box-shadow:0 3px 12px rgba(16,185,129,0.12);">
                    <div style="display:flex; align-items:flex-start; gap:12px;">
                        <div style="width:38px; height:38px; border-radius:50%; background:#10b981; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.15rem; flex-shrink:0; margin-top:2px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px; margin-bottom:4px;">
                                <h4 style="font-size:1.1rem; font-weight:800; color:#065f46; margin:0;">
                                    Terima Kasih atas Donasi {{ $sDon['program'] }}
                                </h4>
                                <span style="font-size:0.75rem; background:#dcfce7; color:#15803d; font-weight:700; padding:2px 8px; border-radius:999px;">
                                    Kode: {{ $sDon['kode'] }}
                                </span>
                            </div>
                            <p style="font-size:0.92rem; color:#166534; line-height:1.6; margin:0 0 10px;">
                                {{ is_array($ucapan) ? ($ucapan['pesan'] ?? '') : $ucapan }}
                            </p>
                            <div style="font-size:0.82rem; color:#475569; background:#fff; padding:6px 12px; border-radius:6px; border:1px solid #d1fae5; display:inline-block;">
                                <strong style="color:#0f172a;">{{ $sDon['nama'] }}</strong> • Rp {{ number_format($sDon['nominal'], 0, ',', '.') }} via {{ $sDon['bank'] }}
                                @if(!empty($sDon['doa']))
                                    <span style="color:#64748b;"> • Titipan Doa: <em>"{{ $sDon['doa'] }}"</em></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        var el = document.getElementById('sukses-donasi');
                        if (el) {
                            el.scrollIntoView({ behavior: 'auto', block: 'center' });
                        }
                    });
                </script>
            @endif

            <!-- FORMULIR KONFIRMASI ZAKAT & TITIPAN DOA -->
            <div id="form-donasi" style="background:#ffffff; border:1px solid #e2e8f0; border-radius:10px; padding:24px; box-shadow:0 4px 16px rgba(0,0,0,0.04);">
                <div style="margin-bottom:18px;">
                    <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin:0 0 6px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-hands-praying" style="color:var(--primary-green);"></i> Formulir Konfirmasi Zakat & Doa Muzakki
                    </h3>
                    <p style="font-size:0.9rem; color:#64748b; margin:0;">
                        Mohon cantumkan <strong>nama pemberi zakat / muzakki</strong> dan titipan doa hajat agar dicatat amil pesantren dan para santri membacakannya saat majelis doa istighatsah.
                    </p>
                </div>

                <form method="POST" action="{{ route('donasi.store') }}">
                    @csrf

                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:0.86rem; font-weight:700; color:#334155; margin-bottom:6px;">
                            Nama Lengkap Pemberi Zakat / Muzakki <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" required class="search-field-input" placeholder="Contoh: H. Ahmad Syukri bin Abdullah / Ibu Siti (atau Hamba Allah)">
                        <span style="font-size:0.78rem; color:#64748b; margin-top:3px; display:block;">
                            *Nama ini akan masuk ke panel admin LAZISWAF dan dibacakan saat doa santri.
                        </span>
                    </div>

                    <div class="form-row-2col" style="margin-bottom:16px;">
                        <div>
                            <label style="display:block; font-size:0.86rem; font-weight:700; color:#334155; margin-bottom:6px;">
                                Jenis Program ZISWAF <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="program" id="programSelectLazis" required class="search-field-input">
                                <option value="Zakat Mal" {{ old('program') == 'Zakat Mal' ? 'selected' : '' }}>Zakat Mal (Harta / Tabungan / Penghasilan)</option>
                                <option value="Zakat Fitrah" {{ old('program') == 'Zakat Fitrah' ? 'selected' : '' }}>Zakat Fitrah</option>
                                <option value="Fidyah & Kafarat" {{ old('program') == 'Fidyah & Kafarat' ? 'selected' : '' }}>Fidyah & Kafarat</option>
                                <option value="Infaq & Shadaqah" {{ old('program') == 'Infaq & Shadaqah' ? 'selected' : '' }}>Infaq & Shadaqah Umat</option>
                                <option value="Sedekah Subuh" {{ old('program') == 'Sedekah Subuh' ? 'selected' : '' }}>Sedekah Subuh Santri</option>
                                <option value="Wakaf Qur'an & Kitab" {{ old('program') == "Wakaf Qur'an & Kitab" ? 'selected' : '' }}>Wakaf Mushaf Al-Qur'an & Kitab Kuning</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; font-size:0.86rem; font-weight:700; color:#334155; margin-bottom:6px;">
                                Bank Tujuan Penyaluran <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="bank_tujuan" id="bankSelectLazis" required class="search-field-input" onchange="renderBankInfoLazis(this.value)">
                                <option value="" disabled {{ old('bank_tujuan') ? '' : 'selected' }}>-- Pilih Bank Tujuan Transfer --</option>
                                <option value="BSI" {{ old('bank_tujuan') == 'BSI' ? 'selected' : '' }}>Bank Syariah Indonesia (BSI)</option>
                                <option value="Bank Mandiri" {{ old('bank_tujuan') == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                <option value="Bank BRI" {{ old('bank_tujuan') == 'Bank BRI' ? 'selected' : '' }}>Bank BRI</option>
                                <option value="Bank BNI" {{ old('bank_tujuan') == 'Bank BNI' ? 'selected' : '' }}>Bank BNI</option>
                                <option value="Tunai" {{ old('bank_tujuan') == 'Tunai' ? 'selected' : '' }}>Tunai Langsung ke Kantor Amil</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kotak Informasi Rekening Dinamis Sesuai Pilihan Bank -->
                    <div id="bankInfoCardLazis" style="display:none; margin-bottom:16px; border-radius:8px; padding:16px; transition:all 0.25s ease;"></div>

                    <div style="margin-top:14px;">
                        <label style="display:block; font-size:0.86rem; font-weight:700; color:#334155; margin-bottom:6px;">
                            Besaran Nominal (Rp) <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="number" id="nominalLazisInput" name="nominal" value="{{ old('nominal', '150000') }}" min="1000" required class="search-field-input" placeholder="Contoh: 150000">
                        
                        <!-- Tombol Nominal Cepat -->
                        <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:8px;">
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=50000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">50 Rb</button>
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=100000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">100 Rb</button>
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=250000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">250 Rb</button>
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=500000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">500 Rb</button>
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=1000000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">1 Juta</button>
                            <button type="button" onclick="document.getElementById('nominalLazisInput').value=2500000;" style="background:#f1f5f9; border:1px solid #cbd5e1; padding:4px 10px; border-radius:4px; font-size:0.78rem; font-weight:700; cursor:pointer;">2.5 Juta</button>
                        </div>
                    </div>

                    <div style="margin-top:16px; margin-bottom:20px;">
                        <label style="display:block; font-size:0.86rem; font-weight:700; color:#334155; margin-bottom:6px;">
                            <i class="fa-solid fa-scroll" style="color:var(--primary-green);"></i> Doa, Hajat Khusus Muzakki, atau Titipan Al-Fatihah (Opsional)
                        </label>
                        <textarea name="doa_harapan" rows="3" class="search-field-input" placeholder="Tuliskan hajat keselamatan keluarga, ampunan orang tua, kemudahan usaha, atau titipan fatihah yang ingin didoakan saat kegiatan tahlil / istighatsah pondok...">{{ old('doa_harapan') }}</textarea>
                        <span style="font-size:0.8rem; color:#64748b; margin-top:4px; display:block;">
                            Doa ini otomatis tersimpan di data admin LAZISWAF agar ustadz & santri membacakannya dalam majelis doa bersama.
                        </span>
                    </div>

                    <button type="submit" style="background:var(--primary-green); color:#fff; border:none; padding:14px 24px; border-radius:6px; font-weight:800; font-size:1rem; cursor:pointer; width:100%; box-shadow:0 3px 10px rgba(15,133,40,0.3); transition:background 0.2s ease;">
                        <i class="fa-solid fa-paper-plane" style="margin-right:8px;"></i> Kirim Konfirmasi Zakat / Infaq & Simpan Doa
                    </button>
                </form>
            </div>

            <!-- Tautan Dua Program Utama (Donasi Masjid & Donasi Pondok) -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px; margin-top:24px;">
                <div style="background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:8px; padding:16px;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                        <i class="fa-solid fa-mosque" style="font-size:1.2rem; color:var(--primary-green);"></i>
                        <h4 style="margin:0; font-size:1rem; font-weight:800; color:#0f172a;">Donasi Masjid</h4>
                    </div>
                    <p style="font-size:0.84rem; color:#64748b; margin-bottom:10px;">
                        Infaq jariyah untuk operasional, perluasan tempat wudhu, karpet, dan kemakmuran masjid santri.
                    </p>
                    <a href="{{ route('donasi.masjid') }}" style="background:var(--primary-green); color:#fff; padding:6px 14px; border-radius:5px; font-weight:700; font-size:0.82rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        Buka Donasi Masjid <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div style="background:#eff6ff; border:1.5px solid #bfdbfe; border-radius:8px; padding:16px;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
                        <i class="fa-solid fa-school" style="font-size:1.2rem; color:#1d4ed8;"></i>
                        <h4 style="margin:0; font-size:1rem; font-weight:800; color:#1e3a8a;">Donasi Pondok</h4>
                    </div>
                    <p style="font-size:0.84rem; color:#64748b; margin-bottom:10px;">
                        Bantuan pembangunan gedung asrama santri, beasiswa santri yatim, dan sarana belajar diniyah.
                    </p>
                    <a href="{{ route('donasi.pondok') }}" style="background:#1d4ed8; color:#fff; padding:6px 14px; border-radius:5px; font-weight:700; font-size:0.82rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        Buka Donasi Pondok <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- SIDEBAR KANAN KHUSUS INFORMASI LAYANAN DONATUR (TANPA BERITA) -->
    <aside class="sidebar-wrapper">
        <!-- Widget Layanan Donasi & Konsultasi -->
        <div class="sidebar-widget">
            <div class="widget-head head-green">
                <h3 class="widget-heading-text"><i class="fa-solid fa-headset"></i> Layanan Donatur</h3>
            </div>
            <div class="widget-content" style="padding:18px;">
                <p style="font-size:0.86rem; color:#475569; line-height:1.6; margin:0 0 14px;">
                    Butuh bantuan konfirmasi transfer atau konsultasi perhitungan zakat mal dan fidyah? Hubungi amil kami:
                </p>
                <a href="https://wa.me/6281234567890?text=Assalamu'alaikum%20Amil%20LAZISWAF%20Nurussyam" target="_blank" style="background:#25D366; color:#fff; display:flex; align-items:center; justify-content:center; gap:8px; padding:10px 14px; border-radius:6px; font-weight:700; font-size:0.88rem; text-decoration:none; margin-bottom:14px; box-shadow:0 2px 6px rgba(37,211,102,0.3);">
                    <i class="fa-brands fa-whatsapp" style="font-size:1.2rem;"></i> WhatsApp Amil ZISWAF
                </a>
                <div style="font-size:0.82rem; color:#64748b; line-height:1.6;">
                    <div><i class="fa-solid fa-location-dot" style="color:var(--primary-green); margin-right:6px;"></i> Kantor Sekretariat PP. Nurussyam, Wringin Bondowoso</div>
                    <div style="margin-top:6px;"><i class="fa-regular fa-clock" style="color:var(--primary-green); margin-right:6px;"></i> Pelayanan Setiap Hari: 07.30 - 21.00 WIB</div>
                </div>
            </div>
        </div>

        <!-- Widget Keutamaan Didoakan Santri -->
        <div class="sidebar-widget">
            <div class="widget-head" style="background:#0f172a; color:#fff;">
                <h3 class="widget-heading-text" style="color:#fff;"><i class="fa-solid fa-hands-praying" style="color:#4ade80;"></i> Majelis Doa Santri</h3>
            </div>
            <div class="widget-content" style="padding:18px; background:#f8fafc;">
                <div style="font-size:0.86rem; color:#334155; line-height:1.7;">
                    <p style="margin:0 0 10px;">
                        Setiap nama yang terdaftar di formulir donasi akan <strong>dicatat dalam buku ikhtiar doa</strong> pesantren.
                    </p>
                    <p style="margin:0;">
                        Nama dan titipan hajat Anda dibacakan secara khusus oleh dewan asatidz dan para santri pada:
                    </p>
                    <ul style="margin:8px 0 0 18px; padding:0; font-size:0.84rem; color:#475569;">
                        <li>Majelis Istighatsah Malam Jumat</li>
                        <li>Khataman Al-Qur'an Santri Tahfidz</li>
                        <li>Kajian Kitab Kuning Ba'da Subuh</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Widget Media Sosial -->
        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text"><i class="fa-solid fa-share-nodes"></i> Sosial Media Resmi</h3>
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
                    <a href="{{ $social_stats['tiktok']['url'] }}" target="_blank" class="social-button btn-tiktok" title="TikTok">
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
    </aside>
</div>

<script>
    const bankDataLazis = {
        'BSI': {
            name: 'BANK SYARIAH INDONESIA (BSI)',
            rek: '7143-0029-80',
            rekRaw: '7143002980',
            an: 'LAZISWAF NURUSSYAM',
            badgeBg: '#15803d',
            boxBorder: '#86efac',
            boxBg: '#f0fdf4'
        },
        'Bank Mandiri': {
            name: 'BANK MANDIRI',
            rek: '143-00-2980022-2',
            rekRaw: '1430029800222',
            an: 'YYS PONPES NURUSSYAM',
            badgeBg: '#0f172a',
            boxBorder: '#cbd5e1',
            boxBg: '#f8fafc'
        },
        'Bank BRI': {
            name: 'BANK RAKYAT INDONESIA (BRI)',
            rek: '0018-01-002980-53-0',
            rekRaw: '001801002980530',
            an: 'LAZISWAF NURUSSYAM',
            badgeBg: '#0284c7',
            boxBorder: '#bae6fd',
            boxBg: '#f0f9ff'
        },
        'Bank BNI': {
            name: 'BANK NEGARA INDONESIA (BNI)',
            rek: '029-800-2224',
            rekRaw: '0298002224',
            an: 'LAZISWAF NURUSSYAM',
            badgeBg: '#ea580c',
            boxBorder: '#fed7aa',
            boxBg: '#fff7ed'
        },
        'Tunai': {
            name: 'PEMBAYARAN TUNAI',
            rek: 'KANTOR AMIL LAZISWAF NURUSSYAM',
            rekRaw: '',
            an: 'Pengurus Amil ZISWAF Nurussyam',
            badgeBg: '#475569',
            boxBorder: '#e2e8f0',
            boxBg: '#f8fafc',
            isTunai: true
        }
    };

    function renderBankInfoLazis(bankKey) {
        const card = document.getElementById('bankInfoCardLazis');
        if (!card) return;

        if (!bankKey || !bankDataLazis[bankKey]) {
            card.style.display = 'none';
            card.innerHTML = '';
            return;
        }

        card.style.display = 'block';
        const item = bankDataLazis[bankKey];
        card.style.background = item.boxBg;
        card.style.border = '1.5px solid ' + item.boxBorder;

        if (item.isTunai) {
            card.innerHTML = `
                <span style="background:${item.badgeBg}; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:999px; display:inline-block; margin-bottom:6px;">
                    ${item.name}
                </span>
                <div style="font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:4px;">
                    Penyerahan Zakat & Infaq Langsung
                </div>
                <div style="font-size:0.86rem; color:#475569;">
                    Silakan serahkan langsung ke Kantor Amil LAZISWAF di kawasan Pondok Pesantren Nurussyam Wringin Bondowoso.
                </div>
            `;
            return;
        }

        card.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                <span style="background:${item.badgeBg}; color:#fff; font-size:0.75rem; font-weight:800; padding:3px 10px; border-radius:999px; display:inline-block;">
                    ${item.name}
                </span>
                <span style="font-size:0.78rem; color:#64748b; font-weight:600;"><i class="fa-solid fa-shield-check" style="color:var(--primary-green);"></i> Rekening Resmi Terverifikasi</span>
            </div>
            <div style="font-family:monospace; font-size:1.35rem; font-weight:800; color:#0f172a; letter-spacing:1px; margin-bottom:4px;">
                ${item.rek}
            </div>
            <div style="font-size:0.88rem; color:#475569; margin-bottom:12px;">
                Atas Nama: <strong>${item.an}</strong>
            </div>
            <button type="button" onclick="navigator.clipboard.writeText('${item.rekRaw}'); alert('Nomor Rekening ${item.name} (' + '${item.rek}' + ') berhasil disalin!');" style="background:#ffffff; border:1px solid ${item.boxBorder}; color:#0f172a; font-size:0.82rem; font-weight:700; padding:6px 14px; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; gap:8px; box-shadow:0 1px 3px rgba(0,0,0,0.06);">
                <i class="fa-regular fa-copy" style="color:var(--primary-green);"></i> Salin Nomor Rekening ${item.name}
            </button>
        `;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selBank = document.getElementById('bankSelectLazis');
        if (selBank) {
            renderBankInfoLazis(selBank.value);
        }
    });
</script>
@endsection
