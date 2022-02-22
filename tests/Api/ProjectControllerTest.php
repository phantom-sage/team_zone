<?php declare(strict_types=1);


namespace Tests\Api;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $resp->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'deadline',
                    'client_id',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
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
        $project_id = Project::first()->id;
        $resp = $this->get("/api/projects/$project_id");
        $resp->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'deadline',
                'client_id',
                'created_at',
                'updated_at',
            ],
        ]);
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);
    }
}
