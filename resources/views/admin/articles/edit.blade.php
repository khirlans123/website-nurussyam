@extends('admin.layout')

@section('title', 'Edit Berita - ' . $article->title)
@section('page_title', 'Edit Berita')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Berita & Warta</span>
            </h1>
            <p class="page-head-subtitle">Perbarui informasi, isi tulisan, atau gambar untuk berita "{{ $article->title }}".</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('article.show', $article->slug) }}" target="_blank" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat di Web</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="adm-form-layout">
            <!-- Main Content Form (Left) -->
            <div>
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-file-lines"></i>
                            <span>Konten Utama</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <!-- Judul -->
                        <div class="form-group">
                            <label for="title" class="form-label">Judul Berita <span class="required">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug URL -->
                        <div class="form-group">
                            <label for="slug" class="form-label">Slug URL</label>
                            <div class="input-group">
                                <span class="input-group-text">/artikel/</span>
                                <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}" class="form-control" placeholder="url-ramah-seo">
                            </div>
                            <div class="form-text">Biarkan apa adanya atau ubah sesuai kebutuhan tautan ramah SEO.</div>
                        </div>

                        <!-- Ringkasan Singkat -->
                        <div class="form-group">
                            <label for="summary" class="form-label">Ringkasan / Excerpt</label>
                            <textarea id="summary" name="summary" rows="3" class="form-control">{{ old('summary', $article->summary) }}</textarea>
                        </div>

                        <!-- Editor Toolbar & Content -->
                        <div class="form-group">
                            <label for="editorContent" class="form-label">Isi Berita Lengkap <span class="required">*</span></label>
                            
                            <!-- Formatting Toolbar -->
                            <div style="background-color: var(--adm-surface-alt); border: 1px solid var(--adm-border); border-bottom: none; border-top-left-radius: var(--adm-radius-sm); border-top-right-radius: var(--adm-radius-sm); padding: 0.5rem; display: flex; gap: 0.35rem; flex-wrap: wrap;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<b>', '</b>')" title="Bold"><i class="fa-solid fa-bold"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<i>', '</i>')" title="Italic"><i class="fa-solid fa-italic"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<h2>', '</h2>')" title="Subjudul H2">H2</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<h3>', '</h3>')" title="Subjudul H3">H3</button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<blockquote>', '</blockquote>')" title="Kutipan"><i class="fa-solid fa-quote-left"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<ul>\n  <li>', '</li>\n</ul>')" title="Daftar List"><i class="fa-solid fa-list-ul"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertTag('<p>', '</p>')" title="Paragraf"><i class="fa-solid fa-paragraph"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="insertLink()" title="Sisipkan Link"><i class="fa-solid fa-link"></i></button>
                            </div>

                            <textarea id="editorContent" name="content" rows="18" class="form-control @error('content') is-invalid @enderror" style="border-top-left-radius: 0; border-top-right-radius: 0; font-family: monospace; font-size: 0.9rem;" required>{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Form (Right) -->
            <div>
                <!-- Metadata & Kategori -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-tag"></i>
                            <span>Kategori & Penulis</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <!-- Kategori -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">Kategori Berita</label>
                            <select id="category_id" name="category_id" class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal Publikasi / Kegiatan -->
                        <div class="form-group">
                            <label for="date" class="form-label">Tanggal Berita / Kegiatan</label>
                            <input type="text" id="date" name="date" value="{{ old('date', $article->date ?? \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y')) }}" class="form-control" placeholder="Contoh: 19 Oktober 2026">
                            <div class="form-text">Format tanggal pelaksanaan kegiatan atau unggah berita.</div>
                        </div>

                        <!-- Jam Up Berita / Kegiatan -->
                        <div class="form-group">
                            <label for="activity_time" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                                <span><i class="fa-regular fa-clock" style="color: var(--adm-primary); margin-right: 4px;"></i> Jam Up Berita / Waktu Kegiatan</span>
                                <span style="font-size: 0.75rem; color: var(--adm-text-muted);">Format WIB</span>
                            </label>
                            <input type="text" id="activity_time" name="activity_time" value="{{ old('activity_time', $article->activity_time ?? ($article->created_at ? $article->created_at->format('H:i') . ' WIB' : '12:00 WIB')) }}" class="form-control" placeholder="Contoh: 14:30 WIB atau 08:00 - 11:30 WIB">
                            <div class="form-text">Jam kegiatan santri atau waktu berita di-up ke website.</div>
                        </div>

                        <!-- Penulis -->
                        <div class="form-group">
                            <label for="author" class="form-label">Nama Penulis</label>
                            <input type="text" id="author" name="author" value="{{ old('author', $article->author) }}" class="form-control">
                        </div>

                        <!-- Waktu Baca -->
                        <div class="form-group">
                            <label for="read_time" class="form-label">Estimasi Waktu Baca</label>
                            <input type="text" id="read_time" name="read_time" value="{{ old('read_time', $article->read_time) }}" class="form-control">
                        </div>

                        <!-- Warna Badge -->
                        <div class="form-group">
                            <label for="badge_color" class="form-label">Warna Label</label>
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <input type="color" id="badgeColorPicker" value="{{ old('badge_color', $article->badge_color ?? '#0f8528') }}" style="width: 44px; height: 38px; border: 1px solid var(--adm-border); border-radius: var(--adm-radius-sm); cursor: pointer;" onchange="document.getElementById('badge_color').value = this.value">
                                <input type="text" id="badge_color" name="badge_color" value="{{ old('badge_color', $article->badge_color ?? '#0f8528') }}" class="form-control" style="flex: 1;" onkeyup="document.getElementById('badgeColorPicker').value = this.value">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Foto Utama -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-image"></i>
                            <span>Foto Berita</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Foto Berita</span>
                                <span style="font-size: 0.75rem; color: var(--adm-text-muted); font-weight: normal;">Bisa diklik untuk ganti</span>
                            </label>

                            <!-- Box Preview Clickable -->
                            <div class="image-preview-box" id="imagePreviewContainer" onclick="document.getElementById('image_file').click()" title="Klik untuk mengganti foto dari perangkat Anda">
                                <img id="imagePreview" src="{{ (str_starts_with($article->image, 'http') || str_starts_with($article->image, '/')) ? $article->image : asset($article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="image-preview-overlay" id="imageChangeOverlay" style="display: flex;">
                                    <i class="fa-solid fa-camera"></i>
                                    <span>Klik untuk Ganti Gambar</span>
                                </div>
                            </div>

                            <!-- Native File Input & Petunjuk -->
                            <div style="margin-top: 0.75rem;">
                                <input type="file" id="image_file" name="image_file" accept="image/*" class="form-control" onchange="previewSelectedImage(event)">
                                <div class="form-text" style="font-size: 0.75rem; margin-top: 0.35rem; color: var(--adm-text-muted);">
                                    <i class="fa-solid fa-circle-info" style="margin-right: 0.25rem;"></i>Pilih file baru jika ingin mengganti gambar (JPG, PNG, WebP maks. 5MB).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Publikasi -->
                <div class="adm-card">
                    <div class="adm-card-header">
                        <h2 class="adm-card-title">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Status & Perubahan</span>
                        </h2>
                    </div>
                    <div class="adm-card-body">
                        <div class="form-group">
                            <label class="toggle-switch-wrapper">
                                <div class="toggle-switch">
                                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.88rem;">Status Terbit (Live)</div>
                                    <div style="font-size: 0.75rem; color: var(--adm-text-muted);">Aktifkan untuk menampilkan di website</div>
                                </div>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="toggle-switch-wrapper">
                                <div class="toggle-switch">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </div>
                                <div>
                                    <div style="font-weight: 600; font-size: 0.88rem;">Berita Utama (Featured)</div>
                                    <div style="font-size: 0.75rem; color: var(--adm-text-muted);">Tampil di sorotan teratas</div>
                                </div>
                            </label>
                        </div>

                        <hr style="border: none; border-top: 1px solid var(--adm-border); margin: 1.25rem 0;">

                        <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                            <button type="submit" class="btn btn-primary" style="padding: 0.75rem;">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                                <span>Batalkan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function previewSelectedImage(event) {
        const file = event.target.files && event.target.files[0];
        const preview = document.getElementById('imagePreview');
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }

    // Drag & Drop Support on Preview Box
    document.addEventListener('DOMContentLoaded', function() {
        const dropBox = document.getElementById('imagePreviewContainer');
        const fileInput = document.getElementById('image_file');

        if (dropBox && fileInput) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropBox.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropBox.style.borderColor = 'var(--adm-primary)';
                    dropBox.style.backgroundColor = '#ecfdf5';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropBox.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropBox.style.borderColor = '';
                    dropBox.style.backgroundColor = '';
                }, false);
            });

            dropBox.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                if (dt && dt.files && dt.files.length > 0) {
                    fileInput.files = dt.files;
                    previewSelectedImage({ target: fileInput });
                }
            }, false);
        }
    });

    function insertTag(openTag, closeTag) {
        const textarea = document.getElementById('editorContent');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end);
        const replacement = openTag + (selected || 'Teks') + closeTag;
        textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + openTag.length, start + openTag.length + (selected ? selected.length : 4));
    }

    function insertLink() {
        const url = prompt('Masukkan tautan URL (misal: https://...):', 'https://');
        if (url) {
            insertTag('<a href="' + url + '" target="_blank">', '</a>');
        }
    }
</script>
@endpush
