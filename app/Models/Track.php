<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Track extends Model
{
    /** @use HasFactory<\Database\Factories\TrackFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'isrc',
        'title',
        'release_date',
        'duration',
        'album_thumbnail_url',
        'preview_url',
        'spotify_url',
        'is_available_in_brazil',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_available_in_brazil' => 'boolean',
    ];

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_track');
    }
}
