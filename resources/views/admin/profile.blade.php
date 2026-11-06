@extends('admin.layout')

@section('title', 'Profil & Keamanan Akun')
@section('page_title', 'Profil Pengelola')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Profil & Keamanan Akun Pengelola</span>
            </h1>
            <p class="page-head-subtitle">Kelola nama pengguna, email login, serta perbarui password akses admin.</p>
        </div>
    </div>

    <div class="adm-grid-2col">
        
        <!-- Profile & Info -->
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Informasi Akun Admin</span>
                </h2>
            </div>
            <div class="adm-card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Pengelola <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Login <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.5rem 0;">

                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--adm-text-main); margin-bottom: 0.75rem;">
                        <i class="fa-solid fa-key" style="color: var(--adm-primary); margin-right: 0.35rem;"></i>
                        Ganti Password (Opsional)
                    </h3>
                    <p style="font-size: 0.78rem; color: var(--adm-text-muted); margin-bottom: 1.25rem;">
                        Kosongkan bagian ini jika Anda tidak ingin mengubah password saat ini.
                    </p>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Ketikkan password lama">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; margin-top: 0.5rem;">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Akun</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Security Guide & Tips -->
        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>Panduan Keamanan Panel</span>
                </h2>
            </div>
            <div class="adm-card-body" style="font-size: 0.85rem; line-height: 1.6; color: #475569;">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1rem; border-radius: var(--adm-radius-sm); margin-bottom: 1rem;">
                    <strong style="color: #166534; display: block; margin-bottom: 0.25rem;">
                        <i class="fa-solid fa-lock"></i> Hak Akses Super Admin
                    </strong>
                    Akun ini memiliki otoritas penuh untuk menambah/mengedit berita, memverifikasi santri pendaftaran, dan mengubah rekening donasi.
                </div>

                <ul style="padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li>Gunakan kata sandi kombinasi huruf, angka, dan karakter agar tidak mudah ditebak.</li>
                    <li>Jangan memberikan kredensial login kepada pihak di luar tim redaksi pondok.</li>
                    <li>Selalu klik tombol <strong>Logout</strong> setelah selesai menggunakan panel admin pada komputer bersama atau warnet.</li>
                    <li>Pastikan nomor WhatsApp layanan panitia PSB selalu aktif untuk melayani calon santri dan wali.</li>
                </ul>
            </div>
        </div>

    </div>
@endsection
