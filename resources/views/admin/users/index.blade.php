@extends('admin.layout')

@section('title', 'Manajemen Pengguna & Hak Akses')
@section('page_title', 'Kelola Pengguna')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-users-gear"></i>
                <span>Manajemen Pengguna & Role Akses</span>
            </h1>
            <p class="page-head-subtitle">Atur hak akses akun pengelola: Super Admin, Staff PSB & Berita, dan Penulis Berita.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Kelola Role Akses</span>
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Histori Aktivitas User</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Role -->
    <div class="adm-stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-emerald"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['admin'] }}</span>
                <span class="stat-label">Super Admin (Penuh)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-blue"><i class="fa-solid fa-user-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['staff'] }}</span>
                <span class="stat-label">Staff (PSB & Berita)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-amber"><i class="fa-solid fa-feather-pointed"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['penulis'] }}</span>
                <span class="stat-label">Penulis (Up Berita)</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-slate"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-label">Total Pengguna</span>
            </div>
        </div>
    </div>

    <div class="adm-detail-layout">
        
        <!-- List of Users (Left) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header" style="flex-wrap: wrap; gap: 0.75rem;">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-list-ul"></i>
                        <span>Daftar Akun Pengguna</span>
                    </h2>

                    <!-- Filter by Role -->
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm {{ empty($roleFilter) ? 'btn-primary' : 'btn-secondary' }}" style="font-size: 0.75rem;">Semua</a>
                        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="btn btn-sm {{ $roleFilter === 'admin' ? 'btn-primary' : 'btn-secondary' }}" style="font-size: 0.75rem;">Admin</a>
                        <a href="{{ route('admin.users.index', ['role' => 'staff']) }}" class="btn btn-sm {{ $roleFilter === 'staff' ? 'btn-primary' : 'btn-secondary' }}" style="font-size: 0.75rem;">Staff</a>
                        <a href="{{ route('admin.users.index', ['role' => 'penulis']) }}" class="btn btn-sm {{ $roleFilter === 'penulis' ? 'btn-primary' : 'btn-secondary' }}" style="font-size: 0.75rem;">Penulis</a>
                    </div>
                </div>

                <div class="adm-card-body" style="padding: 0;">
                    <!-- Desktop Table View -->
                    <div class="desktop-only-table table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Nama Pengguna</th>
                                    <th>Email / Login</th>
                                    <th>Role Akses</th>
                                    <th>Terdaftar</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $u)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                                <div style="width: 34px; height: 34px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #334155; font-size: 0.85rem;">
                                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight: 700; color: var(--adm-text-main);">
                                                        {{ $u->name }}
                                                        @if($u->id === auth()->id())
                                                            <span class="badge badge-emerald" style="font-size: 0.65rem; margin-left: 0.25rem;">Akun Anda</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code>{{ $u->email }}</code>
                                        </td>
                                        <td>
                                            @if($u->role === 'admin')
                                                <span class="badge badge-emerald">
                                                    <i class="fa-solid fa-shield-halved"></i> Super Admin
                                                </span>
                                            @elseif($u->role === 'staff')
                                                <span class="badge badge-blue">
                                                    <i class="fa-solid fa-user-check"></i> Staff PSB & Berita
                                                </span>
                                            @elseif($u->role === 'penulis')
                                                <span class="badge badge-amber">
                                                    <i class="fa-solid fa-feather-pointed"></i> Penulis Berita
                                                </span>
                                            @else
                                                <span class="badge badge-slate">{{ ucfirst($u->role) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="font-size: 0.8rem; color: var(--adm-text-muted);">
                                                {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: inline-flex; gap: 0.35rem;">
                                                <button type="button" class="btn btn-secondary btn-icon" onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}')" title="Edit Akun & Role">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                
                                                @if($u->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($u->name) }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-icon" title="Hapus Pengguna">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 2.5rem 1rem; color: var(--adm-text-muted);">
                                            Tidak ada pengguna ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Touch-Friendly Card List (Phone Only) -->
                    <div class="mobile-only-cards">
                        @forelse($users as $u)
                            <div class="mobile-card">
                                <div class="mobile-card-header">
                                    <div style="display: flex; align-items: center; gap: 0.65rem; min-width: 0;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #334155; font-size: 0.9rem; flex-shrink: 0;">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div style="min-width: 0;">
                                            <div class="mobile-card-title">
                                                {{ $u->name }}
                                            </div>
                                            @if($u->id === auth()->id())
                                                <span class="badge badge-emerald" style="font-size: 0.62rem; padding: 0.1rem 0.4rem; margin-top: 2px;">Akun Anda</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="flex-shrink: 0;">
                                        @if($u->role === 'admin')
                                            <span class="badge badge-emerald" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-shield-halved"></i> Super Admin
                                            </span>
                                        @elseif($u->role === 'staff')
                                            <span class="badge badge-blue" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-user-check"></i> Staff PSB
                                            </span>
                                        @elseif($u->role === 'penulis')
                                            <span class="badge badge-amber" style="font-size: 0.72rem;">
                                                <i class="fa-solid fa-feather-pointed"></i> Penulis
                                            </span>
                                        @else
                                            <span class="badge badge-slate" style="font-size: 0.72rem;">{{ ucfirst($u->role) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mobile-card-body" style="padding: 0.45rem 0;">
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label"><i class="fa-regular fa-envelope"></i> Email:</span>
                                        <code style="font-size: 0.75rem;">{{ $u->email }}</code>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label"><i class="fa-regular fa-calendar"></i> Terdaftar:</span>
                                        <span class="mobile-card-value">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>

                                <div class="mobile-card-footer" style="display: grid; grid-template-columns: {{ $u->id === auth()->id() ? '1fr' : '1fr 1fr' }}; gap: 0.5rem;">
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}')" style="justify-content: center; width: 100%;">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit Akun</span>
                                    </button>
                                    
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($u->name) }}?')" style="width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="justify-content: center; width: 100%;">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 2.5rem 1rem; color: var(--adm-text-muted); font-size: 0.85rem;">
                                Tidak ada pengguna ditemukan.
                            </div>
                        @endforelse
                    </div>

                    @if($users->hasPages())
                        <div style="padding: 1rem;">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Panduan Role Card -->
            <div class="adm-card" style="margin-top: 1.5rem;">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Ringkasan Hak Akses Masing-Masing Role</span>
                    </h2>
                </div>
                <div class="adm-card-body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: var(--adm-radius-sm); padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; color: #166534; font-weight: 700; margin-bottom: 0.4rem;">
                                <i class="fa-solid fa-shield-halved"></i> Super Admin
                            </div>
                            <ul style="font-size: 0.78rem; color: #14532d; padding-left: 1.1rem; margin: 0; line-height: 1.6;">
                                <li>Akses penuh ke seluruh menu sistem.</li>
                                <li><strong>Wewenang utama persetujuan (Diterima)</strong> pendaftaran santri baru.</li>
                                <li>Kelola Data Santri Aktif & Laziswaf.</li>
                                <li>Kelola Pengaturan & Akun Pengguna.</li>
                            </ul>
                        </div>

                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: var(--adm-radius-sm); padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; color: #1e40af; font-weight: 700; margin-bottom: 0.4rem;">
                                <i class="fa-solid fa-user-check"></i> Staff PSB & Berita
                            </div>
                            <ul style="font-size: 0.78rem; color: #1e3a8a; padding-left: 1.1rem; margin: 0; line-height: 1.6;">
                                <li>Akses menu Berita & Kategori Berita.</li>
                                <li>Akses menu Pendaftaran Santri Baru (PSB).</li>
                                <li><strong>Hanya bisa memverifikasi berkas santri</strong> (tidak bisa klik setujui diterima).</li>
                                <li>Tidak memiliki akses ke Konfigurasi & Pengguna.</li>
                            </ul>
                        </div>

                        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--adm-radius-sm); padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; color: #92400e; font-weight: 700; margin-bottom: 0.4rem;">
                                <i class="fa-solid fa-feather-pointed"></i> Penulis Berita
                            </div>
                            <ul style="font-size: 0.78rem; color: #78350f; padding-left: 1.1rem; margin: 0; line-height: 1.6;">
                                <li><strong>Hanya akses bagian berita</strong> (up berita baru & edit berita).</li>
                                <li>Otomatis diarahkan langsung ke daftar berita saat login.</li>
                                <li>Tidak memiliki akses ke PSB santri maupun keuangan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create User Form (Right) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Tambah Akun Baru</span>
                    </h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Ustadz Ahmad Fauzi" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email (Login) <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@nurussyam.ponpes.id" required>
                        </div>

                        <div class="form-group">
                            <label for="role" class="form-label">Role / Hak Akses <span class="required">*</span></label>
                            <select id="role" name="role" class="form-control" required style="font-weight: 600;">
                                @foreach($availableRoles as $r)
                                    <option value="{{ $r->slug }}" {{ old('role', 'staff') === $r->slug ? 'selected' : '' }}>
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Pilih tingkatan wewenang pengguna dalam sistem.</div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Akun Pengguna</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="adm-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 0.75rem;">
        <div class="adm-card" style="width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; margin: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-user-pen"></i>
                    <span>Edit Pengguna & Role</span>
                </h2>
                <button type="button" class="btn btn-secondary btn-icon" onclick="closeEditModal()" style="border: none;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="adm-card-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_email" class="form-label">Alamat Email <span class="required">*</span></label>
                        <input type="email" id="edit_email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_role" class="form-label">Role Akses <span class="required">*</span></label>
                        <select id="edit_role" name="role" class="form-control" required style="font-weight: 600;">
                            @foreach($availableRoles as $r)
                                <option value="{{ $r->slug }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_password" class="form-label">Ganti Password (Opsional)</label>
                        <input type="password" id="edit_password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 1.25rem;">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openEditModal(id, name, email, role) {
        const form = document.getElementById('editUserForm');
        form.action = '{{ url("admin/users") }}/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_password').value = '';

        const modal = document.getElementById('editUserModal');
        modal.style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editUserModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editUserModal');
        if (event.target === modal) {
            closeEditModal();
        }
    };
</script>
@endpush
