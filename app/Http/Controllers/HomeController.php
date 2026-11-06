<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\SocialStat;
use App\Models\SiteSetting;
use App\Models\Registration;
use App\Models\Donation;

class HomeController extends Controller
{
    /**
     * Get all articles and site data (loaded directly from MySQL database).
     */
    private function getData()
    {
        $articles = $this->loadArticles();
        $socialStats = $this->loadSocialStats();
        $siteSettings = $this->loadSiteSettings();

        $articlesList = array_values($articles);

        // Section Berita Terbaru: Artikel yang baru diunggah dalam batas waktu 1 hari (<= 24 jam)
        $newUploads = array_values(array_filter($articlesList, fn($a) => !empty($a['is_new_upload'])));

        // Featured Articles & Berita Terbaru:
        // Jika tidak ada berita sama sekali di database, kosongkan array murni (tanpa dummy)
        if (empty($articlesList)) {
            $featured_articles = [];
            $beritaLead = null;
            $beritaItems = [];
            $sidebar_news = [];
        } else {
            if (count($newUploads) >= 2) {
                $featured_articles = array_slice($newUploads, 0, 2);
            } else {
                $featured_articles = array_slice($articlesList, 0, 2);
            }

            if (!empty($newUploads)) {
                $beritaLead = $newUploads[0];
                $otherUploads = array_values(array_filter($articlesList, fn($a) => $a['slug'] !== $beritaLead['slug']));
                $beritaItems = array_slice($otherUploads, 0, 4);
            } else {
                $beritaLead = $articlesList[0];
                $beritaItems = count($articlesList) > 1 ? array_slice($articlesList, 1, 4) : [];
            }

            // Sidebar Berita Terkini: 5 berita terbaru dari database
            $sidebar_news = array_slice($articlesList, 0, 5);
        }

        // Section Catatan (Hanya tampil jika ada artikel yang diinput)
        $catatanMatches = array_values(array_filter($articlesList, function($a) {
            $cat = strtolower($a['base_category'] ?? $a['category'] ?? '');
            return str_contains($cat, 'catatan');
        }));
        $catatanSection = [
            'lead' => $catatanMatches[0] ?? null,
            'items' => array_slice($catatanMatches, 1, 4)
        ];

        // Section Alumni (Hanya tampil jika ada artikel berkategori Alumni)
        $alumniMatches = array_values(array_filter($articlesList, function($a) {
            $cat = strtolower($a['base_category'] ?? $a['category'] ?? '');
            return str_contains($cat, 'alumni');
        }));
        $alumniSection = [
            'lead' => $alumniMatches[0] ?? null,
            'items' => array_slice($alumniMatches, 1, 4)
        ];

        // Section Laziswaf & Donasi (Program & Rekening Resmi)
        $laziswafSection = [
            'donasi' => [
                'bank_mandiri' => $siteSettings['bank_mandiri'] ?? '143-00-2980022-2',
                'an_mandiri' => $siteSettings['an_mandiri'] ?? 'YYS PONPES NURUSSYAM',
                'bank_bsi' => $siteSettings['bank_bsi'] ?? '7143-0029-80',
                'an_bsi' => $siteSettings['an_bsi'] ?? 'LAZISWAF NURUSSYAM',
                'wa_confirm' => $siteSettings['wa_confirm'] ?? 'https://wa.me/6281234567890?text=Assalamu%27alaikum%20Admin%20LAZISWAF%20Nurussyam,%20saya%20ingin%20konfirmasi%20donasi/zakat',
                'phone' => $siteSettings['phone'] ?? '+62 812-3456-7890'
            ]
        ];

        return [
            'all_articles' => $articles,
            'featured_articles' => $featured_articles,
            'berita_terbaru' => [
                'lead' => $beritaLead,
                'items' => $beritaItems
            ],
            'catatan_section' => $catatanSection,
            'alumni_section' => $alumniSection,
            'laziswaf_section' => $laziswafSection,
            'sidebar_news' => $sidebar_news,
            'social_stats' => $socialStats,
            'prayer_times' => [
                'Subuh' => '04:12',
                'Terbit' => '05:28',
                'Dzuhur' => '11:32',
                'Ashar' => '14:45',
                'Maghrib' => '17:38',
                'Isya' => '18:49'
            ]
        ];
    }

    /**
     * Load articles from MySQL database with static fallback.
     */
    private function loadArticles()
    {
        try {
            $dbArticles = Article::with('categoryRel')->where('is_published', true)->orderBy('id', 'desc')->get();
            if ($dbArticles->isNotEmpty()) {
                $articles = [];
                foreach ($dbArticles as $row) {
                    // Cek batas waktu berita terbaru (1 hari / 24 jam setelah upload)
                    $uploadTime = $row->created_at ? \Carbon\Carbon::parse($row->created_at) : ($row->date ? \Carbon\Carbon::parse($row->date) : null);
                    $isNew = false;
                    if ($uploadTime) {
                        $isNew = $uploadTime->diffInHours(now()) <= 24;
                    }

                    // Kategori dasar masing-masing berita
                    $baseCategory = $row->categoryRel?->name ?? $row->category;
                    if (strtoupper($baseCategory) === 'BERITA TERBARU') {
                        $baseCategory = 'TERKINI';
                    }

                    // Jika masih dalam batas waktu 1 hari setelah upload, tampilkan badge BERITA TERBARU
                    // Setelah lewat 1 hari, otomatis masuk & kembali ke kategori masing-masing
                    $displayCategory = $isNew ? 'BERITA TERBARU' : $baseCategory;
                    
                    // Warna badge rapi persis baitularqom.id
                    $catNorm = strtoupper(trim($displayCategory));
                    if ($isNew || $catNorm === 'BERITA TERBARU' || $catNorm === 'TERKINI') {
                        $badgeColor = '#0284c7'; // Biru cerah persis baitularqom
                    } elseif ($catNorm === 'CATATAN') {
                        $badgeColor = '#222222'; // Hitam pekat persis baitularqom
                    } elseif ($catNorm === 'ALUMNI') {
                        $badgeColor = '#1e293b'; // Slate dark persis baitularqom
                    } elseif (!empty($row->badge_color)) {
                        $badgeColor = $row->badge_color;
                    } elseif (!empty($row->categoryRel?->color)) {
                        $badgeColor = $row->categoryRel->color;
                    } else {
                        $badgeColor = '#0284c7';
                    }

                    // Format tanggal rapi konsisten dalam bahasa Indonesia
                    try {
                        $rawDateVal = $row->date ?: ($row->created_at ? $row->created_at->format('Y-m-d') : now()->format('Y-m-d'));
                        $dateFormatted = \Carbon\Carbon::parse($rawDateVal)->locale('id')->translatedFormat('d F Y');
                    } catch (\Exception $e) {
                        $dateFormatted = $row->date ?: now()->format('d F Y');
                    }

                    $rawImg = $row->image ?? '';
                    if (!empty($rawImg)) {
                        if (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) {
                            $articleImage = $rawImg;
                        } else {
                            $articleImage = asset(ltrim($rawImg, '/'));
                        }
                    } else {
                        $articleImage = asset('images/logo-ppns.png');
                    }

                    $timeFormatted = !empty($row->activity_time)
                        ? $row->activity_time
                        : ($row->created_at ? $row->created_at->format('H:i') . ' WIB' : '08:00 WIB');

                    $articles[$row->slug] = [
                        'id' => $row->id,
                        'slug' => $row->slug,
                        'title' => $row->title,
                        'category' => $displayCategory,
                        'base_category' => $baseCategory,
                        'is_new_upload' => $isNew,
                        'author' => $row->author ?? 'admin',
                        'date' => $dateFormatted,
                        'activity_time' => $timeFormatted,
                        'time_ago' => $row->created_at ? $row->created_at->diffForHumans() : ($row->date ? \Carbon\Carbon::parse($row->date)->diffForHumans() : 'Baru saja'),
                        'formatted_date' => date('d F Y', strtotime($dateFormatted)),
                        'image' => $articleImage,
                        'badge_color' => $badgeColor,
                        'comments_count' => (int) ($row->comments_count ?? 0),
                        'views_count' => (int) ($row->views_count ?? 0),
                        'read_time' => $row->read_time ?? '5 menit baca',
                        'summary' => $row->summary,
                        'content' => Article::formatContent($row->content),
                        'created_at' => $row->created_at,
                    ];
                }
                return $articles;
            }
            return [];
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Error loading articles: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Load social stats from MySQL database with fallback.
     */
    private function loadSocialStats()
    {
        try {
            $stats = SocialStat::all();
            if ($stats->isNotEmpty()) {
                $res = [];
                foreach ($stats as $s) {
                    $res[$s->platform] = [
                        'name' => $s->name,
                        'count' => $s->count_formatted,
                        'raw_count' => (int) $s->raw_count,
                        'label' => $s->label,
                        'color' => $s->color,
                        'icon' => $s->icon,
                        'url' => $s->url,
                    ];
                }

                if (isset($res['whatsapp']) && !isset($res['facebook'])) {
                    $res['facebook'] = $res['whatsapp'];
                } elseif (isset($res['facebook']) && !isset($res['whatsapp'])) {
                    $res['whatsapp'] = $res['facebook'];
                }

                // Otomatis sinkronisasi pengikut setiap 1 jam jika ada kunjungan
                \Illuminate\Support\Facades\Cache::remember('social_auto_sync_interval', 3600, function() {
                    try {
                        \App\Services\SocialFollowerService::syncAll();
                    } catch (\Throwable $e) {}
                    return time();
                });

                return $res;
            }
        } catch (\Throwable $e) {
            // graceful fallback
        }

        $waData = [
            'name' => 'Saluran WhatsApp',
            'count' => '1,250',
            'raw_count' => 1250,
            'label' => 'Saluran WA',
            'color' => '#25D366',
            'icon' => 'fa-whatsapp',
            'url' => 'https://whatsapp.com/channel/0029VbAwbLkCMY0NUoymZd1f'
        ];

        return [
            'whatsapp' => $waData,
            'facebook' => $waData,
            'instagram' => [
                'name' => 'Instagram',
                'count' => '266',
                'raw_count' => 266,
                'label' => 'Followers',
                'color' => '#e1306c',
                'icon' => 'fa-instagram',
                'url' => 'https://www.instagram.com/ppnurussyam_official'
            ],
            'tiktok' => [
                'name' => 'TikTok',
                'count' => '1,364',
                'raw_count' => 1364,
                'label' => 'Followers',
                'color' => '#000000',
                'icon' => 'fa-tiktok',
                'url' => 'https://www.tiktok.com/@ppnurussyam_official'
            ],
            'youtube' => [
                'name' => 'YouTube',
                'count' => '500',
                'raw_count' => 500,
                'label' => 'Subscribers',
                'color' => '#ff0000',
                'icon' => 'fa-youtube',
                'url' => 'https://www.youtube.com/@ppnurussyamofficial'
            ]
        ];
    }

    /**
     * Load site settings from MySQL database with fallback.
     */
    private function loadSiteSettings()
    {
        $defaults = [
            'bank_mandiri' => '143-00-2980022-2',
            'an_mandiri' => 'YYS PONPES NURUSSYAM',
            'bank_bsi' => '7143-0029-80',
            'an_bsi' => 'LAZISWAF NURUSSYAM',
            'wa_confirm' => 'https://wa.me/6281234567890?text=Assalamu%27alaikum%20Admin%20LAZISWAF%20Nurussyam,%20saya%20ingin%20konfirmasi%20donasi/zakat',
            'phone' => '+62 812-3456-7890'
        ];

        try {
            $settings = SiteSetting::pluck('value', 'key')->toArray();
            return array_merge($defaults, $settings);
        } catch (\Throwable $e) {
            return $defaults;
        }
    }

    /**
     * Fallback static articles list
     */
    private function getStaticArticles()
    {
        return [
            'pesantren-tempat-membentuk-generasi-berilmu-dan-berakhlak' => [
                'id' => 1,
                'slug' => 'pesantren-tempat-membentuk-generasi-berilmu-dan-berakhlak',
                'title' => 'Pesantren: Tempat Membentuk Generasi Berilmu dan Berakhlak',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'October 16, 2026',
                'formatted_date' => '16 Oktober 2026',
                'image' => asset('images/article1.jpg'),
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Bondowoso- Pesantren merupakan salah satu wujud dari lembaga pendidikan yang sudah lama berkembang di tanah air. Dengan gaya asrama berdisiplin dan wajibnya anak didik mendalami ilmu agama serta akhlakul karimah, pesantren senantiasa menjadi benteng moral generasi muslim.',
                'content' => '<p><strong class="article-lead-green">Bondowoso- Pesantren</strong> merupakan salah satu wujud dari lembaga pendidikan yang sudah lama berkembang di tanah air. Dengan gaya asrama berdisiplin dan wajibnya anak didik mendalami ilmu agama serta akhlakul karimah, pesantren senantiasa menjadi benteng moral generasi muslim.</p><p>Di tengah pesatnya laju transformasi teknologi dan arus globalisasi yang tak terbendung, pesantren tetap teguh berdiri sebagai benteng moral dan spiritual umat. Kehidupan di Pondok Pesantren Nurussyam membiasakan para santri untuk senantiasa menyelaraskan antara ketajaman intelektual dengan kemurnian akhlakul karimah.</p><p>Melalui metode pembelajaran kitab kuning (turats) yang teruji selama berabad-abad, santri dididik memiliki sanad keilmuan yang bersambung langsung hingga baginda Rasulullah SAW. Tidak hanya menghafal teks, santri diajarkan metodologi berpikir kritis, tabayyun dalam menyikapi kabar, serta menjunjung tinggi adab di atas ilmu.</p><p>Sebagaimana nasihat masyhur dari para ulama salaf, ilmu tanpa adab laksana api tanpa kayu bakar. Di Nurussyam Wringin Arak arak Bondowoso, setiap detik hembusan nafas santri adalah madrasah kehidupan: mulai dari shalat tahajjud berjamaah, tilawah Al-Qur\'an di fajar hari, hingga mudzakarah ilmiah malam hari di bawah bimbingan para kiai dan ustadz tercinta.</p>'
            ],
            'panduan-memilih-pondok-pesantren-terbaik-di-bondowoso' => [
                'id' => 2,
                'slug' => 'panduan-memilih-pondok-pesantren-terbaik-di-bondowoso',
                'title' => 'Panduan Memilih Pondok Pesantren Terbaik di Bondowoso',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 14, 2026',
                'formatted_date' => '14 Oktober 2026',
                'image' => asset('images/article2.jpg'),
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'read_time' => '7 menit baca',
                'summary' => 'Memilih lembaga pendidikan pesantren yang tepat untuk buah hati memerlukan pertimbangan matang mengenai sanad keilmuan, integrasi kurikulum salaf dan formal, kenyamanan lingkungan, serta rekam jejak alumni.',
                'content' => '<p>Kabupaten Bondowoso dikenal luas sebagai salah satu lumbung pesantren terkemuka di Jawa Timur dengan tradisi keilmuan Islam yang mengakar kuat. Bagi para orang tua yang hendak menitipkan amanah pendidikan putra-putrinya, ada beberapa indikator krusial yang perlu diperhatikan dengan seksama.</p><p>Pertama, teliti kredibilitas dan sanad keilmuan pengasuh pondok pesantren. Figur kiai yang ikhlas dan istiqamah adalah ruh dari sebuah pesantren. Kedua, pastikan adanya keseimbangan antara pendalaman ilmu agama (Madrasah Diniyah) dan pendidikan formal terakreditasi agar santri siap menghadapi tantangan zaman tanpa kehilangan jati diri santri.</p><p>Ketiga, amati lingkungan dan fasilitas santri. Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso menghadirkan atmosfer belajar yang asri, sejuk, bersih, dan modern yang mendukung tumbuh kembang santri secara komprehensif, baik jasmani, rohani, maupun intelektual.</p>'
            ],
            'pendidikan-karakter-yang-kuat-di-pondok-pesantren' => [
                'id' => 3,
                'slug' => 'pendidikan-karakter-yang-kuat-di-pondok-pesantren',
                'title' => 'Pesantren Di Jawa Timur dengan Pendidikan Karakter yang Kuat',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'October 11, 2026',
                'formatted_date' => '11 Oktober 2026',
                'image' => asset('images/article3.jpg'),
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'read_time' => '6 menit baca',
                'summary' => 'Bondowoso- Jika kita berbicara tentang "Pesantren", sebelum itu kita perlu mengenal arti dari "Pesantren". Pesantren adalah lembaga pendidikan Islam yang menjadi tempat para santri ditempa kemandirian dan integritas ruhaninya.',
                'content' => '<p>Karakter tidak dapat diajarkan sekadar lewat ceramah satu jam di ruang kelas. Karakter ditempa melalui pembiasaan terus-menerus, keteladanan nyata (uswah hasanah), dan disiplin diri yang konsisten. Inilah rahasia utama keberhasilan sistem pendidikan pondok pesantren.</p><p>Di Pondok Pesantren Nurussyam, santri belajar hidup mandiri jauh dari orang tua. Mereka mencuci pakaian sendiri, mengatur waktu belajar dan ibadah tanpa harus disuruh, serta berbagi ruang dengan kawan dari berbagai penjuru nusantara. Perbedaan suku dan bahasa dilebur dalam ikatan ukhuwah islamiyah yang kokoh.</p><p>Nilai tawadhu\' kepada guru dan orang tua ditanamkan secara mendalam. Para santri menyadari bahwa keberkahan ilmu terletak pada ridha guru dan keikhlasan hati dalam berkhidmat demi kemaslahatan umat dan bangsa.</p>'
            ],
            'pesan-pengasuh-pesantren-itu-kerajaan-cahaya-ilmu' => [
                'id' => 4,
                'slug' => 'pesan-pengasuh-pesantren-itu-kerajaan-cahaya-ilmu',
                'title' => 'Pesan Dr. H. Ahmad Suharto: "Pondok Pesantren itu Kerajaan Cahaya Ilmu,..."',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 9, 2026',
                'formatted_date' => '9 Oktober 2026',
                'image' => asset('images/sidebar1.jpg'),
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'read_time' => '4 menit baca',
                'summary' => 'Pondok pesantren laksana mercusuar yang memancarkan cahaya keilmuan dan adab di tengah kegelapan zaman, mendidik santri menjadi pejuang yang tak gentar membela kebenaran.',
                'content' => '<p>Kunjungan tokoh ulama dan cendekiawan ke Pondok Pesantren Nurussyam senantiasa membawa pesan berharga bagi para santri. Dalam taushiyah terbarunya, ditekankan bahwa pesantren adalah kerajaan ilmu yang mandiri dan berdaulat, tempat nilai-nilai ketuhanan dipadukan dengan ilmu kemanusiaan.</p>'
            ],
            'ketika-pesantren-memberikan-ruang-imajinasi-pagelaran-seni-akbar' => [
                'id' => 5,
                'slug' => 'ketika-pesantren-memberikan-ruang-imajinasi-pagelaran-seni-akbar',
                'title' => 'Ketika Pesantren Memberikan Ruang Imajinasi: Pagelaran Seni Akbar Arena Gembira',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 7, 2026',
                'formatted_date' => '7 Oktober 2026',
                'image' => asset('images/sidebar2.jpg'),
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Malam puncak Arena Gembira santri Nurussyam membuktikan bahwa santri tidak hanya piawai membaca kitab kuning, melainkan juga sarat talenta seni panggung yang memukau ribuan hadirin.',
                'content' => '<p>Sorot tata lampu megah dan iringan musik islami mewarnai panggung akbar Arena Gembira Pondok Pesantren Nurussyam. Dari drama teatrikal perjuangan, tari saman nusantara, hingga orkestra shalawat dibawakan dengan penuh penghayatan oleh para santri.</p>'
            ],
            'pesantren-nurussyam-wringin-arak-arak-bondowoso-terbaik' => [
                'id' => 6,
                'slug' => 'pesantren-nurussyam-wringin-arak-arak-bondowoso-terbaik',
                'title' => 'Pesantren Nurussyam Wringin Arak arak Bondowoso: Pilihan Pendidikan Islam...',
                'category' => 'ALUMNI',
                'author' => 'admin',
                'date' => 'October 4, 2026',
                'formatted_date' => '4 Oktober 2026',
                'image' => asset('images/sidebar1.jpg'),
                'badge_color' => '#1e293b',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Jejak langkah pengabdian alumni dalam mengembangkan model pendidikan pesantren terpadu yang memadukan disiplin salaf dan kurikulum modern di Jawa Timur.',
                'content' => '<p>Pesantren Nurussyam terus memperkuat sinergi dengan berbagai jaringan pondok pesantren alumni untuk saling menguatkan mutu kurikulum, pembinaan bahasa asing, dan kaderisasi kepemimpinan santri.</p>'
            ],
            'tips-mengatur-waktu-antara-belajar-dan-ibadah-ala-santri' => [
                'id' => 7,
                'slug' => 'tips-mengatur-waktu-antara-belajar-dan-ibadah-ala-santri',
                'title' => 'Tips Mengatur Waktu antara Belajar dan Ibadah ala Santri',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'July 31, 2026',
                'formatted_date' => '31 Juli 2026',
                'image' => asset('images/catatan1.jpg'),
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'read_time' => '4 menit baca',
                'summary' => 'Bagaimana santri mampu menghafal puluhan bait nadzam, menelaah lembaran kitab kuning tebal, dan tetap khusyuk menjalankan rangkaian wirid serta shalat berjamaah tepat waktu setiap hari.',
                'content' => '<p>Manajemen waktu di pesantren seringkali membuat kagum masyarakat luas. Jam 03.30 pagi santri sudah terjaga untuk qiyamullail dan shalat Shubuh berjamaah, dilanjutkan pengajian Al-Qur\'an hingga fajar merekah. Pagi hingga siang diisi dengan sekolah formal, sore dengan madrasah diniyah, dan malam hari untuk muthala\'ah kitab mandiri.</p>'
            ],
            'pesantren-modern-perpaduan-antara-ilmu-agama-dan-ilmu-dunia' => [
                'id' => 8,
                'slug' => 'pesantren-modern-perpaduan-antara-ilmu-agama-dan-ilmu-dunia',
                'title' => 'Pesantren Modern: Perpaduan Antara Ilmu Agama dan Ilmu Dunia',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'August 23, 2026',
                'formatted_date' => '23 Agustus 2026',
                'image' => asset('images/article2.jpg'),
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Pesantren membuktikan bahwa ilmu agama dan sains bukanlah dua kutub yang terpisah, melainkan sayap kembar yang menerbangkan santri menuju kemuliaan hakiki.',
                'content' => '<p>Integrasi kurikulum di Nurussyam memfasilitasi santri mendalami ilmu falaq, biologi, matematika, sekaligus menguasai fiqih mawaris dan tafsir ayat-ayat kauniyah secara seimbang.</p>'
            ],
            'hikmah-hidup-sederhana-dalam-kehidupan-pesantren' => [
                'id' => 9,
                'slug' => 'hikmah-hidup-sederhana-dalam-kehidupan-pesantren',
                'title' => 'Hikmah Hidup Sederhana dalam Kehidupan Pesantren',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'July 27, 2026',
                'formatted_date' => '27 Juli 2026',
                'image' => asset('images/catatan2.jpg'),
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'read_time' => '4 menit baca',
                'summary' => 'Tradisi makan bersama satu talam (mayoran) beralaskan daun pisang menyimpan filosofi kesetaraan, menghilangkan sekat status sosial, dan mengasah rasa empati yang mendalam.',
                'content' => '<p>Kesederhanaan (zuhud dan qana\'ah) adalah mahkota kehidupan pesantren. Di Pondok Pesantren Nurussyam, tidak ada perbedaan antara anak pejabat, pengusaha, maupun petani. Semuanya mengenakan sarung yang sama, tidur di kamar yang sama, dan bersila di hadapan kiai yang sama.</p>'
            ],
            'kisah-nabi-ibrahim-dan-ismail-teladan-ketaatan-dan-keikhlasan' => [
                'id' => 10,
                'slug' => 'kisah-nabi-ibrahim-dan-ismail-teladan-ketaatan-dan-keikhlasan',
                'title' => 'Kisah Nabi Ibrahim dan Ismail: Teladan Ketaatan dan Keikhlasan dalam Menjalankan...',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'May 14, 2026',
                'formatted_date' => '14 Mei 2026',
                'image' => asset('images/qurban_laziswaf.jpg'),
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'read_time' => '6 menit baca',
                'summary' => 'Bondowoso- Kisah Nabi Ibrahim AS dan Nabi Ismail AS merupakan salah satu kisah paling menginspirasi dalam sejarah Islam. Perjalanan keduanya menghadapi perintah Allah SWT menjadi pondasi utama ibadah Qurban dan kepedulian sosial santri.',
                'content' => '<p>Ibadah qurban bukan semata tentang menyembelih hewan ternak, melainkan tentang menyembelih ego, ketamakan, dan rasa cinta dunia yang berlebihan. Melalui LAZISWAF Nurussyam, semangat qurban disalurkan menjadi aksi nyata pemberdayaan dhuafa dan pemenuhan gizi santri penghafal Al-Qur\'an.</p>'
            ],
            'zakat-menyempurnakan-ramadhan-dengan-berbagi' => [
                'id' => 11,
                'slug' => 'zakat-menyempurnakan-ramadhan-dengan-berbagi',
                'title' => 'Zakat: Menyempurnakan Ramadhan Dengan Berbagi',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'March 17, 2026',
                'formatted_date' => '17 Maret 2026',
                'image' => asset('images/catatan1.jpg'),
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Zakat fitrah dan zakat mal yang dikelola secara amanah menjadi instrumen keadilan sosial bagi keluarga pra-sejahtera dan anak-anak yatim binaan pesantren.',
                'content' => '<p>LAZISWAF Pondok Pesantren Nurussyam menyalurkan ratusan paket sembako dan santunan pendidikan zakat fitrah kepada mustahiq di kawasan Wringin Arak arak Bondowoso.</p>'
            ],
            'dari-pesantren-untuk-umat-spirit-berbagi-melalui-zakat' => [
                'id' => 12,
                'slug' => 'dari-pesantren-untuk-umat-spirit-berbagi-melalui-zakat',
                'title' => 'Dari Pesantren untuk Umat: Spirit Berbagi Melalui Zakat',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'March 12, 2026',
                'formatted_date' => '12 Maret 2026',
                'image' => asset('images/catatan2.jpg'),
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Menghidupkan peran historis pesantren sebagai simpul pemberdayaan ekonomi umat melalui penghimpunan dan pendistribusian infaq shadaqah produktif.',
                'content' => '<p>Program pemberdayaan zakat produktif Nurussyam memberikan modal usaha bergulir tanpa riba bagi para pelaku UMKM dhuafa di sekitar lingkungan pesantren.</p>'
            ],
            'dari-masjid-pesantren-bergerak-nurussyam-bondowoso' => [
                'id' => 13,
                'slug' => 'dari-masjid-pesantren-bergerak-nurussyam-bondowoso',
                'title' => 'Dari Masjid, Pesantren Bergerak: Nurussyam Bondowoso Wujudkan Pembangunan Lahir dan...',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'November 10, 2025',
                'formatted_date' => '10 November 2025',
                'image' => asset('images/article2.jpg'),
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'read_time' => '4 menit baca',
                'summary' => 'Masjid pesantren bukan hanya tempat sujud ritual, melainkan sentra pergerakan wakaf tunai dan musyawarah kemaslahatan masyarakat sekitar.',
                'content' => '<p>Wakaf pembangunan asrama santri baru dan perluasan aula tahfidz terus bergulir dengan dukungan kaum muslimin dan para dermawan dari berbagai kota.</p>'
            ],
            'hidupilah-pondok-tapi-jangan-gantungkan-hidup-pada-pondok' => [
                'id' => 14,
                'slug' => 'hidupilah-pondok-tapi-jangan-gantungkan-hidup-pada-pondok',
                'title' => 'KH. Izzat Fahd, M.Pd.I: "Hidupilah Pondok, Tapi Jangan Gantungkan Hidup Pada..."',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'November 8, 2025',
                'formatted_date' => '8 November 2025',
                'image' => asset('images/sidebar2.jpg'),
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'read_time' => '5 menit baca',
                'summary' => 'Pesan ketulusan bagi seluruh pengurus pesantren dan relawan LAZISWAF agar senantiasa mendahulukan pengorbanan ikhlas demi kemakmuran dakwah Islam.',
                'content' => '<p>Keberkahan mengalir saat seseorang mewakafkan waktu, tenaga, dan hartanya untuk mendampingi generasi santri penerus risalah kenabian.</p>'
            ]
        ];
    }

    /**
     * Homepage
     */
    public function index(Request $request, $category = null)
    {
        $data = $this->getData();
        $query = $request->get('q');
        $category = $category ?: $request->get('category');

        $allArticles = array_values($data['all_articles']);

        if ($query) {
            $filtered = array_filter($allArticles, function ($item) use ($query) {
                return stripos($item['title'], $query) !== false || stripos($item['summary'], $query) !== false;
            });
            $filteredList = array_values($filtered);
            $data['featured_articles'] = array_slice($filteredList, 0, 3);
            $data['berita_terbaru']['lead'] = $filteredList[0] ?? null;
            $data['berita_terbaru']['items'] = array_slice($filteredList, 1, 4);
            $data['search_query'] = $query;
        }

        if ($category) {
            $categoryUpper = strtoupper($category);
            $filtered = array_filter($allArticles, function ($item) use ($categoryUpper) {
                return strtoupper($item['category']) === $categoryUpper || strtoupper($item['base_category'] ?? '') === $categoryUpper;
            });
            $filteredList = array_values($filtered);
            $data['featured_articles'] = array_slice($filteredList, 0, 3);
            $data['berita_terbaru']['lead'] = $filteredList[0] ?? null;
            $data['berita_terbaru']['items'] = array_slice($filteredList, 1, 4);
            $data['active_category'] = $categoryUpper;
        }

        return view('home', $data);
    }

    /**
     * Single Article Page / API
     */
    public function article($slug)
    {
        $dbArticle = Article::where('slug', $slug)->first();

        // Increment views count secara real jika belum pernah dilihat di sesi saat ini
        if ($dbArticle) {
            $viewKey = 'viewed_article_' . $dbArticle->id;
            if (!session()->has($viewKey)) {
                $dbArticle->increment('views_count');
                session()->put($viewKey, true);
            }
        }

        $data = $this->getData();
        $article = $data['all_articles'][$slug] ?? null;

        if (!$article) {
            foreach ($data['all_articles'] as $item) {
                if ($item['slug'] === $slug) {
                    $article = $item;
                    break;
                }
            }
        }

        if (!$article) {
            return redirect()->route('home')->with('error', 'Artikel tidak ditemukan.');
        }

        // Pastikan views_count ter-update secara real
        if ($dbArticle) {
            $article['views_count'] = (int) $dbArticle->fresh()->views_count;
        }

        // On article detail page, show other latest articles in sidebar
        if (!empty($data['sidebar_news'])) {
            $otherNews = array_values(array_filter($data['sidebar_news'], fn($item) => ($item['slug'] ?? '') !== $slug));
            if (count($otherNews) < 4) {
                $otherNews = array_values(array_filter(array_values($data['all_articles']), fn($item) => ($item['slug'] ?? '') !== $slug));
            }
            $data['sidebar_news'] = array_slice($otherNews, 0, 5);
        }

        return view('article', array_merge($data, [
            'article' => $article,
        ]));
    }

    /**
     * Simpan komentar pembaca pada artikel
     */
    public function storeComment(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
            'comment' => 'required|string|min:3|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'comment.required' => 'Isi komentar tidak boleh kosong.',
            'comment.min' => 'Komentar minimal 3 karakter.',
            'comment.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        $rawName = strip_tags(trim($validated['name']));
        $rawComment = strip_tags(trim($validated['comment']));

        // Filter kata kasar, sara, pornografi, makian, dan spam
        if (\App\Services\ProfanityFilter::containsProfanity($rawName) || \App\Services\ProfanityFilter::containsProfanity($rawComment)) {
            return redirect()->to(route('article.show', $slug) . '#tulis-komentar')
                ->withInput()
                ->with('error_comment', 'Mohon maaf, nama atau isi komentar Anda terdeteksi mengandung kata-kata yang tidak pantas atau dilarang. Harap gunakan bahasa yang santun dan berakhlak karimah.');
        }

        \App\Models\Comment::create([
            'article_id' => $article->id,
            'name' => $rawName,
            'email' => !empty($validated['email']) ? strip_tags(trim($validated['email'])) : null,
            'comment' => $rawComment,
            'is_approved' => true,
        ]);

        $article->increment('comments_count');

        return redirect()->to(route('article.show', $slug) . '#komentar')
            ->with('success_comment', 'Alhamdulillah, komentar Anda berhasil dikirim dan ditayangkan!');
    }

    /**
     * Hapus komentar pada artikel (Bisa dilakukan oleh admin maupun user pengunjung)
     */
    public function destroyComment(Request $request, $id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $article = $comment->article;
        $slug = $article ? $article->slug : null;

        $authorName = $comment->name;
        $comment->delete();

        if ($article && $article->comments_count > 0) {
            $article->decrement('comments_count');
        }

        if (\Illuminate\Support\Facades\Auth::check()) {
            \App\Services\ActivityLogger::log(
                'KOMENTAR_DELETE',
                'Menghapus komentar dari "' . $authorName . '" pada artikel: "' . ($article->title ?? '-') . '"'
            );
        }

        $redirectUrl = $slug ? route('article.show', $slug) . '#komentar' : url()->previous();
        return redirect()->to($redirectUrl)->with('success_comment', 'Komentar berhasil dihapus.');
    }

    /**
     * Informasi Penerimaan Santri Baru (Murni Informasi PSB)
     */
    public function psbInfo()
    {
        $data = $this->getData();
        $data['psb'] = SiteSetting::getPsbSettings();
        return view('pendaftaran_info', $data);
    }

    /**
     * Syarat & Berkas Pendaftaran Santri Baru
     */
    public function psbSyarat()
    {
        $data = $this->getData();
        $data['psb'] = SiteSetting::getPsbSettings();
        return view('pendaftaran_syarat', $data);
    }

    /**
     * Registration / Pendaftaran Page with Admin Approval Check
     */
    public function pendaftaran(Request $request)
    {
        $data = $this->getData();
        $data['psb'] = SiteSetting::getPsbSettings();

        if ($request->filled('cek_pendaftaran')) {
            $keyword = trim($request->input('cek_pendaftaran'));
            $cleanDigits = preg_replace('/[^0-9]/', '', $keyword);

            $checkResult = Registration::where('no_pendaftaran', $keyword)
                ->orWhere('no_wa', $keyword)
                ->orWhere(function ($q) use ($cleanDigits, $keyword) {
                    if (strlen($cleanDigits) >= 8) {
                        $q->where('no_wa', 'like', "%" . substr($cleanDigits, -8) . "%");
                    }
                    $q->orWhere('nama_lengkap', 'like', "%{$keyword}%");
                })
                ->orderBy('id', 'desc')
                ->first();

            $data['checkResult'] = $checkResult;
            $data['searchedKeyword'] = $keyword;
            $data['searched'] = true;
        }

        return view('pendaftaran', $data);
    }


    /**
     * Public Printable Registration Slip for Approved Students
     */
    public function printSlipPublic($no_pendaftaran)
    {
        $registration = Registration::where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
        return view('admin.registrations.print', compact('registration'));
    }

    /**
     * Page Handler for standard navigation (Sejarah, Profil, etc.)
     */
    public function page($slug)
    {
        if ($slug === 'pendaftaran') {
            return redirect()->route('pendaftaran');
        }

        if ($slug === 'laziswaf') {
            return redirect()->route('laziswaf.index');
        }

        if ($slug === 'donasi-masjid' || $slug === 'masjid') {
            return redirect()->route('donasi.masjid');
        }

        if ($slug === 'donasi-pondok' || $slug === 'wakaf-produktif' || $slug === 'rekening-donasi') {
            return redirect()->route('donasi.pondok');
        }

        $data = $this->getData();
        $titles = [
            'berdirinya-pesantren' => 'Berdirinya Pondok Pesantren Nurussyam Wringin Bondowoso',
            'gagasan-dan-cita-cita' => 'Gagasan dan Cita-cita',
            'kepemimpinan-generasi-pertama' => 'Kepemimpinan Generasi Pertama',
            'kepemimpinan-generasi-kedua' => 'Kepemimpinan Generasi Kedua',
            'biografi-pendiri' => 'Biografi Pendiri',
            'sejarah' => 'Sejarah Pondok Pesantren Nurussyam',
            'pendiri' => 'KH. As\'ari Afandi',
            'pengasuh-kh-sanusi-syam' => 'KH. Sanusi Syam (Pengasuh ke-2)',
            'pengasuh-kh-abdul-malik-sanusi' => 'KH. Abdul Malik Sanusi (Pengasuh ke-3)',
            'lembaga' => 'Lembaga Pendidikan & Dakwah Nurussyam',
            'visi-misi' => 'Visi Misi',
            'motto' => 'Motto Pondok Pesantren Nurussyam',
            'panca-jiwa' => 'Panca Jiwa',
            'panca-jangka' => 'Panca Jangka',
            'madrasah-diniyah' => 'Madrasah Diniyah',
            'kegiatan-ekstrakurikuler' => 'Kegiatan Ekstrakurikuler',
            'profil' => 'Profil Pondok Pesantren Nurussyam',
            'pendaftaran' => 'Pendaftaran Santri Baru (PSB)',
            'terkini' => 'Berita & Informasi Terkini',
            'catatan' => 'Catatan & Esai Santri Nurussyam',
            'alumni' => 'Ikatan Alumni Pondok Pesantren Nurussyam (IKAPEN)',
            'laziswaf' => 'Lembaga Amil Zakat, Infaq, Shadaqah & Wakaf (LAZISWAF)',
            'galeri' => 'Galeri Foto & Video Kegiatan Pesantren',
            'belanja' => 'Nurussyam Store & Koperasi Santri',
            'sekolah' => 'Sekolah Pondok Pesantren Nurussyam',
            'mts-nurussyam' => 'MTs Nurussyam',
            'ma-nurussyam' => 'MA Nurussyam'
        ];

        $pageTitle = $titles[$slug] ?? ucfirst(str_replace('-', ' ', $slug));

        $extraData = ['slug' => $slug, 'pageTitle' => $pageTitle];

        if ($slug === 'galeri') {
            // 1. Ambil foto kegiatan dari database Galeri (upload manual pengelola)
            $manualGalleries = \App\Models\Gallery::where('is_published', true)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($g) {
                    return [
                        'id' => 'gal-' . $g->id,
                        'title' => $g->title,
                        'image' => $g->image_url,
                        'category' => $g->category ?? 'Kegiatan Santri',
                        'date' => $g->activity_date ?? ($g->created_at ? $g->created_at->format('d M Y') : date('d M Y')),
                        'source' => 'manual',
                    ];
                });

            // 2. Ambil foto kegiatan otomatis dari seluruh berita santri yang memiliki foto
            $articlePhotos = \App\Models\Article::where('is_published', true)
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($a) {
                    $img = $a->image;
                    if (!str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                        $img = asset(ltrim($img, '/'));
                    }
                    return [
                        'id' => 'art-' . $a->id,
                        'title' => $a->title, // Hanya foto dan judul foto dari judul berita santri
                        'image' => $img,
                        'category' => $a->categoryRel?->name ?? ($a->category ?? 'Kegiatan Santri'),
                        'date' => $a->date,
                        'source' => 'berita',
                    ];
                });

            // Gabungkan kedua sumber foto
            $galleryItems = $manualGalleries->concat($articlePhotos);

            // Fallback jika belum ada data sama sekali
            if ($galleryItems->isEmpty()) {
                $galleryItems = collect([
                    [
                        'id' => 1,
                        'title' => 'Pentas Seni & Kreasi Santri',
                        'image' => asset('images/article1.jpg'),
                        'category' => 'Pentas Seni & Kreasi',
                        'date' => '16 Oktober 2026',
                        'source' => 'default',
                    ],
                    [
                        'id' => 2,
                        'title' => 'Shalat Berjamaah & Kajian Rutin',
                        'image' => asset('images/article2.jpg'),
                        'category' => 'Kajian & Shalat',
                        'date' => '14 Oktober 2026',
                        'source' => 'default',
                    ],
                    [
                        'id' => 3,
                        'title' => 'Gerbang Pesantren Waktu Malam',
                        'image' => asset('images/article3.jpg'),
                        'category' => 'Fasilitas & Lingkungan',
                        'date' => '11 Oktober 2026',
                        'source' => 'default',
                    ],
                ]);
            }

            $extraData['galleryItems'] = $galleryItems;
        }

        return view('page', array_merge($data, $extraData));
    }

    /**
     * Public LAZISWAF Page (Lembaga Amil Zakat, Infaq, Shadaqah & Wakaf)
     */
    public function laziswaf()
    {
        $data = $this->getData();
        return view('laziswaf', $data);
    }

    /**
     * Public Donasi Masjid Page
     */
    public function donasiMasjid()
    {
        $data = $this->getData();
        return view('donasi_masjid', $data);
    }

    /**
     * Public Donasi Pondok Page
     */
    public function donasiPondok()
    {
        $data = $this->getData();
        return view('donasi_pondok', $data);
    }

    /**
     * Store Public Donation / Zakat & Prayer notes into MySQL database
     */
    public function storePublicDonation(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'no_wa' => 'nullable|string|max:30',
            'program' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1000',
            'bank_tujuan' => 'required|string|max:100',
            'doa_harapan' => 'nullable|string|max:1000',
        ]);

        $kode = 'DON-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

        $donation = Donation::create([
            'kode_transaksi' => $kode,
            'nama_donatur' => $validated['nama_donatur'],
            'no_wa' => $validated['no_wa'] ?? '-',
            'program' => $validated['program'],
            'nominal' => $validated['nominal'],
            'bank_tujuan' => $validated['bank_tujuan'],
            'status' => 'Menunggu Konfirmasi',
            'doa_harapan' => $validated['doa_harapan'] ?? null,
        ]);

        \App\Services\ActivityLogger::log(
            'DONASI_PUBLIK',
            "Donasi publik masuk: {$donation->kode_transaksi} dari {$donation->nama_donatur} ({$donation->program} - Rp " . number_format($donation->nominal, 0, ',', '.') . ")"
        );

        $prevUrl = strtok(url()->previous(), '#');
        return redirect()->to($prevUrl . '#sukses-donasi')->with('success_donation', [
            'kode' => $donation->kode_transaksi,
            'nama' => $donation->nama_donatur,
            'program' => $donation->program,
            'nominal' => $donation->nominal,
            'bank' => $donation->bank_tujuan,
            'doa' => $donation->doa_harapan,
            'ucapan' => self::getUcapanTerimakasih($donation->program, $donation->nama_donatur),
        ]);
    }

    /**
     * Get specific gratitude message and prayer tailored to the donation program.
     */
    public static function getUcapanTerimakasih($program, $namaDonatur = 'Muhsinin')
    {
        $prog = strtolower($program);
        $nama = !empty($namaDonatur) ? $namaDonatur : 'Bapak/Ibu Donatur';

        if (str_contains($prog, 'karpet') || str_contains($prog, 'saf') || str_contains($prog, 'sajadah')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas sedekah wakaf karpet saf shalat santri. Semoga setiap helai sajadah yang digunakan sujud para santri menjadi butiran pahala jariyah yang tiada putus bagi Anda sekeluarga.";
        } elseif (str_contains($prog, 'sound') || str_contains($prog, 'air') || str_contains($prog, 'wudhu')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas infaq pengadaan sound system adzan & kelancaran air wudhu. Semoga setiap tetesan air wudhu dan kumandang adzan santri menjadi saksi amal jariyah suci bagi Anda di hadapan Allah SWT.";
        } elseif (str_contains($prog, 'renovasi')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas sedekah wakaf renovasi fasilitas masjid. Semoga Allah SWT membalas kedermawanan Anda dengan membangunkan rumah istana megah di surga kelak.";
        } elseif (str_contains($prog, 'masjid')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas infaq pemakmuran Masjid Nurussyam. Semoga Allah SWT melipatgandakan rezeki berkah dan menjaga keluarga Anda dalam lindungan dan ketenteraman.";
        } elseif (str_contains($prog, 'yatim') || str_contains($prog, 'beasiswa')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas donasi beasiswa santri yatim & dhuafa. Semoga amal mulia ini mengantarkan Anda berdampingan bersama Rasulullah SAW di surga tertinggi kelak.";
        } elseif (str_contains($prog, 'kitab') || str_contains($prog, 'qur\'an') || str_contains($prog, 'quran') || str_contains($prog, 'perpustakaan') || str_contains($prog, 'mushaf')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas sedekah wakaf Al-Qur'an & kitab kuning. Setiap ayat dan ilmu yang dipelajari serta dihafal santri siang dan malam akan terus memancarkan pahala jariyah bagi Anda.";
        } elseif (str_contains($prog, 'asrama') || str_contains($prog, 'sarana')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas wakaf pembangunan asrama & sarana santri. Semoga fasilitas yang menaungi ibadah para santri penuntut ilmu ini menjadi amal jariyah abadi bagi Anda sekeluarga.";
        } elseif (str_contains($prog, 'fitrah')) {
            return "Jazakumullahu khairan katsiran kepada Muzakki {$nama} atas penunaian Zakat Fitrah. Semoga Allah SWT menerima amal ibadah puasa Anda dan menyucikan jiwa lahir dan batin.";
        } elseif (str_contains($prog, 'zakat')) {
            return "Jazakumullahu khairan katsiran kepada Muzakki {$nama} atas penunaian Zakat Mal. Semoga Allah SWT membersihkan harta Anda, menyucikan jiwa, dan melipatgandakan rezeki yang halal dan berkah.";
        } elseif (str_contains($prog, 'fidyah') || str_contains($prog, 'kafarat')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas penunaian fidyah / kafarat. Makanan pokok yang disalurkan bagi santri dhuafa semoga menjadi pembersih kewajiban syar'i dan wasilah keselamatan keluarga.";
        } elseif (str_contains($prog, 'subuh')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas Sedekah Subuh berkah. Semoga diijabah doa para malaikat dan santri untuk kemudahan urusan serta kelimpahan rezeki Anda hari ini.";
        } elseif (str_contains($prog, 'infaq') || str_contains($prog, 'shadaqah') || str_contains($prog, 'sedekah')) {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas infaq dan sedekah yang diikhlaskan. Semoga menjadi penolak bala, pemadam kekhilafan, dan pembuka pintu kelapangan rezeki bagi keluarga.";
        } else {
            return "Jazakumullahu khairan katsiran kepada {$nama} atas keikhlasan donasi untuk Pondok Pesantren Nurussyam. Segenap pengasuh dan santri mendoakan keberkahan, kesehatan, dan kemudahan hidup bagi Anda sekeluarga.";
        }
    }

    /**
     * Store online registration into MySQL database with duplicate prevention
     */
    public function storeRegistration(Request $request)
    {
        $psb = SiteSetting::getPsbSettings();
        if (($psb['psb_status'] ?? '1') !== '1') {
            return redirect()->to(route('pendaftaran') . '#form-daftar')
                ->withInput()
                ->with('error_psb', 'Mohon maaf, pendaftaran santri baru saat ini sedang dinonaktifkan atau belum dibuka. Silakan pantau pengumuman gelombang pendaftaran di halaman Informasi PSB.');
        }

        $validated = $request->validate([

            'nama_lengkap' => 'required|string|max:255',
            'no_wa' => 'required|string|max:30',
            'pilihan_jenjang' => 'required|string|max:100',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'nama_wali' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'asal_sekolah' => 'nullable|string|max:255',
        ], [
            'nama_lengkap.required' => 'Nama calon santri wajib diisi.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'pilihan_jenjang.required' => 'Jenjang pendidikan wajib dipilih.',
        ]);

        $rawNama = trim($validated['nama_lengkap']);
        $cleanNama = mb_strtolower(preg_replace('/\s+/', ' ', $rawNama));
        $rawWa = trim($validated['no_wa']);
        $cleanWa = preg_replace('/[^0-9]/', '', $rawWa);

        // 1. Cek Duplikasi Berdasarkan NAMA LENGKAP (case-insensitive)
        $existingByName = Registration::whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [$cleanNama])->first();
        if ($existingByName) {
            $msg = "Calon santri atas nama <strong>" . e($existingByName->nama_lengkap) . "</strong> sudah terdaftar di sistem dengan <strong>No. Pendaftaran: " . e($existingByName->no_pendaftaran) . "</strong> (Jenjang: " . e($existingByName->pilihan_jenjang) . ", Status: " . e($existingByName->status) . "). Untuk mencegah duplikasi database, pendaftaran baru dengan nama yang sama tidak diperbolehkan. Silakan periksa status pendaftaran Anda pada formulir 'Cek Persetujuan' di atas.";
            
            return redirect()->to(route('pendaftaran') . '#form-daftar')
                ->withInput()
                ->with('error_psb', $msg)
                ->withErrors(['nama_lengkap' => "Data calon santri atas nama '{$existingByName->nama_lengkap}' sudah terdaftar sebelumnya (No: {$existingByName->no_pendaftaran})."]);
        }

        // 2. Cek Duplikasi Berdasarkan NOMOR WHATSAPP (9 digit terakhir)
        if (strlen($cleanWa) >= 9) {
            $last9 = substr($cleanWa, -9);
            $existingByWa = Registration::where('no_wa', $rawWa)
                ->orWhere('no_wa', $cleanWa)
                ->orWhere('no_wa', 'like', '%' . $last9)
                ->first();

            if ($existingByWa) {
                $msg = "Nomor WhatsApp <strong>" . e($rawWa) . "</strong> sudah pernah digunakan untuk mendaftarkan calon santri atas nama <strong>" . e($existingByWa->nama_lengkap) . "</strong> (No. Pendaftaran: " . e($existingByWa->no_pendaftaran) . "). Satu nomor WhatsApp hanya dapat digunakan untuk satu pendaftaran santri.";
                
                return redirect()->to(route('pendaftaran') . '#form-daftar')
                    ->withInput()
                    ->with('error_psb', $msg)
                    ->withErrors(['no_wa' => "Nomor WhatsApp ini sudah terdaftar atas nama {$existingByWa->nama_lengkap}."]);
            }
        }

        $noPendaftaran = Registration::generateNoPendaftaran('PSB');

        $registration = Registration::create([
            'no_pendaftaran' => $noPendaftaran,
            'nama_lengkap' => $rawNama,
            'no_wa' => $rawWa,
            'pilihan_jenjang' => $validated['pilihan_jenjang'],
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? 'Laki-laki',
            'nama_wali' => $validated['nama_wali'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'asal_sekolah' => $validated['asal_sekolah'] ?? null,
            'status' => 'Pending',
        ]);

        return redirect()->to(route('pendaftaran') . '#form-daftar')->with('success_psb', [
            'no_pendaftaran' => $registration->no_pendaftaran,
            'nama' => $registration->nama_lengkap,
            'jenjang' => $registration->pilihan_jenjang,
            'wa' => $registration->no_wa
        ]);
    }
}
