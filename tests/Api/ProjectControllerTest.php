<?php declare(strict_types=1);


namespace Tests\Api;

use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * get client project.
     *
     * @test
     */
    public function get_client_project(): void
    {


        Project::factory()->count(1)->create();
        TeamMember::factory()->create();
        Task::factory([
            'project_id' => Project::first()['id'] ?? null,
            'team_member_id' => TeamMember::first()['id'] ?? null,
        ])->count(5)->create();
        $this->assertDatabaseCount('projects', 6);
        $this->assertDatabaseCount('tasks', 5);
        $this->assertDatabaseCount('team_members', 6);

        $resp = $this->postJson('/api/client/project', [
            'code' => Project::first()['code'] ?? null,
        ]);
        $project = Project::first() ?? null;

        $resp->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 11)
            ->has('data', fn($json) => $json->where('id', 1)
                ->where('id', $project['id'] ?? null)
                ->where('name', $project['name'] ?? null)
                ->where('deadline', $project['deadline'] ?? null)
                ->where('status', $project['status'] ?? null)
                ->where('code', $project['code'] ?? null)
                ->where('created_at', $project->created_at ? $project->created_at->format('Y-m-d h:i:s') : null)
                ->where('updated_at', $project->updated_at ? $project->updated_at->format('Y-m-d h:i:s') : null)
                ->where('owner', $project['owner'] ?? null)
                ->where('staff', $project['staff'] ?? null)
                ->where('manager', $project['manager'] ?? null)
                ->where('manager', $project['manager'] ?? null)
                ->where('tasks', $project['tasks'] ?? null)
                ->etc()
            )
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
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
        $resp = $this->putJson('/api/projects/' . $project_id);
        $resp->assertOk();
    }


    /**
     * projects destroy route.
     *
     * @test
     * @return void
     */
    public function projects_destroy_route(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $project_id = Project::first()['id'] ?? null;
        $resp = $this->deleteJson('/api/projects/' . $project_id);
        $resp->assertOk();
    }

    /**
     * project store route.
     *
     * @test
     * @return void
     */
    public function project_store_route(): void
    {
        $this->post('/api/projects/')->assertOk();
    }

    /**
     * collection of projects.
     *
     * @test
     * @return void
     */
    public function collection_of_projects(): void
    {
        Project::factory()->count(10)->create();
        $resp = $this->get('/api/projects');
        $project = Project::first() ?? null;
        if ($project) {
            $resp->assertJson(fn(AssertableJson $json) => $json
                ->has('data', 10)
                ->has('data.0', fn($json) => $json->where('id', 1)
                    ->where('id', $project['id'] ?? null)
                    ->where('name', $project['name'] ?? null)
                    ->where('deadline', $project['deadline'] ?? null)
                    ->where('client_id', $project['client_id'] ?? null)
                    ->where('created_at', $project->created_at ? $project->created_at->format('Y-m-d h:i:s') : null)
                    ->where('updated_at', $project->updated_at ? $project->updated_at->format('Y-m-d h:i:s') : null)
                    ->where('owner', $project['owner'] ?? null)
                    ->where('staff', $project['staff'] ?? null)
                    ->where('manager', $project['manager'] ?? null)
                    ->etc()
                )
            );
        }
        $this->assertDatabaseCount('projects', 10);
        $this->assertDatabaseCount('clients', 10);
    }


    /**
     * single project resource.
     *
     * @test
     * @return void
     */
    public function single_project_resource(): void
    {
        Project::factory()->create();
        $project_id = Project::first()['id'] ?? null;
        $resp = $this->get("/api/projects/$project_id");
        $project = Project::first() ?? null;
        if ($project) {
            $resp->assertJson(fn(AssertableJson $json) => $json->where('data.id', $project['id'] ?? null)
                ->where('data.name', $project['name'] ?? null)
                ->where('data.deadline', $project['deadline'] ?? null)
                ->where('data.client_id', $project['client_id'] ?? null)
                ->where('data.created_at', $project->created_at ? $project->created_at->format('Y-m-d h:i:s') : null)
                ->where('data.updated_at', $project->updated_at ? $project->updated_at->format('Y-m-d h:i:s') : null)
                ->where('data.owner', $project['owner'] ?? null)
                ->where('data.staff', $project['staff'] ?? null)
                ->where('data.manager', $project['manager'] ?? null)
                ->etc()
            );
        }
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);
    }
}
