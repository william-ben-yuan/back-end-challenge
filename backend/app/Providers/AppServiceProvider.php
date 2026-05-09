<?php

namespace App\Providers;

use App\Repositories\Artists\ArtistRepository;
use App\Repositories\Artists\ArtistRepositoryInterface;
use App\Repositories\Tracks\TrackRepository;
use App\Repositories\Tracks\TrackRepositoryInterface;
use App\Services\StreamingImporter\SpotifyImporterService;
use App\Services\StreamingImporter\StreamingImporterServiceInterface;
use App\Services\Tracks\TrackService;
use App\Services\Tracks\TrackServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(
            TrackRepositoryInterface::class,
            TrackRepository::class
        );

        $this->app->bind(
            ArtistRepositoryInterface::class,
            ArtistRepository::class
        );

        // Services
        $this->app->bind(
            TrackServiceInterface::class,
            TrackService::class
        );
        $this->app->bind(
            StreamingImporterServiceInterface::class,
            SpotifyImporterService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
