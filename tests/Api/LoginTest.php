<?php declare(strict_types=1);


namespace Tests\Api;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
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
     * login as client with invalid email and invalid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_invalid_email_and_invalid_project_code(): void
    {
        $data = [
            'email' => 'email@not.found',
            'code' => Str::random(8),
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with invalid username and invalid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_invalid_username_and_invalid_project_code(): void
    {
        $data = [
            'username' => 'not found',
            'code' => Str::random(8),
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with valid email and invalid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_valid_email_and_invalid_project_code(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $data = [
            'email' => Client::first()['email'] ?? null,
            'code' => Str::random(8),
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with valid username and invalid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_valid_username_and_invalid_project_code(): void
    {
        Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $data = [
            'username' => Client::first()['username'] ?? null,
            'code' => Str::random(8),
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with invalid email and valid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_invalid_email_and_valid_project_code(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);

        $data = [
            'email' => 'email@not.found',
            'code' => Project::first()['code'] ?? null,
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with invalid username and valid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_invalid_username_and_valid_project_code(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);

        $data = [
            'username' => 'not found',
            'code' => Project::first()['code'] ?? null,
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $resp->assertNotFound()
            ->assertJson(fn(AssertableJson $json) => $json->where('message', 'NOT FOUND'));
    }

    /**
     * login as client with valid username and valid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_valid_username_and_valid_project_code(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);

        $data = [
            'username' => Client::first()['username'] ?? null,
            'code' => Project::first()['code'] ?? null,
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $project = Project::first() ?? null;
        if ($project) {
            $resp->assertOk()->assertJson(fn(AssertableJson $json) => $json->where('data.id', $project['id'] ?? null)
                ->where('data.name', $project['name'] ?? null)
                ->where('data.deadline', $project['deadline'] ?? null)
                ->where('data.client_id', $project['client_id'] ?? null)
                ->where('data.code', $project['code'] ?? null)
                ->where('data.owner', $project['owner'] ?? null)
                ->where('data.staff', $project['staff'] ?? null)
                ->where('data.manager', $project['manager'] ?? null)
                ->where('data.created_at', $project->created_at ? $project->created_at->format('Y-m-d h:i:s') : null)
                ->where('data.updated_at', $project->updated_at ? $project->updated_at->format('Y-m-d h:i:s') : null)
            );
        }
    }

    /**
     * login as client with valid email and valid project code.
     *
     * @test
     * @return void
     */
    public function login_as_client_with_valid_email_and_valid_project_code(): void
    {
        Project::factory()->create();
        $this->assertDatabaseCount('projects', 1);
        $this->assertDatabaseCount('clients', 1);

        $data = [
            'email' => Client::first()['email'] ?? null,
            'code' => Project::first()['code'] ?? null,
        ];
        $resp = $this->postJson('/api/users/client/login', $data);
        $project = Project::first() ?? null;
        if ($project) {
            $resp->assertOk()->assertJson(fn(AssertableJson $json) => $json->where('data.id', $project['id'] ?? null)
                ->where('data.name', $project['name'] ?? null)
                ->where('data.deadline', $project['deadline'] ?? null)
                ->where('data.client_id', $project['client_id'] ?? null)
                ->where('data.code', $project['code'] ?? null)
                ->where('data.owner', $project['owner'] ?? null)
                ->where('data.staff', $project['staff'] ?? null)
                ->where('data.manager', $project['manager'] ?? null)
                ->where('data.created_at', $project->created_at ? $project->created_at->format('Y-m-d h:i:s') : null)
                ->where('data.updated_at', $project->updated_at ? $project->updated_at->format('Y-m-d h:i:s') : null)
            );
        }
    }

}
