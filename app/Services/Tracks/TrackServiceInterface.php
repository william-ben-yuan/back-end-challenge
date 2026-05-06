<?php

namespace App\Services\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

interface TrackServiceInterface
{
    public function import(string $isrc): ?Track;
    public function create(array $data): Track;
    public function find(array $filters): Collection;
}