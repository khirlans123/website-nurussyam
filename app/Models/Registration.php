<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pendaftaran',
        'nama_lengkap',
        'nisn',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_wali',
        'no_wa',
        'alamat',
        'asal_sekolah',
        'pilihan_jenjang',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Generate a guaranteed unique registration / student number.
     * Format: {PREFIX}-{YEAR}-{4_DIGIT_SEQUENCE} (e.g. PSB-2026-0004 or SNTR-2026-0004)
     */
    public static function generateNoPendaftaran(string $prefixType = 'PSB'): string
    {
        $year = date('Y');
        $basePrefix = $prefixType . '-' . $year . '-';

        // Pluck existing numbers with this prefix to find the absolute highest sequence
        $existing = static::where('no_pendaftaran', 'like', $basePrefix . '%')
            ->pluck('no_pendaftaran')
            ->toArray();

        $maxNum = 0;
        foreach ($existing as $no) {
            if (preg_match('/' . preg_quote($basePrefix, '/') . '(\d+)/', $no, $m)) {
                $val = (int) $m[1];
                if ($val > $maxNum) {
                    $maxNum = $val;
                }
            }
        }

        // Candidate sequence based on max sequence + 1 and max id + 1
        $candidateSeq = max($maxNum + 1, (static::max('id') ?? 0) + 1);

        $code = $basePrefix . str_pad($candidateSeq, 4, '0', STR_PAD_LEFT);

        // Safety guarantee against any collision
        while (static::where('no_pendaftaran', $code)->exists()) {
            $candidateSeq++;
            $code = $basePrefix . str_pad($candidateSeq, 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }
}
