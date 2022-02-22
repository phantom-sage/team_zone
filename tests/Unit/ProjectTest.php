<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * add team member to project to test many to many relationship.
     *
     * @test
     * @return void
     */
    public function add_team_member_to_project(): void
    {
        Project::factory()->create();
        TeamMember::factory()->create();

        $project = Project::first();
        $team_member = TeamMember::first();
        $project->staff()->attach($team_member->id, [
            'role' => $this->faker->name(),
        ]);

        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('team_members', 1);
    }
}
