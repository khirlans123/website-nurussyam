<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama_donatur',
        'no_wa',
        'program',
        'nominal',
        'bank_tujuan',
        'status',
        'doa_harapan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];
}
