<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * tasks index route.
     *
     * @test
     * @return void
     */
    public function tasks_index_route(): void
    {
        Task::factory()->count(10)->create();
        $this->assertDatabaseCount('tasks', 10);

        $resp = $this->get(route('tasks.index'));
        $resp->assertOk();
    }

    /**
     * tasks create route.
     *
     * @test
     * @return void
     */
    public function tasks_create_route(): void
    {
        $resp = $this->get(route('tasks.create'));
        $resp->assertOk();
    }

    /**
     * tasks show route.
     *
     * @test
     * @return void
     */
    public function tasks_show_route(): void
    {
        Task::factory()->create();
        $this->assertDatabaseCount('tasks', 1);
        $task_id = Task::first()['id'] ?? null;
        $resp = $this->get(route('tasks.show', ['task' => $task_id]));
        $resp->assertOk();
    }


    /**
     * tasks update route.
     *
     * @test
     * @return void
     */
    public function tasks_update_route(): void
    {
        Task::factory()->create();
        $this->assertDatabaseCount('tasks', 1);
        $task_id = Task::first()['id'] ?? null;
        $resp = $this->put(route('tasks.update', ['task' => $task_id]));
        $resp->assertOk();
    }


    /**
     * tasks destroy route.
     *
     * @test
     * @return void
     */
    public function tasks_destroy_route(): void
    {
        Task::factory()->create();
        $this->assertDatabaseCount('tasks', 1);
        $task_id = Task::first()['id'] ?? null;
        $resp = $this->delete(route('tasks.show', ['task' => $task_id]));
        $resp->assertOk();
    }

    /**
     * tasks edit route.
     *
     * @test
     * @return void
     */
    public function tasks_edit_route(): void
    {
        Task::factory()->create();
        $this->assertDatabaseCount('tasks', 1);
        $task_id = Task::first()['id'] ?? null;
        $resp = $this->get(route('tasks.edit', ['task' => $task_id]));
        $resp->assertOk();
    }


    /**
     * add task.
     *
     * @test
     * @return void
     */
    public function add_task(): void
    {
        Project::factory()->create();
        TeamMember::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'duration' => now()->format('d-m-Y'),
            'status' => $this->faker->name(),
            'project_id' => Project::first()['id'] ?? null,
            'team_member_id' => TeamMember::first()['id'] ?? null,
        ];
        $resp = $this->post(route('tasks.store'), $data);
        $resp->assertStatus(302);
        $this->assertDatabaseCount('tasks', 1);
    }
}
