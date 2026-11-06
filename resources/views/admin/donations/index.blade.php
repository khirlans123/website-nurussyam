@extends('admin.layout')

@section('title', 'LAZISWAF & Donasi')
@section('page_title', 'LAZISWAF & Donasi')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-hand-holding-dollar"></i>
                <span>Manajemen LAZISWAF & Donasi Umat</span>
            </h1>
            <p class="page-head-subtitle">Pencatatan dan verifikasi amanah infaq, zakat, wakaf, dan sedekah dari para muhsinin.</p>
        </div>
        <div class="page-head-actions">
            <button type="button" class="btn btn-primary" onclick="openAddDonationModal()">
                <i class="fa-solid fa-plus"></i>
                <span>Catat Donasi Manual</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="adm-chips-container">
        <div class="adm-chips-item">
            <span style="color: var(--adm-text-muted);">Total Terverifikasi:</span>
            <strong style="font-size: 1.15rem; color: #15803d; margin-left: 0.35rem;">
                Rp {{ number_format($stats['total_nominal'], 0, ',', '.') }}
            </strong>
        </div>
        <div class="adm-chips-item" style="background: #fef3c7; border-color: #fde68a; color: #92400e;">
            <span>Menunggu Konfirmasi:</span>
            <strong style="font-size: 1.15rem; margin-left: 0.35rem;">{{ $stats['pending_count'] }}</strong>
        </div>
        <div class="adm-chips-item" style="background: #f1f5f9;">
            <span style="color: var(--adm-text-muted);">Total Riwayat:</span>
            <strong style="font-size: 1.15rem; margin-left: 0.35rem;">{{ $stats['total_count'] }}</strong>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="adm-card" style="margin-bottom: 1.25rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.donations.index') }}" method="GET" class="adm-toolbar-form">
                <div style="flex: 1; min-width: 220px;">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari donatur, kode transaksi, nomor WA...">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>

                <div style="min-width: 170px;">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="Menunggu Konfirmasi" {{ request('status') === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Terverifikasi" {{ request('status') === 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Table (Desktop) and Cards (Mobile) -->
    <div class="adm-card">
        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Donatur & Doa</th>
                            <th>Program & Bank</th>
                            <th>Nominal</th>
                            <th>Kontak WA</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $don)
                            <tr>
                                <td>
                                    <strong style="color: var(--adm-primary); font-size: 0.85rem;">{{ $don->kode_transaksi }}</strong>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                        {{ $don->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--adm-text-main); font-size: 0.95rem;">
                                        {{ $don->nama_donatur }}
                                    </div>
                                    @if($don->doa_harapan)
                                        <div style="font-size: 0.78rem; color: #166534; background: #f0fdf4; padding: 4px 8px; border-radius: 4px; border-left: 3px solid #16a34a; font-style: italic; margin-top: 0.35rem; max-width: 320px; word-break: break-word;" title="Titipan Doa / Hajat Donatur">
                                            <i class="fa-solid fa-hands-praying" style="margin-right: 3px; font-size: 0.72rem; color: #15803d;"></i> "{{ $don->doa_harapan }}"
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-slate" style="font-size: 0.75rem;">{{ $don->program }}</span>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                                        Tujuan: <strong>{{ $don->bank_tujuan }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <strong style="font-size: 0.95rem; color: #15803d;">
                                        Rp {{ number_format($don->nominal, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    @php
                                        $cleanWa = preg_replace('/[^0-9]/', '', (string)$don->no_wa);
                                        if (str_starts_with($cleanWa, '0')) {
                                            $cleanWa = '62' . substr($cleanWa, 1);
                                        }
                                    @endphp
                                    @if(!empty($cleanWa) && $don->no_wa !== '-')
                                        <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="btn btn-sm btn-secondary" style="color: #15803d; font-weight: 600;">
                                            <i class="fa-brands fa-whatsapp"></i> {{ $don->no_wa }}
                                        </a>
                                    @else
                                        <span style="color: var(--adm-text-muted); font-size: 0.85rem;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($don->status === 'Terverifikasi')
                                        <span class="badge badge-emerald"><span class="badge-dot"></span> Terverifikasi</span>
                                    @else
                                        <span class="badge badge-amber"><span class="badge-dot"></span> Menunggu</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.35rem;">
                                        @if($don->status !== 'Terverifikasi')
                                            <form action="{{ route('admin.donations.verify', $don) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm" title="Verifikasi Donasi">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>Verifikasi</span>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.donations.destroy', $don) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data donasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--adm-text-muted);">
                                    Belum ada data donasi yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Touch-Friendly Card List (Phone Only) -->
            <div class="mobile-only-cards">
                @forelse($donations as $don)
                    @php
                        $cleanWa = preg_replace('/[^0-9]/', '', $don->no_wa);
                        if (str_starts_with($cleanWa, '0')) {
                            $cleanWa = '62' . substr($cleanWa, 1);
                        }
                    @endphp
                    <div class="mobile-card" style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 0.95rem; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
                        <div class="mobile-card-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.75rem; padding-bottom: 0.65rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="min-width: 0; flex: 1;">
                                <div class="mobile-card-title" style="font-size: 0.95rem; font-weight: 700; color: #0f172a; line-height: 1.35; word-break: break-word;">{{ $don->nama_donatur }}</div>
                                <div style="font-size: 0.72rem; color: #64748b; display: flex; align-items: center; gap: 0.35rem; margin-top: 0.25rem; flex-wrap: wrap;">
                                    <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-weight: 600; color: #334155;">{{ $don->kode_transaksi }}</code>
                                    <span>&bull;</span>
                                    <span>{{ $don->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div style="flex-shrink: 0; text-align: right;">
                                <strong style="font-size: 1.05rem; color: #15803d; display: block; font-weight: 800; line-height: 1.2;">
                                    Rp {{ number_format($don->nominal, 0, ',', '.') }}
                                </strong>
                                <div style="margin-top: 0.25rem;">
                                    @if($don->status === 'Terverifikasi')
                                        <span class="badge badge-emerald" style="font-size: 0.68rem; padding: 0.2rem 0.55rem; border-radius: 9999px;">Terverifikasi</span>
                                    @else
                                        <span class="badge badge-amber" style="font-size: 0.68rem; padding: 0.2rem 0.55rem; border-radius: 9999px;">Menunggu</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mobile-card-body" style="display: flex; flex-direction: column; gap: 0.6rem; padding: 0.65rem 0; border: none;">
                            <!-- Program & Bank Info -->
                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                <span class="mobile-card-label" style="font-size: 0.75rem; color: #64748b; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i class="fa-solid fa-hand-holding-heart" style="color: #059669;"></i> Program Donasi:
                                </span>
                                <div>
                                    <span class="badge badge-slate" style="font-size: 0.75rem; white-space: normal !important; text-align: left; display: inline-block; line-height: 1.45; padding: 0.35rem 0.65rem; border-radius: 8px; width: 100%; box-sizing: border-box; background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0;">
                                        <strong>{{ $don->program }}</strong> <span style="color: #475569;">({{ $don->bank_tujuan }})</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Doa & Harapan -->
                            @if($don->doa_harapan)
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-left: 3px solid #10b981; padding: 0.55rem 0.75rem; border-radius: 6px;">
                                    <div style="font-size: 0.72rem; color: #0f766e; font-weight: 700; margin-bottom: 0.2rem; display: flex; align-items: center; gap: 0.35rem;">
                                        <i class="fa-solid fa-comment-dots"></i> Doa / Harapan:
                                    </div>
                                    <div style="font-style: italic; color: #334155; font-size: 0.8rem; line-height: 1.5; word-break: break-word;">
                                        "{{ $don->doa_harapan }}"
                                    </div>
                                </div>
                            @endif

                            <!-- WhatsApp Contact -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.15rem;">
                                <span class="mobile-card-label" style="font-size: 0.75rem; color: #64748b; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i class="fa-brands fa-whatsapp" style="color: #16a34a; font-size: 0.85rem;"></i> WhatsApp:
                                </span>
                                @if(!empty($cleanWa) && $don->no_wa !== '-')
                                    <a href="https://wa.me/{{ $cleanWa }}" target="_blank" style="color: #15803d; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.78rem; background: #dcfce7; padding: 0.25rem 0.65rem; border-radius: 6px; border: 1px solid #bbf7d0;">
                                        <span>{{ $don->no_wa }}</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem;"></i>
                                    </a>
                                @else
                                    <span style="color: #94a3b8; font-size: 0.8rem;">-</span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Actions Footer -->
                        <div class="mobile-card-footer" style="padding-top: 0.65rem; border-top: 1px dashed #e2e8f0; display: flex; gap: 0.5rem; align-items: center;">
                            @if($don->status !== 'Terverifikasi')
                                <form action="{{ route('admin.donations.verify', $don) }}" method="POST" style="flex: 1;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" style="width: 100%; justify-content: center; gap: 0.4rem; padding: 0.45rem 0.75rem; font-weight: 600;" title="Verifikasi">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Verifikasi</span>
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.donations.destroy', $don) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data donasi ini?')" style="{{ $don->status === 'Terverifikasi' ? 'width: 100%;' : '' }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="{{ $don->status === 'Terverifikasi' ? 'width: 100%; justify-content: center;' : '' }} gap: 0.4rem; padding: 0.45rem 0.75rem; font-weight: 600;" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="padding: 2.5rem 1rem; text-align: center; color: var(--adm-text-muted);">
                        Belum ada data donasi tercatat.
                    </div>
                @endforelse
            </div>
        </div>

        @if($donations->hasPages())
            <div class="adm-card-footer">
                <div style="font-size: 0.82rem; color: var(--adm-text-muted);">
                    Menampilkan {{ $donations->firstItem() }} - {{ $donations->lastItem() }} dari {{ $donations->total() }} data
                </div>
                <div>
                    {{ $donations->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Add Donation Modal -->
    <div id="addDonationModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1100; align-items: center; justify-content: center; padding: 1.5rem;">
        <div class="adm-card" style="width: 100%; max-width: 500px; margin-bottom: 0;">
            <div class="adm-card-header">
                <h3 class="adm-card-title">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Catat Donasi Manual</span>
                </h3>
                <button type="button" class="btn-sidebar-logout" onclick="closeAddDonationModal()" style="font-size: 1.25rem;">&times;</button>
            </div>
            <div class="adm-card-body">
                <form action="{{ route('admin.donations.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama_donatur" class="form-label">Nama Donatur / Hamba Allah <span class="required">*</span></label>
                        <input type="text" id="nama_donatur" name="nama_donatur" class="form-control" placeholder="Contoh: H. Ahmad Subarjo" required>
                    </div>

                    <div class="form-group">
                        <label for="no_wa" class="form-label">Nomor WhatsApp <span class="required">*</span></label>
                        <input type="text" id="no_wa" name="no_wa" class="form-control" placeholder="081234567890" required>
                    </div>

                    <div class="form-group">
                        <label for="program" class="form-label">Program LAZISWAF & Donasi <span class="required">*</span></label>
                        <select id="program" name="program" class="form-control" required>
                            <option value="Donasi Masjid">Donasi Masjid</option>
                            <option value="Donasi Pondok">Donasi Pondok</option>
                            <option value="Zakat Mal">Zakat Mal</option>
                            <option value="Zakat Fitrah">Zakat Fitrah</option>
                            <option value="Fidyah & Kafarat">Fidyah & Kafarat</option>
                            <option value="Infaq & Shadaqah">Infaq & Shadaqah</option>
                            <option value="Wakaf Pembangunan">Wakaf Pembangunan</option>
                            <option value="Sedekah Subuh">Sedekah Subuh</option>
                            <option value="Qurban">Qurban</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nominal" class="form-label">Nominal (Rp) <span class="required">*</span></label>
                        <input type="number" id="nominal" name="nominal" class="form-control" placeholder="500000" min="1000" required>
                    </div>

                    <div class="form-group">
                        <label for="bank_tujuan" class="form-label">Penyaluran / Bank <span class="required">*</span></label>
                        <select id="bank_tujuan" name="bank_tujuan" class="form-control" required>
                            <option value="BSI (7143-0029-80)">BSI (7143-0029-80) a/n LAZISWAF NURUSSYAM</option>
                            <option value="Bank Mandiri (143-00-2980022-2)">Bank Mandiri (143-00-2980022-2) a/n YYS PONPES NURUSSYAM</option>
                            <option value="Tunai / Kas Langsung">Tunai / Kas Langsung</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status <span class="required">*</span></label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Terverifikasi">Terverifikasi (Dana Sudah Masuk)</option>
                            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="doa_harapan" class="form-label">Doa / Hajat Donatur</label>
                        <textarea id="doa_harapan" name="doa_harapan" rows="2" class="form-control" placeholder="Semoga barokah untuk pondok..."></textarea>
                    </div>

                    <div style="display: flex; gap: 0.65rem; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" onclick="closeAddDonationModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Donasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openAddDonationModal() {
        document.getElementById('addDonationModal').style.display = 'flex';
    }

    function closeAddDonationModal() {
        document.getElementById('addDonationModal').style.display = 'none';
    }
</script>
@endpush
