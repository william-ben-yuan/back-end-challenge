<?php

namespace App\Services\Tracks;

use App\Repositories\Tracks\TrackRepositoryInterface;

class TrackService implements TrackServiceInterface
{
    protected TrackRepositoryInterface $repository;

    public function __construct(TrackRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function find(array $filters)
    {
        return $this->repository->find($filters);
    }
}