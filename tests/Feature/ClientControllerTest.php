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
     * add client.
     *
     * @test
     * @return void
     */
    public function add_client(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
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
