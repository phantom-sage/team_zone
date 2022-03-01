<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'duration' => $this->faker->date(),
            'status' => 'Completed',
            'description' => $this->faker->sentence(),
            'project_id' => Project::factory()->create(),
            'team_member_id' => TeamMember::factory()->create(),
        ];
    }
}
