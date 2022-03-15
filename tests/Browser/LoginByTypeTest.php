<?php declare(strict_types=1);

namespace Tests\Browser;

use App\Models\Client;
use App\Models\Hr;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

final class LoginByTypeTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * login by type as hr manager.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_as
     * @return void
     * @throws Throwable
     */
    public function login_by_type_as_hr_manager():  void
    {
        Hr::factory()->create();
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.as'))
                ->typeSlowly('#email', Hr::first()['email'] ?? null)
                ->typeSlowly('#password', 'password')
                ->select('#type', 'hr_manager')
                ->click('button[type=submit]')
                ->pause(3000)
                ->assertPathIs('/hr/manager/dashboard')
                ->assertSee('Hello, ' . Hr::first()['name']);
        });
    }

    /**
     * login by type as project manager.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     * @throws Throwable
     */
    public function login_by_type_as_project_manager(): void
    {

        Client::factory()->create();
        Project::factory([
            'client_id' => Client::first()['id'] ?? 0,
        ])->create();
        TeamMember::factory([
            'type' => 'project_manager',
            'project_id' => Project::first()['id'] ?? 0,
        ])->create();
        $this->browse(function (Browser $browser) {
            $browser->maximize()
            ->visit(route('login.as'))
            ->typeSlowly('#email', TeamMember::first()['email'])
            ->typeSlowly('#password', 'password')
            ->select('#type', 'project_manager')
            ->click('button[type=submit]')
            ->pause(3000)
            ->assertPathIs('/project/manager/dashboard')
            ->assertSee('Hello, ' . TeamMember::first()['name']);
        });
    }

    /**
     * login by type as team member.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     * @throws Throwable
     */
    public function login_by_type_as_team_member(): void
    {
        Project::factory()->create();
        Task::factory([
            'project_id' => Project::first()['id'],
        ])->create();
        TeamMember::factory()->create();
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit(route('login.as'))
                ->typeSlowly('#email', TeamMember::first()['email'])
                ->typeSlowly('#password', 'password')
                ->select('#type', 'team_member')
                ->click('button[type=submit]')
                ->pause(3000)
                ->assertPathIs('/team-member/dashboard')
                ->assertSee('Hello, ' . TeamMember::first()['name']);
        });
    }
}
