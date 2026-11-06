@extends('admin.layout')

@section('title', 'Edit Foto Kegiatan')
@section('page_title', 'Edit Foto Kegiatan')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Foto Kegiatan</span>
            </h1>
            <p class="page-head-subtitle">Perbarui judul foto, kategori, atau ganti file foto kegiatan.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Galeri</span>
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="adm-alert adm-alert-danger" style="margin-bottom: 1.5rem;">
            <i class="fa-solid fa-circle-exclamation adm-alert-icon"></i>
            <div>
                <strong>Terdapat kesalahan pengisian formulir:</strong>
                <ul style="margin: 4px 0 0 16px; padding: 0;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="adm-form-layout" style="display: grid; grid-template-columns: 2fr 1.1fr; gap: 24px;">
            <!-- Kolom Kiri: Informasi Foto & Deskripsi -->
            <div>
                <div class="adm-card" style="margin-bottom: 1.5rem;">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-camera"></i>
                            <span>Informasi Foto Kegiatan</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <!-- Judul Foto -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="title" class="form-label" style="font-weight: 700;">
                                Judul Foto Kegiatan <span class="required" style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            <div class="form-text" style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px;">
                                Judul ini tampil di bawah foto pada galeri publik.
                            </div>
                        </div>

                        <!-- Kategori Kegiatan -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="category" class="form-label" style="font-weight: 700;">Kategori Kegiatan</label>
                            <div style="display: flex; gap: 10px;">
                                <select id="categorySelect" class="form-select" style="max-width: 240px;" onchange="handleCategorySelect(this.value)">
                                    <option value="Kegiatan Santri" {{ old('category', $gallery->category) == 'Kegiatan Santri' ? 'selected' : '' }}>Kegiatan Santri</option>
                                    <option value="Pentas Seni & Kreasi" {{ old('category', $gallery->category) == 'Pentas Seni & Kreasi' ? 'selected' : '' }}>Pentas Seni & Kreasi</option>
                                    <option value="Kajian & Shalat Berjamaah" {{ old('category', $gallery->category) == 'Kajian & Shalat Berjamaah' ? 'selected' : '' }}>Kajian & Shalat Berjamaah</option>
                                    <option value="Pendidikan & Madrasah" {{ old('category', $gallery->category) == 'Pendidikan & Madrasah' ? 'selected' : '' }}>Pendidikan & Madrasah</option>
                                    <option value="Peringatan Hari Besar" {{ old('category', $gallery->category) == 'Peringatan Hari Besar' ? 'selected' : '' }}>Peringatan Hari Besar</option>
                                    <option value="Fasilitas & Lingkungan" {{ old('category', $gallery->category) == 'Fasilitas & Lingkungan' ? 'selected' : '' }}>Fasilitas & Lingkungan</option>
                                    <option value="custom">-- Tulis Kategori Lain --</option>
                                </select>
                                <input type="text" id="categoryInput" name="category" value="{{ old('category', $gallery->category) }}" class="form-control">
                            </div>
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="activity_date" class="form-label" style="font-weight: 700;">Tanggal Kegiatan</label>
                            <input type="text" id="activity_date" name="activity_date" value="{{ old('activity_date', $gallery->activity_date) }}" class="form-control">
                        </div>

                        <!-- Keterangan Singkat -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="description" class="form-label" style="font-weight: 700;">Keterangan Tambahan (Opsional)</label>
                            <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', $gallery->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Upload File & Live Preview -->
            <div>
                <div class="adm-card" style="margin-bottom: 1.5rem;">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-image"></i>
                            <span>File Gambar / Foto</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <!-- Preview Box -->
                        <div id="imagePreviewBox" style="width: 100%; height: 210px; background: #0f172a; border: 2px dashed #cbd5e1; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 14px; position: relative;">
                            <img id="previewImage" src="{{ $gallery->image_url }}" alt="Preview Foto" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>

                        <!-- Ganti File Foto -->
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="image_file" class="form-label" style="font-weight: 700;">Ganti Foto (Biarkan kosong jika tidak diganti)</label>
                            <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/jpg,image/webp" class="form-control" onchange="previewSelectedImage(this)">
                            <div class="form-text" style="font-size: 0.75rem; color: var(--adm-text-muted); margin-top: 4px;">
                                Format: JPG, PNG, WEBP. Maksimal 5 MB.
                            </div>
                        </div>

                        <!-- Status Publikasi -->
                        <div class="form-group" style="margin-bottom: 1.5rem; background: var(--adm-surface-alt); padding: 12px; border-radius: 6px; border: 1px solid var(--adm-border);">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; font-size: 0.88rem; font-weight: 700;">
                                <input type="checkbox" name="is_published" value="1" {{ $gallery->is_published ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--adm-primary);">
                                <span>Tampilkan di Website Publik</span>
                            </label>
                        </div>

                        <!-- Tombol Simpan -->
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 11px;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function handleCategorySelect(val) {
            const input = document.getElementById('categoryInput');
            if (val === 'custom') {
                input.value = '';
                input.focus();
            } else {
                input.value = val;
            }
        }

        function previewSelectedImage(input) {
            const preview = document.getElementById('previewImage');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
