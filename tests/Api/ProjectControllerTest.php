<?php declare(strict_types=1);


namespace Tests\Api;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
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
