<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'spotify_id',
        'name',
    ];

    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, 'artist_track');
    }
}
