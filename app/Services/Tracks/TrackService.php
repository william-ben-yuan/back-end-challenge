<?php

namespace App\Services\Tracks;

use App\Models\Track;
use App\Repositories\Tracks\TrackRepositoryInterface;
use App\Services\StreamingImporter\StreamingImporterServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class TrackService implements TrackServiceInterface
{
    protected TrackRepositoryInterface $repository;
    protected StreamingImporterServiceInterface $importer;

    public function __construct(TrackRepositoryInterface $repository, StreamingImporterServiceInterface $importer)
    {
        $this->repository = $repository;
        $this->importer = $importer;
    }

    public function import(string $isrc): ?Track
    {
        // Checa se a faixa já existe para evitar importações duplicadas
        $existingTracks = $this->repository->find(['isrc' => $isrc]);
        if ($existingTracks->isNotEmpty()) {
            return null; // Faixa já existe, não importa novamente
        }

        $data = $this->importer->import($isrc);
        if (!$data) {
            return null; // Importação falhou, retorna null
        }

        return $this->repository->create($data);
    }

    public function create(array $data): Track
    {
        return $this->repository->create($data);
    }

    public function find(array $filters): Collection
    {
        return $this->repository->find($filters);
    }
}