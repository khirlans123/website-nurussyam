@extends('admin.layout')

@section('title', 'Tambah Santri Baru')
@section('page_title', 'Tambah Santri Baru')

@section('content')
    <div class="page-head">
        <div class="page-head-info">
            <div class="page-head-badge">
                <i class="fa-solid fa-user-plus"></i>
                <span>Entri Data Santri</span>
            </div>
            <h1 class="page-head-title">
                Tambah <strong>Santri Aktif Baru</strong>
            </h1>
            <p class="page-head-subtitle">Tambahkan data santri baru secara langsung ke pangkalan data santri aktif Pondok Pesantren Nurussyam.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Data Santri</span>
            </a>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1.5rem; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.25rem; border-radius: var(--adm-radius-sm);">
            <strong style="display: block; margin-bottom: 0.35rem;"><i class="fa-solid fa-circle-exclamation"></i> Mohon lengkapi formulir dengan benar:</strong>
            <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf

        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-user"></i>
                    <span>Biodata Diri Santri</span>
                </h2>
            </div>
            <div class="adm-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nama Lengkap Santri</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Muhammad Fatih Al-Faruq">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki (Putra)</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan (Putri)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Jenjang Pendidikan</label>
                        <select name="pilihan_jenjang" class="form-control" required>
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="MTs Nurussyam" {{ old('pilihan_jenjang') === 'MTs Nurussyam' ? 'selected' : '' }}>MTs Nurussyam</option>
                            <option value="MA Nurussyam" {{ old('pilihan_jenjang') === 'MA Nurussyam' ? 'selected' : '' }}>MA Nurussyam</option>
                            <option value="Madrasah Diniyah" {{ old('pilihan_jenjang') === 'Madrasah Diniyah' ? 'selected' : '' }}>Madrasah Diniyah</option>
                            <option value="Tahfidzul Qur'an" {{ old('pilihan_jenjang') === 'Tahfidzul Qur\'an' ? 'selected' : '' }}>Tahfidzul Qur'an</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}" placeholder="Contoh: MI Nurul Huda">
                    </div>

                    <div class="form-group">
                        <label class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" placeholder="Contoh: 0081234567">
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="Contoh: 3511012345670001">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Bondowoso">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="adm-card">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-users"></i>
                    <span>Data Orang Tua / Wali & Kontak</span>
                </h2>
            </div>
            <div class="adm-card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}" required placeholder="Contoh: H. Ahmad Syarifuddin">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nomor WhatsApp Aktif</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa') }}" required placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label required">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required placeholder="Alamat lengkap: Dusun, Desa/Kelurahan, RT/RW, Kecamatan, Kabupaten/Kota">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan asrama, kesehatan, atau riwayat khusus...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="adm-card-footer" style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Data Santri</span>
                </button>
            </div>
        </div>
    </form>
@endsection
