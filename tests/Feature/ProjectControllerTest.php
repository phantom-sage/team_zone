<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Events\NewProjectCreated;
use App\Models\Client;
use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
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
     * rate project after end.
     *
     * @test
     */
    public function rate_project_after_end(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $data = [
            'rate' => 123
        ];
        $project = Project::first() ?? null;
        if ($project) {
            $resp = $this->put(route('projects.rate', ['project' => $project['id']]), $data);
            $project->refresh();
            $resp->assertOk();
            $this->assertEquals(123, $project['rate']);
            $this->assertDatabaseCount('projects', 1);
        }
    }

    /**
     * create project.
     *
     * @test
     * @return void
     */
    public function create_project(): void
    {
        Event::fake();
        TeamMember::factory(['type' => 'project_manager'])->create();
        $project_manager_id = TeamMember::first()['id'] ?? null;
        if ($project_manager_id != null) {
            $data = [
                'name' => $this->faker->name(),
                'deadline' => now(),
                'client_username' => $this->faker->name(),
                'client_email' => 'abdoeltayeb10@gmail.com',
                'status' => $this->faker->title(),
                'project_manager_id' => $project_manager_id,
            ];
            $resp = $this->post(route('projects.store'), $data);
            Event::assertDispatched(NewProjectCreated::class);

            $resp->assertStatus(302);
            $this->assertDatabaseCount('projects', 1);
            $this->assertDatabaseCount('clients', 1);
        }
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


    /**
     * projects index route.
     *
     * @test
     * @return void
     */
    public function projects_index_route(): void
    {
        Project::factory()->count(10)->create();
        $this->assertDatabaseCount('projects', 10);

        $resp = $this->get(route('projects.index'));
        $resp->assertOk();
    }


    /**
     * projects create route.
     *
     * @test
     * @return void
     */
    public function projects_create_route(): void
    {
        $resp = $this->get(route('projects.create'));
        $resp->assertOk();
    }


    /**
     * projects show route.
     *
     * @test
     * @return void
     */
    public function projects_show_route(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);

        $project_id = Project::first()['id'] ?? null;
        $resp = $this->get(route('projects.show', ['project' => $project_id]));
        $resp->assertOk();
    }


    /**
     * projects edit route.
     *
     * @test
     * @return void
     */
    public function projects_edit_route(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);

        $project_id = Project::first()['id'] ?? null;
        $resp = $this->get(route('projects.edit', ['project' => $project_id]));
        $resp->assertOk();
    }

    /**
     * projects update route.
     *
     * @test
     * @return void
     */
    public function projects_update_route(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);

        $project_id = Project::first()['id'] ?? null;
        $resp = $this->put(route('projects.update', ['project' => $project_id]));
        $resp->assertOk();
    }
}
