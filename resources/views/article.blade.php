@extends('layouts.app')

@section('title', $article['title'] . ' - Pondok Pesantren Nurus Syam')
@section('og_title', $article['title'])
@section('og_description', !empty($article['summary']) ? $article['summary'] : \Illuminate\Support\Str::limit(strip_tags($article['content'] ?? ''), 160))
@section('og_image', $article['image'])
@section('og_type', 'article')
@section('og_author', $article['author'] ?? 'Admin Nurus Syam')

@section('extra_meta')
    <meta property="article:published_time" content="{{ isset($article['created_at']) && $article['created_at'] ? \Carbon\Carbon::parse($article['created_at'])->toIso8601String() : '' }}">
    <meta property="article:section" content="{{ $article['category'] ?? 'Berita' }}">
    <meta property="article:author" content="{{ $article['author'] ?? 'Admin Nurus Syam' }}">
@endsection

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <article class="article-single-post">
            <!-- Breadcrumb: Home › Category -->
            <nav class="article-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="bc-sep">›</span>
                <a href="{{ route('category.show', strtolower($article['category'])) }}">{{ ucfirst(strtolower($article['category'])) }}</a>
            </nav>

            <!-- Category Badge -->
            <div class="article-badge-wrap">
                <span class="article-cat-badge">
                    {{ ucfirst(strtolower($article['category'])) }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="article-headline">
                {{ $article['title'] }}
            </h1>

            <!-- Meta: Date & Time on Left, Stats on Right -->
            <div class="article-meta-line">
                <span class="meta-date">
                    <i class="fa-regular fa-calendar-days" style="margin-right: 4px; color: var(--primary-green);"></i> {{ $article['date'] }}
                    @if(!empty($article['activity_time']))
                        <span style="margin: 0 6px; opacity: 0.35;">•</span>
                        <i class="fa-regular fa-clock" style="margin-right: 4px; color: var(--primary-green);"></i> <strong>{{ $article['activity_time'] }}</strong>
                    @endif
                </span>
                <div class="meta-stats">
                    <span class="stat-item" title="Jumlah Pembaca"><i class="fa-regular fa-eye"></i> {{ number_format($article['views_count'] ?? 1) }} Views</span>
                </div>
            </div>

            <!-- Social Share Buttons Row (TikTok, WA Saluran, Instagram, YouTube) -->
            <div class="article-social-shares">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . "\n\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-wa" aria-label="Bagikan ke WhatsApp / Saluran WA" title="Bagikan ke WhatsApp / Saluran WA">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="{{ $social_stats['tiktok']['url'] ?? 'https://www.tiktok.com/@ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-tiktok" onclick="copyArticleShareLink(event, 'TikTok')" aria-label="TikTok Pondok Pesantren Nurussyam" title="Salin Tautan Berita & Buka TikTok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="{{ $social_stats['instagram']['url'] ?? 'https://www.instagram.com/ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-ig" onclick="copyArticleShareLink(event, 'Instagram')" aria-label="Instagram Pondok Pesantren Nurussyam" title="Salin Tautan Berita & Buka Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="{{ $social_stats['youtube']['url'] ?? 'https://www.youtube.com/@ppnurussyamofficial' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-yt" aria-label="YouTube Pondok Pesantren Nurussyam" title="Kunjungi Saluran YouTube Resmi">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>

            <!-- Main Featured Image -->
            <div class="article-main-image-wrap">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="article-main-img">
            </div>

            <!-- Article Body -->
            <div class="article-body-content">
                @if(!empty($article['content']))
                    {!! \App\Models\Article::formatContent($article['content']) !!}
                @elseif(!empty($article['summary']))
                    {!! \App\Models\Article::formatContent($article['summary']) !!}
                @endif
            </div>

            <!-- Bagikan Artikel (Bawah Konten) -->
            <div class="article-share-footer" style="margin-top: 30px; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #1e293b; font-size: 0.92rem;">
                    <i class="fa-solid fa-share-nodes" style="color: var(--primary-green);"></i>
                    <span>Bagikan berita ini:</span>
                </div>
                <div class="article-social-shares" style="margin-bottom: 0;">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . "\n\n" . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-wa" aria-label="Bagikan ke WhatsApp / Saluran WA" title="Bagikan ke WhatsApp / Saluran WA">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="{{ $social_stats['tiktok']['url'] ?? 'https://www.tiktok.com/@ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-tiktok" onclick="copyArticleShareLink(event, 'TikTok')" aria-label="TikTok Pondok Pesantren Nurussyam" title="Salin Tautan Berita & Buka TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                    <a href="{{ $social_stats['instagram']['url'] ?? 'https://www.instagram.com/ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-ig" onclick="copyArticleShareLink(event, 'Instagram')" aria-label="Instagram Pondok Pesantren Nurussyam" title="Salin Tautan Berita & Buka Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="{{ $social_stats['youtube']['url'] ?? 'https://www.youtube.com/@ppnurussyamofficial' }}" target="_blank" rel="noopener noreferrer" class="social-share-btn share-yt" aria-label="YouTube Pondok Pesantren Nurussyam" title="Kunjungi Saluran YouTube Resmi">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </article>
    </div>

    <!-- SIDEBAR KANAN -->
    <aside class="sidebar-wrapper">
        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text"><i class="fa-solid fa-share-nodes"></i> Sosial Media</h3>
            </div>
            <div class="widget-content">
                <div class="social-grid-2x2">
                    <a href="{{ $social_stats['whatsapp']['url'] ?? $social_stats['facebook']['url'] ?? 'https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f' }}" target="_blank" class="social-button btn-whatsapp" title="Saluran WhatsApp Resmi">
                        <div class="soc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['whatsapp']['raw_count'] ?? $social_stats['facebook']['raw_count'] ?? 1250 }}">0</span><span class="soc-label">{{ $social_stats['whatsapp']['label'] ?? 'Saluran WA' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['instagram']['url'] }}" target="_blank" class="social-button btn-instagram" title="Instagram">
                        <div class="soc-icon"><i class="fa-brands fa-instagram"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['instagram']['raw_count'] ?? 266 }}">0</span><span class="soc-label">{{ $social_stats['instagram']['label'] ?? 'Followers' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['tiktok']['url'] ?? 'https://www.tiktok.com/@ppnurussyam_official' }}" target="_blank" rel="noopener noreferrer" class="social-button btn-tiktok" title="TikTok">
                        <div class="soc-icon"><i class="fa-brands fa-tiktok"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['tiktok']['raw_count'] ?? 1364 }}">0</span><span class="soc-label">{{ $social_stats['tiktok']['label'] ?? 'Followers' }}</span></div>
                    </a>
                    <a href="{{ $social_stats['youtube']['url'] }}" target="_blank" class="social-button btn-youtube" title="YouTube">
                        <div class="soc-icon"><i class="fa-brands fa-youtube"></i></div>
                        <div class="soc-info"><span class="soc-count" data-target="{{ $social_stats['youtube']['raw_count'] ?? 500 }}">0</span><span class="soc-label">{{ $social_stats['youtube']['label'] ?? 'Subscribers' }}</span></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-widget">
            <div class="widget-head">
                <h3 class="widget-heading-text"><i class="fa-solid fa-bolt"></i> Berita Terkini</h3>
            </div>
            <div class="widget-content" style="padding-top:12px;">
                <div class="news-vertical-list">
                    @foreach($sidebar_news as $news)
                        <div class="news-vert-item">
                            <a href="{{ route('article.show', $news['slug']) }}" class="news-vert-thumb">
                                <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" loading="lazy" decoding="async">
                            </a>
                            <div class="news-vert-body">
                                <span class="news-vert-date">{{ $news['date'] }}</span>
                                <h4 class="news-vert-title">
                                    <a href="{{ route('article.show', $news['slug']) }}">{{ $news['title'] }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>
</div>

<script>
function copyArticleShareLink(e, platform) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(window.location.href);
        if (typeof showToast === 'function') {
            showToast('Tautan berita berhasil disalin! Membuka ' + platform + '...', 'success');
        }
    }
}
</script>
@endsection
