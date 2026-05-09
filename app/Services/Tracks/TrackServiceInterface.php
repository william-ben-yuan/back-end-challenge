<?php

namespace App\Services\Tracks;

use App\Models\Track;
use Illuminate\Pagination\LengthAwarePaginator;

interface TrackServiceInterface
{
    public function import(string $isrc): ?Track;
    public function create(array $data): Track;
    public function paginate(array $filters, int $perPage = 15, int $page = 1): LengthAwarePaginator;
}
