<?php

namespace App\Repositories\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface TrackRepositoryInterface
{
    public function create(array $data): Track;
    public function search(array $filters): Builder;
    public function paginate(array $filters, int $perPage = 15, int $page = 1): LengthAwarePaginator;
}
