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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('isrc')->unique();
            $table->string('title');
            $table->date('release_date');
            $table->integer('duration');
            $table->string('album_thumbnail_url');
            $table->string('preview_url');
            $table->string('spotify_url');
            $table->boolean('is_available_in_brazil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
