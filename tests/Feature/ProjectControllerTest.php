<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * create project.
     *
     * @test
     * @return void
     */
    public function create_project(): void
    {
        Client::factory()->create();
        $data = [
            'name' => $this->faker->name(),
            'deadline' => now(),
            'client_id' => Client::first()['id'] ?? null,
        ];
        $resp = $this->post(route('projects.store'), $data);

        $resp->assertOk();
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);
    }

    /**
     * destroy project.
     *
     * @test
     * @return void
     */
    public function destroy_project(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $resp = $this->delete(route('projects.destroy', ['project' => Project::first()]));
        $resp->assertOk();
        $this->assertDatabaseCount('projects', 0);
    }

    /**
     * verify owner of project.
     *
     * @test
     * @return void
     */
    public function verify_owner_of_project(): void
    {
        Project::factory()->create();
        $project = Project::first();
        $this->assertInstanceOf(Client::class, $project['owner'] ?? null);
        $this->assertSame(Client::first()['id'] ?? null, $project['owner']['id'] ?? null);
    }
}
