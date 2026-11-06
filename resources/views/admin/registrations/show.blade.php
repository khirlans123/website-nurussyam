@extends('admin.layout')

@section('title', 'Detail Pendaftaran - ' . $registration->nama_lengkap)
@section('page_title', 'Detail Santri Baru')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-address-card"></i>
                <span>Data Calon Santri: {{ $registration->nama_lengkap }}</span>
            </h1>
            <p class="page-head-subtitle">No. Registrasi: <strong>{{ $registration->no_pendaftaran }}</strong> &bull; Didaftarkan pada {{ $registration->created_at->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.registrations.print', $registration) }}" target="_blank" class="btn btn-secondary">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Lembar Bukti</span>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    @php
        $cleanWa = preg_replace('/[^0-9]/', '', $registration->no_wa);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        }
        $waMessage = rawurlencode("Assalamu'alaikum Wr. Wb. Bpk/Ibu wali santri dari {$registration->nama_lengkap}. Kami dari Panitia Penerimaan Santri Baru (PSB) Pondok Pesantren Nurussyam Wringin Bondowoso menginformasikan bahwa berkas pendaftaran dengan No. {$registration->no_pendaftaran} saat ini berstatus: {$registration->status}.");
    @endphp

    <div class="adm-detail-layout">
        
        <!-- Main Student Data (Left) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-id-card"></i>
                        <span>Biodata Calon Santri</span>
                    </h2>
                    <div>
                        @if($registration->status === 'Pending')
                            <span class="badge badge-amber"><span class="badge-dot"></span> Pending</span>
                        @elseif($registration->status === 'Diverifikasi')
                            <span class="badge badge-blue"><span class="badge-dot"></span> Diverifikasi</span>
                        @elseif($registration->status === 'Diterima')
                            <span class="badge badge-emerald"><span class="badge-dot"></span> Diterima</span>
                        @else
                            <span class="badge badge-red"><span class="badge-dot"></span> {{ $registration->status }}</span>
                        @endif
                    </div>
                </div>
                <div class="adm-card-body">
                    <div class="adm-biodata-grid">
                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nomor Pendaftaran</div>
                            <div style="font-size: 1.15rem; font-weight: 800; color: var(--adm-primary); margin-top: 0.2rem;">{{ $registration->no_pendaftaran }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Jenjang Pilihan</div>
                            <div style="font-size: 1.05rem; font-weight: 700; margin-top: 0.2rem;">
                                <span class="badge badge-slate" style="font-size: 0.85rem;">{{ str_replace('Salafiyah', "Ma'had Nurussyam", $registration->pilihan_jenjang) }}</span>
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nama Lengkap</div>
                            <div style="font-size: 1rem; font-weight: 700; color: var(--adm-text-main); margin-top: 0.2rem;">{{ $registration->nama_lengkap }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Jenis Kelamin</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $registration->jenis_kelamin }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">NISN</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $registration->nisn ?: '-' }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">NIK</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $registration->nik ?: '-' }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Tempat / Tanggal Lahir</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">
                                {{ $registration->tempat_lahir ?: '-' }} / {{ $registration->tanggal_lahir ? $registration->tanggal_lahir->format('d F Y') : '-' }}
                            </div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Asal Sekolah</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem;">{{ $registration->asal_sekolah ?: '-' }}</div>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.5rem 0;">

                    <h3 style="font-size: 0.95rem; font-weight: 700; color: var(--adm-text-main); margin-bottom: 1rem;">
                        <i class="fa-solid fa-users" style="color: var(--adm-primary); margin-right: 0.4rem;"></i>
                        Data Wali & Kontak
                    </h3>

                    <div class="adm-biodata-grid">
                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nama Orang Tua / Wali</div>
                            <div style="font-size: 0.95rem; font-weight: 600; margin-top: 0.2rem;">{{ $registration->nama_wali ?: '-' }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Nomor WhatsApp</div>
                            <div style="margin-top: 0.2rem;">
                                <a href="https://wa.me/{{ $cleanWa }}?text={{ $waMessage }}" target="_blank" class="btn btn-sm btn-success" style="font-size: 0.85rem;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i>
                                    <span>Hubungi WA ({{ $registration->no_wa }})</span>
                                </a>
                            </div>
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <div style="font-size: 0.76rem; color: var(--adm-text-muted); text-transform: uppercase; font-weight: 700;">Alamat Lengkap</div>
                            <div style="font-size: 0.95rem; margin-top: 0.2rem; background: var(--adm-surface-alt); padding: 0.85rem; border-radius: var(--adm-radius-sm); border: 1px solid var(--adm-border);">
                                {{ $registration->alamat ?: 'Tidak mencantumkan alamat lengkap.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification & Status Card (Right) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-stamp"></i>
                        <span>Verifikasi Pendaftaran</span>
                    </h2>
                </div>
                <div class="adm-card-body">
                    @if(auth()->user()->isAdmin())
                        <!-- Tindakan Persetujuan Admin -->
                        <div style="background: #f8fafc; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); padding: 1rem; margin-bottom: 1.25rem;">
                            <div style="font-size: 0.76rem; font-weight: 700; color: var(--adm-text-muted); text-transform: uppercase; margin-bottom: 0.65rem;">
                                <i class="fa-solid fa-gavel"></i> Tindakan Persetujuan Admin:
                            </div>
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                @if($registration->status === 'Diverifikasi')
                                    <!-- HANYA MUNCUL JIKA SUDAH DIVERIFIKASI OLEH STAFF -->
                                    <form action="{{ route('admin.registrations.approve', $registration) }}" method="POST" style="width: 100%;" onsubmit="return confirm('Setujui dan terima santri {{ addslashes($registration->nama_lengkap) }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success" style="width: 100%; padding: 0.65rem; justify-content: center;">
                                            <i class="fa-solid fa-check"></i>
                                            <span>Setujui & Terima Jadi Santri</span>
                                        </button>
                                    </form>
                                @elseif($registration->status === 'Pending')
                                    <!-- BELUM DIVERIFIKASI: Di panel Admin TIDAK ADA tombol verifikasi (khusus staff). -->
                                    <div style="width: 100%; background: #fffbeb; border: 1px solid #fde68a; color: #92400e; font-size: 0.82rem; font-weight: 600; padding: 0.85rem; border-radius: var(--adm-radius-sm); line-height: 1.5;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.88rem; font-weight: 700; color: #b45309; margin-bottom: 0.35rem;">
                                            <i class="fa-solid fa-user-clock"></i> Menunggu Verifikasi Staff
                                        </div>
                                        Pendaftaran ini masih berstatus <strong>Pending</strong>. Verifikasi berkas merupakan tugas khusus <strong>Staff Panitia PSB</strong>. Tombol <strong>Setujui</strong> akan otomatis aktif di panel Admin ini setelah berkas diverifikasi oleh Staff.
                                    </div>
                                @elseif($registration->status === 'Diterima')
                                    <div style="width: 100%; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-size: 0.85rem; font-weight: 700; padding: 0.65rem; border-radius: var(--adm-radius-sm); text-align: center;">
                                        <i class="fa-solid fa-circle-check"></i> Santri Sudah Disetujui (Diterima)
                                    </div>
                                @else
                                    <div style="width: 100%; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; font-size: 0.85rem; font-weight: 700; padding: 0.65rem; border-radius: var(--adm-radius-sm); text-align: center;">
                                        <i class="fa-solid fa-circle-xmark"></i> Pendaftaran Telah Ditolak
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Petunjuk & Tindakan Khusus Staff -->
                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: var(--adm-radius-sm); padding: 0.85rem; margin-bottom: 1.25rem;">
                            <div style="font-size: 0.78rem; font-weight: 700; color: #1e40af; margin-bottom: 0.25rem;">
                                <i class="fa-solid fa-clipboard-check"></i> Tugas Staff Panitia PSB:
                            </div>
                            <p style="font-size: 0.75rem; color: #1e3a8a; margin: 0 0 0.65rem 0; line-height: 1.5;">
                                Periksa kelengkapan berkas fisik & data calon santri. Setelah Anda verifikasi, pendaftaran akan diteruskan ke panel Admin untuk disetujui (Diterima).
                            </p>
                            @if($registration->status === 'Pending')
                                <form action="{{ route('admin.registrations.verify', $registration) }}" method="POST" onsubmit="return confirm('Verifikasi kelengkapan berkas santri {{ addslashes($registration->nama_lengkap) }}?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 0.65rem; justify-content: center; color: #1e40af; border-color: #bfdbfe; background: #ffffff; font-weight: 700;">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                        <span>Verifikasi Berkas Santri Sekarang</span>
                                    </button>
                                </form>
                            @elseif($registration->status === 'Diverifikasi')
                                <div style="background: #ffffff; border: 1px solid #93c5fd; color: #1d4ed8; font-size: 0.78rem; font-weight: 700; padding: 0.5rem; border-radius: var(--adm-radius-sm); text-align: center;">
                                    <i class="fa-solid fa-circle-check"></i> Berkas Sudah Anda Verifikasi (Menunggu Persetujuan Admin)
                                </div>
                            @elseif($registration->status === 'Diterima')
                                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-size: 0.78rem; font-weight: 700; padding: 0.5rem; border-radius: var(--adm-radius-sm); text-align: center;">
                                    <i class="fa-solid fa-check-double"></i> Santri Telah Disetujui Admin
                                </div>
                            @endif
                        </div>
                    @endif

                    <form action="{{ route('admin.registrations.update-status', $registration) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status" class="form-label">Ubah Status Santri <span class="required">*</span></label>
                            <select id="status" name="status" class="form-control" style="font-weight: 700;">
                                @if(auth()->user()->isAdmin())
                                    @if($registration->status === 'Pending')
                                        <option value="Pending" selected>⏳ Pending (Menunggu Verifikasi Staff)</option>
                                        <option value="Diterima" disabled>🔒 Diterima (Wajib Diverifikasi Staff Dahulu)</option>
                                    @elseif($registration->status === 'Diverifikasi')
                                        <option value="Diverifikasi" selected>🔍 Diverifikasi (Siap Disetujui)</option>
                                        <option value="Diterima">✅ Diterima Jadi Santri (Disetujui Admin)</option>
                                    @elseif($registration->status === 'Diterima')
                                        <option value="Diterima" selected>✅ Diterima Jadi Santri (Disetujui Admin)</option>
                                    @else
                                        <option value="Ditolak" selected>❌ Ditolak</option>
                                    @endif
                                @else
                                    <option value="Pending" {{ $registration->status === 'Pending' ? 'selected' : '' }}>⏳ Pending (Belum Diverifikasi)</option>
                                    <option value="Diverifikasi" {{ $registration->status === 'Diverifikasi' ? 'selected' : '' }}>🔍 Diverifikasi (Berkas Lengkap)</option>
                                    @if($registration->status === 'Diterima')
                                        <option value="Diterima" selected disabled>✅ Diterima Jadi Santri (Disetujui Admin)</option>
                                    @endif
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan Panitia PSB</label>
                            <textarea id="catatan" name="catatan" rows="4" class="form-control" placeholder="Tuliskan catatan verifikasi, misal: berkas fotokopi KK sudah diterima, siap mengikuti tes tahfidz...">{{ old('catatan', $registration->catatan) }}</textarea>
                            <div class="form-text">Catatan ini tersimpan untuk arsip panitia penerimaan santri.</div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Status</span>
                        </button>
                    </form>

                    <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.25rem 0;">

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="{{ route('admin.registrations.print', $registration) }}" target="_blank" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                            <i class="fa-solid fa-print"></i>
                            <span>Cetak Bukti Pendaftaran</span>
                        </a>

                        @if(auth()->user()->isAdmin())
                            <form action="{{ route('admin.registrations.destroy', $registration) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran santri ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Hapus Pendaftaran</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
