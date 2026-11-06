@extends('layouts.app')

@section('title', 'Syarat & Berkas Pendaftaran Santri Baru (PSB) - Pondok Pesantren Nurussyam')

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="bc-sep">›</span>
            <a href="{{ route('pendaftaran.info') }}">Pendaftaran</a>
            <span class="bc-sep">›</span>
            <span class="breadcrumb-current">Syarat & Berkas</span>
        </nav>

        <div class="info-page-card">
            
            <div style="border-bottom:2px solid var(--primary-green); padding-bottom:14px; margin-bottom:24px;">
                <span class="badge-overlay badge-catatan" style="display:inline-block; margin-bottom:8px;">
                    PERSYARATAN & BERKAS RESMI PSB
                </span>
                <h1 class="article-title-heading">
                    Syarat & Berkas Pendaftaran Santri Baru
                </h1>
                <p style="color:#64748b; font-size:0.92rem; margin-top:6px;">
                    Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso
                </p>
            </div>


            @php
                $isPsbOpen = ($psb['psb_status'] ?? ($psbSettings['psb_status'] ?? '1')) == '1';
            @endphp
            <!-- Tombol Navigasi Pintas -->
            <div style="display:flex; gap:12px; margin-bottom:28px; flex-wrap:wrap;">
                <a href="{{ route('pendaftaran.info') }}" style="background:#0f172a; color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-circle-info" style="color:#86efac;"></i> Informasi & Jadwal PSB
                </a>
                @if($isPsbOpen)
                    <a href="{{ route('pendaftaran') }}" style="background:var(--primary-green); color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 2px 8px rgba(15,133,40,0.3);">
                        <i class="fa-solid fa-file-pen"></i> Isi Formulir Online Sekarang
                    </a>
                @else
                    <a href="{{ route('pendaftaran') }}#cek-status" style="background:#475569; color:#fff; padding:11px 20px; border-radius:6px; font-weight:700; font-size:0.92rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Cek Status Pendaftaran
                    </a>
                @endif
            </div>

            <!-- Pengantar -->
            <div style="line-height:1.85; color:#334155; font-size:1.02rem; margin-bottom:28px;">
                <p>
                    Demi kelancaran dan ketertiban proses Penerimaan Santri Baru (PSB) Pondok Pesantren Nurussyam, seluruh calon santri dan orang tua/wali diharapkan membaca dan mempersiapkan seluruh persyaratan umum serta kelengkapan dokumen administrasi berikut:
                </p>
            </div>

            <!-- Bagian 1: Persyaratan Umum -->
            <div style="margin-bottom:34px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-user-check" style="color:var(--primary-green);"></i> A. Persyaratan Umum Calon Santri
                </h3>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:20px 24px;">
                    <ol style="margin:0; padding-left:20px; line-height:2; color:#334155; font-size:0.95rem;">
                        <li><strong>Beragama Islam</strong> dan memiliki kemauan yang tulus serta bersungguh-sungguh (<em>lillahi ta'ala</em>) untuk menuntut ilmu di pondok pesantren.</li>
                        <li><strong>Sanggup Mukim di Asrama:</strong> Bersedia tinggal dan menetap di asrama Pondok Pesantren Nurussyam selama masa jenjang pendidikan berlangsung.</li>
                        <li><strong>Menaati Tata Tertib:</strong> Sanggup mematuhi segenap peraturan, disiplin waktu, etika santri, dan sunnah pesantren yang berlaku.</li>
                        <li><strong>Menjaga Kehormatan Lembaga:</strong> Berkomitmen menjaga nama baik almamater pondok pesantren, asatidz, dan para pengasuh di mana pun berada.</li>
                        <li><strong>Didampingi Orang Tua / Wali:</strong> Wajib didampingi oleh orang tua kandung atau wali yang sah pada saat penyerahan berkas dan prosesi sowan ta'aruf kepada Pengasuh.</li>
                        <li><strong>Bebas NAPZA & Kenakalan:</strong> Tidak merokok, bebas dari narkoba, minuman keras, pergaulan bebas, dan tidak terlibat dalam tindakan kriminal.</li>
                    </ol>
                </div>
            </div>

            <!-- Bagian 2: Kelengkapan Berkas Administrasi (Checklist) -->
            <div style="margin-bottom:34px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-folder-open" style="color:var(--primary-green);"></i> B. Berkas Dokumen Administrasi yang Wajib Diserahkan
                </h3>

                <p style="font-size:0.92rem; color:#64748b; margin-bottom:16px;">
                    Mohon menyiapkan dokumen-dokumen fisik berikut dalam rangkap yang rapi untuk diserahkan ke sekretariat panitia:
                </p>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:14px;">
                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">1. Bukti Pendaftaran</strong>
                        <span style="font-size:0.88rem; color:#64748b;">1 lembar cetak bukti pendaftaran online atau formulir registrasi resmi dari panitia.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">2. Fotokopi Ijazah / SKL</strong>
                        <span style="font-size:0.88rem; color:#64748b;">3 lembar fotokopi ijazah terakhir atau Surat Keterangan Lulus (SKL) berlegalisir cap basah.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">3. Fotokopi Kartu Keluarga (KK)</strong>
                        <span style="font-size:0.88rem; color:#64748b;">3 lembar fotokopi Kartu Keluarga terbaru yang jelas dan dapat terbaca barcode-nya.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">4. Fotokopi Akta Kelahiran</strong>
                        <span style="font-size:0.88rem; color:#64748b;">3 lembar fotokopi Akta Kelahiran calon santri dari dinas kependudukan dan pencatatan sipil.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">5. Fotokopi KTP Orang Tua / Wali</strong>
                        <span style="font-size:0.88rem; color:#64748b;">Masing-masing 3 lembar fotokopi KTP ayah dan ibu kandung atau wali yang masih aktif.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">6. Bukti Nomor NISN</strong>
                        <span style="font-size:0.88rem; color:#64748b;">1 lembar cetak Nomor Induk Siswa Nasional (NISN) yang valid dari database Kemdikbud/Kemenag.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">7. Pas Foto Terbaru (3x4)</strong>
                        <span style="font-size:0.88rem; color:#64748b;">5 lembar pas foto berwarna 3x4 (Santri Putra: peci hitam & kemeja; Putri: jilbab putih; latar merah).</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">8. Surat Keterangan Sehat</strong>
                        <span style="font-size:0.88rem; color:#64748b;">Surat asli keterangan sehat dari Dokter, Puskesmas, atau Rumah Sakit pemerintah setempat.</span>
                    </div>

                    <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:4px solid var(--primary-green); padding:16px; border-radius:0 8px 8px 0; box-shadow:0 2px 4px rgba(0,0,0,0.03);">
                        <strong style="color:#0f172a; display:block; font-size:0.96rem; margin-bottom:4px;">9. Berkas KIP/PKH (Jika Ada)</strong>
                        <span style="font-size:0.88rem; color:#64748b;">2 lembar fotokopi Kartu Indonesia Pintar (KIP) atau bukti kepesertaan bansos bagi jalur dhuafa.</span>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Ketentuan Stopmap Berkas -->
            <div style="margin-bottom:34px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-box-archive" style="color:var(--primary-green);"></i> C. Ketentuan Stopmap Penyerahan Berkas
                </h3>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
                    <div style="background:#f0fdf4; border:2px solid #86efac; border-radius:8px; padding:20px; text-align:center;">
                        <div style="width:50px; height:50px; border-radius:50%; background:#15803d; color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:12px;">
                            <i class="fa-solid fa-mars"></i>
                        </div>
                        <h4 style="font-size:1.1rem; font-weight:800; color:#064e18; margin:0 0 6px;">Santri Putra</h4>
                        <p style="font-size:0.92rem; color:#166534; margin:0;">
                            Menggunakan <strong>Stopmap Warna HIJAU</strong>
                        </p>
                    </div>

                    <div style="background:#fefce8; border:2px solid #fde047; border-radius:8px; padding:20px; text-align:center;">
                        <div style="width:50px; height:50px; border-radius:50%; background:#ca8a04; color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:1.4rem; margin-bottom:12px;">
                            <i class="fa-solid fa-venus"></i>
                        </div>
                        <h4 style="font-size:1.1rem; font-weight:800; color:#713f12; margin:0 0 6px;">Santri Putri</h4>
                        <p style="font-size:0.92rem; color:#854d0e; margin:0;">
                            Menggunakan <strong>Stopmap Warna KUNING</strong>
                        </p>
                    </div>
                </div>

                <div style="margin-top:12px; font-size:0.88rem; color:#64748b; line-height:1.6;">
                    * Pada cover depan stopmap, tuliskan secara jelas menggunakan spidol/pena: <strong>Nama Lengkap Santri</strong>, <strong>Jenjang Pilihan</strong>, <strong>Nomor Pendaftaran</strong>, dan <strong>Nomor WhatsApp Wali</strong>.
                </div>
            </div>

            <!-- Bagian 4: Materi Tes Observasi -->
            <div style="margin-bottom:34px;">
                <h3 style="font-size:1.25rem; font-weight:800; color:#0f172a; margin-bottom:14px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-file-invoice" style="color:var(--primary-green);"></i> D. Materi Seleksi & Pemetaan Calon Santri
                </h3>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:20px;">
                    <ul style="list-style:none; padding:0; margin:0; line-height:2.1; font-size:0.94rem; color:#334155;">
                        <li><i class="fa-solid fa-check" style="color:var(--primary-green); width:24px;"></i> <strong>Tes Baca Tulis Al-Qur'an (BTQ):</strong> Mengetahui kelancaran membaca Al-Qur'an serta penerapan tajwid dasar.</li>
                        <li><i class="fa-solid fa-check" style="color:var(--primary-green); width:24px;"></i> <strong>Praktik Ibadah Shalat:</strong> Praktik wudhu, gerakan shalat fardhu, dan bacaan doa shalat sehari-hari.</li>
                        <li><i class="fa-solid fa-check" style="color:var(--primary-green); width:24px;"></i> <strong>Wawancara Motivasi Santri:</strong> Mengukur niat, kesiapan mental, dan kemandirian tinggal di pondok.</li>
                        <li><i class="fa-solid fa-check" style="color:var(--primary-green); width:24px;"></i> <strong>Wawancara Orang Tua / Wali:</strong> Menyelaraskan visi pendidikan dan komitmen pendampingan santri.</li>
                    </ul>
                </div>
            </div>

            <!-- CTA Menuju Formulir Online -->
            <div style="background:linear-gradient(135deg, #f0fdf4, #dcfce7); border:1.5px solid #86efac; border-radius:8px; padding:24px; text-align:center;">
                <h3 style="font-size:1.2rem; font-weight:800; color:#064e18; margin-bottom:8px;">
                    Berkas Sudah Lengkap? Segera Daftarkan Diri Anda Secara Online!
                </h3>
                <p style="font-size:0.92rem; color:#166534; max-width:540px; margin:0 auto 18px; line-height:1.6;">
                    Pengisian formulir online hanya membutuhkan waktu 2-3 menit. Setelah mengisi, Anda akan langsung memperoleh Nomor Registrasi resmi PSB Nurussyam.
                </p>
                <a href="{{ route('pendaftaran') }}" style="background:var(--primary-green); color:#fff; padding:12px 28px; border-radius:6px; font-weight:800; font-size:1rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; box-shadow:0 3px 10px rgba(15,133,40,0.3);">
                    <i class="fa-solid fa-file-pen"></i> Buka Formulir Pendaftaran Online
                </a>
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
