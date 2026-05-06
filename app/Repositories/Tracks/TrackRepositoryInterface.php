<?php 

namespace App\Repositories\Tracks;

interface TrackRepositoryInterface
{
    public function create(array $data);
    public function find(array $filters);
}