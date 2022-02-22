<?php declare(strict_types=1);

namespace Tests\Feature;

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
