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
        Schema::create('social_stats', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // facebook, instagram, tiktok, youtube
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('count_formatted')->default('0');
            $table->unsignedInteger('raw_count')->default(0);
            $table->string('label')->default('Followers');
            $table->string('color')->default('#0f8528');
            $table->string('icon')->default('fa-share-nodes');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_stats');
    }
};
