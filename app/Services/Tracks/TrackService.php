<?php

namespace App\Services\Tracks;

use App\Exceptions\TrackAlreadyExistsException;
use App\Exceptions\TrackImportFailedException;
use App\Models\Artist;
use App\Models\Track;
use App\Repositories\Tracks\TrackRepositoryInterface;
use App\Services\StreamingImporter\StreamingImporterServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrackService implements TrackServiceInterface
{
    protected TrackRepositoryInterface $repository;
    protected StreamingImporterServiceInterface $importer;

    public function __construct(TrackRepositoryInterface $repository, StreamingImporterServiceInterface $importer)
    {
        $this->repository = $repository;
        $this->importer = $importer;
    }

    public function import(string $isrc): Track
    {
        // Checa se a faixa já existe para evitar importações duplicadas
        $existingTracks = $this->repository->search(['isrc' => $isrc]);
        if ($existingTracks->isNotEmpty()) {
            throw new TrackAlreadyExistsException(
                "Track with ISRC {$isrc} already exists"
            );
        }

        $data = $this->importer->import($isrc);
        if (!$data) {
            throw new TrackImportFailedException(
                "Failed to import track {$isrc}: No data returned from importer"
            );
        }

        try {
            return DB::transaction(function () use ($data) {
                $track = $this->repository->create($data);
                $this->syncArtists($track, $data['artists']);
                return $track;
            });
        } catch (\Exception $e) {
            Log::error('Failed to import track with ISRC ' . $isrc . ': ' . $e->getMessage());
            throw new TrackImportFailedException(
                "Failed to import track {$isrc} : " . $e->getMessage()
            );
        }
    }

    public function create(array $data): Track
    {
        return $this->repository->create($data);
    }

    public function paginate(array $filters, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage, $page);
    }

    private function syncArtists(Track $track, array $artists): void
    {
        $artistIds = collect($artists)->map(function ($artist) {
            return Artist::firstOrCreate(['spotify_id' => $artist['id'], 'name' => $artist['name']])->id;
        })->toArray();

        $track->artists()->sync($artistIds);
    }
}
