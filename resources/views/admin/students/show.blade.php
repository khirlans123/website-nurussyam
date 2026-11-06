@extends('admin.layout')

@section('title', 'Profil Santri - ' . $student->nama_lengkap)
@section('page_title', 'Profil Santri Aktif')

@section('content')
    <div class="page-head">
        <div class="page-head-info">
            <div class="page-head-badge">
                <i class="fa-solid fa-user-check"></i>
                <span>Santri Resmi Nurussyam</span>
            </div>
            <h1 class="page-head-title">
                Profil: <strong>{{ $student->nama_lengkap }}</strong>
            </h1>
            <p class="page-head-subtitle">No. Induk / Reg: <strong>{{ $student->no_pendaftaran }}</strong> &bull; Resmi Diterima pada {{ $student->updated_at->format('d F Y') }}</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.students.card', $student) }}" target="_blank" class="btn btn-primary" title="Cetak Kartu Tanda Santri">
                <i class="fa-solid fa-id-card"></i>
                <span>Cetak Kartu Santri</span>
            </a>
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-secondary" title="Edit Data Santri">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Biodata</span>
            </a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @php
        $cleanWa = preg_replace('/[^0-9]/', '', $student->no_wa);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        }
        $waMessage = rawurlencode("Assalamu'alaikum Wr. Wb. Bpk/Ibu wali dari ananda {$student->nama_lengkap}. Kami dari Pengurus Pondok Pesantren Nurussyam Wringin Bondowoso mengonfirmasi status keaktifan santri.");
    @endphp

    <div class="adm-detail-layout">
        
        <!-- Main Student Data (Left Column) -->
        <div>
            <!-- Personal Data Card -->
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-address-card"></i>
                        <span>Biodata Lengkap Santri</span>
                    </h2>
                    <span class="badge badge-emerald" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                        <i class="fa-solid fa-circle-check"></i> Santri Aktif
                    </span>
                </div>
                <div class="adm-card-body">
                    <div class="adm-biodata-grid">
                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">No. Induk / Registrasi</div>
                            <div style="font-size: 1.15rem; font-weight: 800; color: var(--adm-primary); margin-top: 0.2rem;">
                                {{ $student->no_pendaftaran }}
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Jenjang Pendidikan</div>
                            <div style="font-size: 1.05rem; font-weight: 700; margin-top: 0.2rem;">
                                <span class="badge badge-slate" style="font-size: 0.85rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $student->pilihan_jenjang) }}</span>
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nama Lengkap</div>
                            <div style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-main); margin-top: 0.2rem;">
                                {{ $student->nama_lengkap }}
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Jenis Kelamin</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem; font-weight: 600;">
                                @if($student->jenis_kelamin === 'Laki-laki')
                                    <span style="color: #2563eb;"><i class="fa-solid fa-mars"></i> Laki-laki (Santri Putra)</span>
                                @else
                                    <span style="color: #db2777;"><i class="fa-solid fa-venus"></i> Perempuan (Santri Putri)</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">NISN</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $student->nisn ?: '-' }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">NIK / No. KTP</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $student->nik ?: '-' }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Tempat & Tanggal Lahir</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">
                                {{ $student->tempat_lahir ?: '-' }}, {{ $student->tanggal_lahir ? $student->tanggal_lahir->format('d F Y') : '-' }}
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Asal Sekolah</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $student->asal_sekolah ?: '-' }}</div>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.5rem 0;">

                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--adm-text-main); margin-bottom: 1rem;">
                        <i class="fa-solid fa-user-group" style="color: var(--adm-primary); margin-right: 0.4rem;"></i>
                        Informasi Orang Tua / Wali & Kontak
                    </h3>

                    <div class="adm-biodata-grid">
                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nama Orang Tua / Wali</div>
                            <div style="font-size: 1rem; font-weight: 700; margin-top: 0.2rem; color: var(--adm-text-main);">
                                {{ $student->nama_wali }}
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nomor WhatsApp</div>
                            <div style="margin-top: 0.2rem;">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ $waMessage }}" target="_blank" class="btn btn-sm btn-success" style="font-size: 0.85rem;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i>
                                    <span>Hubungi Wali ({{ $student->no_wa }})</span>
                                </a>
                            </div>
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Alamat Lengkap Domisili</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem; background: var(--adm-surface-alt); padding: 0.85rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border); line-height: 1.5;">
                                {{ $student->alamat }}
                            </div>
                        </div>

                        @if($student->catatan)
                            <div style="grid-column: 1 / -1;">
                                <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Catatan Tambahan</div>
                                <div style="font-size: 0.9rem; margin-top: 0.2rem; background: #fffbeb; padding: 0.85rem; border-radius: var(--adm-radius-sm); border: 1px solid #fde68a; color: #92400e;">
                                    {{ $student->catatan }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions & Mini Card (Right Column) -->
        <div>
            <!-- Mini Identity Badge -->
            <div class="adm-card" style="text-align: center;">
                <div class="adm-card-body" style="padding: 1.75rem 1.25rem;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; background: linear-gradient(135deg, #0f8528, #15803d); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 12px rgba(15, 133, 40, 0.25);">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--adm-text-main); margin-bottom: 0.25rem;">
                        {{ $student->nama_lengkap }}
                    </h3>
                    <div style="font-size: 0.85rem; color: var(--adm-primary); font-weight: 700; margin-bottom: 0.5rem;">
                        {{ $student->no_pendaftaran }}
                    </div>

                    <div style="display: flex; gap: 0.35rem; justify-content: center; flex-wrap: wrap; margin-bottom: 1.25rem;">
                        <span class="badge badge-emerald"><i class="fa-solid fa-circle-check"></i> Santri Aktif</span>
                        <span class="badge badge-slate">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $student->pilihan_jenjang) }}</span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem; text-align: left; font-size: 0.82rem; color: var(--adm-text-muted); background: var(--adm-surface-alt); padding: 0.85rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border); margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span>Tanggal Diterima:</span>
                            <strong style="color: var(--adm-text-main);">{{ $student->updated_at->format('d/m/Y') }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Asal Sekolah:</span>
                            <strong style="color: var(--adm-text-main);">{{ $student->asal_sekolah ?: '-' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Jenis Kelamin:</span>
                            <strong style="color: var(--adm-text-main);">{{ $student->jenis_kelamin }}</strong>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="{{ route('admin.students.card', $student) }}" target="_blank" class="btn btn-primary" style="justify-content: center;">
                            <i class="fa-solid fa-id-card"></i>
                            <span>Cetak Kartu Santri</span>
                        </a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-secondary" style="justify-content: center;">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Edit Biodata</span>
                        </a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                                <i class="fa-solid fa-trash-can"></i>
                                <span>Hapus Santri</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Quick Info Pesantren -->
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3 class="adm-card-title">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Ketentuan Santri</span>
                    </h3>
                </div>
                <div class="adm-card-body" style="font-size: 0.82rem; color: var(--adm-text-muted); line-height: 1.5;">
                    <p style="margin-bottom: 0.5rem;">
                        Data santri yang ada di halaman ini adalah santri aktif resmi Pondok Pesantren Nurussyam.
                    </p>
                    <p>
                        Jika terdapat kekeliruan biodata (NISN, NIK, alamat, nama wali), silakan tekan tombol <strong>Edit Biodata</strong>.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection
