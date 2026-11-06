<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\SocialStat;
use App\Models\SiteSetting;
use App\Models\Registration;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@nurussyam.ponpes.id'],
            [
                'name' => 'Admin Nurussyam',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Categories
        $categories = [
            'BERITA TERBARU' => ['slug' => 'berita-terbaru', 'color' => '#0f8528', 'desc' => 'Kumpulan warta dan berita kegiatan pondok pesantren.'],
            'TERKINI' => ['slug' => 'terkini', 'color' => '#b91c1c', 'desc' => 'Kabar terhangat dan liputan khusus terbaru.'],
            'CATATAN' => ['slug' => 'catatan', 'color' => '#15803d', 'desc' => 'Kolom pemikiran, tausiyah, dan catatan para asatidz.'],
            'ALUMNI' => ['slug' => 'alumni', 'color' => '#1e293b', 'desc' => 'Kabar ikatan alumni dan kiprah santri di masyarakat.'],
            'LAZISWAF' => ['slug' => 'laziswaf', 'color' => '#d97706', 'desc' => 'Lembaga Amil Zakat, Infaq, Shadaqah & Wakaf Nurussyam.']
        ];

        $catModels = [];
        foreach ($categories as $name => $meta) {
            $catModels[$name] = Category::updateOrCreate(
                ['slug' => $meta['slug']],
                [
                    'name' => $name,
                    'color' => $meta['color'],
                    'description' => $meta['desc']
                ]
            );
        }

        // 3. Social Media Stats (Real Data)
        $socials = [
            [
                'platform' => 'facebook',
                'name' => 'Facebook',
                'username' => 'Pondok Pesantren Nurussyam',
                'count_formatted' => '1,250',
                'raw_count' => 1250,
                'label' => 'Fans',
                'color' => '#1877f2',
                'icon' => 'fa-facebook-f',
                'url' => 'https://facebook.com'
            ],
            [
                'platform' => 'instagram',
                'name' => 'Instagram',
                'username' => '@ppnurussyam_official',
                'count_formatted' => '266',
                'raw_count' => 266,
                'label' => 'Followers',
                'color' => '#e1306c',
                'icon' => 'fa-instagram',
                'url' => 'https://www.instagram.com/ppnurussyam_official'
            ],
            [
                'platform' => 'tiktok',
                'name' => 'TikTok',
                'username' => '@ppnurussyam_official',
                'count_formatted' => '1,364',
                'raw_count' => 1364,
                'label' => 'Followers',
                'color' => '#000000',
                'icon' => 'fa-tiktok',
                'url' => 'https://www.tiktok.com/@ppnurussyam_official'
            ],
            [
                'platform' => 'youtube',
                'name' => 'YouTube',
                'username' => '@ppnurussyamofficial',
                'count_formatted' => '500',
                'raw_count' => 500,
                'label' => 'Subscribers',
                'color' => '#ff0000',
                'icon' => 'fa-youtube',
                'url' => 'https://www.youtube.com/@ppnurussyamofficial'
            ],
        ];

        foreach ($socials as $soc) {
            SocialStat::updateOrCreate(
                ['platform' => $soc['platform']],
                $soc
            );
        }

        // 4. Articles Data
        $articles = [
            [
                'title' => 'Pesantren: Tempat Membentuk Generasi Berilmu dan Berakhlak',
                'slug' => 'pesantren-tempat-membentuk-generasi-berilmu-dan-berakhlak',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'October 16, 2026',
                'image' => 'images/article1.jpg',
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'views_count' => 1420,
                'read_time' => '5 menit baca',
                'summary' => 'Bondowoso- Pesantren merupakan salah satu wujud dari lembaga pendidikan yang sudah lama berkembang di tanah air. Dengan gaya asrama berdisiplin dan wajibnya anak didik mendalami ilmu agama serta akhlakul karimah, pesantren senantiasa menjadi benteng moral generasi muslim.',
                'content' => '<p><strong class="article-lead-green">Bondowoso- Pesantren</strong> merupakan salah satu wujud dari lembaga pendidikan yang sudah lama berkembang di tanah air. Dengan gaya asrama berdisiplin dan wajibnya anak didik mendalami ilmu agama serta akhlakul karimah, pesantren senantiasa menjadi benteng moral generasi muslim.</p><p>Di tengah pesatnya laju transformasi teknologi dan arus globalisasi yang tak terbendung, pesantren tetap teguh berdiri sebagai benteng moral dan spiritual umat. Kehidupan di Pondok Pesantren Nurussyam membiasakan para santri untuk senantiasa menyelaraskan antara ketajaman intelektual dengan kemurnian akhlakul karimah.</p><p>Melalui metode pembelajaran kitab kuning (turats) yang teruji selama berabad-abad, santri dididik memiliki sanad keilmuan yang bersambung langsung hingga baginda Rasulullah SAW. Tidak hanya menghafal teks, santri diajarkan metodologi berpikir kritis, tabayyun dalam menyikapi kabar, serta menjunjung tinggi adab di atas ilmu.</p><p>Sebagaimana nasihat masyhur dari para ulama salaf, ilmu tanpa adab laksana api tanpa kayu bakar. Di Nurussyam Wringin Arak arak Bondowoso, setiap detik hembusan nafas santri adalah madrasah kehidupan: mulai dari shalat tahajjud berjamaah, tilawah Al-Qur\'an di fajar hari, hingga mudzakarah ilmiah malam hari di bawah bimbingan para kiai dan ustadz tercinta.</p>',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Panduan Memilih Pondok Pesantren Terbaik di Bondowoso',
                'slug' => 'panduan-memilih-pondok-pesantren-terbaik-di-bondowoso',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 14, 2026',
                'image' => 'images/article2.jpg',
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'views_count' => 980,
                'read_time' => '7 menit baca',
                'summary' => 'Memilih lembaga pendidikan pesantren yang tepat untuk buah hati memerlukan pertimbangan matang mengenai sanad keilmuan, integrasi kurikulum salaf dan formal, kenyamanan lingkungan, serta rekam jejak alumni.',
                'content' => '<p>Kabupaten Bondowoso dikenal luas sebagai salah satu lumbung pesantren terkemuka di Jawa Timur dengan tradisi keilmuan Islam yang mengakar kuat. Bagi para orang tua yang hendak menitipkan amanah pendidikan putra-putrinya, ada beberapa indikator krusial yang perlu diperhatikan dengan seksama.</p><p>Pertama, teliti kredibilitas dan sanad keilmuan pengasuh pondok pesantren. Figur kiai yang ikhlas dan istiqamah adalah ruh dari sebuah pesantren. Kedua, pastikan adanya keseimbangan antara pendalaman ilmu agama (Madrasah Diniyah) dan pendidikan formal terakreditasi agar santri siap menghadapi tantangan zaman tanpa kehilangan jati diri santri.</p><p>Ketiga, amati lingkungan dan fasilitas santri. Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso menghadirkan atmosfer belajar yang asri, sejuk, bersih, dan modern yang mendukung tumbuh kembang santri secara komprehensif, baik jasmani, rohani, maupun intelektual.</p>',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Pesantren Di Jawa Timur dengan Pendidikan Karakter yang Kuat',
                'slug' => 'pendidikan-karakter-yang-kuat-di-pondok-pesantren',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'October 11, 2026',
                'image' => 'images/article3.jpg',
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'views_count' => 1120,
                'read_time' => '6 menit baca',
                'summary' => 'Bondowoso- Jika kita berbicara tentang "Pesantren", sebelum itu kita perlu mengenal arti dari "Pesantren". Pesantren adalah lembaga pendidikan Islam yang menjadi tempat para santri ditempa kemandirian dan integritas ruhaninya.',
                'content' => '<p>Karakter tidak dapat diajarkan sekadar lewat ceramah satu jam di ruang kelas. Karakter ditempa melalui pembiasaan terus-menerus, keteladanan nyata (uswah hasanah), dan disiplin diri yang konsisten. Inilah rahasia utama keberhasilan sistem pendidikan pondok pesantren.</p><p>Di Pondok Pesantren Nurussyam, santri belajar hidup mandiri jauh dari orang tua. Mereka mencuci pakaian sendiri, mengatur waktu belajar dan ibadah tanpa harus disuruh, serta berbagi ruang dengan kawan dari berbagai penjuru nusantara. Perbedaan suku dan bahasa dilebur dalam ikatan ukhuwah islamiyah yang kokoh.</p><p>Nilai tawadhu\' kepada guru dan orang tua ditanamkan secara mendalam. Para santri menyadari bahwa keberkahan ilmu terletak pada ridha guru dan keikhlasan hati dalam berkhidmat demi kemaslahatan umat dan bangsa.</p>',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Pesan Pengasuh: "Pesantren itu Kerajaan Cahaya Ilmu dan Budi Pekerti Luhur"',
                'slug' => 'pesan-pengasuh-pesantren-itu-kerajaan-cahaya-ilmu',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 9, 2026',
                'image' => 'images/sidebar1.jpg',
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'views_count' => 840,
                'read_time' => '4 menit baca',
                'summary' => 'Nasihat penuh hikmah dari Pengasuh Pondok Pesantren Nurussyam kepada seluruh santri agar senantiasa meluruskan niat mencari ridha Allah dan menjaga kehormatan ilmu agama.',
                'content' => '<p>Dalam mau\'idzah hasanah di hadapan ribuan santri, Pengasuh mengingatkan bahwa kesuksesan seorang penuntut ilmu tidak diukur dari kemewahan duniawi, melainkan dari seberapa besar ilmu tersebut mampu mendekatkan dirinya kepada Allah dan menebar manfaat bagi sesama.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Ketika Pesantren Memberikan Ruang Imajinasi: Pagelaran Seni Akbar Arena Gembira',
                'slug' => 'ketika-pesantren-memberikan-ruang-imajinasi-pagelaran-seni-akbar',
                'category' => 'TERKINI',
                'author' => 'admin',
                'date' => 'October 7, 2026',
                'image' => 'images/sidebar2.jpg',
                'badge_color' => '#b91c1c',
                'comments_count' => 0,
                'views_count' => 930,
                'read_time' => '5 menit baca',
                'summary' => 'Malam puncak Arena Gembira santri Nurussyam membuktikan bahwa santri tidak hanya piawai membaca kitab kuning, melainkan juga sarat talenta seni panggung yang memukau ribuan hadirin.',
                'content' => '<p>Sorot tata lampu megah dan iringan musik islami mewarnai panggung akbar Arena Gembira Pondok Pesantren Nurussyam. Dari drama teatrikal perjuangan, tari saman nusantara, hingga orkestra shalawat dibawakan dengan penuh penghayatan oleh para santri.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Pesantren Nurussyam Wringin Arak arak Bondowoso: Pilihan Pendidikan Islam Terbaik...',
                'slug' => 'pesantren-nurussyam-wringin-arak-arak-bondowoso-terbaik',
                'category' => 'ALUMNI',
                'author' => 'admin',
                'date' => 'October 4, 2026',
                'image' => 'images/sidebar1.jpg',
                'badge_color' => '#1e293b',
                'comments_count' => 0,
                'views_count' => 760,
                'read_time' => '5 menit baca',
                'summary' => 'Jejak langkah pengabdian alumni dalam mengembangkan model pendidikan pesantren terpadu yang memadukan disiplin salaf dan kurikulum modern di Jawa Timur.',
                'content' => '<p>Pesantren Nurussyam terus memperkuat sinergi dengan berbagai jaringan pondok pesantren alumni untuk saling menguatkan mutu kurikulum, pembinaan bahasa asing, dan kaderisasi kepemimpinan santri.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Tips Mengatur Waktu antara Belajar dan Ibadah ala Santri',
                'slug' => 'tips-mengatur-waktu-antara-belajar-dan-ibadah-ala-santri',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'July 31, 2026',
                'image' => 'images/catatan1.jpg',
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'views_count' => 1340,
                'read_time' => '4 menit baca',
                'summary' => 'Bagaimana santri mampu menghafal puluhan bait nadzam, menelaah lembaran kitab kuning tebal, dan tetap khusyuk menjalankan rangkaian wirid serta shalat berjamaah tepat waktu setiap hari.',
                'content' => '<p>Manajemen waktu di pesantren seringkali membuat kagum masyarakat luas. Jam 03.30 pagi santri sudah terjaga untuk qiyamullail dan shalat Shubuh berjamaah, dilanjutkan pengajian Al-Qur\'an hingga fajar merekah. Pagi hingga siang diisi dengan sekolah formal, sore dengan madrasah diniyah, dan malam hari untuk muthala\'ah kitab mandiri.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Pesantren Modern: Perpaduan Antara Ilmu Agama dan Ilmu Dunia',
                'slug' => 'pesantren-modern-perpaduan-antara-ilmu-agama-dan-ilmu-dunia',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'August 23, 2026',
                'image' => 'images/article2.jpg',
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'views_count' => 880,
                'read_time' => '5 menit baca',
                'summary' => 'Integrasi kurikulum pesantren salafiah dengan sains dan teknologi di era digital. Membuktikan bahwa santri mampu berdaya saing global tanpa kehilangan akar nilai-nilai kepesantrenan.',
                'content' => '<p>Pondok Pesantren Nurussyam menepis anggapan dikotomi antara ilmu agama dan ilmu umum. Keduanya adalah satu kesatuan ayat-ayat Allah; ayat qauliyah dan ayat kauniyah yang saling melengkapi.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Hikmah Hidup Sederhana dalam Kehidupan Pesantren',
                'slug' => 'hikmah-hidup-sederhana-dalam-kehidupan-pesantren',
                'category' => 'CATATAN',
                'author' => 'admin',
                'date' => 'August 15, 2026',
                'image' => 'images/article3.jpg',
                'badge_color' => '#15803d',
                'comments_count' => 0,
                'views_count' => 950,
                'read_time' => '4 menit baca',
                'summary' => 'Kesederhanaan bukanlah kemiskinan, melainkan kebesaran jiwa untuk menempatkan dunia di tangan dan bukan di dalam hati. Nilai luhur yang menjadi ruh kehidupan para santri.',
                'content' => '<p>Di pesantren, santri dididik tidur beralas kasur tipis atau tikar, makan bersama dalam satu nampan (talaman), dan mengenakan pakaian bersahaja. Dari kesederhanaan inilah lahir rasa empati mendalam dan kepekaan sosial tinggi.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Kisah Nabi Ibrahim AS dan Nabi Ismail AS: Teladan Ketaatan dan Keikhlasan',
                'slug' => 'kisah-nabi-ibrahim-dan-ismail-teladan-ketaatan-dan-keikhlasan',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'June 6, 2026',
                'image' => 'images/qurban_laziswaf.jpg',
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'views_count' => 1250,
                'read_time' => '6 menit baca',
                'summary' => 'Bondowoso- Kisah Nabi Ibrahim AS dan Nabi Ismail AS merupakan salah satu kisah paling menginspirasi dalam sejarah Islam. Perjalanan keduanya menghadapi perintah Allah SWT menjadi pondasi utama ibadah Qurban dan kepedulian sosial santri.',
                'content' => '<p>Ibadah qurban bukan semata tentang menyembelih hewan ternak, melainkan tentang menyembelih ego, ketamakan, dan rasa cinta dunia yang berlebihan. Melalui LAZISWAF Nurussyam, semangat qurban disalurkan menjadi aksi nyata pemberdayaan dhuafa dan pemenuhan gizi santri penghafal Al-Qur\'an.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Zakat: Menyempurnakan Ramadhan Dengan Berbagi',
                'slug' => 'zakat-menyempurnakan-ramadhan-dengan-berbagi',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'March 17, 2026',
                'image' => 'images/catatan1.jpg',
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'views_count' => 1100,
                'read_time' => '5 menit baca',
                'summary' => 'Zakat fitrah dan zakat mal yang dikelola secara amanah menjadi instrumen keadilan sosial bagi keluarga pra-sejahtera dan anak-anak yatim binaan pesantren.',
                'content' => '<p>LAZISWAF Pondok Pesantren Nurussyam menyalurkan ratusan paket sembako dan santunan pendidikan zakat fitrah kepada mustahiq di kawasan Wringin Arak arak Bondowoso.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Dari Pesantren untuk Umat: Spirit Berbagi Melalui Zakat',
                'slug' => 'dari-pesantren-untuk-umat-spirit-berbagi-melalui-zakat',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'March 12, 2026',
                'image' => 'images/catatan2.jpg',
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'views_count' => 870,
                'read_time' => '5 menit baca',
                'summary' => 'Menghidupkan peran historis pesantren sebagai simpul pemberdayaan ekonomi umat melalui penghimpunan dan pendistribusian infaq shadaqah produktif.',
                'content' => '<p>Program pemberdayaan zakat produktif Nurussyam memberikan modal usaha bergulir tanpa riba bagi para pelaku UMKM dhuafa di sekitar lingkungan pesantren.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Dari Masjid, Pesantren Bergerak: Nurussyam Bondowoso Wujudkan Pembangunan Lahir dan...',
                'slug' => 'dari-masjid-pesantren-bergerak-nurussyam-bondowoso',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'November 10, 2025',
                'image' => 'images/article2.jpg',
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'views_count' => 790,
                'read_time' => '4 menit baca',
                'summary' => 'Masjid pesantren bukan hanya tempat sujud ritual, melainkan sentra pergerakan wakaf tunai dan musyawarah kemaslahatan masyarakat sekitar.',
                'content' => '<p>Wakaf pembangunan asrama santri baru dan perluasan aula tahfidz terus bergulir dengan dukungan kaum muslimin dan para dermawan dari berbagai kota.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'KH. Izzat Fahd, M.Pd.I: "Hidupilah Pondok, Tapi Jangan Gantungkan Hidup Pada..."',
                'slug' => 'hidupilah-pondok-tapi-jangan-gantungkan-hidup-pada-pondok',
                'category' => 'LAZISWAF',
                'author' => 'admin',
                'date' => 'November 8, 2025',
                'image' => 'images/sidebar2.jpg',
                'badge_color' => '#d97706',
                'comments_count' => 0,
                'views_count' => 1050,
                'read_time' => '5 menit baca',
                'summary' => 'Pesan ketulusan bagi seluruh pengurus pesantren dan relawan LAZISWAF agar senantiasa mendahulukan pengorbanan ikhlas demi kemakmuran dakwah Islam.',
                'content' => '<p>Keberkahan mengalir saat seseorang mewakafkan waktu, tenaga, dan hartanya untuk mendampingi generasi santri penerus risalah kenabian.</p>',
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($articles as $art) {
            $catId = isset($catModels[$art['category']]) ? $catModels[$art['category']]->id : null;
            Article::updateOrCreate(
                ['slug' => $art['slug']],
                array_merge($art, ['category_id' => $catId])
            );
        }

        // 5. Site Settings
        $settings = [
            ['key' => 'site_title', 'value' => 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Cahaya Keberkahan, Ilmu, dan Akhlakul Karimah', 'group' => 'general'],
            ['key' => 'address', 'value' => 'Wringin Arak arak, Kabupaten Bondowoso, Jawa Timur', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'admin@nurussyam.ponpes.id', 'group' => 'contact'],
            ['key' => 'phone', 'value' => '+62 812-3456-7890', 'group' => 'contact'],
            ['key' => 'wa_psb', 'value' => 'https://wa.me/6281234567890', 'group' => 'contact'],
            ['key' => 'bank_mandiri', 'value' => '143-00-2980022-2 a.n YYS PONPES NURUSSYAM', 'group' => 'donation'],
            ['key' => 'bank_bsi', 'value' => '7143-0029-80 a.n LAZISWAF NURUSSYAM', 'group' => 'donation'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // 5b. Default PSB & Waves Settings
        foreach (SiteSetting::defaultPsbSettings() as $psbKey => $psbVal) {
            SiteSetting::firstOrCreate(
                ['key' => $psbKey],
                ['value' => $psbVal, 'group' => 'psb']
            );
        }


        // 6. Sample Registration (Contoh Pendaftar Santri Baru)
        Registration::updateOrCreate(
            ['no_pendaftaran' => 'PSB-2026-0001'],
            [
                'nama_lengkap' => 'Muhammad Fatih Al-Faruq',
                'nisn' => '0098234712',
                'nik' => '3511091204090001',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bondowoso',
                'tanggal_lahir' => '2012-04-12',
                'nama_wali' => 'H. Ahmad Syarifuddin',
                'no_wa' => '081234567890',
                'alamat' => 'Jl. Raya Wringin No. 45, Bondowoso',
                'asal_sekolah' => 'MI Nurul Huda',
                'pilihan_jenjang' => 'MTS NURUSSYAM',
                'status' => 'Pending',
                'catatan' => 'Pilihan program reguler & Tahfidz Al-Qur\'an'
            ]
        );
    }
}
