<?php

namespace App\Services;

use App\Models\SocialStat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocialFollowerService
{
    /**
     * Crawl and sync all social media followers.
     */
    public static function syncAll(): array
    {
        $socials = SocialStat::all();
        $results = [];

        foreach ($socials as $soc) {
            $platform = strtolower($soc->platform);
            $url = $soc->url;
            $detected = null;

            if ($platform === 'whatsapp' || str_contains($url, 'whatsapp.com/channel')) {
                $detected = self::fetchWhatsAppChannel($url);
            } elseif ($platform === 'instagram' || str_contains($url, 'instagram.com')) {
                $detected = self::fetchInstagram($url);
            } elseif ($platform === 'tiktok' || str_contains($url, 'tiktok.com')) {
                $detected = self::fetchTikTok($url);
            } elseif ($platform === 'youtube' || str_contains($url, 'youtube.com')) {
                $detected = self::fetchYouTube($url);
            }

            if ($detected !== null && $detected['raw'] > 0) {
                $soc->raw_count = $detected['raw'];
                $soc->count_formatted = $detected['formatted'];
                $soc->save();

                $results[$platform] = [
                    'status' => 'success',
                    'raw' => $detected['raw'],
                    'formatted' => $detected['formatted']
                ];
            } else {
                $results[$platform] = [
                    'status' => 'skipped_or_failed',
                    'raw' => $soc->raw_count,
                    'formatted' => $soc->count_formatted
                ];
            }
        }

        return $results;
    }

    /**
     * Fetch WhatsApp Channel followers from public link.
     */
    public static function fetchWhatsAppChannel(string $url): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept-Language' => 'id-ID,id;q=0.9,en;q=0.8'
            ])->timeout(8)->get($url);

            if ($response->successful()) {
                $html = $response->body();
                // Match: "85 pengikut" or "85 followers"
                if (preg_match('/(\d[\d.,]*)\s*(pengikut|followers)/i', $html, $m)) {
                    $clean = preg_replace('/[^\d]/', '', $m[1]);
                    $num = (int) $clean;
                    if ($num > 0) {
                        return [
                            'raw' => $num,
                            'formatted' => number_format($num, 0, ',', '.')
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning("SocialFollowerService WA Channel error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch Instagram followers using Social Crawler User-Agent.
     */
    public static function fetchInstagram(string $url): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'
            ])->timeout(8)->get($url);

            if ($response->successful()) {
                $html = $response->body();
                // Match: "270 Followers, 34 Following"
                if (preg_match('/([0-9.,]+[KMBkmb]?)\s*Followers/i', $html, $m)) {
                    $str = $m[1];
                    $num = self::parseCountToNumber($str);
                    return [
                        'raw' => $num,
                        'formatted' => number_format($num, 0, ',', '.')
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning("SocialFollowerService Instagram error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch TikTok followers using Social Crawler User-Agent.
     */
    public static function fetchTikTok(string $url): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)'
            ])->timeout(8)->get($url);

            if ($response->successful()) {
                $html = $response->body();
                // Match: "@ppnurussyam_official 1414 Followers, 6 Following"
                if (preg_match('/([0-9.,]+[KMBkmb]?)\s*Followers/i', $html, $m)) {
                    $str = $m[1];
                    $num = self::parseCountToNumber($str);
                    return [
                        'raw' => $num,
                        'formatted' => number_format($num, 0, ',', '.')
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning("SocialFollowerService TikTok error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch YouTube subscriber count.
     */
    public static function fetchYouTube(string $url): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept-Language' => 'id-ID,id;q=0.9,en;q=0.8'
            ])->timeout(8)->get($url);

            if ($response->successful()) {
                $html = $response->body();
                // Match: "500 subscriber" or "500 subscribers"
                if (preg_match('/([0-9.,]+[KMBkmb]?)\s*(subscriber|subscribers|pelanggan)/i', $html, $m)) {
                    $str = $m[1];
                    $num = self::parseCountToNumber($str);
                    return [
                        'raw' => $num,
                        'formatted' => number_format($num, 0, ',', '.')
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning("SocialFollowerService YouTube error: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Convert strings like 1.4K, 1414, 2.5M to integer.
     */
    private static function parseCountToNumber(string $str): int
    {
        $str = trim(strtoupper($str));
        $multiplier = 1;

        if (str_ends_with($str, 'K')) {
            $multiplier = 1000;
            $str = substr($str, 0, -1);
        } elseif (str_ends_with($str, 'M')) {
            $multiplier = 1000000;
            $str = substr($str, 0, -1);
        } elseif (str_ends_with($str, 'B')) {
            $multiplier = 1000000000;
            $str = substr($str, 0, -1);
        }

        $clean = str_replace(',', '.', $str);
        return (int) (floatval($clean) * $multiplier);
    }
}
