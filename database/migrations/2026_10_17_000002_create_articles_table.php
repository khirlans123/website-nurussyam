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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('BERITA');
            $table->string('author')->default('admin');
            $table->string('date')->nullable();
            $table->string('image')->nullable();
            $table->string('badge_color')->default('#0f8528');
            $table->integer('comments_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->string('read_time')->default('5 menit baca');
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
