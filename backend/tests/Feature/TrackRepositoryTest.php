<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Track;
use App\Repositories\Tracks\TrackRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected TrackRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new TrackRepository();
    }

    public function test_can_search_by_isrc(): void
    {
        $track1 = Track::factory()->create();
        $track2 = Track::factory()->create();

        $tracks = $this->repository
            ->search(['isrc' => $track1->isrc])
            ->get();

        $this->assertCount(1, $tracks);

        $this->assertEquals(
            $track1->isrc,
            $tracks->first()->isrc
        );
    }

    public function test_can_search_by_title(): void
    {
        $title1 = $this->faker->sentence(3);
        $title2 = $this->faker->sentence(3);
        Track::factory()->create([
            'title' => $title1,
        ]);

        Track::factory()->create([
            'title' => $title2,
        ]);

        $tracks = $this->repository
            ->search(['title' => $title1])
            ->get();

        $this->assertCount(1, $tracks);

        $this->assertEquals(
            $title1,
            $tracks->first()->title
        );
    }

    public function test_paginate_returns_paginated_result(): void
    {
        Track::factory()->count(30)->create();

        $result = $this->repository->paginate([], null, 15);

        $this->assertCount(15, $result->items());

        $this->assertEquals(30, $result->total());
    }

    public function test_search_loads_artists_relationship(): void
    {
        $track = Track::factory()->create();

        $artist = Artist::factory()->create();

        $track->artists()->attach($artist->id);

        $result = $this->repository
            ->search([])
            ->first();

        $this->assertTrue(
            $result->relationLoaded('artists')
        );

        $this->assertCount(1, $result->artists);
    }
}
