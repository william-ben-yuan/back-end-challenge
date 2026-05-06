<?php 

namespace App\Repositories\Tracks;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

interface TrackRepositoryInterface
{
    public function create(array $data): Track;
    public function find(array $filters): Collection;
}