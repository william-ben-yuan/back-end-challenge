<?php

namespace App\Repositories\Artists;

use App\Models\Artist;

class ArtistRepository implements ArtistRepositoryInterface
{
    public function create(array $data)
    {
        return Artist::create($data);
    }
}
