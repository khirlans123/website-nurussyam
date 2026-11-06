<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('nama_donatur');
            $table->string('no_wa');
            $table->string('program')->default('Infaq & Shadaqah'); // Zakat Fitrah, Zakat Mal, Sedekah Subuh, Wakaf Pembangunan, Qurban
            $table->decimal('nominal', 15, 2)->default(0);
            $table->string('bank_tujuan')->default('BSI'); // Mandiri / BSI
            $table->string('status')->default('Menunggu Konfirmasi'); // Menunggu Konfirmasi, Terverifikasi
            $table->text('doa_harapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
