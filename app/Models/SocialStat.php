<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'name',
        'username',
        'count_formatted',
        'raw_count',
        'label',
        'color',
        'icon',
        'url',
    ];

    protected $casts = [
        'raw_count' => 'integer',
    ];
}
