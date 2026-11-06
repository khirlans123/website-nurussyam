@extends('admin.layout')

@section('title', 'Edit Data Santri - ' . $student->nama_lengkap)
@section('page_title', 'Edit Data Santri')

@section('content')
    <div class="page-head">
        <div class="page-head-info">
            <div class="page-head-badge">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Perbarui Informasi</span>
            </div>
            <h1 class="page-head-title">
                Edit Santri: <strong>{{ $student->nama_lengkap }}</strong>
            </h1>
            <p class="page-head-subtitle">No. Induk / Reg: <strong>{{ $student->no_pendaftaran }}</strong> &bull; Silakan perbarui data santri di bawah ini.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.students.show', $student) }}" class="btn btn-secondary">
                <i class="fa-solid fa-eye"></i>
                <span>Lihat Profil</span>
            </a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1.5rem; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.25rem; border-radius: var(--adm-radius-sm);">
            <strong style="display: block; margin-bottom: 0.35rem;"><i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan input:</strong>
            <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')

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
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $student->nama_lengkap) }}" required placeholder="Contoh: Ahmad Fawaid Al-Bustami">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $student->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki (Putra)</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $student->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan (Putri)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Jenjang Pendidikan</label>
                        <select name="pilihan_jenjang" class="form-control" required>
                            <option value="MTs Nurussyam" {{ old('pilihan_jenjang', $student->pilihan_jenjang) === 'MTs Nurussyam' ? 'selected' : '' }}>MTs Nurussyam</option>
                            <option value="MA Nurussyam" {{ old('pilihan_jenjang', $student->pilihan_jenjang) === 'MA Nurussyam' ? 'selected' : '' }}>MA Nurussyam</option>
                            <option value="Madrasah Diniyah" {{ old('pilihan_jenjang', $student->pilihan_jenjang) === 'Madrasah Diniyah' ? 'selected' : '' }}>Madrasah Diniyah</option>
                            <option value="Tahfidzul Qur'an" {{ old('pilihan_jenjang', $student->pilihan_jenjang) === 'Tahfidzul Qur\'an' ? 'selected' : '' }}>Tahfidzul Qur'an</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah', $student->asal_sekolah) }}" placeholder="Contoh: MTs Negeri 1 Bondowoso">
                    </div>

                    <div class="form-group">
                        <label class="form-label">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $student->nisn) }}" placeholder="Contoh: 0081234567">
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $student->nik) }}" placeholder="Contoh: 3511012345670001">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" placeholder="Contoh: Bondowoso">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $student->tanggal_lahir ? $student->tanggal_lahir->format('Y-m-d') : '') }}">
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
                        <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali', $student->nama_wali) }}" required placeholder="Contoh: H. Bustami Ahmad">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nomor WhatsApp Aktif</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa', $student->no_wa) }}" required placeholder="Contoh: 081298765432">
                        <small style="color: var(--adm-text-muted); font-size: 0.75rem;">Digunakan untuk komunikasi pihak pesantren dengan wali santri.</small>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label required">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required placeholder="Alamat domisili lengkap: Dusun, Desa/Kelurahan, RT/RW, Kecamatan, Kabupaten/Kota">{{ old('alamat', $student->alamat) }}</textarea>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan asrama, kesehatan, atau riwayat khusus...">{{ old('catatan', $student->catatan) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="adm-card-footer" style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </form>
@endsection
