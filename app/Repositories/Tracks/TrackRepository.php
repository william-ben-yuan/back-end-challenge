<?php

namespace App\Repositories\Tracks;

use App\Models\Track;

class TrackRepository implements TrackRepositoryInterface
{
    public function create(array $data)
    {
        return Track::create($data);
    }

    public function find(array $filters)
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