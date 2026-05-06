<?php

namespace App\Repositories\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

class TrackRepository implements TrackRepositoryInterface
{
    public function create(array $data): Track
    {
        return Track::create($data);
    }

    public function find(array $filters): Collection
    {
        $query = Track::query();

        if (isset($filters['isrc'])) {
            $query->where('isrc', $filters['isrc']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        return $query->get();
    }
}