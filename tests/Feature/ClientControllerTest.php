<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class ClientControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }


    /**
     * client update route.
     *
     * @test
     * @return void
     */
    public function client_update_route(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $client_id = Client::first()['id'] ?? null;
        $resp = $this->put(route('clients.update', ['client' => $client_id]));
        $resp->assertOk();
    }

    /**
     * client edit route.
     *
     * @test
     * @return void
     */
    public function client_edit_route(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $client_id = Client::first()['id'] ?? null;
        $resp = $this->get(route('clients.edit', ['client' => $client_id]));
        $resp->assertOk();
    }

    /**
     * client show route.
     *
     * @test
     * @return void
     */
    public function client_show_route(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $client_id = Client::first()['id'] ?? null;
        $resp = $this->get(route('clients.show', ['client' => $client_id]));
        $resp->assertOk();
    }

    /**
     * client create route.
     *
     * @test
     * @return void
     */
    public function client_create_route(): void
    {
        $this->get(route('clients.create'))->assertOk();
    }

    /**
     * client index route.
     *
     * @test
     * @return void
     */
    public function client_index_route(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $this->get(route('clients.index'))->assertOk();
    }

    /**
     * add client.
     *
     * @test
     * @return void
     */
    public function add_client(): void
    {
        $data = [
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
        $resp = $this->post(route('clients.store'), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('clients', 1);
    }

    /**
     * delete client.
     *
     * @test
     * @return void
     */
    public function delete_client(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $client_id = Client::first()['id'] ?? null;
        $resp = $this->delete(route("clients.destroy", ['client' => $client_id]));
        $resp->assertOk();
        $this->assertDatabaseCount('clients', 0);
    }
}
