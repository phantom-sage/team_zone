<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class TeamMemberControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * team members update route.
     *
     * @test
     * @return void
     */
    public function team_members_update_route(): void
    {
        TeamMember::factory()->create();
        $this->assertDatabaseCount('team_members', 1);
        $team_member_id = TeamMember::first()['id'] ?? null;
        $resp = $this->put(route('team_members.update', ['team_member'  => $team_member_id]));
        $resp->assertOk();
    }

    /**
     * team members edit route.
     *
     * @test
     * @return void
     */
    public function team_members_edit_route(): void
    {
        TeamMember::factory()->create();
        $this->assertDatabaseCount('team_members', 1);
        $team_member_id = TeamMember::first()['id'] ?? null;
        $resp = $this->get(route('team_members.edit', ['team_member'  => $team_member_id]));
        $resp->assertOk();
    }

    /**
     * team members show route.
     *
     * @test
     * @return void
     */
    public function team_members_show_route(): void
    {
        TeamMember::factory()->create();
        $this->assertDatabaseCount('team_members', 1);
        $team_member_id = TeamMember::first()['id'] ?? null;
        $resp = $this->get(route('team_members.show', ['team_member'  => $team_member_id]));
        $resp->assertOk();
    }


    /**
     * team members create route.
     *
     * @test
     * @return void
     */
    public function team_members_create_route(): void
    {
        $this->get(route('team_members.create'))->assertOk();
    }

    /**
     * team member index route.
     *
     * @test
     * @return void
     */
    public function team_member_index_route(): void
    {
        TeamMember::factory()->count(10)->create();
        $this->assertDatabaseCount('team_members', 10);

        $resp = $this->get(route('team_members.index'));
        $resp->assertOk();
    }

    /**
     * add team member as project manager.
     *
     * @test
     * @return void
     */
    public function add_team_member_as_project_manager(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => 'project_manager',
        ];
        $resp = $this->post(route('team_members.store'), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('team_members', 1);
        $this->assertSame('project_manager', TeamMember::first()['type'] ?? null);
    }

    /**
     * add team member as team member.
     *
     * @test
     * @return void
     */
    public function add_team_member_as_team_member(): void
    {
        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => 'team_member',
        ];
        $resp = $this->post(route('team_members.store'), $data);
        $resp->assertOk();
        $this->assertDatabaseCount('team_members', 1);
        $this->assertSame('team_member', TeamMember::first()['type'] ?? null);
    }

    /**
     * delete team member.
     *
     * @test
     * @return void
     */
    public function delete_team_member(): void
    {
        TeamMember::factory()->create();
        $this->assertDatabaseCount('team_members', 1);
        $team_member_id = TeamMember::first()['id'] ?? null;
        $resp = $this->delete(route('team_members.destroy', ['team_member' => $team_member_id]));
        $resp->assertOk();
        $this->assertDatabaseCount('team_members', 0);
    }

    /**
     * add project manager.
     *
     * @test
     * @return void
     */
    public function add_project_manager(): void
    {
        Project::factory()->create();
        TeamMember::factory([
            'type' => 'project_manager',
            'project_id' => Project::first()['id'] ?? null,
        ])->create();
        $this->assertInstanceOf(Project::class, TeamMember::first()['project'] ?? null);
        $this->assertInstanceOf(TeamMember::class, Project::first()['manager'] ?? null);
    }
}
