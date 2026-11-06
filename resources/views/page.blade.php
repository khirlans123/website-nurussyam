@extends('layouts.app')

@section('title', $pageTitle . ' - Pondok Pesantren Nurus Syam')

@section('content')
<div class="layout-grid">
    <div class="content-left">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}">Home</a>
            <span class="bc-sep">›</span>
            @if(in_array($slug, ['berdirinya-pesantren', 'gagasan-dan-cita-cita', 'kepemimpinan-generasi-pertama', 'kepemimpinan-generasi-kedua']))
                <a href="{{ route('page.show', 'berdirinya-pesantren') }}">Nurus Syam</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['sejarah', 'biografi-pendiri']))
                <a href="{{ route('page.show', 'sejarah') }}">Sejarah</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['pendiri']))
                <a href="{{ route('page.show', 'pendiri') }}">Pendiri</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['pengasuh-kh-sanusi-syam', 'pengasuh-kh-abdul-malik-sanusi']))
                <a href="{{ route('page.show', 'pengasuh-kh-sanusi-syam') }}">Pengasuh</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['motto', 'panca-jangka', 'panca-jiwa']))
                <a href="{{ route('page.show', 'visi-misi') }}">Visi Misi</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['madrasah-diniyah', 'kegiatan-ekstrakurikuler']))
                <a href="{{ route('page.show', 'madrasah-diniyah') }}">Pendidikan</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['lembaga', 'profil']))
                <a href="{{ route('page.show', 'profil') }}">Profil</a>
                <span class="bc-sep">›</span>
            @elseif(in_array($slug, ['mts-nurussyam', 'ma-nurussyam', 'sekolah']))
                <a href="{{ route('page.show', 'sekolah') }}">Sekolah</a>
                <span class="bc-sep">›</span>
            @endif
            <span class="breadcrumb-current">{{ $pageTitle }}</span>
        </nav>

        <div class="info-page-card">
            <div style="border-bottom:2px solid var(--primary-green); padding-bottom:14px; margin-bottom:20px;">
                <span class="badge-overlay badge-catatan" style="display:inline-block; margin-bottom:8px;">
                    INFORMASI RESMI
                </span>
                <h1 class="article-title-heading">
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b; font-size:0.92rem; margin-top:6px;">
                    Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso
                </p>
            </div>

            @if(in_array($slug, [
                'berdirinya-pesantren', 
                'gagasan-dan-cita-cita', 
                'kepemimpinan-generasi-pertama', 
                'kepemimpinan-generasi-kedua', 
                'sejarah', 
                'biografi-pendiri', 
                'pendiri',
                'pengasuh-kh-sanusi-syam', 
                'pengasuh-kh-abdul-malik-sanusi',
                'lembaga',
                'visi-misi',
                'madrasah-diniyah',
                'kegiatan-ekstrakurikuler',
                'sekolah',
                'mts-nurussyam',
                'ma-nurussyam'
            ]))
                <div style="text-align:center; padding:60px 24px; background:#f8fafc; border:1px dashed #cbd5e1; border-radius:10px; margin:24px 0;">
                    <div style="width:64px; height:64px; border-radius:50%; background:#f1f5f9; display:inline-flex; align-items:center; justify-content:center; margin-bottom:16px;">
                        <i class="fa-solid fa-file-pen" style="font-size:1.8rem; color:#64748b;"></i>
                    </div>
                    <h3 style="font-size:1.2rem; font-weight:700; color:#1e293b; margin-bottom:8px;">
                        Konten Sedang Dalam Proses Penyusunan
                    </h3>
                    <p style="color:#64748b; font-size:0.95rem; line-height:1.6; max-width:480px; margin:0 auto;">
                        Informasi resmi mengenai <strong>{{ $pageTitle }}</strong> saat ini sedang dalam proses penyusunan dan akan segera diperbarui.
                    </p>
                </div>

            @elseif($slug === 'motto')

                <div style="line-height:1.85; color:#334155; font-size:1.02rem;">
                    <div style="border-radius:4px; overflow:hidden; margin-bottom:20px; box-shadow:0 3px 12px rgba(0,0,0,0.12);">
                        <img src="{{ asset('images/article2.jpg') }}" alt="Motto Pondok Pesantren Nurus Syam" style="width:100%; height:auto; max-height:480px; object-fit:cover; display:block;" loading="lazy" decoding="async">
                    </div>

                    <h3 style="font-size:1.3rem; font-weight:800; color:#0f172a; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;">
                        MOTTO PONDOK PESANTREN NURUS SYAM
                    </h3>

                    <p style="margin-bottom:18px;">
                        Motto Pondok Pesantren Nurus Syam merupakan kristalisasi falsafah pendidikan yang menjadi orientasi seluruh santri, guru, dan pengasuh dalam menjalani setiap derap langkah kehidupan di pesantren:
                    </p>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:18px; margin:24px 0;">
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <div style="font-size:1.6rem; color:var(--primary-green); margin-bottom:8px;"><i class="fa-solid fa-heart"></i></div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#15803d; margin-bottom:6px;">1. Berbudi Tinggi</h4>
                            <p style="font-size:0.94rem; margin:0; color:#334155;">Menjunjung tinggi akhlakul karimah, ketawadhu'an, kejujuran, dan sopan santun kepada siapapun, di manapun, dan kapanpun.</p>
                        </div>

                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <div style="font-size:1.6rem; color:var(--primary-green); margin-bottom:8px;"><i class="fa-solid fa-dumbbell"></i></div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#15803d; margin-bottom:6px;">2. Berbadan Sehat</h4>
                            <p style="font-size:0.94rem; margin:0; color:#334155;">Jasmani yang kuat, bersih, dan prima sebagai sarana penunjang kekhusyukan ibadah dan ketangguhan dalam menuntut ilmu.</p>
                        </div>

                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <div style="font-size:1.6rem; color:var(--primary-green); margin-bottom:8px;"><i class="fa-solid fa-book-quran"></i></div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#15803d; margin-bottom:6px;">3. Berpengetahuan Luas</h4>
                            <p style="font-size:0.94rem; margin:0; color:#334155;">Mendalami kitab turats ulama salaf, menguasai ilmu pengetahuan kontemporer, teknologi informasi, dan bahasa peradaban dunia.</p>
                        </div>

                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <div style="font-size:1.6rem; color:var(--primary-green); margin-bottom:8px;"><i class="fa-solid fa-lightbulb"></i></div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#15803d; margin-bottom:6px;">4. Berpikiran Bebas</h4>
                            <p style="font-size:0.94rem; margin:0; color:#334155;">Kemandirian berpikir yang matang, kritis, dan berjiwa besar dalam kerangka syariat Islam Ahlussunnah wal Jama'ah.</p>
                        </div>

                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.04); grid-column: 1 / -1;">
                            <div style="font-size:1.6rem; color:var(--primary-green); margin-bottom:8px;"><i class="fa-solid fa-hand-holding-heart"></i></div>
                            <h4 style="font-size:1.15rem; font-weight:800; color:#15803d; margin-bottom:6px;">5. Ikhlas Beramal</h4>
                            <p style="font-size:0.94rem; margin:0; color:#334155;">Segala karya, pengabdian, dan kegiatan santri didasari semata-mata mengharap ridha Allah SWT tanpa pamrih keduniawian.</p>
                        </div>
                    </div>
                </div>

            @elseif($slug === 'panca-jiwa')
                <div style="line-height:1.85; color:#334155; font-size:1.02rem;">
                    <h3 style="font-size:1.4rem; font-weight:800; color:#0f172a; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;">
                        PANCA JIWA PONDOK PESANTREN NURUS SYAM
                    </h3>

                    <p style="margin-bottom:16px;">
                        Seluruh kehidupan di Pondok Pesantren didasarkan pada nilai-nilai yang dijiwai oleh suasana yang dapat disimpulkan dalam <strong>Panca Jiwa</strong>.
                    </p>

                    <p style="margin-bottom:20px;">
                        Panca Jiwa adalah lima prinsip luhur yang menjadi intisari kehidupan santri Pondok Pesantren Nurus Syam:
                    </p>

                    <div style="display:flex; flex-direction:column; gap:20px; margin-bottom:24px;">
                        <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:5px solid var(--primary-green); padding:18px 22px; border-radius:0 8px 8px 0; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <h4 style="font-size:1.18rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">
                                1. Jiwa Keikhlasan
                            </h4>
                            <p style="margin:0; line-height:1.8;">
                                Jiwa ini berarti <em>sepi ing pamrih</em>, yakni berbuat sesuatu bukan karena didorong oleh keinginan untuk mendapatkan keuntungan materi tertentu. Segala perbuatan dilakukan dengan semata-mata untuk ibadah lillahi ta'ala. Kiai ikhlas mendidik para pembantu kiai ikhlas mendampingi, dan santri ikhlas dididik dan ditempa demi meraih ridha Allah SWT.
                            </p>
                        </div>

                        <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:5px solid var(--primary-green); padding:18px 22px; border-radius:0 8px 8px 0; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <h4 style="font-size:1.18rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">
                                2. Jiwa Kesederhanaan
                            </h4>
                            <p style="margin:0; line-height:1.8;">
                                Kesederhanaan bukan berarti kemiskinan atau kepapaan, melainkan sikap hidup bersahaja, wajar, tidak bermegah-megahan, dan mampu menahan hawa nafsu. Di dalam kesederhanaan itulah bersemayam keagungan jiwa, ketabahan mental, dan keberanian menghadapi badai kehidupan.
                            </p>
                        </div>

                        <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:5px solid var(--primary-green); padding:18px 22px; border-radius:0 8px 8px 0; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <h4 style="font-size:1.18rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">
                                3. Jiwa Berdikari (Kemandirian)
                            </h4>
                            <p style="margin:0; line-height:1.8;">
                                Kesanggupan menolong dirinya sendiri dan tidak menggantungkan nasib kepada belas kasihan orang lain. Santri dididik mampu mencuci, merawat diri, mengatur keuangan, dan mengelola permasalahan hidupnya sendiri dengan penuh rasa tanggung jawab.
                            </p>
                        </div>

                        <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:5px solid var(--primary-green); padding:18px 22px; border-radius:0 8px 8px 0; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <h4 style="font-size:1.18rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">
                                4. Jiwa Ukhuwah Islamiyah
                            </h4>
                            <p style="margin:0; line-height:1.8;">
                                Suasana persaudaraan intim yang menyatukan para santri dari berbagai latar belakang suku, bahasa, dan daerah. Senang dirasakan bersama, susah ditanggung bersama, saling menolong dalam kebaikan, dan mengikat tali silaturahim sepanjang hayat.
                            </p>
                        </div>

                        <div style="background:#ffffff; border:1px solid #e2e8f0; border-left:5px solid var(--primary-green); padding:18px 22px; border-radius:0 8px 8px 0; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                            <h4 style="font-size:1.18rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">
                                5. Jiwa Bebas
                            </h4>
                            <p style="margin:0; line-height:1.8;">
                                Bebas dalam berpikir, bebas dalam berijtihad, dan bebas dalam menentukan masa depan dengan tetap berpijak kokoh di atas koridor syariat Islam dan akhlakul karimah. Santri tidak kerdil pemikirannya dan tidak sempit pandangannya.
                            </p>
                        </div>
                    </div>
                </div>

            @elseif($slug === 'panca-jangka')
                <div style="line-height:1.85; color:#334155; font-size:1.02rem;">
                    <div style="border-radius:4px; overflow:hidden; margin-bottom:20px; box-shadow:0 3px 12px rgba(0,0,0,0.12);">
                        <img src="{{ asset('images/sejarah_berdirinya.jpg') }}" alt="Panca Jangka Pesantren" style="width:100%; height:auto; max-height:480px; object-fit:cover; display:block;" loading="lazy" decoding="async">
                    </div>

                    <h3 style="font-size:1.3rem; font-weight:800; color:#0f172a; margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;">
                        PANCA JANGKA PONDOK PESANTREN NURUS SYAM
                    </h3>

                    <p style="margin-bottom:18px;">
                        Panca Jangka adalah lima program strategis jangka panjang yang menjadi kompas pengembangan Pondok Pesantren Nurus Syam dalam mewujudkan lembaga pendidikan Islam yang mandiri, bermartabat, dan unggul:
                    </p>

                    <div style="display:flex; flex-direction:column; gap:16px; margin:20px 0 24px;">
                        <div style="background:#f8fafc; border-left:4px solid var(--primary-green); padding:16px 20px; border-radius:0 6px 6px 0;">
                            <strong style="color:var(--primary-green); font-size:1.08rem; display:block; margin-bottom:4px;">1. Peningkatan Kualitas Pendidikan dan Pengajaran</strong>
                            <span>Penguatan kurikulum salafiyah, modernisasi metode pengajaran, serta pembinaan kompetensi keilmuan para dewan asatidz dan santri.</span>
                        </div>

                        <div style="background:#f8fafc; border-left:4px solid var(--primary-green); padding:16px 20px; border-radius:0 6px 6px 0;">
                            <strong style="color:var(--primary-green); font-size:1.08rem; display:block; margin-bottom:4px;">2. Penyempurnaan Sarana dan Prasarana</strong>
                            <span>Pembangunan dan penataan fasilitas asrama yang higienis, masjid yang representatif, perpustakaan kutubut turats, laboratorium, serta fasilitas olahraga santri.</span>
                        </div>

                        <div style="background:#f8fafc; border-left:4px solid var(--primary-green); padding:16px 20px; border-radius:0 6px 6px 0;">
                            <strong style="color:var(--primary-green); font-size:1.08rem; display:block; margin-bottom:4px;">3. Kaderisasi Sumber Daya Insani</strong>
                            <span>Mempersiapkan kader-kader ulama, pemimpin masyarakat, dan tenaga pendidik penerus yang tangguh, istiqamah, dan berakhlakul karimah.</span>
                        </div>

                        <div style="background:#f8fafc; border-left:4px solid var(--primary-green); padding:16px 20px; border-radius:0 6px 6px 0;">
                            <strong style="color:var(--primary-green); font-size:1.08rem; display:block; margin-bottom:4px;">4. Kemandirian Finansial & Pembiayaan</strong>
                            <span>Mengembangkan unit-unit usaha produktif, koperasi pondok pesantren, dan pendayagunaan wakaf demi menjamin keberlanjutan pembiayaan operasional pesantren.</span>
                        </div>

                        <div style="background:#f8fafc; border-left:4px solid var(--primary-green); padding:16px 20px; border-radius:0 6px 6px 0;">
                            <strong style="color:var(--primary-green); font-size:1.08rem; display:block; margin-bottom:4px;">5. Kesejahteraan Keluarga Besar Pondok & Pengabdian Masyarakat</strong>
                            <span>Meningkatkan taraf kesejahteraan para asatidz, pengurus, serta senantiasa aktif memberikan sumbangsih nyata dalam dakwah sosial keagamaan di tengah umat.</span>
                        </div>
                    </div>
                </div>
            @elseif($slug === 'profil')
                <div style="line-height:1.85; color:#334155; font-size:1rem;">
                    <img src="{{ asset('images/article1.jpg') }}" alt="Profil Pesantren" style="width:100%; border-radius:4px; margin-bottom:20px;" loading="lazy" decoding="async">
                    <h3 style="font-size:1.2rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">Visi</h3>
                    <p style="margin-bottom:18px;">
                        "Menjadi lembaga pendidikan pesantren yang mencetak generasi tafaqquh fiddin, mandiri, berwawasan global, dan berakhlaq mulia."
                    </p>
                    <h3 style="font-size:1.2rem; font-weight:800; color:var(--primary-green); margin-bottom:8px;">Misi</h3>
                    <ul style="list-style:disc; margin-left:22px; margin-bottom:20px;">
                        <li>Menyelenggarakan pendidikan kitab kuning (turats) berjenjang dan terintegrasi kurikulum formal.</li>
                        <li>Membiasakan amaliah Ahlussunnah wal Jama'ah dalam kehidupan sehari-hari santri.</li>
                        <li>Membekali santri dengan kecakapan berbahasa, sains, kepemimpinan, dan kemandirian.</li>
                    </ul>
                </div>
            @elseif($slug === 'alumni')
                <div style="line-height:1.85; color:#334155; font-size:1rem;">
                    <img src="{{ asset('images/sidebar1.jpg') }}" alt="Alumni Nurus Syam" style="width:100%; border-radius:4px; margin-bottom:20px;" loading="lazy" decoding="async">
                    <p style="margin-bottom:16px;">
                        Ikatan Alumni Pondok Pesantren Nurus Syam menghimpun ribuan santri yang kini tersebar di berbagai sektor kehidupan, baik sebagai pengasuh pesantren, pendidik, birokrat, maupun wirausahawan muslim di berbagai daerah di Indonesia.
                    </p>
                </div>
            @elseif($slug === 'laziswaf')
                <div style="line-height:1.85; color:#334155; font-size:1rem;">
                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:18px; border-radius:6px; margin-bottom:20px;">
                        <h3 style="color:#15803d; font-size:1.15rem; font-weight:800; margin-bottom:8px;">
                            LAZISWAF NURUS SYAM
                        </h3>
                        <p style="margin:0; font-size:0.92rem;">
                            Menyalurkan dana zakat, infaq, shadaqah, dan wakaf produktif secara transparan untuk beasiswa santri dan pembangunan fasilitas asrama pondok.
                        </p>
                    </div>
                </div>
            @elseif($slug === 'galeri')
                <div class="gallery-page-wrap" style="margin-top: 15px;">
                    <!-- Filter Tabs -->
                    @php
                        $galCategories = isset($galleryItems) ? $galleryItems->pluck('category')->filter()->unique()->values() : collect();
                    @endphp
                    @if($galCategories->count() > 1)
                        <div class="gallery-filter-bar" style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0;">
                            <button type="button" class="gallery-filter-btn active" onclick="filterGallery('all', this)" style="background: var(--primary-green); color: #fff; border: none; padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
                                Semua Foto ({{ isset($galleryItems) ? $galleryItems->count() : 0 }})
                            </button>
                            @foreach($galCategories as $gCat)
                                <button type="button" class="gallery-filter-btn" onclick="filterGallery('{{ Str::slug($gCat) }}', this)" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 6px 14px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; cursor: pointer; transition: all 0.2s ease;">
                                    {{ $gCat }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Grid Galeri Foto -->
                    <div class="gallery-grid" id="galleryGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 22px;">
                        @forelse($galleryItems ?? [] as $index => $item)
                            <div class="gallery-card-item" data-category="{{ Str::slug($item['category'] ?? 'santri') }}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: transform 0.25s ease, box-shadow 0.25s ease;">
                                <!-- Image with click to view lightbox -->
                                <div class="gallery-img-container" style="position: relative; width: 100%; height: 210px; overflow: hidden; cursor: pointer; background: #0f172a;" onclick="openGalleryLightbox({{ $index }})" title="Klik untuk memperbesar foto">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.35s ease;" class="gallery-zoom-img" loading="lazy">
                                    <div class="gallery-img-overlay" style="position: absolute; inset: 0; background: rgba(3, 35, 14, 0.4); opacity: 0; transition: opacity 0.25s ease; display: flex; align-items: center; justify-content: center; color: #fff;">
                                        <span style="background: rgba(0,0,0,0.65); padding: 8px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i> Lihat Foto
                                        </span>
                                    </div>
                                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(15, 133, 40, 0.9); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 3px 9px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); text-transform: uppercase;">
                                        {{ $item['category'] ?? 'Galeri' }}
                                    </span>
                                </div>

                                <!-- Photo Title Only (Tanpa Isi Berita) -->
                                <div style="padding: 14px 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                    <h4 style="font-size: 0.96rem; font-weight: 700; color: #0f172a; line-height: 1.45; margin: 0 0 8px; cursor: pointer;" onclick="openGalleryLightbox({{ $index }})">
                                        {{ $item['title'] }}
                                    </h4>
                                    @if(!empty($item['date']))
                                        <div style="font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 5px; margin-top: auto;">
                                            <i class="fa-regular fa-calendar-days" style="color: var(--primary-green);"></i>
                                            <span>{{ $item['date'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 40px 15px; background: #f8fafc; border-radius: 8px; border: 1.5px dashed #cbd5e1;">
                                <i class="fa-regular fa-images" style="font-size: 2.5rem; color: #94a3b8; margin-bottom: 10px; display: block;"></i>
                                <h4 style="font-weight: 700; color: #334155; margin-bottom: 4px;">Belum Ada Foto di Galeri</h4>
                                <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Foto kegiatan pesantren akan tampil di sini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Lightbox Modal Fullscreen -->
                <div id="galleryLightboxModal" style="display: none; position: fixed; inset: 0; z-index: 99999999; background: rgba(3, 15, 8, 0.94); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); flex-direction: column; align-items: center; justify-content: center; padding: 20px;" onclick="closeGalleryLightboxOnBackdrop(event)">
                    <!-- Close button -->
                    <button type="button" onclick="closeGalleryLightbox()" style="position: absolute; top: 20px; right: 25px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; font-size: 1.4rem; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Tutup (Esc)">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Nav prev/next buttons -->
                    <button type="button" onclick="changeGalleryLightbox(-1)" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; font-size: 1.3rem; width: 46px; height: 46px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Foto Sebelumnya">
                        <i class="fa-solid fa-angle-left"></i>
                    </button>
                    <button type="button" onclick="changeGalleryLightbox(1)" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: #fff; font-size: 1.3rem; width: 46px; height: 46px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Foto Berikutnya">
                        <i class="fa-solid fa-angle-right"></i>
                    </button>

                    <!-- Image Display Area -->
                    <div style="max-width: 90vw; max-height: 75vh; display: flex; align-items: center; justify-content: center; margin-bottom: 14px;">
                        <img id="lightboxImg" src="" alt="" style="max-width: 100%; max-height: 75vh; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.6);">
                    </div>

                    <!-- Caption & Meta -->
                    <div style="text-align: center; max-width: 700px; color: #fff; padding: 0 15px;">
                        <span id="lightboxCategory" style="display: inline-block; background: var(--primary-green); color: #fff; font-size: 0.75rem; font-weight: 700; padding: 2px 10px; border-radius: 12px; margin-bottom: 6px; text-transform: uppercase;"></span>
                        <h3 id="lightboxTitle" style="font-size: 1.1rem; font-weight: 800; margin: 0 0 4px; line-height: 1.4; color: #ffffff;"></h3>
                        <p id="lightboxDate" style="font-size: 0.8rem; color: #94a3b8; margin: 0;"></p>
                    </div>
                </div>

                <style>
                    .gallery-img-container:hover .gallery-zoom-img {
                        transform: scale(1.06);
                    }
                    .gallery-img-container:hover .gallery-img-overlay {
                        opacity: 1 !important;
                    }
                    .gallery-card-item:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 10px 24px rgba(0,0,0,0.1) !important;
                    }
                </style>

                <script>
                    const galleryData = @json(isset($galleryItems) ? $galleryItems->values() : []);
                    let currentLightboxIdx = 0;

                    function filterGallery(categorySlug, btn) {
                        document.querySelectorAll('.gallery-filter-btn').forEach(b => {
                            b.style.background = '#f1f5f9';
                            b.style.color = '#475569';
                            b.style.border = '1px solid #e2e8f0';
                        });
                        btn.style.background = 'var(--primary-green)';
                        btn.style.color = '#fff';
                        btn.style.border = 'none';

                        const items = document.querySelectorAll('.gallery-card-item');
                        items.forEach(card => {
                            if (categorySlug === 'all' || card.getAttribute('data-category') === categorySlug) {
                                card.style.display = 'flex';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    }

                    function openGalleryLightbox(idx) {
                        if (!galleryData[idx]) return;
                        currentLightboxIdx = idx;
                        updateLightboxContent();
                        const modal = document.getElementById('galleryLightboxModal');
                        modal.style.display = 'flex';
                        document.body.style.overflow = 'hidden';
                    }

                    function updateLightboxContent() {
                        const item = galleryData[currentLightboxIdx];
                        if (!item) return;
                        document.getElementById('lightboxImg').src = item.image;
                        document.getElementById('lightboxTitle').textContent = item.title;
                        document.getElementById('lightboxCategory').textContent = item.category || 'Galeri';
                        document.getElementById('lightboxDate').textContent = item.date ? 'Dokumentasi: ' + item.date : '';
                    }

                    function changeGalleryLightbox(direction) {
                        currentLightboxIdx += direction;
                        if (currentLightboxIdx < 0) currentLightboxIdx = galleryData.length - 1;
                        if (currentLightboxIdx >= galleryData.length) currentLightboxIdx = 0;
                        updateLightboxContent();
                    }

                    function closeGalleryLightbox() {
                        const modal = document.getElementById('galleryLightboxModal');
                        modal.style.display = 'none';
                        document.body.style.overflow = '';
                    }

                    function closeGalleryLightboxOnBackdrop(e) {
                        if (e.target.id === 'galleryLightboxModal') {
                            closeGalleryLightbox();
                        }
                    }

                    window.addEventListener('keydown', function(e) {
                        const modal = document.getElementById('galleryLightboxModal');
                        if (modal && modal.style.display === 'flex') {
                            if (e.key === 'Escape') closeGalleryLightbox();
                            if (e.key === 'ArrowLeft') changeGalleryLightbox(-1);
                            if (e.key === 'ArrowRight') changeGalleryLightbox(1);
                        }
                    });
                </script>
            @else
                <div style="line-height:1.85; color:#334155; font-size:1rem;">
                    <p style="margin-bottom:14px;">
                        Sekretariat Pondok Pesantren Nurus Syam:
                    </p>
                    <ul style="list-style:none; padding:0; line-height:2.1;">
                        <li><i class="fa-solid fa-location-dot" style="color:var(--primary-green); width:24px;"></i> Wringin Arak arak, Kabupaten Bondowoso, Jawa Timur</li>
                        <li><i class="fa-solid fa-phone" style="color:var(--primary-green); width:24px;"></i> +62 812-3456-7890 (Call / WhatsApp)</li>
                        <li><i class="fa-solid fa-envelope" style="color:var(--primary-green); width:24px;"></i> admin@nurussyam.ponpes.id</li>
                    </ul>
                </div>
            @endif

            <div style="margin-top:24px;">
                <a href="{{ route('home') }}" style="color:var(--primary-green); font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
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
                @if(!empty($sidebar_news) && count($sidebar_news) > 0)
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
                @else
                <div style="padding: 24px 14px; text-align: center; color: #94a3b8; font-size: 0.86rem;">
                    <i class="fa-regular fa-folder-open" style="font-size: 1.4rem; margin-bottom: 6px; display: block; color: #cbd5e1;"></i>
                    Belum ada berita terkini.
                </div>
                @endif
            </div>
        </div>
    </aside>
</div>
@endsection
