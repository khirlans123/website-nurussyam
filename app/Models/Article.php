<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'category',
        'author',
        'date',
        'activity_time',
        'image',
        'badge_color',
        'comments_count',
        'views_count',
        'read_time',
        'summary',
        'content',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'comments_count' => 'integer',
        'views_count' => 'integer',
    ];

    public function categoryRel(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Format teks berita agar enter / baris baru memiliki jarak paragraf rapi sesuai inputan.
     */
    public static function formatContent(?string $content): string
    {
        if (empty($content)) {
            return '';
        }

        // Jika teks sama sekali belum dibungkus tag <p>
        if (!preg_match('/<p[\s>]/i', $content)) {
            $normalized = str_replace(["\r\n", "\r"], "\n", trim($content));
            $blocks = preg_split('/\n{2,}/', $normalized);
            $output = [];
            foreach ($blocks as $block) {
                $block = trim($block);
                if ($block !== '') {
                    if (preg_match('/^<(h[1-6]|ul|ol|blockquote|table|div)[\s>]/i', $block)) {
                        $output[] = $block;
                    } else {
                        $output[] = '<p>' . nl2br($block) . '</p>';
                    }
                }
            }
            return implode("\n\n", $output);
        }

        return $content;
    }

    public function getFormattedContentAttribute(): string
    {
        return self::formatContent($this->content);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/logo-ppns.png');
        }
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }
        return asset(ltrim($this->image, '/'));
    }
}
