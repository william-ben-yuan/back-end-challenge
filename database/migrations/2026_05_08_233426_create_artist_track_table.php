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
        Schema::create('artist_track', function (Blueprint $table) {
            $table->foreignUuid('artist_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('track_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->primary(['artist_id', 'track_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_track');
    }
};
