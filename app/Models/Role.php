<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'permissions',
        'is_system',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_system' => 'boolean',
    ];

    /**
     * Pre-defined available permissions in the system.
     */
    public static function availablePermissions(): array
    {
        return [
            'dashboard_view' => [
                'label' => 'Melihat Dashboard Utama',
                'group' => 'Dashboard',
            ],
            'articles_view' => [
                'label' => 'Melihat Daftar Berita',
                'group' => 'Berita & Artikel',
            ],
            'articles_create' => [
                'label' => 'Menulis & Upload Berita Baru',
                'group' => 'Berita & Artikel',
            ],
            'articles_edit' => [
                'label' => 'Mengedit Berita & Mengubah Status Terbit',
                'group' => 'Berita & Artikel',
            ],
            'articles_delete' => [
                'label' => 'Menghapus Berita',
                'group' => 'Berita & Artikel',
            ],
            'categories_manage' => [
                'label' => 'Mengelola Kategori Berita',
                'group' => 'Berita & Artikel',
            ],
            'registrations_view' => [
                'label' => 'Melihat Data Pendaftaran PSB',
                'group' => 'Penerimaan Santri (PSB)',
            ],
            'registrations_verify' => [
                'label' => 'Memverifikasi Berkas Calon Santri',
                'group' => 'Penerimaan Santri (PSB)',
            ],
            'registrations_approve' => [
                'label' => 'Menyetujui & Menerima Santri (Khusus Admin)',
                'group' => 'Penerimaan Santri (PSB)',
            ],
            'registrations_delete' => [
                'label' => 'Menghapus Pendaftaran Santri',
                'group' => 'Penerimaan Santri (PSB)',
            ],
            'students_manage' => [
                'label' => 'Mengelola Data Santri Aktif & Cetak Kartu',
                'group' => 'Data Santri',
            ],
            'donations_manage' => [
                'label' => 'Mengelola LAZISWAF & Verifikasi Donasi',
                'group' => 'Keuangan & LAZISWAF',
            ],
            'settings_manage' => [
                'label' => 'Mengatur Konfigurasi & Medsos Website',
                'group' => 'Pengaturan & Sistem',
            ],
            'users_manage' => [
                'label' => 'Mengelola Akun Pengguna & Role Akses',
                'group' => 'Pengaturan & Sistem',
            ],
            'logs_view' => [
                'label' => 'Melihat Histori Aktivitas & Jam Login',
                'group' => 'Histori & Audit',
            ],
        ];
    }

    /**
     * Relationship: users who have this role slug
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role', 'slug');
    }
}
