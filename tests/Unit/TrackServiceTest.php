<?php

namespace Tests\Unit\Services\Tracks;

use App\Exceptions\TrackAlreadyExistsException;
use App\Models\Track;
use App\Repositories\Tracks\TrackRepositoryInterface;
use App\Services\StreamingImporter\StreamingImporterServiceInterface;
use App\Services\Tracks\TrackService;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Tests\TestCase;

class TrackServiceTest extends TestCase
{
    const TRACK = [
        'title' => 'Test Track',
        'isrc' => 'ABC123',
        'artists' => [],
    ];
    public function test_import_throws_exception_when_track_already_exists(): void
    {
        $repository = Mockery::mock(TrackRepositoryInterface::class);
        $importer = Mockery::mock(StreamingImporterServiceInterface::class);
        $builder = Mockery::mock(Builder::class);

        $repository
            ->shouldReceive('search')
            ->once()
            ->with(['isrc' => self::TRACK['isrc']])
            ->andReturn($builder);

        $builder
            ->shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $service = new TrackService($repository, $importer);

        $this->expectException(TrackAlreadyExistsException::class);

        $service->import(self::TRACK['isrc']);
    }

    public function test_import_creates_track_successfully(): void
    {
        $repository = Mockery::mock(TrackRepositoryInterface::class);
        $importer = Mockery::mock(StreamingImporterServiceInterface::class);
        $builder = Mockery::mock(Builder::class);

        $track = new Track([
            'title' => 'Test Track',
            'isrc' => 'ABC123',
        ]);

        $repository
            ->shouldReceive('search')
            ->once()
            ->andReturn($builder);

        $builder
            ->shouldReceive('exists')
            ->once()
            ->andReturn(false);

        $importer
            ->shouldReceive('import')
            ->once()
            ->with(self::TRACK['isrc'])
            ->andReturn([
                'title' => self::TRACK['title'],
                'isrc' => self::TRACK['isrc'],
                'artists' => self::TRACK['artists'],
            ]);

        $repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($track);

        $service = new TrackService($repository, $importer);

        $result = $service->import(self::TRACK['isrc']);

        $this->assertInstanceOf(Track::class, $result);
        $this->assertEquals(self::TRACK['isrc'], $result->isrc);
    }
}
