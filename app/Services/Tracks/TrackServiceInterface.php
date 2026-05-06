<?php

namespace App\Services\Tracks;

interface TrackServiceInterface
{
    public function create(array $data);
    public function find(array $filters);
}