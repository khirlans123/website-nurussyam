<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\SocialStat;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        $socials = SocialStat::all();

        return view('admin.settings.index', compact('settings', 'socials'));
    }

    /**
     * Update general settings.
     */
    public function update(Request $request)
    {
        $fields = [
            'site_name',
            'site_tagline',
            'phone',
            'wa_psb',
            'email',
            'address',
            'bank_mandiri',
            'an_mandiri',
            'bank_bsi',
            'an_bsi',
            'wa_confirm',
            'count_santri',
            'count_asatidz',
            'count_alumni',
            'count_lembaga',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->input($field), 'general');
            }
        }

        \App\Services\ActivityLogger::log('SETTINGS_UPDATE', 'Memperbarui informasi umum & kontak pesantren pada pengaturan website.');

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }

    /**
     * Update social media links and stats.
     */
    public function updateSocial(Request $request)
    {
        $validated = $request->validate([
            'social' => 'required|array',
            'social.*.id' => 'required|exists:social_stats,id',
            'social.*.count_formatted' => 'required|string',
            'social.*.raw_count' => 'required|integer',
            'social.*.url' => 'required|string',
        ]);

        foreach ($validated['social'] as $item) {
            $stat = SocialStat::find($item['id']);
            if ($stat) {
                $stat->update([
                    'count_formatted' => $item['count_formatted'],
                    'raw_count' => $item['raw_count'],
                    'url' => $item['url'],
                ]);
            }
        }

        \App\Services\ActivityLogger::log('SETTINGS_UPDATE', 'Memperbarui statistik & tautan media sosial pondok pesantren.');

        return back()->with('success', 'Statistik & tautan media sosial berhasil diperbarui.');
    }

    /**
     * Sinkronkan pengikut media sosial secara otomatis dari link akun resmi.
     */
    public function syncSocial()
    {
        $results = \App\Services\SocialFollowerService::syncAll();
        \App\Services\ActivityLogger::log('SETTINGS_UPDATE', 'Menjalankan sinkronisasi otomatis pengikut media sosial dari link akun resmi.');

        return back()->with('success', 'Sinkronisasi berhasil! Jumlah pengikut WhatsApp, Instagram, TikTok, dan YouTube telah diperbarui otomatis sesuai kondisi nyata.');
    }
}
