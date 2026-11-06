@extends('admin.layout')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-sliders"></i>
                <span>Pengaturan & Konfigurasi Website</span>
            </h1>
            <p class="page-head-subtitle">Perbarui data kontak resmi, rekening LAZISWAF, counter statistik, kelola role akses, dan histori aktivitas user.</p>
        </div>
    </div>

    <!-- Quick Access Hub: Role Akses & Histori Aktivitas (Sesuai Permintaan Pengaturan Admin) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem;">
        
        <!-- Card 1: Role & Hak Akses -->
        <div class="adm-card" style="border-left: 4px solid var(--adm-primary); background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(240,253,244,0.7));">
            <div class="adm-card-body" style="padding: 1.5rem;">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 0.85rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(15, 133, 40, 0.12); color: var(--adm-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <span class="badge badge-emerald" style="padding: 0.35rem 0.65rem; font-size: 0.75rem;">
                        Fitur Wewenang
                    </span>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 0.45rem;">
                    Role & Hak Akses Pengguna
                </h3>
                <p style="font-size: 0.86rem; color: var(--adm-text-muted); line-height: 1.5; margin-bottom: 1.25rem;">
                    Tambah role akses baru (seperti Staff, Penulis Berita, atau role custom) dan tentukan izin wewenang (kelola santri, verifikasi PSB, persetujuan penerimaan admin, upload berita).
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary" style="padding: 0.65rem 1.15rem; font-size: 0.85rem;">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Nambah & Kelola Role Akses</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="padding: 0.65rem 1rem; font-size: 0.85rem;">
                        <i class="fa-solid fa-users"></i>
                        <span>Penugasan User</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: Histori Aktivitas & Jam Login -->
        <div class="adm-card" style="border-left: 4px solid #0284c7; background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(240,249,255,0.7));">
            <div class="adm-card-body" style="padding: 1.5rem;">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 0.85rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(2, 132, 199, 0.12); color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <span class="badge badge-blue" style="padding: 0.35rem 0.65rem; font-size: 0.75rem;">
                        Audit Log Real-Time
                    </span>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 0.45rem;">
                    Histori Aktivitas & Jam Login
                </h3>
                <p style="font-size: 0.86rem; color: var(--adm-text-muted); line-height: 1.5; margin-bottom: 1.25rem;">
                    Pantau jam login setiap user role, alamat IP, dan apa saja yang dilakukan user secara rinci (publikasi berita, verifikasi PSB, tambah santri, pengaturan website).
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn" style="background: #0284c7; color: #fff; padding: 0.65rem 1.15rem; font-size: 0.85rem; border: none; border-radius: 8px; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600;">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Lihat Histori Aktivitas User</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3: Informasi & Gelombang PSB -->
        <div class="adm-card" style="border-left: 4px solid #10b981; background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(240,253,244,0.7));">
            <div class="adm-card-body" style="padding: 1.5rem;">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 0.85rem;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <span class="badge {{ ($psbSettings['psb_status'] ?? '1') == '1' ? 'badge-emerald' : 'badge-rose' }}" style="padding: 0.35rem 0.65rem; font-size: 0.75rem;">
                        {{ ($psbSettings['psb_status'] ?? '1') == '1' ? 'PSB Buka (T.A ' . ($psbSettings['psb_tahun_ajaran'] ?? '2026/2027') . ')' : 'PSB Ditutup' }}
                    </span>
                </div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 0.45rem;">
                    Informasi & Gelombang PSB
                </h3>
                <p style="font-size: 0.86rem; color: var(--adm-text-muted); line-height: 1.5; margin-bottom: 1.25rem;">
                    Atur tahun ajaran baru, jadwal Gelombang I & II, kontak sekretariat, dan aktifkan atau nonaktifkan pendaftaran santri baru langsung dari panel admin.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.65rem;">
                    <a href="{{ route('admin.psb.settings') }}" class="btn btn-primary" style="padding: 0.65rem 1.15rem; font-size: 0.85rem;">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Atur Informasi & Gelombang</span>
                    </a>
                </div>
            </div>
        </div>

    </div>


    <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
        
        <!-- General Settings Form -->
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-mosque"></i>
                    <span>Informasi Umum & Kontak Pesantren</span>
                </h2>
            </div>
            <div class="adm-card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="site_name" class="form-label">Nama Website / Lembaga</label>
                            <input type="text" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="site_tagline" class="form-label">Slogan / Tagline</label>
                            <input type="text" id="site_tagline" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Berilmu, Berakhlak, dan Berkhidmah untuk Ummat' }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone" class="form-label">Telepon Kantor</label>
                            <input type="text" id="phone" name="phone" value="{{ $settings['phone'] ?? '+62 812-3456-7890' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="wa_psb" class="form-label">Nomor WhatsApp Layanan PSB</label>
                            <input type="text" id="wa_psb" name="wa_psb" value="{{ $settings['wa_psb'] ?? '081234567890' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Resmi</label>
                            <input type="email" id="email" name="email" value="{{ $settings['email'] ?? 'info@nurussyam.ponpes.id' }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Alamat Lengkap Pesantren</label>
                        <textarea id="address" name="address" rows="2" class="form-control">{{ $settings['address'] ?? 'Jl. Raya Bondowoso - Besuki, Desa Wringin, Kec. Wringin, Kab. Bondowoso, Jawa Timur 68252' }}</textarea>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.5rem 0;">

                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--adm-text-main); margin-bottom: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-building-columns" style="color: var(--adm-primary);"></i>
                        <span>Rekening Resmi LAZISWAF</span>
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bank_bsi" class="form-label">Nomor Rekening Bank BSI</label>
                            <input type="text" id="bank_bsi" name="bank_bsi" value="{{ $settings['bank_bsi'] ?? '7143-0029-80' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="an_bsi" class="form-label">Atas Nama Rekening BSI</label>
                            <input type="text" id="an_bsi" name="an_bsi" value="{{ $settings['an_bsi'] ?? 'LAZISWAF NURUSSYAM' }}" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bank_mandiri" class="form-label">Nomor Rekening Bank Mandiri</label>
                            <input type="text" id="bank_mandiri" name="bank_mandiri" value="{{ $settings['bank_mandiri'] ?? '143-00-2980022-2' }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="an_mandiri" class="form-label">Atas Nama Rekening Mandiri</label>
                            <input type="text" id="an_mandiri" name="an_mandiri" value="{{ $settings['an_mandiri'] ?? 'YYS PONPES NURUSSYAM' }}" class="form-control">
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.5rem 0;">

                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--adm-text-main); margin-bottom: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-chart-simple" style="color: var(--adm-primary);"></i>
                        <span>Counter Angka Statistik Pesantren (Beranda)</span>
                    </h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="count_santri" class="form-label">Jumlah Santri Aktif</label>
                            <input type="text" id="count_santri" name="count_santri" value="{{ $settings['count_santri'] ?? '1.250+' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="count_asatidz" class="form-label">Dewan Asatidz / Guru</label>
                            <input type="text" id="count_asatidz" name="count_asatidz" value="{{ $settings['count_asatidz'] ?? '85+' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="count_alumni" class="form-label">Jumlah Alumni Tersebar</label>
                            <input type="text" id="count_alumni" name="count_alumni" value="{{ $settings['count_alumni'] ?? '5.000+' }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="count_lembaga" class="form-label">Unit Pendidikan & Lembaga</label>
                            <input type="text" id="count_lembaga" name="count_lembaga" value="{{ $settings['count_lembaga'] ?? '6 Unit' }}" class="form-control">
                        </div>
                    </div>

                    <div style="margin-top: 1rem;">
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Pengaturan Website</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="adm-card">
            <div class="adm-card-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <h2 class="adm-card-title" style="margin: 0;">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Tautan & Statistik Media Sosial</span>
                </h2>
                <form action="{{ route('admin.settings.social.sync') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.45rem 0.95rem; font-size: 0.85rem; border: 1px solid var(--adm-primary); color: var(--adm-primary); font-weight: 700; background: #f0fdf4; border-radius: 6px; cursor: pointer;" title="Tarik data pengikut terkini dari link akun resmi secara otomatis">
                        <i class="fa-solid fa-rotate"></i>
                        <span>Sinkronkan Pengikut Otomatis</span>
                    </button>
                </form>
            </div>
            <div class="adm-card-body">
                <form action="{{ route('admin.settings.social') }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Platform</th>
                                    <th>Jumlah Pengikut / Tampilan</th>
                                    <th>Angka Riil (Raw)</th>
                                    <th>Tautan URL Akun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($socials as $index => $soc)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="social[{{ $index }}][id]" value="{{ $soc->id }}">
                                            <div style="display: flex; align-items: center; gap: 0.65rem; font-weight: 700;">
                                                <i class="fa-brands {{ $soc->icon }}" style="font-size: 1.25rem; color: {{ $soc->color }};"></i>
                                                <span>{{ $soc->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="social[{{ $index }}][count_formatted]" value="{{ $soc->count_formatted }}" class="form-control" style="max-width: 150px;" required>
                                        </td>
                                        <td>
                                            <input type="number" name="social[{{ $index }}][raw_count]" value="{{ $soc->raw_count }}" class="form-control" style="max-width: 140px;" required>
                                        </td>
                                        <td>
                                            <input type="text" name="social[{{ $index }}][url]" value="{{ $soc->url }}" class="form-control" required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 1.25rem;">
                        <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Perbarui Media Sosial</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
