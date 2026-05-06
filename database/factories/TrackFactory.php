<?php

namespace Database\Factories;

use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isrc' => $this->faker->unique()->regexify('[A-Z]{2}[A-Z0-9]{3}[0-9]{7}'),
            'title' => $this->faker->sentence(3),
            'release_date' => $this->faker->date(),
            'duration' => $this->faker->numberBetween(120, 420),
            'album_thumbnail_url' => $this->faker->imageUrl(200, 200, 'music', true),
            'preview_url' => $this->faker->url(),
            'spotify_url' => $this->faker->url(),
            'is_available_in_brazil' => $this->faker->boolean(80), 
        ];
    }
}
