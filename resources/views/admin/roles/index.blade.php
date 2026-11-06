@extends('admin.layout')

@section('title', 'Kelola Role & Hak Akses Pengguna')
@section('page_title', 'Kelola Role Akses')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Kelola Tingkatan Role & Wewenang Akses</span>
            </h1>
            <p class="page-head-subtitle">Atur izin wewenang sistem: buat role khusus baru dan sesuaikan batas akses masing-masing jabatan pengelola.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Histori Aktivitas User</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-users"></i>
                <span>Akun Pengguna</span>
            </a>
        </div>
    </div>

    <div class="adm-detail-layout">
        
        <!-- List of Roles (Left) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-id-card-clip"></i>
                        <span>Daftar Role Aktif</span>
                    </h2>
                </div>
                <div class="adm-card-body" style="padding: 0;">
                    <!-- Desktop Table View -->
                    <div class="desktop-only-table table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Nama Role</th>
                                    <th>Slug / Kode</th>
                                    <th>Pengguna</th>
                                    <th>Tipe Role</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $r)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: var(--adm-text-main); font-size: 0.95rem;">
                                                {{ $r->name }}
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--adm-text-muted); margin-top: 0.2rem; line-height: 1.4;">
                                                {{ $r->description ?: 'Role pengelola sistem pondok.' }}
                                            </div>
                                        </td>
                                        <td>
                                            <code>{{ $r->slug }}</code>
                                        </td>
                                        <td>
                                            <span class="badge badge-slate" style="font-size: 0.78rem;">
                                                <i class="fa-solid fa-users"></i> {{ $r->users_count }} Akun
                                            </span>
                                        </td>
                                        <td>
                                            @if($r->is_system)
                                                <span class="badge badge-emerald" style="font-size: 0.72rem;">
                                                    <i class="fa-solid fa-lock"></i> Sistem Bawaan
                                                </span>
                                            @else
                                                <span class="badge badge-blue" style="font-size: 0.72rem;">
                                                    <i class="fa-solid fa-user-plus"></i> Kustom
                                                </span>
                                            @endif
                                        </td>
                                        <td style="text-align: right; white-space: nowrap;">
                                            <div style="display: inline-flex; gap: 0.35rem;">
                                                <button type="button" class="btn btn-secondary btn-icon" onclick="openEditRoleModal({{ $r->id }}, '{{ addslashes($r->name) }}', '{{ addslashes($r->description ?? '') }}', {{ json_encode($r->permissions ?? []) }}, {{ $r->is_system ? 'true' : 'false' }})" title="Lihat / Edit Hak Akses">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                @if(!$r->is_system)
                                                    <form action="{{ route('admin.roles.destroy', $r) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role kustom {{ addslashes($r->name) }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-icon" title="Hapus Role" {{ $r->users_count > 0 ? 'disabled' : '' }}>
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Touch-Friendly Card List (Phone Only) -->
                    <div class="mobile-only-cards">
                        @foreach($roles as $r)
                            <div class="mobile-card">
                                <div class="mobile-card-header">
                                    <div>
                                        <div class="mobile-card-title">{{ $r->name }}</div>
                                        <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 0.15rem;">
                                            <code>{{ $r->slug }}</code>
                                        </div>
                                    </div>
                                    <div>
                                        @if($r->is_system)
                                            <span class="badge badge-emerald" style="font-size: 0.7rem;">
                                                <i class="fa-solid fa-lock"></i> Sistem Bawaan
                                            </span>
                                        @else
                                            <span class="badge badge-blue" style="font-size: 0.7rem;">
                                                <i class="fa-solid fa-user-plus"></i> Kustom
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if($r->description)
                                    <div style="font-size: 0.76rem; color: var(--adm-text-muted); line-height: 1.4;">
                                        {{ $r->description }}
                                    </div>
                                @endif

                                <div class="mobile-card-body" style="padding: 0.4rem 0;">
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label"><i class="fa-solid fa-users"></i> Jumlah Pengguna:</span>
                                        <span class="badge badge-slate" style="font-size: 0.72rem;">{{ $r->users_count }} Akun</span>
                                    </div>
                                </div>

                                <div class="mobile-card-footer" style="display: grid; grid-template-columns: {{ $r->is_system ? '1fr' : '1fr 1fr' }}; gap: 0.5rem;">
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openEditRoleModal({{ $r->id }}, '{{ addslashes($r->name) }}', '{{ addslashes($r->description ?? '') }}', {{ json_encode($r->permissions ?? []) }}, {{ $r->is_system ? 'true' : 'false' }})" style="justify-content: center; width: 100%;">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit Wewenang</span>
                                    </button>

                                    @if(!$r->is_system)
                                        <form action="{{ route('admin.roles.destroy', $r) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role kustom {{ addslashes($r->name) }}?')" style="width: 100%;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="justify-content: center; width: 100%;" {{ $r->users_count > 0 ? 'disabled' : '' }}>
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Role Permissions Matrix Explainer -->
            <div class="adm-card" style="margin-top: 1.5rem;">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Tentang Pengaturan Hak Akses</span>
                    </h2>
                </div>
                <div class="adm-card-body" style="font-size: 0.85rem; color: var(--adm-text-muted); line-height: 1.6;">
                    <p style="margin-bottom: 0.75rem;">
                        Sistem Nurussyam membagi wewenang secara aman:
                    </p>
                    <ul style="padding-left: 1.25rem; margin-bottom: 0;">
                        <li><strong>Super Admin:</strong> Memegang wewenang tertinggi, termasuk persetujuan santri diterima (*Diterima*) dan kelola akun.</li>
                        <li><strong>Staff PSB & Berita:</strong> Diberi wewenang verifikasi dokumen dan kelola warta. <em>Tidak dapat menerima santri secara final.</em></li>
                        <li><strong>Penulis Berita:</strong> Hanya memiliki akses untuk membuat dan mengelola warta pondok.</li>
                        <li><strong>Role Kustom Baru:</strong> Anda dapat membuat role baru seperti <em>Koordinator LAZISWAF</em> atau <em>Panitia Ujian</em> dengan memilih izin spesifik pada form di samping.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Create Role Form (Right) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Tambah Role Akses Baru</span>
                    </h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Role Wewenang <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Koordinator PSB, Bendahara, dll" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Deskripsi Jabatan / Tugas</label>
                            <textarea id="description" name="description" rows="2" class="form-control" placeholder="Jelaskan wewenang jabatan ini..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Izin & Batas Akses Sistem <span class="required">*</span></span>
                                <button type="button" class="btn btn-link btn-sm" style="font-size: 0.75rem; text-decoration: underline;" onclick="toggleAllPermissions(true)">Pilih Semua</button>
                            </label>

                            <div style="max-height: 340px; overflow-y: auto; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); padding: 0.85rem; background: var(--adm-surface-alt);">
                                @php
                                    $grouped = [];
                                    foreach($permissions as $permKey => $permVal) {
                                        $grouped[$permVal['group']][$permKey] = $permVal['label'];
                                    }
                                @endphp

                                @foreach($grouped as $groupName => $permItems)
                                    <div style="margin-bottom: 0.85rem;">
                                        <div style="font-size: 0.76rem; font-weight: 800; color: var(--adm-primary); text-transform: uppercase; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.3rem;">
                                            <i class="fa-solid fa-caret-right"></i> {{ $groupName }}
                                        </div>
                                        @foreach($permItems as $pKey => $pLabel)
                                            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; margin-bottom: 0.3rem; cursor: pointer; user-select: none;">
                                                <input type="checkbox" name="permissions[]" value="{{ $pKey }}" class="create-perm-check">
                                                <span>{{ $pLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-text">Tentukan menu apa saja yang dapat dibuka oleh akun dengan role ini.</div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Role Akses</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Role Modal -->
    <div id="editRoleModal" class="adm-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 0.75rem;">
        <div class="adm-card" style="width: 100%; max-width: 540px; max-height: 90vh; overflow-y: auto; margin: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);">
            <div class="adm-card-header">
                <h2 class="adm-card-title">
                    <i class="fa-solid fa-pen-ruler"></i>
                    <span>Edit Hak Akses Role</span>
                </h2>
                <button type="button" class="btn btn-secondary btn-icon" onclick="closeEditRoleModal()" style="border: none;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="adm-card-body">
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_role_name" class="form-label">Nama Role <span class="required">*</span></label>
                        <input type="text" id="edit_role_name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_role_desc" class="form-label">Deskripsi Jabatan</label>
                        <textarea id="edit_role_desc" name="description" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group" id="editPermissionsContainer">
                        <label class="form-label">Izin Akses Role</label>
                        <div style="max-height: 250px; overflow-y: auto; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); padding: 0.85rem; background: var(--adm-surface-alt);">
                            @foreach($grouped as $groupName => $permItems)
                                <div style="margin-bottom: 0.75rem;">
                                    <div style="font-size: 0.76rem; font-weight: 800; color: var(--adm-primary); text-transform: uppercase; margin-bottom: 0.25rem;">
                                        {{ $groupName }}
                                    </div>
                                    @foreach($permItems as $pKey => $pLabel)
                                        <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; margin-bottom: 0.25rem; cursor: pointer;">
                                            <input type="checkbox" name="permissions[]" value="{{ $pKey }}" class="edit-perm-check" id="edit_perm_{{ $pKey }}">
                                            <span>{{ $pLabel }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 1.25rem;">
                        <button type="button" class="btn btn-secondary" onclick="closeEditRoleModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-check"></i>
                            <span>Simpan Hak Akses</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleAllPermissions(checked) {
        document.querySelectorAll('.create-perm-check').forEach(cb => cb.checked = checked);
    }

    function openEditRoleModal(id, name, desc, permissions, isSystem) {
        const form = document.getElementById('editRoleForm');
        form.action = '{{ url("admin/roles") }}/' + id;
        document.getElementById('edit_role_name').value = name;
        document.getElementById('edit_role_desc').value = desc;

        // If system role admin, disable renaming
        if (isSystem && name === 'Super Admin') {
            document.getElementById('edit_role_name').readOnly = true;
        } else {
            document.getElementById('edit_role_name').readOnly = false;
        }

        // Uncheck all edit checkboxes first
        document.querySelectorAll('.edit-perm-check').forEach(cb => cb.checked = false);

        // Check assigned permissions
        if (Array.isArray(permissions)) {
            permissions.forEach(p => {
                const cb = document.getElementById('edit_perm_' + p);
                if (cb) cb.checked = true;
            });
        }

        document.getElementById('editRoleModal').style.display = 'flex';
    }

    function closeEditRoleModal() {
        document.getElementById('editRoleModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('editRoleModal');
        if (event.target === modal) {
            closeEditRoleModal();
        }
    };
</script>
@endpush
