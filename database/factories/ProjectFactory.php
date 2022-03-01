<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Client::factory()->create();
        return [
            'name' => $this->faker->name(),
            'deadline' => now(),
            'client_id' => Client::first()['id'] ?? null,
            'code' => Str::random(8),
            'status' => $this->faker->name(),
        ];
    }
}
