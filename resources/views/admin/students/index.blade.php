@extends('admin.layout')

@section('title', 'Data Santri Aktif')
@section('page_title', 'Data Santri Aktif')

@section('content')
    <!-- Page Header -->
    <div class="page-head">
        <div class="page-head-info">
            <div class="page-head-badge">
                <i class="fa-solid fa-id-card"></i>
                <span>Direktori Santri Resmi</span>
            </div>
            <h1 class="page-head-title">
                Data Santri Aktif <span>Pondok Pesantren</span>
            </h1>
            <p class="page-head-subtitle">Daftar santri resmi yang telah disetujui & diterima di Pondok Pesantren Nurussyam Wringin Bondowoso.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Santri Baru</span>
            </a>
            <a href="{{ route('admin.students.export.print', request()->all()) }}" target="_blank" class="btn btn-secondary" style="background: #0f8528; color: #ffffff; border-color: #0f8528;" title="Cetak Rekap Fisik / Simpan PDF (Hard File)">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Hard File</span>
            </a>
            <a href="{{ route('admin.students.export.excel', request()->all()) }}" class="btn btn-secondary" style="background: #10b981; color: #ffffff; border-color: #10b981;" title="Unduh Format Excel (.csv)">
                <i class="fa-solid fa-file-excel"></i>
                <span>Ekspor Excel</span>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Pendaftaran (PSB)</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Chips -->
    <div class="adm-chips-container" style="margin-bottom: 1.25rem;">
        <div class="adm-chips-item" style="background: #ecfdf5; border-color: #a7f3d0; color: #065f46;">
            <i class="fa-solid fa-users" style="color: #10b981;"></i>
            <span>Total Santri Diterima:</span>
            <strong style="font-size: 1.05rem;">{{ $stats['total'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #eff6ff; border-color: #bfdbfe; color: #1e40af;">
            <i class="fa-solid fa-person" style="color: #3b82f6;"></i>
            <span>Santri Putra:</span>
            <strong style="font-size: 1.05rem;">{{ $stats['putra'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #fdf2f8; border-color: #fbcfe8; color: #9d174d;">
            <i class="fa-solid fa-person-dress" style="color: #ec4899;"></i>
            <span>Santri Putri:</span>
            <strong style="font-size: 1.05rem;">{{ $stats['putri'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #f8fafc; border-color: #cbd5e1; color: #334155;">
            <i class="fa-solid fa-graduation-cap" style="color: #64748b;"></i>
            <span>MTs: <strong>{{ $stats['mts'] }}</strong> &bull; MA: <strong>{{ $stats['ma'] }}</strong></span>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="adm-card" style="margin-bottom: 1.25rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.students.index') }}" method="GET" class="adm-toolbar-form">
                <div style="flex: 1; min-width: 220px;">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama santri, no pendaftaran/NIS, wali, sekolah...">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>

                <div style="min-width: 150px;">
                    <select name="jenjang" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Jenjang --</option>
                        <option value="MTS" {{ request('jenjang') === 'MTS' ? 'selected' : '' }}>MTs Nurussyam</option>
                        <option value="MA" {{ request('jenjang') === 'MA' ? 'selected' : '' }}>MA Nurussyam</option>
                        <option value="Diniyah" {{ request('jenjang') === 'Diniyah' ? 'selected' : '' }}>Madrasah Diniyah</option>
                        <option value="Tahfidz" {{ request('jenjang') === 'Tahfidz' ? 'selected' : '' }}>Tahfidzul Qur'an</option>
                    </select>
                </div>

                <div style="min-width: 150px;">
                    <select name="gender" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Gender --</option>
                        <option value="Laki-laki" {{ request('gender') === 'Laki-laki' ? 'selected' : '' }}>Santri Putra</option>
                        <option value="Perempuan" {{ request('gender') === 'Perempuan' ? 'selected' : '' }}>Santri Putri</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'jenjang', 'gender']))
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Students Table (Desktop & Tablet) and Mobile Cards (Phone) -->
    <div class="adm-card">
        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table" style="min-width: 1050px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 135px; white-space: nowrap;">No. Induk / Reg</th>
                            <th style="min-width: 180px;">Nama Santri</th>
                            <th style="width: 130px; white-space: nowrap;">Jenjang</th>
                            <th style="width: 150px; white-space: nowrap;">Kontak & WA</th>
                            <th style="min-width: 140px;">Asal Sekolah</th>
                            <th style="width: 130px; text-align: center; white-space: nowrap;">Status</th>
                            <th style="width: 240px; text-align: right; white-space: nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $st)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $st->no_wa);
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                                $waText = rawurlencode("Assalamu'alaikum Wr. Wb. Halo {$st->nama_lengkap}, kami dari Pengurus Pondok Pesantren Nurussyam Wringin Bondowoso.");
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;">
                                    <strong style="color: var(--adm-primary); font-size: 0.88rem;">{{ $st->no_pendaftaran }}</strong>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        Masuk: {{ $st->updated_at->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--adm-text-main);">
                                        <a href="{{ route('admin.students.show', $st) }}" style="color: var(--adm-text-main);">
                                            {{ $st->nama_lengkap }}
                                        </a>
                                    </div>
                                    <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        @if($st->jenis_kelamin === 'Laki-laki')
                                            <span style="color: #2563eb;"><i class="fa-solid fa-mars"></i> Putra</span>
                                        @else
                                            <span style="color: #db2777;"><i class="fa-solid fa-venus"></i> Putri</span>
                                        @endif
                                        &bull; Wali: {{ $st->nama_wali ?? '-' }}
                                    </div>
                                </td>
                                <td style="white-space: nowrap;">
                                    <span class="badge badge-slate" style="font-size: 0.75rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang) }}</span>
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="https://wa.me/{{ $cleanWa }}?text={{ $waText }}" target="_blank" class="btn btn-sm btn-secondary" style="color: #15803d; font-weight: 600; white-space: nowrap;" title="Kirim Pesan WhatsApp">
                                        <i class="fa-brands fa-whatsapp" style="font-size: 1rem;"></i>
                                        <span>{{ $st->no_wa }}</span>
                                    </a>
                                </td>
                                <td>
                                    <span style="font-size: 0.82rem; color: var(--adm-text-muted);">{{ $st->asal_sekolah ?? '-' }}</span>
                                </td>
                                <td style="text-align: center; white-space: nowrap;">
                                    <span class="badge badge-emerald" style="padding: 0.35rem 0.65rem; font-size: 0.76rem; white-space: nowrap;">
                                        <i class="fa-solid fa-circle-check"></i> Aktif (Diterima)
                                    </span>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <div class="table-actions-row" style="display: flex; gap: 0.35rem; align-items: center; justify-content: flex-end; flex-wrap: nowrap; min-width: 220px;">
                                        <a href="{{ route('admin.students.card', $st) }}" target="_blank" class="btn btn-sm btn-secondary" style="padding: 0.32rem 0.6rem; font-size: 0.76rem; color: #1e40af; border-color: #bfdbfe; white-space: nowrap;" title="Cetak Kartu Santri">
                                            <i class="fa-solid fa-id-card"></i>
                                            <span>Kartu</span>
                                        </a>

                                        <a href="{{ route('admin.students.show', $st) }}" class="btn btn-primary btn-sm" style="padding: 0.32rem 0.6rem; font-size: 0.76rem; white-space: nowrap;" title="Lihat Profil Lengkap">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Detail</span>
                                        </a>

                                        <a href="{{ route('admin.students.edit', $st) }}" class="btn btn-secondary btn-icon" style="width: 30px; height: 30px; font-size: 0.76rem;" title="Edit Data Santri">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.students.destroy', $st) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri {{ addslashes($st->nama_lengkap) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-icon" style="width: 30px; height: 30px; font-size: 0.76rem;" title="Hapus Data">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3.5rem 1rem;">
                                    <i class="fa-solid fa-user-graduate" style="font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 0.75rem;"></i>
                                    <div style="font-weight: 700; font-size: 1.05rem; color: var(--adm-text-main);">Belum Ada Data Santri Diterima</div>
                                    <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-top: 0.35rem; max-width: 450px; margin-left: auto; margin-right: auto;">
                                        Santri yang telah disetujui di menu Pendaftaran (PSB) otomatis masuk ke sini, atau Anda dapat menambahkannya secara manual.
                                    </p>
                                    <div style="margin-top: 1.25rem; display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="{{ route('admin.registrations.index') }}" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-check"></i>
                                            <span>Setujui Pendaftar PSB</span>
                                        </a>
                                        <a href="{{ route('admin.students.create') }}" class="btn btn-secondary btn-sm">
                                            <i class="fa-solid fa-user-plus"></i>
                                            <span>Tambah Santri Manual</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Touch-Friendly Card List (Phone Only) -->
            <div class="mobile-only-cards">
                @forelse($students as $st)
                    @php
                        $cleanWa = preg_replace('/[^0-9]/', '', $st->no_wa);
                        if (str_starts_with($cleanWa, '0')) {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        }
                    @endphp
                    <div class="mobile-card">
                        <div class="mobile-card-header">
                            <div style="min-width: 0;">
                                <div class="mobile-card-title">{{ $st->nama_lengkap }}</div>
                                <div style="font-size: 0.72rem; color: var(--adm-text-muted); display: flex; align-items: center; gap: 0.4rem; margin-top: 0.15rem;">
                                    <code>{{ $st->no_pendaftaran }}</code>
                                    &bull;
                                    @if($st->jenis_kelamin === 'Laki-laki')
                                        <span style="color: #2563eb;">Putra</span>
                                    @else
                                        <span style="color: #db2777;">Putri</span>
                                    @endif
                                </div>
                            </div>
                            <div style="flex-shrink: 0;">
                                <span class="badge badge-emerald" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;">
                                    <i class="fa-solid fa-circle-check"></i> Aktif
                                </span>
                            </div>
                        </div>

                        <div class="mobile-card-body">
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-graduation-cap"></i> Jenjang:</span>
                                <span class="badge badge-slate" style="font-size: 0.72rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $st->pilihan_jenjang) }}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-school"></i> Asal Sekolah:</span>
                                <span class="mobile-card-value">{{ $st->asal_sekolah ?? '-' }}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-user-group"></i> Wali:</span>
                                <span class="mobile-card-value">{{ $st->nama_wali ?? '-' }}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-brands fa-whatsapp"></i> WhatsApp:</span>
                                <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="mobile-card-value" style="color: #15803d; font-weight: 700;">
                                    {{ $st->no_wa }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem;"></i>
                                </a>
                            </div>
                        </div>

                        <div class="mobile-card-footer" style="padding-top: 0.75rem; border-top: 1px solid #f1f5f9;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                                <a href="{{ route('admin.students.card', $st) }}" target="_blank" class="btn btn-sm btn-secondary" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Cetak Kartu Santri">
                                    <i class="fa-solid fa-id-card"></i>
                                    <span>Kartu</span>
                                </a>

                                <a href="{{ route('admin.students.show', $st) }}" class="btn btn-primary btn-sm" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Detail Lengkap">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Detail</span>
                                </a>

                                <a href="{{ route('admin.students.edit', $st) }}" class="btn btn-secondary btn-sm" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.students.destroy', $st) }}" method="POST" style="margin: 0; width: 100%;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Hapus Santri">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 2.5rem 1rem; text-align: center; color: var(--adm-text-muted);">
                        Belum ada data santri aktif.
                    </div>
                @endforelse
            </div>
        </div>

        @if($students->hasPages())
            <div class="adm-card-footer">
                <div style="font-size: 0.82rem; color: var(--adm-text-muted);">
                    Menampilkan {{ $students->firstItem() }} - {{ $students->lastItem() }} dari {{ $students->total() }} santri
                </div>
                <div>
                    {{ $students->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
