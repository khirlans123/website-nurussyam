@extends('layouts.app')

@section('title', 'Pendaftaran Santri Baru (PSB) - Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso')

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="bc-sep">›</span>
            <a href="{{ route('pendaftaran.info') }}">Pendaftaran</a>
            <span class="bc-sep">›</span>
            <span class="breadcrumb-current">Formulir Pendaftaran Online</span>
        </nav>

        <div class="info-page-card">
            
            <div style="border-bottom:2px solid var(--primary-green); padding-bottom:14px; margin-bottom:20px;">
                <span class="badge-overlay badge-terkini" style="display:inline-block; margin-bottom:8px;">
                    PENERIMAAN SANTRI BARU (PSB) T.A {{ $psb['psb_tahun_ajaran'] ?? ($psbSettings['psb_tahun_ajaran'] ?? '2026/2027') }}
                </span>

                <h1 class="article-title-heading">
                    Pendaftaran Santri Baru Pondok Pesantren Nurussyam
                </h1>
                <p style="color:#64748b; font-size:0.92rem; margin-top:6px;">
                    Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso
                </p>
            </div>

            <!-- Syarat & Ketentuan -->
            <h3 style="font-size:1.15rem; font-weight:800; color:#0f172a; margin-bottom:10px;">
                Syarat Pendaftaran:
            </h3>
            <ul style="list-style:disc; margin-left:22px; color:#475569; font-size:0.92rem; line-height:1.7; margin-bottom:24px;">
                <li>Mengisi formulir pendaftaran santri baru secara online atau di sekretariat pondok.</li>
                <li>Foto copy Ijazah & SKHUN legalisir (3 lembar).</li>
                <li>Foto copy Kartu Keluarga (KK) & Akta Kelahiran (3 lembar).</li>
                <li>Pas foto 3x4 berseragam rapi (5 lembar).</li>
                <li>Surat Keterangan Sehat dari dokter/puskesmas.</li>
            </ul>

            @php
                $isPsbActive = (($psb['psb_status'] ?? ($psbSettings['psb_status'] ?? '1')) == '1');
            @endphp
            <!-- Navigasi Pintas: Form Baru / Cek Status Persetujuan -->
            <div style="display: flex; gap: 10px; margin-bottom: 22px; flex-wrap: wrap;">
                @if($isPsbActive)
                    <a href="#form-daftar" style="background: var(--primary-green); color: #fff; padding: 10px 18px; border-radius: 6px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-file-pen"></i> Isi Formulir Santri Baru
                    </a>
                @else
                    <a href="{{ route('pendaftaran.info') }}" style="background: #dc2626; color: #fff; padding: 10px 18px; border-radius: 6px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-lock"></i> Pendaftaran Sedang Ditutup (Lihat Jadwal)
                    </a>
                @endif
                <a href="#cek-status" style="background: #0f172a; color: #fff; padding: 10px 18px; border-radius: 6px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-certificate"></i> Cek Status Persetujuan Admin
                </a>
            </div>

            <!-- Card Pengecekan Persetujuan Admin PSB -->
            <div id="cek-status" style="scroll-margin-top: 100px; background: linear-gradient(135deg, #f0fdf4, #e8f5ec); border: 2px solid #86efac; border-radius: 8px; padding: 20px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(15, 133, 40, 0.08);">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <div style="width: 42px; height: 42px; border-radius: 8px; background: var(--primary-green); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;">
                        <i class="fa-solid fa-stamp"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 1.15rem; font-weight: 800; color: #064e18; margin: 0;">
                            Cek Hasil Persetujuan Pendaftaran Santri Baru (PSB)
                        </h4>
                        <p style="font-size: 0.84rem; color: #166534; margin: 2px 0 0;">
                            Ketikkan Nomor Registrasi atau Nomor WhatsApp untuk memeriksa apakah pendaftaran Anda telah disetujui admin pondok.
                        </p>
                    </div>
                </div>

                <form method="GET" action="{{ route('pendaftaran.cek') }}#cek-status" style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 240px;">
                        <input type="text" name="cek_pendaftaran" value="{{ $searchedKeyword ?? request('cek_pendaftaran') }}" class="search-field-input" placeholder="Masukkan Nomor Pendaftaran (misal: PSB-2026-0001) atau No. WhatsApp..." required style="background: #fff; border: 1.5px solid #86efac; padding: 11px 14px; font-size: 16px;">
                    </div>
                    <button type="submit" style="background: var(--primary-green); color: #fff; border: none; padding: 11px 22px; border-radius: 6px; font-weight: 800; font-size: 0.95rem; cursor: pointer; white-space: nowrap; box-shadow: 0 2px 6px rgba(15,133,40,0.3);">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 6px;"></i> Cek Persetujuan
                    </button>
                    @if(request()->filled('cek_pendaftaran'))
                        <a href="{{ route('pendaftaran') }}#cek-status" style="display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #cbd5e1; color: #64748b; padding: 0 16px; border-radius: 6px; font-size: 0.88rem; text-decoration: none;">
                            Reset
                        </a>
                    @endif
                </form>

                <!-- HASIL PENGECEKAN STATUS PERSETUJUAN -->
                @if(isset($searched) && $searched)
                    <div style="margin-top: 18px; padding-top: 18px; border-top: 1px solid #bbf7d0;">
                        @if($checkResult)
                            @if($checkResult->status === 'Diterima')
                                <div style="background: #ffffff; border: 2px solid #10b981; border-radius: 10px; padding: 22px; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.15);">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                                        <span style="background: #10b981; color: #fff; font-size: 0.82rem; font-weight: 800; padding: 4px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase;">
                                            <i class="fa-solid fa-circle-check"></i> RESMI DISETUJUI ADMIN & DITERIMA
                                        </span>
                                        <span style="font-family: monospace; font-size: 0.95rem; font-weight: 800; color: #064e18;">
                                            {{ $checkResult->no_pendaftaran }}
                                        </span>
                                    </div>

                                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #065f46; margin-bottom: 8px;">
                                        🎉 Selamat! Pendaftaran Calon Santri RESMI DITERIMA
                                    </h3>
                                    <p style="font-size: 0.92rem; color: #047857; margin-bottom: 14px; line-height: 1.6;">
                                        Alhamdulillah, pendaftaran calon santri atas nama <strong>{{ $checkResult->nama_lengkap }}</strong> telah diverifikasi berkasnya oleh Staff dan <strong>RESMI DISETUJUI OLEH ADMIN & PIMPINAN MA'HAD NURUSSYAM</strong> untuk jenjang <strong>{{ $checkResult->pilihan_jenjang }}</strong>.
                                    </p>

                                    <!-- Timeline Alur Pendaftaran -->
                                    <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 14px 16px; margin-bottom: 14px;">
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #065f46; margin-bottom: 10px;">
                                            <i class="fa-solid fa-timeline"></i> Seluruh Tahap Pendaftaran Telah Selesai:
                                        </div>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px; font-size: 0.8rem;">
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 1. Formulir Dikirim
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 2. Berkas Diverifikasi Staff
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 3. Disetujui Admin
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 4. Resmi Diterima Santri
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: #ffffff; border: 1px dashed #86efac; border-radius: 6px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.88rem; color: #166534;">
                                        <strong>Catatan Panitia PSB:</strong>
                                        <div>{{ $checkResult->catatan ?: 'Silakan segera mengunduh kartu bukti pendaftaran di bawah ini dan melakukan daftar ulang ke sekretariat Ma\'had Nurussyam dengan melampirkan berkas fisik.' }}</div>
                                    </div>

                                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <a href="{{ route('pendaftaran.slip', $checkResult->no_pendaftaran) }}" target="_blank" style="background: #15803d; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                            <i class="fa-solid fa-print"></i>
                                            <span>Unduh / Cetak Bukti Diterima</span>
                                        </a>
                                        @php
                                            $cleanWaPanitia = '6281234567890';
                                            $waConfirmText = rawurlencode("Assalamu'alaikum Admin PSB Ma'had Nurussyam, saya wali dari {$checkResult->nama_lengkap} (No: {$checkResult->no_pendaftaran}) ingin menanyakan jadwal daftar ulang dan orientasi santri baru.");
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanWaPanitia }}?text={{ $waConfirmText }}" target="_blank" style="background: #25D366; color: #fff; padding: 10px 20px; border-radius: 6px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                                            <i class="fa-brands fa-whatsapp"></i>
                                            <span>Konfirmasi ke Panitia</span>
                                        </a>
                                    </div>
                                </div>
                            @elseif($checkResult->status === 'Diverifikasi')
                                <div style="background: #ffffff; border: 2px solid #0284c7; border-radius: 10px; padding: 22px; box-shadow: 0 4px 14px rgba(2, 132, 199, 0.12);">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                                        <span style="background: #e0f2fe; color: #0369a1; font-size: 0.82rem; font-weight: 800; padding: 4px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase;">
                                            <i class="fa-solid fa-user-check"></i> BERKAS DIVERIFIKASI (MENUNGGU PERSETUJUAN ADMIN)
                                        </span>
                                        <span style="font-family: monospace; font-size: 0.95rem; font-weight: 800; color: #0369a1;">
                                            {{ $checkResult->no_pendaftaran }}
                                        </span>
                                    </div>

                                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0369a1; margin-bottom: 8px;">
                                        Berkas Selesai Diverifikasi Staff &bull; Menunggu Persetujuan Admin
                                    </h3>
                                    <p style="font-size: 0.92rem; color: #0c4a6e; margin-bottom: 14px; line-height: 1.6;">
                                        Alhamdulillah, berkas persyaratan calon santri atas nama <strong>{{ $checkResult->nama_lengkap }}</strong> (No: <code>{{ $checkResult->no_pendaftaran }}</code>) <strong>telah selesai ditinjau dan dinyatakan lengkap oleh Staff Panitia PSB</strong>. Saat ini pendaftaran Anda <strong>sedang menunggu keputusan / persetujuan akhir dari Admin & Pimpinan Ma'had Nurussyam</strong>.
                                    </p>

                                    <!-- Timeline Alur Pendaftaran -->
                                    <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px 16px; margin-bottom: 14px;">
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #0369a1; margin-bottom: 10px;">
                                            <i class="fa-solid fa-timeline"></i> Alur Proses Pendaftaran Anda:
                                        </div>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px; font-size: 0.8rem;">
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 1. Formulir Dikirim
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 2. Berkas Diverifikasi Staff
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #0284c7; font-weight: 700;">
                                                <i class="fa-solid fa-spinner fa-spin" style="font-size: 1.1rem;"></i> 3. Persetujuan Admin (Menunggu)
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #94a3b8;">
                                                <i class="fa-regular fa-circle" style="font-size: 1.1rem;"></i> 4. Resmi Diterima
                                            </div>
                                        </div>
                                    </div>

                                    @if($checkResult->catatan)
                                        <div style="background: #ffffff; border: 1px dashed #7dd3fc; border-radius: 6px; padding: 10px 14px; font-size: 0.85rem; color: #0369a1; margin-bottom: 14px;">
                                            <strong>Catatan Staff Verifikator:</strong> {{ $checkResult->catatan }}
                                        </div>
                                    @endif

                                    <div style="font-size: 0.85rem; color: #0369a1;">
                                        <i class="fa-solid fa-circle-info"></i> Keputusan resmi penerimaan santri akan diumumkan langsung di halaman ini begitu Admin / Pengasuh menyelesaikan persetujuan.
                                    </div>
                                </div>
                            @elseif($checkResult->status === 'Pending')
                                <div style="background: #ffffff; border: 2px solid #f59e0b; border-radius: 10px; padding: 22px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.12);">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap;">
                                        <span style="background: #fef3c7; color: #92400e; font-size: 0.82rem; font-weight: 800; padding: 4px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase;">
                                            <i class="fa-solid fa-clock-rotate-left"></i> SEDANG DITINJAU OLEH STAFF
                                        </span>
                                        <span style="font-family: monospace; font-size: 0.95rem; font-weight: 800; color: #92400e;">
                                            {{ $checkResult->no_pendaftaran }}
                                        </span>
                                    </div>

                                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #78350f; margin-bottom: 8px;">
                                        Berkas Sedang Ditinjau oleh Staff Panitia PSB
                                    </h3>
                                    <p style="font-size: 0.92rem; color: #92400e; margin-bottom: 14px; line-height: 1.6;">
                                        Formulir pendaftaran calon santri atas nama <strong>{{ $checkResult->nama_lengkap }}</strong> (No: <code>{{ $checkResult->no_pendaftaran }}</code>) telah masuk ke sistem kami. Saat ini berkas pendaftaran Anda <strong>sedang dalam proses peninjauan & pemeriksaan kelengkapan oleh Staff Panitia PSB Ma'had Nurussyam</strong>. Mohon menunggu proses verifikasi berkas oleh staff.
                                    </p>

                                    <!-- Timeline Alur Pendaftaran -->
                                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 16px; margin-bottom: 14px;">
                                        <div style="font-size: 0.82rem; font-weight: 700; color: #92400e; margin-bottom: 10px;">
                                            <i class="fa-solid fa-timeline"></i> Alur Proses Pendaftaran Anda:
                                        </div>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 10px; font-size: 0.8rem;">
                                            <div style="display: flex; align-items: center; gap: 8px; color: #15803d; font-weight: 700;">
                                                <i class="fa-solid fa-circle-check" style="font-size: 1.1rem;"></i> 1. Formulir Dikirim
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #b45309; font-weight: 700;">
                                                <i class="fa-solid fa-spinner fa-spin" style="font-size: 1.1rem;"></i> 2. Peninjauan Staff (Aktif)
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #94a3b8;">
                                                <i class="fa-regular fa-circle" style="font-size: 1.1rem;"></i> 3. Persetujuan Admin
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 8px; color: #94a3b8;">
                                                <i class="fa-regular fa-circle" style="font-size: 1.1rem;"></i> 4. Resmi Diterima
                                            </div>
                                        </div>
                                    </div>

                                    @if($checkResult->catatan)
                                        <div style="background: #ffffff; border: 1px dashed #fcd34d; border-radius: 6px; padding: 10px 14px; font-size: 0.85rem; color: #92400e; margin-bottom: 14px;">
                                            <strong>Catatan Panitia:</strong> {{ $checkResult->catatan }}
                                        </div>
                                    @endif

                                    <div style="font-size: 0.85rem; color: #78350f;">
                                        <i class="fa-solid fa-circle-info"></i> Setelah berkas selesai diperiksa oleh Staff, status pendaftaran akan beralih ke <strong>"Menunggu Persetujuan Admin"</strong>.
                                    </div>
                                </div>
                            @elseif($checkResult->status === 'Ditolak')
                                <div style="background: #ffffff; border: 2px solid #ef4444; border-radius: 10px; padding: 22px;">
                                    <span style="background: #fee2e2; color: #991b1b; font-size: 0.82rem; font-weight: 800; padding: 4px 12px; border-radius: 999px; display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase; margin-bottom: 10px;">
                                        <i class="fa-solid fa-circle-xmark"></i> BELUM DAPAT DISETUJUI
                                    </span>
                                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #991b1b; margin-bottom: 6px;">
                                        Pendaftaran Belum Diterima
                                    </h3>
                                    <p style="font-size: 0.92rem; color: #7f1d1d; margin-bottom: 12px; line-height: 1.6;">
                                        Mohon maaf, pendaftaran calon santri atas nama <strong>{{ $checkResult->nama_lengkap }}</strong> belum dapat disetujui pada periode ini.
                                    </p>
                                    @if($checkResult->catatan)
                                        <div style="background: #fef2f2; border: 1px dashed #fca5a5; border-radius: 6px; padding: 10px 14px; font-size: 0.85rem; color: #991b1b;">
                                            <strong>Keterangan:</strong> {{ $checkResult->catatan }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 14px 18px; color: #991b1b; font-size: 0.9rem;">
                                <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i>
                                Data pendaftaran dengan kata kunci "<strong>{{ $searchedKeyword }}</strong>" tidak ditemukan. Pastikan Anda memasukkan Nomor Pendaftaran atau Nomor WhatsApp yang tepat saat mendaftar.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div id="form-daftar" style="scroll-margin-top: 100px;"></div>

            <!-- Flash Message Sukses Simpan ke MySQL -->
            @if(session('success_psb'))
                <div id="sukses-psb" style="scroll-margin-top: 100px; background:#ecfdf5; border:1.5px solid #10b981; border-radius:10px; padding:20px; margin-bottom:24px; box-shadow:0 4px 14px rgba(16,185,129,0.12);">
                    <div style="display:flex; align-items:flex-start; gap:14px; margin-bottom:12px;">
                        <div style="width:44px; height:44px; border-radius:50%; background:#dcfce7; color:#15803d; display:flex; align-items:center; justify-content:center; font-size:1.4rem; flex-shrink:0;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <span style="background: #fef3c7; color: #92400e; font-size: 0.76rem; font-weight: 800; padding: 3px 10px; border-radius: 999px; display: inline-flex; align-items: center; gap: 5px; text-transform: uppercase; margin-bottom: 5px;">
                                <i class="fa-solid fa-clock-rotate-left"></i> STATUS: SEDANG DITINJAU OLEH STAFF
                            </span>
                            <h4 style="font-size:1.25rem; font-weight:800; color:#065f46; margin:0 0 4px;">
                                Formulir Pendaftaran Berhasil Terkirim!
                            </h4>
                            <p style="font-size:0.9rem; color:#047857; margin:0; line-height:1.55;">
                                Data pendaftaran santri baru telah diterima sistem. Berkas Anda saat ini <strong>sedang ditinjau & diperiksa kelengkapannya oleh Staff Panitia PSB Ma'had Nurussyam</strong>.
                            </p>
                        </div>
                    </div>

                    <div style="background:#fff; border:1px dashed #86efac; border-radius:8px; padding:14px 16px; margin-top:10px; font-size:0.9rem;">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px;">
                            <div>
                                <span style="color:#64748b; font-size:0.8rem; display:block;">Nomor Registrasi:</span>
                                <strong style="color:var(--primary-green); font-family:monospace; font-size:1.1rem;">{{ session('success_psb')['no_pendaftaran'] }}</strong>
                            </div>
                            <div>
                                <span style="color:#64748b; font-size:0.8rem; display:block;">Nama Calon Santri:</span>
                                <strong>{{ session('success_psb')['nama'] }}</strong>
                            </div>
                            <div>
                                <span style="color:#64748b; font-size:0.8rem; display:block;">Jenjang Pendidikan:</span>
                                <strong>{{ session('success_psb')['jenjang'] }}</strong>
                            </div>
                            <div>
                                <span style="color:#64748b; font-size:0.8rem; display:block;">No. WhatsApp:</span>
                                <strong>{{ session('success_psb')['wa'] }}</strong>
                            </div>
                        </div>
                    </div>

                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:6px; padding:10px 14px; margin-top:12px; font-size:0.82rem; color:#166534; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <span><strong>Tahap Berikutnya:</strong> Setelah berkas Anda selesai diverifikasi oleh Staff, status akan beralih ke <em>"Menunggu Persetujuan Admin"</em>. Anda dapat memantau status persetujuan kapan saja menggunakan formulir <strong>Cek Hasil Persetujuan</strong> di atas.</span>
                    </div>
                </div>
            @endif

            @if(session('error_psb'))
                <div id="error-psb" style="scroll-margin-top: 100px; background:#fef2f2; border:1.5px solid #ef4444; border-radius:8px; padding:18px; margin-bottom:24px; box-shadow:0 4px 12px rgba(239,68,68,0.12);">
                    <div style="display:flex; align-items:flex-start; gap:14px;">
                        <div style="width:40px; height:40px; border-radius:50%; background:#fee2e2; color:#dc2626; display:flex; align-items:center; justify-content:center; font-size:1.3rem; flex-shrink:0;">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#991b1b; margin:0 0 6px;">
                                Pendaftaran Ditolak: Data Sudah Terdaftar Sebelumnya!
                            </h4>
                            <p style="font-size:0.92rem; color:#b91c1c; margin:0 0 10px; line-height:1.6;">
                                {!! session('error_psb') !!}
                            </p>
                            <a href="#cek-status" style="display:inline-flex; align-items:center; gap:6px; background:#dc2626; color:#fff; padding:7px 14px; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none;">
                                <i class="fa-solid fa-magnifying-glass"></i> Cek Status Pendaftaran Anda di Atas
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div id="form-errors" style="scroll-margin-top: 100px; background:#fef2f2; border:1px solid #ef4444; border-radius:8px; padding:14px; margin-bottom:20px; color:#991b1b;">
                    <strong><i class="fa-solid fa-triangle-exclamation"></i> Mohon periksa kembali formulir pendaftaran:</strong>
                    <ul style="margin:6px 0 0 20px; font-size:0.88rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulir Pendaftaran Cepat Terhubung Database MySQL -->
            @php
                $isPsbOpen = (($psb['psb_status'] ?? ($psbSettings['psb_status'] ?? '1')) == '1');
            @endphp

            @if($isPsbOpen)
                <div id="form-pendaftaran" style="scroll-margin-top: 100px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:22px;">
                    <h4 style="font-size:1.15rem; font-weight:800; color:#0f172a; margin-bottom:14px;">
                        <i class="fa-solid fa-file-pen" style="color:var(--primary-green); margin-right:6px;"></i> Formulir Pendaftaran Online PSB
                    </h4>

                    <form id="formDaftarPsb" method="POST" action="{{ route('pendaftaran.store') }}#form-daftar">
                        @csrf
                        <div class="form-row-2col">
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Nama Calon Santri *</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="search-field-input" placeholder="Nama lengkap sesuai akta" style="@error('nama_lengkap') border-color: #ef4444; background: #fff5f5; @enderror">
                                @error('nama_lengkap')
                                    <span style="display:block; font-size:0.78rem; color:#dc2626; font-weight:600; margin-top:4px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">No. WhatsApp Wali / Santri *</label>
                                <input type="tel" name="no_wa" value="{{ old('no_wa') }}" required class="search-field-input" placeholder="08xxxxxxxxxx" style="@error('no_wa') border-color: #ef4444; background: #fff5f5; @enderror">
                                @error('no_wa')
                                    <span style="display:block; font-size:0.78rem; color:#dc2626; font-weight:600; margin-top:4px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row-2col" style="margin-top:12px;">
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" required class="search-field-input">
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki (Santri Putra)</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan (Santri Putri)</option>
                                </select>
                            </div>
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Jenjang Pendidikan *</label>
                                <select name="pilihan_jenjang" required class="search-field-input">
                                    <option value="">-- Pilih Jenjang Pendidikan --</option>
                                    <option value="MTS NURUSSYAM" {{ old('pilihan_jenjang') == 'MTS NURUSSYAM' ? 'selected' : '' }}>MTs Nurussyam</option>
                                    <option value="MA NURUSSYAM" {{ old('pilihan_jenjang') == 'MA NURUSSYAM' ? 'selected' : '' }}>MA Nurussyam</option>
                                    <option value="TAHFIDZUL QURAN" {{ old('pilihan_jenjang') == 'TAHFIDZUL QURAN' ? 'selected' : '' }}>Program Tahfidzul Qur'an</option>
                                    <option value="MADRASAH DINIYAH" {{ old('pilihan_jenjang') == 'MADRASAH DINIYAH' ? 'selected' : '' }}>Madrasah Diniyah (Ma'had Nurussyam)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-2col" style="margin-top:12px;">
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Nama Orang Tua / Wali</label>
                                <input type="text" name="nama_wali" value="{{ old('nama_wali') }}" class="search-field-input" placeholder="Nama ayah / ibu / wali">
                            </div>
                            <div>
                                <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Asal Sekolah Sebelumnya</label>
                                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" class="search-field-input" placeholder="Contoh: SD / MI / SMP Asal">
                            </div>
                        </div>

                        <div style="margin-top:12px; margin-bottom:18px;">
                            <label style="display:block; font-size:0.82rem; font-weight:700; margin-bottom:5px;">Alamat Asal Lengkap</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" class="search-field-input" placeholder="Desa, Kecamatan, Kabupaten/Kota">
                        </div>

                        <button type="submit" style="background:var(--primary-green); color:#fff; border:none; padding:12px 24px; border-radius:4px; font-weight:800; font-size:0.95rem; cursor:pointer; width:100%; transition:background 0.2s ease;">
                            <i class="fa-solid fa-paper-plane" style="margin-right:6px;"></i> Kirim Pendaftaran Santri Baru
                        </button>
                    </form>
                </div>
            @else
                <div id="form-pendaftaran" style="background:#ffffff; border:2px dashed #cbd5e1; border-radius:10px; padding:36px 24px; text-align:center; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                    <div style="width:64px; height:64px; border-radius:50%; background:#fef2f2; color:#dc2626; display:inline-flex; align-items:center; justify-content:center; font-size:1.8rem; margin-bottom:16px;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 style="font-size:1.35rem; font-weight:800; color:#1e293b; margin-bottom:8px;">
                        Pendaftaran Online Saat Ini Sedang Ditutup
                    </h3>
                    <p style="color:#64748b; font-size:0.95rem; max-width:540px; margin:0 auto 20px; line-height:1.65;">
                        Mohon maaf, pengisian formulir pendaftaran santri baru secara online untuk Tahun Ajaran <strong>{{ $psb['psb_tahun_ajaran'] ?? ($psbSettings['psb_tahun_ajaran'] ?? '2026/2027') }}</strong> saat ini sedang tidak dibuka. Silakan periksa rincian jadwal gelombang atau hubungi sekretariat panitia PSB pondok.
                    </p>
                    <div style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
                        <a href="{{ route('pendaftaran.info') }}" style="background:var(--primary-green); color:#fff; padding:11px 22px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 2px 6px rgba(15,133,40,0.25);">
                            <i class="fa-solid fa-calendar-days"></i> Lihat Informasi Jadwal Gelombang
                        </a>
                        @php
                            $waContact = preg_replace('/[^0-9]/', '', $psb['psb_contact_wa'] ?? ($psbSettings['psb_contact_wa'] ?? '6281234567890'));
                        @endphp
                        <a href="https://wa.me/{{ $waContact }}?text={{ rawurlencode('Assalamu\'alaikum Panitia PSB Nurussyam, saya ingin menanyakan informasi pendaftaran santri baru.') }}" target="_blank" style="background:#25D366; color:#fff; padding:11px 22px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi Panitia PSB
                        </a>
                    </div>
                </div>
            @endif
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
