@extends('admin.layout')

@section('title', 'Upload Foto Kegiatan Baru')
@section('page_title', 'Upload Foto Kegiatan')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload Foto Kegiatan Baru</span>
            </h1>
            <p class="page-head-subtitle">Unggah dokumentasi foto kegiatan santri dan pesantren ke dalam galeri publik.</p>
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

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Pentas Seni Santri & Peringatan Maulid Nabi" required autofocus>
                            <div class="form-text" style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px;">
                                Judul ini akan tampil di bawah foto pada galeri publik.
                            </div>
                        </div>

                        <!-- Kategori Kegiatan -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="category" class="form-label" style="font-weight: 700;">Kategori Kegiatan</label>
                            <div style="display: flex; gap: 10px;">
                                <select id="categorySelect" class="form-select" style="max-width: 240px;" onchange="handleCategorySelect(this.value)">
                                    <option value="Kegiatan Santri" {{ old('category') == 'Kegiatan Santri' ? 'selected' : '' }}>Kegiatan Santri</option>
                                    <option value="Pentas Seni & Kreasi" {{ old('category') == 'Pentas Seni & Kreasi' ? 'selected' : '' }}>Pentas Seni & Kreasi</option>
                                    <option value="Kajian & Shalat Berjamaah" {{ old('category') == 'Kajian & Shalat Berjamaah' ? 'selected' : '' }}>Kajian & Shalat Berjamaah</option>
                                    <option value="Pendidikan & Madrasah" {{ old('category') == 'Pendidikan & Madrasah' ? 'selected' : '' }}>Pendidikan & Madrasah</option>
                                    <option value="Peringatan Hari Besar" {{ old('category') == 'Peringatan Hari Besar' ? 'selected' : '' }}>Peringatan Hari Besar</option>
                                    <option value="Fasilitas & Lingkungan" {{ old('category') == 'Fasilitas & Lingkungan' ? 'selected' : '' }}>Fasilitas & Lingkungan</option>
                                    <option value="custom">-- Tulis Kategori Lain --</option>
                                </select>
                                <input type="text" id="categoryInput" name="category" value="{{ old('category', 'Kegiatan Santri') }}" class="form-control" placeholder="Nama kategori kegiatan">
                            </div>
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="activity_date" class="form-label" style="font-weight: 700;">Tanggal Kegiatan</label>
                            <input type="text" id="activity_date" name="activity_date" value="{{ old('activity_date', \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y')) }}" class="form-control" placeholder="Contoh: 19 Oktober 2026">
                        </div>

                        <!-- Keterangan Singkat (Opsional) -->
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="description" class="form-label" style="font-weight: 700;">Keterangan Tambahan (Opsional)</label>
                            <textarea id="description" name="description" rows="3" class="form-control" placeholder="Tuliskan keterangan singkat mengenai dokumentasi foto ini jika diperlukan...">{{ old('description') }}</textarea>
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
                            <span>File Gambar / Foto <span style="color: #ef4444;">*</span></span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <!-- Live Preview Box -->
                        <div id="imagePreviewBox" style="width: 100%; height: 210px; background: #0f172a; border: 2px dashed #cbd5e1; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 14px; position: relative;">
                            <img id="previewImage" src="" alt="Preview Foto" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            <div id="previewPlaceholder" style="text-align: center; color: #94a3b8; padding: 20px;">
                                <i class="fa-regular fa-image" style="font-size: 2.5rem; margin-bottom: 8px; display: block; color: #64748b;"></i>
                                <span style="font-size: 0.85rem; font-weight: 600;">Pilih file gambar untuk melihat preview</span>
                            </div>
                        </div>

                        <!-- Upload Input -->
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="image_file" class="form-label" style="font-weight: 700;">Upload dari Perangkat</label>
                            <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/jpg,image/webp" class="form-control" onchange="previewSelectedImage(this)">
                            <div class="form-text" style="font-size: 0.75rem; color: var(--adm-text-muted); margin-top: 4px;">
                                Format: JPG, PNG, WEBP. Maksimal 5 MB.
                            </div>
                        </div>

                        <!-- Status Publikasi -->
                        <div class="form-group" style="margin-bottom: 1.5rem; background: var(--adm-surface-alt); padding: 12px; border-radius: 6px; border: 1px solid var(--adm-border);">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0; font-size: 0.88rem; font-weight: 700;">
                                <input type="checkbox" name="is_published" value="1" checked style="width: 18px; height: 18px; accent-color: var(--adm-primary);">
                                <span>Langsung Tampilkan di Website</span>
                            </label>
                        </div>

                        <!-- Tombol Simpan -->
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 11px;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan ke Galeri</span>
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
            const placeholder = document.getElementById('previewPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        }
    </script>
@endsection
