@extends('admin.layout')

@section('title', 'Daftar Berita & Artikel')
@section('page_title', 'Kelola Berita & Artikel')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-head-title">
                <i class="fa-solid fa-newspaper"></i>
                <span>Daftar Berita & Warta</span>
            </h1>
            <p class="page-head-subtitle">Kelola seluruh publikasi artikel, warta, tausiyah, dan catatan santri.</p>
        </div>
        <div class="page-head-actions">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Tulis Berita Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="adm-card" style="margin-bottom: 1.25rem;">
        <div class="adm-card-body" style="padding: 1rem 1.25rem;">
            <form action="{{ route('admin.articles.index') }}" method="GET" class="adm-toolbar-form">
                <div style="flex: 1; min-width: 220px;">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul berita, penulis...">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>

                <div style="min-width: 170px;">
                    <select name="category_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="min-width: 150px;">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Terbit Saja</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft Saja</option>
                        <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Berita Utama</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-filter"></i>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['q', 'category_id', 'status']))
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary" title="Reset Pencarian">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Articles Table (Desktop) and Cards (Mobile) -->
    <div class="adm-card">
        <div class="adm-card-body" style="padding: 0;">
            <!-- Desktop Table View -->
            <div class="desktop-only-table table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th style="width: 75px;">Gambar</th>
                            <th>Judul & Ringkasan</th>
                            <th>Kategori & Penulis</th>
                            <th>Status Publikasi</th>
                            <th>Pembaca</th>
                            <th style="text-align: right; width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $art)
                            <tr>
                                <td>
                                    <img src="{{ (str_starts_with($art->image, 'http') || str_starts_with($art->image, '/')) ? $art->image : asset($art->image) }}" alt="{{ $art->title }}" class="table-thumbnail">
                                </td>
                                <td>
                                    <div style="font-weight: 700; font-size: 0.95rem; margin-bottom: 0.25rem;">
                                        <a href="{{ route('admin.articles.edit', $art) }}" style="color: var(--adm-text-main);">
                                            {{ $art->title }}
                                        </a>
                                    </div>
                                    <div style="font-size: 0.78rem; color: var(--adm-text-muted); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $art->summary ?? strip_tags($art->content) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $art->badge_color ?? '#0f8528' }}20; color: {{ $art->badge_color ?? '#0f8528' }};">
                                        {{ $art->category }}
                                    </span>
                                    <div style="font-size: 0.74rem; color: var(--adm-text-muted); margin-top: 0.35rem;">
                                        <i class="fa-regular fa-user" style="margin-right: 3px;"></i> {{ $art->author ?? 'admin' }}
                                        <br>
                                        <i class="fa-regular fa-calendar" style="margin-right: 3px;"></i> {{ $art->date ?? 'N/A' }}
                                        @php $jamUp = $art->activity_time ?? ($art->created_at ? $art->created_at->format('H:i') . ' WIB' : ''); @endphp
                                        @if($jamUp)
                                            <br><i class="fa-regular fa-clock" style="margin-right: 3px; color: var(--adm-primary);"></i> <span style="font-weight: 600; color: var(--adm-text-main);">{{ $jamUp }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 0.35rem; align-items: flex-start;">
                                        <form action="{{ route('admin.articles.toggle-publish', $art) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $art->is_published ? 'btn-success' : 'btn-secondary' }}" style="padding: 0.2rem 0.5rem; font-size: 0.72rem;" title="Klik untuk mengubah status">
                                                <i class="fa-solid {{ $art->is_published ? 'fa-check' : 'fa-clock' }}"></i>
                                                <span>{{ $art->is_published ? 'Terbit' : 'Draft' }}</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.articles.toggle-featured', $art) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $art->is_featured ? 'btn-warning' : 'btn-secondary' }}" style="padding: 0.2rem 0.5rem; font-size: 0.72rem;" title="Klik untuk jadikan Berita Utama">
                                                <i class="fa-solid fa-star"></i>
                                                <span>{{ $art->is_featured ? 'Utama' : 'Biasa' }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.82rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                        <span title="Total Tayangan"><i class="fa-regular fa-eye" style="color: var(--adm-text-muted); margin-right: 3px;"></i>{{ number_format($art->views_count) }} Tayangan</span>
                                    </div>
                                    <div style="font-size: 0.72rem; color: var(--adm-text-muted); margin-top: 2px;">
                                        {{ $art->read_time ?? '5 menit' }}
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 0.35rem;">
                                        <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="btn btn-secondary btn-icon" title="Lihat di Website Publik">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $art) }}" class="btn btn-primary btn-icon" title="Edit Berita">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $art) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-icon" title="Hapus Berita">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem 1rem;">
                                    <i class="fa-regular fa-folder-open" style="font-size: 2.5rem; color: #cbd5e1; display: block; margin-bottom: 0.75rem;"></i>
                                    <div style="font-weight: 600; color: var(--adm-text-main);">Belum ada berita yang diterbitkan</div>
                                    <p style="font-size: 0.82rem; color: var(--adm-text-muted); margin-top: 0.25rem;">
                                        Mulai unggah artikel, berita kegiatan, atau warta pesantren sekarang.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Touch-Friendly Card List (Phone Only) -->
            <div class="mobile-only-cards">
                @forelse($articles as $art)
                    <div class="mobile-card">
                        <div style="display: flex; gap: 0.75rem; align-items: flex-start;">
                            <img src="{{ (str_starts_with($art->image, 'http') || str_starts_with($art->image, '/')) ? $art->image : asset($art->image) }}" alt="{{ $art->title }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 10px; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div style="flex: 1; min-width: 0;">
                                <a href="{{ route('admin.articles.edit', $art) }}" style="font-weight: 700; font-size: 0.92rem; color: var(--adm-text-main); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.35;">
                                    {{ $art->title }}
                                </a>
                                <div style="display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; margin-top: 0.35rem;">
                                    <span class="badge" style="background-color: {{ $art->badge_color ?? '#0f8528' }}20; color: {{ $art->badge_color ?? '#0f8528' }}; font-size: 0.7rem; padding: 0.15rem 0.45rem;">
                                        {{ $art->category }}
                                    </span>
                                    <span style="font-size: 0.72rem; color: var(--adm-text-muted);">
                                        <i class="fa-regular fa-eye"></i> {{ number_format($art->views_count) }}
                                    </span>
                                    <span style="font-size: 0.72rem; color: var(--adm-text-muted);">
                                        {{ $art->date ?? 'Baru' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mobile-card-footer" style="margin-top: 0.75rem; padding-top: 0.65rem; border-top: 1px solid var(--adm-border);">
                            <form action="{{ route('admin.articles.toggle-publish', $art) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $art->is_published ? 'btn-success' : 'btn-secondary' }}" style="width: 100%; justify-content: center; font-size: 0.75rem;">
                                    <i class="fa-solid {{ $art->is_published ? 'fa-check' : 'fa-clock' }}"></i>
                                    <span>{{ $art->is_published ? 'Terbit' : 'Draft' }}</span>
                                </button>
                            </form>

                            <a href="{{ route('article.show', $art->slug) }}" target="_blank" class="btn btn-secondary btn-icon" title="Lihat">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>

                            <a href="{{ route('admin.articles.edit', $art) }}" class="btn btn-primary btn-sm" style="justify-content: center;" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('admin.articles.destroy', $art) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="padding: 2.5rem 1rem; text-align: center; color: var(--adm-text-muted);">
                        <i class="fa-regular fa-folder-open" style="font-size: 2rem; color: #cbd5e1; display: block; margin-bottom: 0.5rem;"></i>
                        Belum ada berita yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>

        @if($articles->hasPages())
            <div class="adm-card-footer">
                <div style="font-size: 0.82rem; color: var(--adm-text-muted);">
                    Menampilkan {{ $articles->firstItem() }} - {{ $articles->lastItem() }} dari {{ $articles->total() }} berita
                </div>
                <div>
                    {{ $articles->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
