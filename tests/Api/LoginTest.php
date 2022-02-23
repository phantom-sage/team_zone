<?php declare(strict_types=1);


namespace Tests\Api;


use App\Models\Client;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

final class LoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var string[][]
     */
    private array $admin_json_data_structure;

    /**
     * @var array
     */
    private array $not_found_json_data_structure;

    /**
     * @var array
     */
    private array $client_json_data_structure;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->admin_json_data_structure = [
            'data' => [
                'id',
                'name',
                'username',
                'email',
                'created_at',
                'updated_at',
            ],
        ];
        $this->not_found_json_data_structure = [
            'message',
        ];

        $this->client_json_data_structure = [
            'data' => [
                'id',
                'name',
                'username',
                'email',
                'created_at',
                'updated_at',
            ],
        ];
    }

    /**
     * login as admin with valid username and password.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_username_password(): void
    {
        User::factory([
            'username' => 'username',
        ])->create();
        $data = [
            'username' => 'username',
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->admin_json_data_structure)->assertOk();
    }

    /**
     * login as admin with wrong username.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_wrong_username(): void
    {
        User::factory()->create();
        $data = [
            'username' => 'wrong username',
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as admin with username and wrong password.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_username_with_wrong_password(): void
    {
        User::factory()->create();
        $data = [
            'username' => User::first()['username'] ?? null,
            'password' => 'passwords',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as admin with valid email and password.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_email(): void
    {
        User::factory()->create();
        $data = [
            'email' => User::first()['email'] ?? null,
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->admin_json_data_structure)->assertOk();
    }

    /**
     * login as admin with wrong email.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_wrong_email(): void
    {
        User::factory()->create();
        $data = [
            'email' => 'wrong@email.com',
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as admin with wrong password.
     *
     * @test
     * @return void
     */
    public function login_as_admin_with_wrong_password(): void
    {
        User::factory()->create();
        $data = [
            'email' => User::first()['email'] ?? null,
            'password' => 'passwords',
        ];
        $resp = $this->post('/api/users/admin/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * empty request body.
     *
     * @test
     * @return void
     */
    public function empty_request_body(): void
    {
        $endpoints = [
            '/api/users/admin/login',
            '/api/users/client/login',
        ];
        foreach ($endpoints as $endpoint) {
            $resp = $this->post($endpoint);
            $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
        }
    }

    /**
     * login as client with valid username and password.
     *
     * @test
     * @return void
     */
    public function login_as_client(): void
    {
        Client::factory()->create();
        $data = [
            'username' => Client::first()['username'] ?? null,
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->client_json_data_structure)->assertOk();
    }

    /**
     * login as client with wrong username.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_wrong_username(): void
    {
        Client::factory()->create();
        $data = [
            'username' => 'wrong username',
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as client with wrong password.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_username_wrong_password(): void
    {
        Client::factory()->create();
        $data = [
            'username' => Client::first()['username'] ?? null,
            'password' => 'passwords',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as client with wrong email.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_invalid_email(): void
    {
        Client::factory()->create();
        $data = [
            'email' => 'wrong@email.com',
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as client with valid email and wrong password.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_email_and_wrong_password(): void
    {
        Client::factory()->create();
        $data = [
            'email' => Client::first()['email'] ?? null,
            'password' => 'passwords',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->not_found_json_data_structure)->assertNotFound();
    }

    /**
     * login as client with valid email and password.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_valid_email_password(): void
    {
        Client::factory()->create();
        $data = [
            'email' => Client::first()['email'] ?? null,
            'password' => 'password',
        ];
        $resp = $this->post('/api/users/client/login', $data);
        $resp->assertJsonStructure($this->client_json_data_structure)->assertOk();
    }
}
