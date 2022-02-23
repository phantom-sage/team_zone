<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Task;
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
        $task_id = Task::first()['id'] ?? null;
        $resp = $this->get(route('tasks.show', ['task' => $task_id]));
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
        $data = [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'duration' => now()->format('d-m-Y'),
            'status' => $this->faker->name(),
        ];
        $resp = $this->post(route('tasks.store'), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('tasks', 1);
    }
}
