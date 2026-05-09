<?php

namespace Tests\Unit;

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
    private array $track;

    protected function setUp(): void
    {
        parent::setUp();

        $this->track = [
            'title' => $this->faker->sentence(3),
            'isrc' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'artists' => [],
        ];
    }

    public function test_import_throws_exception_when_track_already_exists(): void
    {
        $repository = Mockery::mock(TrackRepositoryInterface::class);
        $importer = Mockery::mock(StreamingImporterServiceInterface::class);
        $builder = Mockery::mock(Builder::class);

        $repository
            ->shouldReceive('search')
            ->once()
            ->with(['isrc' => $this->track['isrc']])
            ->andReturn($builder);

        $builder
            ->shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $service = new TrackService($repository, $importer);

        $this->expectException(TrackAlreadyExistsException::class);

        $service->import($this->track['isrc']);
    }

    public function test_import_creates_track_successfully(): void
    {
        $repository = Mockery::mock(TrackRepositoryInterface::class);
        $importer = Mockery::mock(StreamingImporterServiceInterface::class);
        $builder = Mockery::mock(Builder::class);

        $track = new Track([
            'title' => $this->track['title'],
            'isrc' => $this->track['isrc'],
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
            ->with($this->track['isrc'])
            ->andReturn([
                'title' => $this->track['title'],
                'isrc' => $this->track['isrc'],
                'artists' => $this->track['artists'],
            ]);

        $repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($track);

        $service = new TrackService($repository, $importer);

        $result = $service->import($this->track['isrc']);

        $this->assertInstanceOf(Track::class, $result);
        $this->assertEquals($this->track['isrc'], $result->isrc);
    }
}
