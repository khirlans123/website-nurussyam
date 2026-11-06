<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Registration;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\File;

class PsbSettingController extends Controller
{
    /**
     * Display PSB settings & wave management page.
     */
    public function index()
    {
        $psb = SiteSetting::getPsbSettings();

        $stats = [
            'total' => Registration::count(),
            'pending' => Registration::where('status', 'Pending')->count(),
            'diverifikasi' => Registration::where('status', 'Diverifikasi')->count(),
            'diterima' => Registration::where('status', 'Diterima')->count(),
        ];

        return view('admin.psb.settings', compact('psb', 'stats'));
    }

    /**
     * Save / update all PSB information and wave configurations.
     */
    public function update(Request $request)
    {
        $fields = [
            'psb_status',
            'psb_tahun_ajaran',
            'psb_title',
            'psb_subtitle',
            'psb_intro_text',

            // Gelombang 1
            'psb_g1_active',
            'psb_g1_badge',
            'psb_g1_name',
            'psb_g1_dates',
            'psb_g1_test',
            'psb_g1_announcement',
            'psb_g1_notes',

            // Gelombang 2
            'psb_g2_active',
            'psb_g2_badge',
            'psb_g2_name',
            'psb_g2_dates',
            'psb_g2_test',
            'psb_g2_announcement',
            'psb_g2_notes',

            // Catatan Kuota & Pengumuman
            'psb_quota_notes',
            'psb_banner_notice',

            // Kontak & Layanan
            'psb_contact_address',
            'psb_contact_phone',
            'psb_contact_wa',
            'psb_service_hours',
        ];

        // Validasi input
        $request->validate([
            'psb_tahun_ajaran' => 'required|string|max:50',
            'psb_title' => 'required|string|max:255',
        ], [
            'psb_tahun_ajaran.required' => 'Tahun Ajaran PSB wajib diisi (misal: 2026/2027).',
            'psb_title.required' => 'Judul halaman PSB wajib diisi.',
        ]);

        // Checkbox status fallback (jika switch tidak dicentang di HTML, request tidak mengirim nilainya)
        $checkboxFields = ['psb_status', 'psb_g1_active', 'psb_g2_active'];
        foreach ($checkboxFields as $cb) {
            $val = $request->has($cb) && $request->input($cb) == '1' ? '1' : '0';
            SiteSetting::set($cb, $val, 'psb');
        }

        // Simpan field teks lainnya
        foreach ($fields as $field) {
            if (!in_array($field, $checkboxFields)) {
                SiteSetting::set($field, $request->input($field, ''), 'psb');
            }
        }

        ActivityLogger::log(
            'PSB_SETTINGS_UPDATE',
            'Memperbarui konfigurasi informasi PSB T.A ' . $request->input('psb_tahun_ajaran') . ' dan jadwal gelombang pendaftaran.'
        );

        return back()->with('success', 'Konfigurasi Informasi & Gelombang PSB berhasil disimpan dan langsung aktif di website!');
    }

    /**
     * Quick toggle for PSB status or wave active status.
     */
    public function toggle(Request $request)
    {
        $target = $request->input('target');
        $allowedTargets = ['psb_status', 'psb_g1_active', 'psb_g2_active'];

        if (!in_array($target, $allowedTargets)) {
            return back()->with('error', 'Target pengaturan tidak valid.');
        }

        $current = SiteSetting::get($target, '1');
        $new = ($current === '1' || $current === 1) ? '0' : '1';
        SiteSetting::set($target, $new, 'psb');

        $labels = [
            'psb_status' => 'Status Utama PSB',
            'psb_g1_active' => 'Gelombang 1',
            'psb_g2_active' => 'Gelombang 2',
        ];
        $label = $labels[$target] ?? $target;
        $statusText = $new === '1' ? 'DIAKTIFKAN (DIBUKA)' : 'DINONAKTIFKAN (DITUTUP)';

        ActivityLogger::log(
            'PSB_TOGGLE',
            "Mengubah status {$label} menjadi {$statusText}."
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'target' => $target,
                'new_status' => $new,
                'message' => "{$label} berhasil {$statusText}!"
            ]);
        }

        return back()->with('success', "{$label} berhasil {$statusText}!");
    }
}
