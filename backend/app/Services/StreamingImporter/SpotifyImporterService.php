<?php

namespace App\Services\StreamingImporter;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SpotifyImporterService implements StreamingImporterServiceInterface
{
    public function getAccessToken(): string
    {
        // Utiliza cache para armazenar o token de acesso por 3500 segundos (pouco menos de 1 hora), para evitar chamadas desnecessárias à API de autenticação do Spotify
        return Cache::remember('spotify_access_token', now()->addSeconds(3500), function () {
            $response = Http::asForm()->post(
                config('services.spotify.auth_url') . '/token',
                [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('services.spotify.client_id'),
                    'client_secret' => config('services.spotify.client_secret'),
                ]
            );

            if ($response->failed()) {
                throw new \Exception('Failed to obtain Spotify access token');
            }

            return $response->json()['access_token'];
        });
    }

    public function import(string $isrc): ?array
    {
        $response = Http::withToken($this->getAccessToken())
            ->get(config('services.spotify.api_url') . '/search', [
                'q' => 'isrc:' . $isrc,
                'type' => 'track',
                'market' => 'BR', // Especifica o mercado para verificar disponibilidade
            ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch track information from Spotify');
        }

        $data = $response->json();
        $track = $data['tracks']['items'][0] ?? null;

        if (!$track) {
            throw new \Exception('Track not found on Spotify');
        }

        return [
            'isrc' => $isrc,
            'title' => $track['name'],
            'artists' => $track['artists'],
            'release_date' => $track['album']['release_date'],
            'duration' => $track['duration_ms'],
            'album_thumbnail_url' => $track['album']['images'][0]['url'] ?? null,
            'preview_url' => $track['preview_url'] ?? null,
            'spotify_url' => $track['external_urls']['spotify'],
            'is_available_in_brazil' => $track['is_playable'] ?? false,
        ];
    }
}
