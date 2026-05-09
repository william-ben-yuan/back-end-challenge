<?php

namespace App\Repositories\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class TrackRepository implements TrackRepositoryInterface
{
    public function create(array $data): Track
    {
        return Track::create($data);
    }

    public function search(array $filters): Builder
    {
        return Track::query()
            ->with('artists')
            ->when(
                $filters['isrc'] ?? null,
                fn($query, $isrc) => $query->where('isrc', $isrc)
            )
            ->when(
                $filters['title'] ?? null,
                fn($query, $title) => $query->where('title', 'like', "%{$title}%")
            );
    }

    public function paginate(array $filters, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->search($filters)->paginate($perPage, ['*'], 'page', $page);
    }
}
