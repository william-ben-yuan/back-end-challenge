<?php

namespace App\Services\Artists;

use App\Repositories\Artists\ArtistRepositoryInterface;

class ArtistService
{
    protected ArtistRepositoryInterface $artistRepository;

    public function __construct(ArtistRepositoryInterface $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function create(array $data)
    {
        return $this->artistRepository->create($data);
    }
}
