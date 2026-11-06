<?php

namespace App\Services;

class ProfanityFilter
{
    /**
     * Daftar kata-kata kasar, dilarang, kotor, sara, dan spam.
     */
    protected static array $badWords = [
        // Kata kotor / alat kelamin / seksual
        'kontol', 'memek', 'jembut', 'pepek', 'peler', 'pantek', 'titit', 'toket', 
        'tetek', 'itil', 'ngentot', 'entot', 'ngewe', 'ewe', 'ngocok', 'coli', 
        'colmek', 'psk', 'pelacur', 'lonte', 'perek', 'jablay', 'boti', 'bokep', 
        'porno', 'porn', 'sex', 'bugil', 'mesum', 'masturbasi', 'vagina', 'penis',
        'cuki', 'puki', 'pukimak', 'kimak', 'tempik',

        // Makian / binatang / hinaan
        'anjing', 'anjir', 'anjay', 'asu', 'babi', 'bangsat', 'bajingan', 'kampret', 
        'monyet', 'kunyuk', 'celeng', 'bodoh', 'goblok', 'bego', 'tolol', 'idiot', 
        'dungu', 'brengsek', 'keparat', 'sialan', 'taik', 'tahi', 'tai', 'eek', 
        'jancuk', 'jancok', 'dancuk', 'cok', 'cuk', 'sundel', 'bencong', 'banci', 
        'setan', 'iblis', 'dajjal', 'biadab', 'laknat',

        // Ujaran kebencian / kekerasan
        'mampus', 'modar', 'mati lu', 'bunuh',

        // Spam Judi / Slot
        'slot gacor', 'judi online', 'situs judi', 'link slot', 'zeus slot', 
        'pragmatic play', 'maxwin', 'depo pulsa', 'togel', 'bandar togel', 'poker online',

        // Kata kasar bahasa Inggris umum
        'fuck', 'fucking', 'fck', 'shit', 'bitch', 'bastard', 'asshole', 'dick', 
        'pussy', 'cunt', 'slut', 'whore'
    ];

    /**
     * Cek apakah teks mengandung kata yang dilarang.
     */
    public static function containsProfanity(?string $text): bool
    {
        if (empty($text)) {
            return false;
        }

        $normalized = self::normalizeText($text);

        foreach (self::$badWords as $word) {
            $wordNormalized = self::normalizeText($word);

            // Cek kecocokan kata utuh atau frase
            $pattern = '/\b' . preg_quote($wordNormalized, '/') . '\b/i';
            if (preg_match($pattern, $normalized)) {
                return true;
            }

            // Jika kata lebih dari 4 huruf, cek juga kemunculan tanpa batas kata (untuk kata leetspeak/gabung)
            if (mb_strlen($wordNormalized) >= 5 && str_contains(str_replace(' ', '', $normalized), str_replace(' ', '', $wordNormalized))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Dapatkan daftar kata terlarang yang terdeteksi dalam teks.
     */
    public static function getDetectedProfanities(?string $text): array
    {
        if (empty($text)) {
            return [];
        }

        $detected = [];
        $normalized = self::normalizeText($text);

        foreach (self::$badWords as $word) {
            $wordNormalized = self::normalizeText($word);
            $pattern = '/\b' . preg_quote($wordNormalized, '/') . '\b/i';
            if (preg_match($pattern, $normalized) || (mb_strlen($wordNormalized) >= 5 && str_contains(str_replace(' ', '', $normalized), str_replace(' ', '', $wordNormalized)))) {
                $detected[] = $word;
            }
        }

        return array_unique($detected);
    }

    /**
     * Normalisasi teks: ganti leetspeak (0->o, 1->i, 3->e, 4->a, dll) dan bersihkan karakter pemisah.
     */
    protected static function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);

        // Ganti leetspeak umum
        $replacements = [
            '0' => 'o',
            '1' => 'i',
            '!' => 'i',
            '|' => 'i',
            '3' => 'e',
            '4' => 'a',
            '@' => 'a',
            '5' => 's',
            '$' => 's',
            '7' => 't',
            '+' => 't',
            '8' => 'b',
        ];

        $text = strtr($text, $replacements);

        // Hapus tanda baca umum pemisah kata (misal: a.n.j.i.n.g, b-a-b-i)
        $cleanPunct = preg_replace('/[.,\-_*#~`\'"]+/u', '', $text);

        // Jika huruf terpisah spasi tunggal (misal: a n j i n g), gabungkan
        $collapsedSpaces = preg_replace('/\b([a-z0-9])\s+(?=[a-z0-9]\b)/i', '$1', $cleanPunct);

        // Ciutkan karakter berulang berlebih (misal: anjiiiing -> anjing)
        $collapsedChars = preg_replace('/(.)\1{2,}/u', '$1', $collapsedSpaces);

        return trim($collapsedChars);
    }
}
