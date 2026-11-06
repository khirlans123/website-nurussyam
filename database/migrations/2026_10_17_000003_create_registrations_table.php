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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->string('nisn')->nullable();
            $table->string('nik')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->default('Laki-laki');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('no_wa');
            $table->text('alamat')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('pilihan_jenjang')->default('MTS NURUSSYAM'); // MTS, MA, Diniyah, Tahfidz
            $table->string('status')->default('Pending'); // Pending, Diverifikasi, Diterima, Ditolak
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
