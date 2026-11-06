x`@extends('admin.layout')

@section('title', 'Pendaftaran Santri Baru (PSB)')
@section('page_title', 'Pendaftaran Santri Baru')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Penerimaan Santri Baru (PSB)</span>
            </h1>
            <p class="page-head-subtitle">Kelola dan verifikasi data formulir santri baru yang masuk secara online melalui website.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.registrations.export.print', request()->all()) }}" target="_blank" class="btn btn-secondary" style="background: #0f8528; color: #ffffff; border-color: #0f8528;" title="Cetak Rekap Fisik / Simpan PDF (Hard File)">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Hard File</span>
            </a>
            <a href="{{ route('admin.registrations.export.excel', request()->all()) }}" class="btn btn-secondary" style="background: #10b981; color: #ffffff; border-color: #10b981;" title="Unduh Format Excel (.csv)">
                <i class="fa-solid fa-file-excel"></i>
                <span>Ekspor Excel</span>
            </a>
            <a href="{{ route('admin.psb.settings') }}" class="btn btn-primary" title="Atur Jadwal Gelombang & Informasi PSB">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Pengaturan PSB</span>
            </a>
            <a href="{{ route('pendaftaran.info') }}" target="_blank" class="btn btn-secondary" title="Lihat Tampilan Web Info PSB">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Web PSB</span>
            </a>
        </div>
    </div>


    <!-- Quick Stat Chips -->
    <div class="adm-chips-container">
        <div class="adm-chips-item">
            <span style="color: var(--adm-text-muted);">Total Terdaftar:</span>
            <strong style="font-size: 1.05rem; color: var(--adm-text-main);">{{ $stats['total'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #fef3c7; border-color: #fde68a; color: #92400e;">
            <i class="fa-solid fa-clock"></i>
            <span>Menunggu (Pending):</span>
            <strong style="font-size: 1.05rem;">{{ $stats['pending'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #e0f2fe; border-color: #bae6fd; color: #0369a1;">
            <i class="fa-solid fa-check"></i>
            <span>Diverifikasi:</span>
            <strong style="font-size: 1.05rem;">{{ $stats['diverifikasi'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #dcfce7; border-color: #bbf7d0; color: #15803d;">
            <i class="fa-solid fa-circle-check"></i>
            <span>Diterima:</span>
            <strong style="font-size: 1.05rem;">{{ $stats['diterima'] }}</strong>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="adm-card" style="margin-bottom: 1.25rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.registrations.index') }}" method="GET" class="adm-toolbar-form">
                <div style="flex: 1; min-width: 220px;">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama santri, no registrasi, WA, sekolah...">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>

                <div style="min-width: 160px;">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Diverifikasi" {{ request('status') === 'Diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                        <option value="Diterima" {{ request('status') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    </select>
                </div>

                <div style="min-width: 160px;">
                    <select name="jenjang" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Jenjang --</option>
                        <option value="MTS" {{ request('jenjang') === 'MTS' ? 'selected' : '' }}>MTs Nurussyam</option>
                        <option value="MA" {{ request('jenjang') === 'MA' ? 'selected' : '' }}>MA Nurussyam</option>
                        <option value="Diniyah" {{ request('jenjang') === 'Diniyah' ? 'selected' : '' }}>Madrasah Diniyah</option>
                        <option value="Tahfidz" {{ request('jenjang') === 'Tahfidz' ? 'selected' : '' }}>Tahfidzul Qur'an</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'status', 'jenjang']))
                    <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Registrations Table (Desktop & Tablet) and Mobile Cards (Phone) -->
    <div class="adm-card">
        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table" style="min-width: 980px; width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 140px; white-space: nowrap;">No. Pendaftaran</th>
                            <th style="min-width: 170px;">Nama Santri</th>
                            <th style="width: 120px; white-space: nowrap;">Jenjang</th>
                            <th style="width: 160px; white-space: nowrap;">Kontak & WhatsApp</th>
                            <th style="min-width: 140px;">Asal Sekolah</th>
                            <th style="width: 170px; text-align: center; white-space: nowrap;">Status</th>
                            <th style="width: 220px; text-align: right; white-space: nowrap;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            @php
                                $cleanWa = preg_replace('/[^0-9]/', '', $reg->no_wa);
                                if (str_starts_with($cleanWa, '0')) {
                                    $cleanWa = '62' . substr($cleanWa, 1);
                                }
                                $waText = rawurlencode("Assalamu'alaikum Wr. Wb. Halo {$reg->nama_lengkap}, kami dari Panitia PSB Pondok Pesantren Nurussyam mengonfirmasi formulir pendaftaran Anda (No: {$reg->no_pendaftaran}).");
                            @endphp
                            <tr>
                                <td style="white-space: nowrap;">
                                    <strong style="color: var(--adm-primary); font-size: 0.88rem;">{{ $reg->no_pendaftaran }}</strong>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                                        {{ $reg->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--adm-text-main);">
                                        {{ $reg->nama_lengkap }}
                                    </div>
                                    <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        {{ $reg->jenis_kelamin }} &bull; Wali: {{ $reg->nama_wali ?? '-' }}
                                    </div>
                                </td>
                                <td style="white-space: nowrap;">
                                    <span class="badge badge-slate" style="font-size: 0.75rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $reg->pilihan_jenjang) }}</span>
                                </td>
                                <td style="white-space: nowrap;">
                                    <a href="https://wa.me/{{ $cleanWa }}?text={{ $waText }}" target="_blank" class="btn btn-sm btn-secondary" style="color: #15803d; font-weight: 600; white-space: nowrap;" title="Kirim Pesan WhatsApp">
                                        <i class="fa-brands fa-whatsapp" style="font-size: 1rem;"></i>
                                        <span>{{ $reg->no_wa }}</span>
                                    </a>
                                </td>
                                <td>
                                    <span style="font-size: 0.82rem; color: var(--adm-text-muted);">{{ $reg->asal_sekolah ?? '-' }}</span>
                                </td>
                                <td style="text-align: center; white-space: nowrap;">
                                    @if($reg->status === 'Pending')
                                        <span class="badge badge-amber" style="padding: 0.35rem 0.65rem; font-size: 0.76rem; white-space: nowrap;" title="Menunggu verifikasi berkas oleh staff">
                                            <i class="fa-solid fa-clock"></i> Belum Diverifikasi
                                        </span>
                                    @elseif($reg->status === 'Diverifikasi')
                                        <span class="badge badge-blue" style="padding: 0.35rem 0.65rem; font-size: 0.76rem; white-space: nowrap;" title="Berkas telah diverifikasi, siap disetujui">
                                            <i class="fa-solid fa-clipboard-check"></i> Sudah Diverifikasi
                                        </span>
                                    @elseif($reg->status === 'Diterima')
                                        <span class="badge badge-emerald" style="padding: 0.35rem 0.65rem; font-size: 0.76rem; white-space: nowrap;">
                                            <i class="fa-solid fa-circle-check"></i> Disetujui (Diterima)
                                        </span>
                                    @else
                                        <span class="badge badge-red" style="padding: 0.35rem 0.65rem; font-size: 0.76rem; white-space: nowrap;">
                                            <i class="fa-solid fa-circle-xmark"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <div class="table-actions-row">
                                        @if(auth()->user()->isAdmin())
                                            {{-- PANEL ADMIN: TIDAK ADA VERIFIKASI. Tombol Setujui HANYA MUNCUL setelah diverifikasi staff --}}
                                            @if($reg->status === 'Diverifikasi')
                                                <form action="{{ route('admin.registrations.approve', $reg) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Apakah Anda yakin menyetujui dan menerima santri {{ addslashes($reg->nama_lengkap) }}?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" style="padding: 0.32rem 0.6rem; font-size: 0.76rem;" title="Setujui pendaftaran ini (Diterima Jadi Santri)">
                                                        <i class="fa-solid fa-check"></i>
                                                        <span>Setujui</span>
                                                    </button>
                                                </form>
                                            @elseif($reg->status === 'Pending')
                                                <span class="badge badge-amber" style="font-size: 0.72rem; padding: 0.3rem 0.5rem;" title="Menunggu staff memverifikasi berkas pendaftar">
                                                    <i class="fa-solid fa-clock"></i> Tunggu Staff
                                                </span>
                                            @endif
                                        @elseif(auth()->user()->isStaff())
                                            {{-- PANEL STAFF: KHUSUS VERIFIKASI BERKAS. Tidak ada fitur Setujui --}}
                                            @if($reg->status === 'Pending')
                                                <form action="{{ route('admin.registrations.verify', $reg) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Tandai berkas pendaftaran calon santri {{ addslashes($reg->nama_lengkap) }} telah diverifikasi?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-secondary" style="padding: 0.32rem 0.6rem; font-size: 0.76rem; color: #1e40af; border-color: #bfdbfe; background: #eff6ff;" title="Verifikasi berkas calon santri ini">
                                                        <i class="fa-solid fa-clipboard-check"></i>
                                                        <span>Verifikasi</span>
                                                    </button>
                                                </form>
                                            @elseif($reg->status === 'Diverifikasi')
                                                <span class="badge badge-blue" style="font-size: 0.72rem; padding: 0.3rem 0.5rem;" title="Berkas telah diverifikasi, menunggu persetujuan Admin">
                                                    <i class="fa-solid fa-hourglass-half"></i> Tunggu Admin
                                                </span>
                                            @endif
                                        @endif

                                        <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-primary btn-sm" style="padding: 0.32rem 0.6rem; font-size: 0.76rem;" title="Lihat Detail & Lengkap">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Detail</span>
                                        </a>

                                        <a href="{{ route('admin.registrations.print', $reg) }}" target="_blank" class="btn btn-secondary btn-icon" style="width: 30px; height: 30px; font-size: 0.76rem;" title="Cetak Bukti Pendaftaran">
                                            <i class="fa-solid fa-print"></i>
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <form action="{{ route('admin.registrations.destroy', $reg) }}" method="POST" style="display: inline-block; margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon" style="width: 30px; height: 30px; font-size: 0.76rem;" title="Hapus Permanen">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem 1rem;">
                                    <i class="fa-solid fa-user-graduate" style="font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 0.75rem;"></i>
                                    <div style="font-weight: 600; color: var(--adm-text-main);">Belum ada formulir pendaftaran santri baru</div>
                                    <p style="font-size: 0.82rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                                        Pendaftaran yang dikirimkan calon santri dari formulir website akan muncul di sini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Touch-Friendly Card List (Phone Only) -->
            <div class="mobile-only-cards">
                @forelse($registrations as $reg)
                    @php
                        $cleanWa = preg_replace('/[^0-9]/', '', $reg->no_wa);
                        if (str_starts_with($cleanWa, '0')) {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        }
                        $waText = rawurlencode("Assalamu'alaikum Wr. Wb. Halo {$reg->nama_lengkap}, kami dari Panitia PSB Pondok Pesantren Nurussyam mengonfirmasi formulir pendaftaran Anda (No: {$reg->no_pendaftaran}).");
                    @endphp
                    <div class="mobile-card">
                        <div class="mobile-card-header">
                            <div style="min-width: 0;">
                                <div class="mobile-card-title">{{ $reg->nama_lengkap }}</div>
                                <div style="font-size: 0.72rem; color: var(--adm-text-muted); display: flex; align-items: center; gap: 0.4rem; margin-top: 0.15rem;">
                                    <code>{{ $reg->no_pendaftaran }}</code>
                                    &bull;
                                    <span>{{ $reg->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div style="flex-shrink: 0;">
                                @if($reg->status === 'Pending')
                                    <span class="badge badge-amber" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;"><i class="fa-solid fa-clock"></i> Belum Diverifikasi</span>
                                @elseif($reg->status === 'Diverifikasi')
                                    <span class="badge badge-blue" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;"><i class="fa-solid fa-clipboard-check"></i> Sudah Diverifikasi</span>
                                @elseif($reg->status === 'Diterima')
                                    <span class="badge badge-emerald" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;"><i class="fa-solid fa-circle-check"></i> Diterima</span>
                                @else
                                    <span class="badge badge-red" style="font-size: 0.72rem; padding: 0.25rem 0.5rem;"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                @endif
                            </div>
                        </div>

                        <div class="mobile-card-body">
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-graduation-cap"></i> Jenjang:</span>
                                <span class="badge badge-slate" style="font-size: 0.72rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $reg->pilihan_jenjang) }}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-school"></i> Sekolah:</span>
                                <span class="mobile-card-value">{{ $reg->asal_sekolah ?? '-' }}</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-solid fa-user-group"></i> Wali:</span>
                                <span class="mobile-card-value">{{ $reg->nama_wali ?? '-' }} ({{ $reg->jenis_kelamin }})</span>
                            </div>
                            <div class="mobile-card-row">
                                <span class="mobile-card-label"><i class="fa-brands fa-whatsapp"></i> WhatsApp:</span>
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ $waText }}" target="_blank" class="mobile-card-value" style="color: #15803d; font-weight: 700;">
                                    {{ $reg->no_wa }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem;"></i>
                                </a>
                            </div>
                        </div>

                        <div class="mobile-card-footer" style="padding-top: 0.75rem; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 8px; width: 100%;">
                            @if($reg->status === 'Diverifikasi' && auth()->user()->isAdmin())
                                <!-- Tombol Setujui Admin Cepat (Hanya muncul jika sudah diverifikasi) -->
                                <form action="{{ route('admin.registrations.approve', $reg) }}" method="POST" style="width: 100%; margin: 0;" onsubmit="return confirm('Apakah Anda yakin menyetujui dan menerima santri {{ addslashes($reg->nama_lengkap) }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" style="width: 100%; justify-content: center; padding: 0.55rem; font-weight: 700; border-radius: 8px;" title="Setujui pendaftaran ini">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Setujui Santri Diterima</span>
                                    </button>
                                </form>
                            @elseif($reg->status === 'Pending' && auth()->user()->isStaff())
                                <!-- Tombol Verifikasi Cepat (Hanya Muncul di Akun Staff) -->
                                <form action="{{ route('admin.registrations.verify', $reg) }}" method="POST" style="width: 100%; margin: 0;" onsubmit="return confirm('Tandai berkas pendaftaran calon santri {{ addslashes($reg->nama_lengkap) }} telah diverifikasi?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-secondary" style="width: 100%; justify-content: center; color: #1e40af; border-color: #bfdbfe; background: #eff6ff; padding: 0.55rem; font-weight: 700; border-radius: 8px;" title="Verifikasi berkas santri">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                        <span>Verifikasi Berkas</span>
                                    </button>
                                </form>
                            @endif

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                                <a href="{{ route('admin.registrations.show', $reg) }}" class="btn btn-primary btn-sm" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Detail Lengkap">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>Detail</span>
                                </a>

                                <a href="{{ route('admin.registrations.print', $reg) }}" target="_blank" class="btn btn-secondary btn-sm" style="justify-content: center; width: 100%; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Cetak Bukti">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Cetak</span>
                                </a>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('admin.registrations.destroy', $reg) }}" method="POST" style="margin: 0; width: 100%;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="width: 100%; justify-content: center; border-radius: 8px; padding: 0.5rem 0.6rem; font-size: 0.82rem;" title="Hapus Permanen">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <span>Hapus Pendaftaran</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="padding: 2.5rem 1rem; text-align: center; color: var(--adm-text-muted);">
                        <i class="fa-solid fa-user-graduate" style="font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: 0.5rem;"></i>
                        Belum ada formulir pendaftaran santri baru.
                    </div>
                @endforelse
            </div>
        </div>

        @if($registrations->hasPages())
            <div class="adm-card-footer">
                <div style="font-size: 0.82rem; color: var(--adm-text-muted);">
                    Menampilkan {{ $registrations->firstItem() }} - {{ $registrations->lastItem() }} dari {{ $registrations->total() }} santri
                </div>
                <div>
                    {{ $registrations->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
