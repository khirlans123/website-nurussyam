<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Badge color or icon for action type.
     */
    public function getActionBadgeAttribute(): array
    {
        return match (strtoupper($this->action)) {
            'LOGIN' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-right-to-bracket', 'text' => 'Login Masuk'],
            'LOGOUT' => ['class' => 'badge-slate', 'icon' => 'fa-solid fa-right-from-bracket', 'text' => 'Logout Sesi'],
            'ARTIKEL_CREATE' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-circle-plus', 'text' => 'Upload Berita'],
            'ARTIKEL_UPDATE' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-pen-to-square', 'text' => 'Edit Berita'],
            'ARTIKEL_DELETE' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-trash-can', 'text' => 'Hapus Berita'],
            'ARTIKEL_STATUS' => ['class' => 'badge-purple', 'icon' => 'fa-solid fa-toggle-on', 'text' => 'Status Berita'],
            'PSB_VERIFIKASI' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-clipboard-check', 'text' => 'Verifikasi PSB'],
            'PSB_SETUJUI' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-check-double', 'text' => 'Persetujuan Santri'],
            'PSB_UPDATE' => ['class' => 'badge-amber', 'icon' => 'fa-solid fa-file-pen', 'text' => 'Update PSB'],
            'PSB_HAPUS' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-trash', 'text' => 'Hapus PSB'],
            'SANTRI_TAMBAH' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-user-plus', 'text' => 'Tambah Santri'],
            'SANTRI_EDIT' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-user-pen', 'text' => 'Edit Santri'],
            'SANTRI_HAPUS' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-user-xmark', 'text' => 'Hapus Santri'],
            'SETTINGS_UPDATE' => ['class' => 'badge-purple', 'icon' => 'fa-solid fa-sliders', 'text' => 'Ubah Pengaturan'],
            'USER_CREATE' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-user-shield', 'text' => 'Tambah Pengguna'],
            'USER_UPDATE' => ['class' => 'badge-amber', 'icon' => 'fa-solid fa-user-gear', 'text' => 'Edit Pengguna'],
            'USER_DELETE' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-user-minus', 'text' => 'Hapus Pengguna'],
            'ROLE_CREATE' => ['class' => 'badge-purple', 'icon' => 'fa-solid fa-id-badge', 'text' => 'Tambah Role'],
            'ROLE_UPDATE' => ['class' => 'badge-amber', 'icon' => 'fa-solid fa-pen-nib', 'text' => 'Edit Role'],
            'ROLE_DELETE' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-ban', 'text' => 'Hapus Role'],
            'PROFILE_UPDATE' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-user-lock', 'text' => 'Profil / Password'],
            'KATEGORI_TAMBAH' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-folder-plus', 'text' => 'Tambah Kategori'],
            'KATEGORI_EDIT' => ['class' => 'badge-amber', 'icon' => 'fa-solid fa-folder', 'text' => 'Edit Kategori'],
            'KATEGORI_HAPUS' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-folder-minus', 'text' => 'Hapus Kategori'],
            'DONASI_TAMBAH' => ['class' => 'badge-blue', 'icon' => 'fa-solid fa-hand-holding-heart', 'text' => 'Catat Donasi'],
            'DONASI_VERIFIKASI' => ['class' => 'badge-emerald', 'icon' => 'fa-solid fa-circle-check', 'text' => 'Verifikasi Donasi'],
            'DONASI_HAPUS' => ['class' => 'badge-red', 'icon' => 'fa-solid fa-trash-can', 'text' => 'Hapus Donasi'],
            default => ['class' => 'badge-slate', 'icon' => 'fa-solid fa-bolt', 'text' => ucfirst(strtolower($this->action))],
        };
    }
}
