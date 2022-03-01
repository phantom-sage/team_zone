<?php

namespace Tests\Feature;

use App\Models\Hr;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HrControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * hr index route.
     *
     * @test
     * @return void
     */
    public function hr_index_route(): void
    {
        Hr::factory()->count(10)->create();
        $this->assertDatabaseCount('hrs', 10);
        $this->get(route('hrs.index'))->assertOk();
    }

    /**
     * hr create route.
     *
     * @test
     * @return void
     */
    public function hr_create_route(): void
    {
        $this->get(route('hrs.create'))->assertOk();
    }

    /**
     * hr store route.
     *
     * @test
     * @return void
     */
    public function hr_store_route(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
        ];
        $resp = $this->post(route('hrs.store'), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('hrs', 1);
    }

    /**
     * hr show route.
     *
     * @test
     * @return void
     */
    public function hr_show_route(): void
    {
        Hr::factory()->create();
        $this->assertDatabaseCount('hrs', 1);
        $hr_id = Hr::first()['id'] ?? null;
        $this->get(route('hrs.show', ['hr' => $hr_id]))->assertOk();
    }

    /**
     * hr edit route.
     *
     * @test
     * @return void
     */
    public function hr_edit_route(): void
    {
        Hr::factory()->create();
        $this->assertDatabaseCount('hrs', 1);
        $hr_id = Hr::first()['id'] ?? null;
        $this->get(route('hrs.edit', ['hr' => $hr_id]))->assertOk();
    }

    /**
     * hr update route.
     *
     * @test
     * @return void
     */
    public function hr_update_route(): void
    {
        Hr::factory()->create();
        $this->assertDatabaseCount('hrs', 1);
        $data = [
            'name' => 'new name',
            'username' => Hr::first()['username'] ?? '',
            'email' => Hr::first()['email'] ?? '',
            'password' => 'password',
        ];
        $hr_id = Hr::first()['id'] ?? null;
        $resp = $this->put(route('hrs.update', ['hr' => $hr_id]), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('hrs', 1);
        $this->assertSame('new name', Hr::first()['name'] ?? null);
    }

    /**
     * hr destroy route.
     *
     * @test
     * @return void
     */
    public function hr_destroy_route(): void
    {
        Hr::factory()->create();
        $this->assertDatabaseCount('hrs', 1);
        $hr_id = Hr::first()['id'] ?? null;
        $this->delete(route('hrs.destroy', ['hr' => $hr_id]))->assertOk();
        $this->assertDatabaseCount('hrs', 0);
    }
}
