<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value, string $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public static function defaultPsbSettings(): array
    {
        return [
            'psb_status' => '1', // 1: Dibuka / Aktif, 0: Ditutup / Nonaktif
            'psb_tahun_ajaran' => '2026/2027',
            'psb_title' => 'Informasi Penerimaan Santri Baru (PSB)',
            'psb_subtitle' => 'Pondok Pesantren Nurussyam Wringin Arak arak Bondowoso',
            'psb_intro_text' => 'Pondok Pesantren Nurussyam kembali membuka pendaftaran bagi calon santri putra dan santri putri baru untuk Tahun Ajaran 2026/2027. Dengan memadukan kedalaman ilmu agama melalui kajian kitab kuning (turats salaf) dan keunggulan pendidikan formal terakreditasi resmi, kami siap mendidik generasi muslim yang berakhlak mulia, cerdas, berilmu amaliah, dan mandiri.',

            // Gelombang 1
            'psb_g1_active' => '1',
            'psb_g1_badge' => 'GELOMBANG I',
            'psb_g1_name' => 'Gelombang Pertama',
            'psb_g1_dates' => '01 Januari – 31 Maret 2026',
            'psb_g1_test' => 'Setiap Hari Ahad',
            'psb_g1_announcement' => '05 April 2026',
            'psb_g1_notes' => 'Pendaftaran online & offline dibuka setiap hari kerja di sekretariat PSB.',

            // Gelombang 2
            'psb_g2_active' => '1',
            'psb_g2_badge' => 'GELOMBANG II',
            'psb_g2_name' => 'Gelombang Kedua',
            'psb_g2_dates' => '01 April – 30 Juni 2026',
            'psb_g2_test' => 'Menyesuaikan Jadwal',
            'psb_g2_announcement' => '05 Juli 2026',
            'psb_g2_notes' => 'Dibuka jika kuota asrama dan kelas santri masih tersedia.',

            // Catatan Kuota
            'psb_quota_notes' => 'Pendaftaran dapat ditutup sewaktu-waktu apabila kuota asrama dan kelas telah terpenuhi. Calon santri disarankan mendaftar pada Gelombang Pertama.',

            // Kontak & Layanan PSB
            'psb_contact_address' => 'Wringin Arak arak, Kab. Bondowoso, Jawa Timur',
            'psb_contact_phone' => '+62 812-3456-7890',
            'psb_contact_wa' => '+62 812-3456-7890',
            'psb_service_hours' => 'Setiap Hari (08.00 - 15.00 WIB)',

            // Pengumuman Penting / Banner darurat & Brosur
            'psb_banner_notice' => '',
            'psb_brosur_url' => '',
        ];
    }

    public static function getPsbSettings(): array
    {
        $defaults = static::defaultPsbSettings();
        try {
            $keys = array_keys($defaults);
            $saved = static::whereIn('key', $keys)->pluck('value', 'key')->toArray();
            return array_merge($defaults, $saved);
        } catch (\Throwable $e) {
            return $defaults;
        }
    }
}

