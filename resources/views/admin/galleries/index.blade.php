@extends('admin.layout')

@section('title', 'Galeri Kegiatan Pesantren')
@section('page_title', 'Manajemen Galeri Kegiatan')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-images"></i>
                <span>Galeri Foto Kegiatan Pesantren</span>
            </h1>
            <p class="page-head-subtitle">Kelola dokumentasi visual santri, kegiatan pondok, majelis, dan peringatan hari besar Islam.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Upload Foto Baru</span>
            </a>
            <a href="{{ route('page.show', 'galeri') }}" target="_blank" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat di Website</span>
            </a>
        </div>
    </div>

    <!-- Alert Informasi Sinkronisasi Otomatis -->
    <div class="adm-card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-left: 4px solid var(--adm-primary);">
        <div class="adm-card-body" style="padding: 1.1rem 1.4rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #dcfce7; color: var(--adm-primary); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <div>
                    <h3 style="font-size: 0.98rem; font-weight: 800; color: #064e18; margin: 0 0 3px;">Sistem Sinkronisasi Galeri Otomatis Aktif</h3>
                    <p style="font-size: 0.83rem; color: #166534; margin: 0;">
                        Foto dari setiap Berita/Artikel santri yang diunggah akan <strong>otomatis tampil di halaman Galeri publik</strong> lengkap dengan judul fotonya (hanya foto dan judul tanpa teks isi berita). Anda juga dapat mengupload foto kegiatan tambahan secara manual di bawah ini.
                    </p>
                </div>
            </div>
            <div style="display: flex; gap: 8px;">
                <span class="badge badge-emerald" style="padding: 6px 12px; font-size: 0.82rem;">
                    <i class="fa-solid fa-camera"></i> {{ $galleries->total() }} Foto Manual
                </span>
                <span class="badge badge-blue" style="padding: 6px 12px; font-size: 0.82rem;">
                    <i class="fa-solid fa-newspaper"></i> {{ $autoArticlePhotos->count() }} Foto dari Berita
                </span>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="adm-card" style="margin-bottom: 1.5rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.galleries.index') }}" method="GET" class="filter-row" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <div style="flex: 1; min-width: 240px; position: relative;">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul kegiatan atau foto..." style="padding-left: 2.4rem;">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: var(--adm-text-muted);"></i>
                </div>

                <div style="min-width: 180px;">
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: flex; gap: 6px;">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    @if(request()->hasAny(['q', 'category']))
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Grid Foto Galeri Manual -->
    <div class="adm-card" style="margin-bottom: 2rem;">
        <div class="adm-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="adm-card-title">
                <i class="fa-solid fa-photo-film"></i>
                <span>Daftar Foto Galeri Kegiatan (Upload Manual)</span>
            </h2>
            <span style="font-size: 0.8rem; color: var(--adm-text-muted);">Menampilkan {{ $galleries->count() }} dari {{ $galleries->total() }} foto</span>
        </div>

        <div class="adm-card-body" style="padding: 1.5rem;">
            @if($galleries->isEmpty())
                <div style="text-align: center; padding: 40px 15px; color: var(--adm-text-muted);">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--adm-surface-alt); display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 12px; color: var(--adm-text-muted);">
                        <i class="fa-regular fa-image"></i>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--adm-text); margin-bottom: 4px;">Belum Ada Foto di Galeri Manual</h3>
                    <p style="font-size: 0.85rem; max-width: 440px; margin: 0 auto 16px;">
                        Foto dari berita santri tetap otomatis tampil di website. Anda juga bisa mengunggah foto kegiatan tambahan ke galeri.
                    </p>
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Upload Foto Pertama
                    </a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
                    @foreach($galleries as $item)
                        <div style="background: var(--adm-surface); border: 1px solid var(--adm-border); border-radius: var(--adm-radius-md); overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); display: flex; flex-direction: column; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                            <!-- Image Container with aspect ratio -->
                            <div style="position: relative; width: 100%; height: 180px; background: #0f172a; overflow: hidden;">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy">
                                <span class="badge {{ $item->is_published ? 'badge-emerald' : 'badge-slate' }}" style="position: absolute; top: 10px; right: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                                    {{ $item->is_published ? 'Aktif' : 'Disembunyikan' }}
                                </span>
                                <span class="badge badge-amber" style="position: absolute; top: 10px; left: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.25);">
                                    {{ $item->category }}
                                </span>
                            </div>

                            <!-- Content Details -->
                            <div style="padding: 14px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h3 style="font-size: 0.92rem; font-weight: 700; color: var(--adm-text); line-height: 1.4; margin: 0 0 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $item->title }}">
                                        {{ $item->title }}
                                    </h3>
                                    <div style="font-size: 0.78rem; color: var(--adm-text-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 12px;">
                                        <i class="fa-regular fa-calendar-days"></i>
                                        <span>{{ $item->activity_date ?? $item->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--adm-border); padding-top: 10px; margin-top: auto;">
                                    <form action="{{ route('admin.galleries.toggle-publish', $item->id) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $item->is_published ? 'btn-secondary' : 'btn-primary' }}" title="{{ $item->is_published ? 'Sembunyikan dari Publik' : 'Tampilkan ke Publik' }}" style="padding: 4px 8px; font-size: 0.75rem;">
                                            <i class="fa-solid {{ $item->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            <span>{{ $item->is_published ? 'Sembunyi' : 'Tayang' }}</span>
                                        </button>
                                    </form>

                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('admin.galleries.edit', $item->id) }}" class="btn btn-secondary btn-sm" title="Edit Data Foto" style="padding: 4px 8px;">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto kegiatan ini dari galeri?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Foto" style="padding: 4px 8px;">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($galleries->hasPages())
                    <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                        {{ $galleries->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Bagian Foto Otomatis dari Berita Santri -->
    <div class="adm-card">
        <div class="adm-card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-newspaper" style="color: var(--adm-primary);"></i>
                <h2 class="adm-card-title" style="margin: 0;">Foto Kegiatan yang Tersinkron Otomatis dari Berita Santri</h2>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-pen-to-square"></i> Kelola Berita
            </a>
        </div>
        <div class="adm-card-body" style="padding: 1.5rem;">
            <p style="font-size: 0.85rem; color: var(--adm-text-muted); margin-bottom: 16px;">
                Setiap berita santri / kegiatan di bawah ini yang berstatus <strong>Tayang</strong> secara otomatis masuk ke halaman galeri publik hanya fotonya saja bersama judul fotonya.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px;">
                @foreach($autoArticlePhotos->take(8) as $art)
                    @php
                        $imgUrl = str_starts_with($art->image, 'http') ? $art->image : asset($art->image);
                    @endphp
                    <div style="background: var(--adm-surface-alt); border: 1px solid var(--adm-border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                        <div style="position: relative; width: 100%; height: 130px; background: #0f172a;">
                            <img src="{{ $imgUrl }}" alt="{{ $art->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block;" loading="lazy">
                            <span class="badge badge-emerald" style="position: absolute; bottom: 6px; left: 6px; font-size: 0.7rem;">
                                <i class="fa-solid fa-check-circle"></i> Auto Berita
                            </span>
                        </div>
                        <div style="padding: 10px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <h4 style="font-size: 0.84rem; font-weight: 700; color: var(--adm-text); line-height: 1.35; margin: 0 0 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="{{ $art->title }}">
                                {{ $art->title }}
                            </h4>
                            <div style="font-size: 0.72rem; color: var(--adm-text-muted);">
                                <span>{{ $art->date }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($autoArticlePhotos->count() > 8)
                <div style="text-align: center; margin-top: 14px;">
                    <span style="font-size: 0.82rem; color: var(--adm-text-muted);">
                        Dan {{ $autoArticlePhotos->count() - 8 }} foto berita lainnya otomatis aktif di galeri publik.
                    </span>
                </div>
            @endif
        </div>
    </div>
@endsection
