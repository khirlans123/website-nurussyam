@extends('admin.layout')

@section('title', 'Kategori Berita')
@section('page_title', 'Kelola Kategori')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-folder-tree"></i>
                <span>Kategori Berita & Tulisan</span>
            </h1>
            <p class="page-head-subtitle">Atur pengelompokan artikel, warta, tausiyah, dan kabar pondok.</p>
        </div>
    </div>

    <div class="adm-detail-layout">
        
        <!-- List of Categories (Left) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-list"></i>
                        <span>Daftar Kategori Aktif</span>
                    </h2>
                </div>
                <div class="adm-card-body" style="padding: 0;">
                    <!-- Desktop Table View -->
                    <div class="desktop-only-table table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Slug URL</th>
                                    <th>Warna Badge</th>
                                    <th>Jumlah Berita</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 700; color: var(--adm-text-main);">
                                                {{ $cat->name }}
                                            </div>
                                            @if($cat->description)
                                                <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.2rem;">
                                                    {{ $cat->description }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <code>{{ $cat->slug }}</code>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 0.45rem;">
                                                <div style="width: 18px; height: 18px; border-radius: 4px; background-color: {{ $cat->color }}; border: 1px solid rgba(0,0,0,0.15);"></div>
                                                <span class="badge" style="background-color: {{ $cat->color }}20; color: {{ $cat->color }}; font-size: 0.72rem;">
                                                    {{ $cat->color }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-slate" style="font-size: 0.8rem;">
                                                {{ $cat->articles_count }} Artikel
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: inline-flex; gap: 0.35rem;">
                                                <button type="button" class="btn btn-secondary btn-icon" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->color }}', '{{ addslashes($cat->description ?? '') }}')" title="Edit Kategori">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                
                                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-icon" title="Hapus Kategori" {{ $cat->articles_count > 0 ? 'disabled' : '' }}>
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--adm-text-muted);">
                                            Belum ada kategori yang dibuat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Touch-Friendly Card List (Phone Only) -->
                    <div class="mobile-only-cards">
                        @forelse($categories as $cat)
                            <div class="mobile-card">
                                <div class="mobile-card-header">
                                    <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 0;">
                                        <div style="width: 22px; height: 22px; border-radius: 6px; background-color: {{ $cat->color }}; flex-shrink: 0; border: 1px solid rgba(0,0,0,0.15);"></div>
                                        <div class="mobile-card-title" style="font-size: 0.95rem; font-weight: 700; color: var(--adm-text-main);">
                                            {{ $cat->name }}
                                        </div>
                                    </div>
                                    <span class="badge badge-slate" style="font-size: 0.72rem; flex-shrink: 0;">
                                        <i class="fa-solid fa-newspaper"></i> {{ $cat->articles_count }} Artikel
                                    </span>
                                </div>

                                @if($cat->description)
                                    <div style="font-size: 0.76rem; color: var(--adm-text-muted); line-height: 1.4;">
                                        {{ $cat->description }}
                                    </div>
                                @endif

                                <div class="mobile-card-body" style="padding: 0.4rem 0;">
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label"><i class="fa-solid fa-link"></i> Slug URL:</span>
                                        <code style="font-size: 0.74rem;">{{ $cat->slug }}</code>
                                    </div>
                                    <div class="mobile-card-row">
                                        <span class="mobile-card-label"><i class="fa-solid fa-palette"></i> Warna:</span>
                                        <span class="badge" style="background-color: {{ $cat->color }}20; color: {{ $cat->color }}; font-size: 0.7rem;">
                                            {{ $cat->color }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mobile-card-footer" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ $cat->color }}', '{{ addslashes($cat->description ?? '') }}')" style="justify-content: center; width: 100%;">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Edit</span>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat->name }}?')" style="width: 100%;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="justify-content: center; width: 100%;" {{ $cat->articles_count > 0 ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 2rem; color: var(--adm-text-muted); font-size: 0.85rem;">
                                Belum ada kategori yang dibuat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Category Form (Right) -->
        <div>
            <div class="adm-card">
                <div class="adm-card-header">
                    <h2 class="adm-card-title">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Tambah Kategori Baru</span>
                    </h2>
                </div>
                <div class="adm-card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="cat_name" class="form-label">Nama Kategori <span class="required">*</span></label>
                            <input type="text" id="cat_name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Contoh: KAJIAN KITAB" required>
                        </div>

                        <div class="form-group">
                            <label for="cat_color" class="form-label">Warna Label</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="color" id="catColorPicker" value="#0f8528" style="width: 44px; height: 38px; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); cursor: pointer;" onchange="document.getElementById('cat_color').value = this.value">
                                <input type="text" id="cat_color" name="color" value="{{ old('color', '#0f8528') }}" class="form-control" style="flex: 1;" onkeyup="document.getElementById('catColorPicker').value = this.value">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cat_desc" class="form-label">Deskripsi Singkat</label>
                            <textarea id="cat_desc" name="description" rows="3" class="form-control" placeholder="Deskripsi mengenai topik kumpulan berita ini...">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                            <i class="fa-solid fa-plus"></i>
                            <span>Simpan Kategori</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Category Modal -->
    <div id="editCatModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1100; align-items: center; justify-content: center; padding: 0.75rem;">
        <div class="adm-card" style="width: 100%; max-width: 480px; max-height: 90vh; overflow-y: auto; margin: auto; border-radius: 14px;">
            <div class="adm-card-header">
                <h3 class="adm-card-title">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Kategori</span>
                </h3>
                <button type="button" class="btn-sidebar-logout" onclick="closeEditModal()" style="font-size: 1.25rem;">&times;</button>
            </div>
            <div class="adm-card-body">
                <form id="editCatForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_cat_name" class="form-label">Nama Kategori <span class="required">*</span></label>
                        <input type="text" id="edit_cat_name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_cat_color" class="form-label">Warna Label</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <input type="color" id="editCatColorPicker" style="width: 44px; height: 38px; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); cursor: pointer;" onchange="document.getElementById('edit_cat_color').value = this.value">
                            <input type="text" id="edit_cat_color" name="color" class="form-control" style="flex: 1;" onkeyup="document.getElementById('editCatColorPicker').value = this.value">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_cat_desc" class="form-label">Deskripsi</label>
                        <textarea id="edit_cat_desc" name="description" rows="3" class="form-control"></textarea>
                    </div>

                    <div style="display: flex; gap: 0.65rem; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openEditModal(id, name, color, desc) {
        const modal = document.getElementById('editCatModal');
        const form = document.getElementById('editCatForm');
        form.action = '{{ url("admin/categories") }}/' + id;
        document.getElementById('edit_cat_name').value = name;
        document.getElementById('edit_cat_color').value = color;
        document.getElementById('editCatColorPicker').value = color;
        document.getElementById('edit_cat_desc').value = desc;

        modal.style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editCatModal').style.display = 'none';
    }
</script>
@endpush
