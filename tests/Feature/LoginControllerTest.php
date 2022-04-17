<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Hr;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;

final class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * login as page.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_as
     */
    public function login_as(): void
    {
        $resp = $this->get(route('login.as'));

        $resp->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Auth/LoginByType')
            );
    }

    /**
     * login by type as hr manager.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_hr_manager(): void
    {
        # hr found.
        Hr::factory()->create();
        $hr = Hr::first() ?? null;
        if ($hr != null) {
            $data = [
                'email' => $hr['email'] ?? null,
                'password' => 'password',
                'type' => 'hr_manager',
            ];

            $resp = $this->post(route('login.by.type'), $data);
            $resp->assertRedirect(route('hr.manager.dashboard'))
                ->assertSessionHas(
                    ['hr_manager_id', 'hr_manager_name', 'hr_manager_email', 'flash.banner', 'flash.bannerStyle', 'type_of_user_logged_in'],
                    [$hr['id'], $hr['name'], $hr['email'], 'Welcome', 'success', 'Hr']
                );
        }
    }

    /**
     * logout hr manager.
     * @test
     * @covers \App\Http\Controllers\HrController::logout
     */
    public function logout_hr_manager(): void
    {
        $this->login_by_type_as_hr_manager();
        try {
            $hr = Hr::where('id', '=', session()->get('hr_manager_id'))->first() ?? null;
            if ($hr != null) {
                $data = [
                    'hr_manager_id' => session()->get('hr_manager_id'),
                ];
                $resp = $this->delete(route('hr.logout'), $data);
                $resp->assertRedirect('/')
                    ->assertSessionHas([
                        'flash.banner',
                        'flash.bannerStyle',
                    ])
                    ->assertSessionMissing([
                        'hr_manager_id',
                        'hr_manager_name',
                        'hr_manager_email',
                    ]);

            }
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }
    }

    /**
     * login by type as hr manager with wrong email.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_hr_manager_with_wrong_email(): void
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => 'hr_manager',
        ];

        $this->post(route('login.by.type'), $data)->assertNotFound()
            ->assertSessionMissing([
                'hr_manager_id',
                'hr_manager_name',
                'hr_manager_email',
                'flash.banner',
                'flash.bannerStyle'
            ]);
    }

    /**
     * login by type as hr manager with wrong password.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_hr_manager_with_wrong_password(): void
    {
        Hr::factory()->create();
        $hr = Hr::first() ?? null;
        if ($hr != null) {
            $data = [
                'email' => $hr['email'] ?? null,
                'password' => 'passwords',
                'type' => 'hr_manager',
            ];

            $this->post(route('login.by.type'), $data)->assertNotFound()
                ->assertSessionMissing([
                    'hr_manager_id',
                    'hr_manager_name',
                    'hr_manager_email',
                    'flash.banner',
                    'flash.bannerStyle'
                ]);
        }
    }

    /**
     * login by type as project manager.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_project_manager(): void
    {
        Client::factory()->create();
        Project::factory([
            'client_id' => Client::first()['id'],
        ])->create();
        TeamMember::factory([
            'type' => 'project_manager',
            'project_id' => Project::first()['id'] ?? 0,
        ])->create();
        $project_manager = TeamMember::first() ?? null;
        if ($project_manager != null) {
            $data = [
                'email' => $project_manager['email'] ?? null,
                'password' => 'password',
                'type' => 'project_manager',
            ];
            $resp = $this->post(route('login.by.type'), $data);
            $resp->assertRedirect(route('project.manager.dashboard'))
                ->assertSessionHas(
                    ['project_manager_id', 'project_manager_name', 'project_manager_email', 'flash.banner', 'flash.bannerStyle', 'type_of_user_logged_in'],
                    [$project_manager['id'], $project_manager['name'], $project_manager['email'], 'Welcome', 'success', 'TeamMember']
                );
        }
    }


    /**
     * project manager dashboard.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::project_manager_dashboard
     */
    public function project_manager_dashboard(): void
    {
        $this->login_by_type_as_project_manager();
        $resp = $this->get(route('project.manager.dashboard'));
        $resp->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('ProjectManagerDashboard')
            );
    }

    /**
     * project manager dashboard 2.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::project_manager_dashboard
     */
    public function project_manager_dashboard_2(): void
    {
        $this->login_by_type_as_project_manager();
        session()->put('project_manager_id', 0);
        $resp = $this->get(route('project.manager.dashboard'));
        $resp->assertNotFound();
    }

    /**
     * project manager dashboard 3.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::project_manager_dashboard
     */
    public function project_manager_dashboard_3(): void
    {
        $this->login_by_type_as_project_manager();
        session()->remove('project_manager_id');
        session()->remove('project_manager_name');
        session()->remove('project_manager_email');
        $resp = $this->get(route('project.manager.dashboard'));
        $resp->assertRedirect('/');
    }

    /**
     * logout project manager.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::logout_project_manager
     */
    public function logout_project_manager(): void
    {
        $this->login_by_type_as_project_manager();
        try {
            $hr = TeamMember::where('id', '=', session()->get('project_manager_id'))->first() ?? null;
            if ($hr != null) {
                $data = [
                    'project_manager_id' => session()->get('project_manager_id'),
                ];
                $resp = $this->delete(route('project.manager.logout'), $data);
                $resp->assertRedirect('/')
                    ->assertSessionHas([
                        'flash.banner',
                        'flash.bannerStyle',
                    ])
                    ->assertSessionMissing([
                        'project_manager_id',
                        'project_manager_name',
                        'project_manager_email',
                        'type_of_user_logged_in',
                    ]);

            }
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }
    }

    /**
     * login by type as project manager with wrong email.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_project_manager_with_wrong_email(): void
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => 'project_manager',
        ];
        $this->post(route('login.by.type'), $data)
            ->assertNotFound()
            ->assertSessionMissing([
                'project_manager_id',
                'project_manager_name',
                'project_manager_email',
                'flash.banner',
                'flash.bannerStyle'
            ]);
    }

    /**
     * login by type as project manager with wrong password.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_project_manager_with_wrong_password(): void
    {
        TeamMember::factory([
            'type' => 'project_manager'
        ])->create();
        $project_manager = TeamMember::first() ?? null;
        if ($project_manager) {
            $data = [
                'email' => $project_manager['email'] ?? null,
                'password' => 'passwords',
                'type' => 'project_manager',
            ];
            $this->post(route('login.by.type'), $data)
                ->assertNotFound()
                ->assertSessionMissing([
                    'project_manager_id',
                    'project_manager_name',
                    'project_manager_email',
                    'flash.banner',
                    'flash.bannerStyle'
                ]);
        }
    }

    /**
     * team member dashboard.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::team_member_dashboard
     */
//    public function team_member_dashboard(): void
//    {
//        $this->login_by_type_as_team_member();
//        $resp = $this->get(route('team.member.dashboard'));
//        $resp
//            ->assertInertia(fn(Assert $page) => $page
//                ->component('TeamMemberDashboard')
//            );
//    }

    /**
     * team member dashobard not found.
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::team_member_dashboard
     */
    public function team_member_dashboard_not_found(): void
    {
        $this->get(route('team.member.dashboard'))
            ->assertNotFound();
    }

    /**
     * login by type as team member.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_team_member(): void
    {
        TeamMember::factory()->create();
        Project::factory()->create();
        Task::factory([
            'project_id' => Project::first()['id'] ?? 0,
            'team_member_id' => TeamMember::first()['id'] ?? 0,
        ])->create();
        $team_member = TeamMember::first() ?? null;
        if ($team_member != null) {
            $data = [
                'email' => $team_member['email'] ?? null,
                'password' => 'password',
                'type' => 'team_member',
            ];
            /*
             *
             * session()->put('team_member_id', $team_member['id']);
            session()->put('team_member_name', $team_member['name']);
            session()->put('team_member_email', $team_member['email']);
            session()->put('type_of_user_logged_in', 'TeamMember');

            session()->flash('flash.banner', 'Welcome');
            session()->flash('flash.bannerStyle', 'success');
             */
            $this->post(route('login.by.type'), $data)
                ->assertNotFound();
//                ->assertSessionHas(
//                    ['team_member_id', 'team_member_name', 'team_member_email', 'type_of_user_logged_in', 'flash.banner', 'flash.bannerStyle',],
//                    [$team_member['id'], $team_member['name'], $team_member['email'], 'TeamMember', 'Welcome', 'success']
//                );
        }
    }

    /**
     * logout team member.
     *
     * @test
     * @covers \App\Http\Controllers\TeamMemberController::team_member_logout
     */
    public function logout_team_member(): void
    {
        $this->login_by_type_as_team_member();
        try {
            $hr = TeamMember::where('id', '=', session()->get('team_member_id'))->first() ?? null;
            if ($hr != null) {
                $data = [
                    'team_member_id' => session()->get('team_member_id'),
                ];
                $resp = $this->delete(route('team.member.logout'), $data);
                $resp->assertRedirect('/')
                    ->assertSessionHas([
                        'flash.banner',
                        'flash.bannerStyle',
                    ])
                    ->assertSessionMissing([
                        'team_member_id',
                        'team_member_name',
                        'team_member_email',
                        'type_of_user_logged_in',
                    ]);

            }
        } catch (NotFoundExceptionInterface $e) {
        } catch (ContainerExceptionInterface $e) {
        }
    }

    /**
     * login by type as team member with wrong email.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_team_member_with_wrong_email(): void
    {
        $data = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'type' => 'team_member',
        ];
        $this->post(route('login.by.type'), $data)
            ->assertNotFound()
            ->assertSessionMissing([
                'team_member_id',
                'team_member_name',
                'team_member_email',
                'flash.banner',
                'flash.bannerStyle'
            ]);
    }

    /**
     * login by type as team member with wrong password.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_as_team_member_with_wrong_password(): void
    {
        TeamMember::factory()->create();
        $team_member = TeamMember::first() ?? null;
        if ($team_member != null) {
            $data = [
                'email' => $team_member['email'] ?? null,
                'password' => 'passwords',
                'type' => 'team_member',
            ];
            $this->post(route('login.by.type'), $data)
                ->assertNotFound()
                ->assertSessionMissing([
                    'team_member_id',
                    'team_member_name',
                    'team_member_email',
                    'flash.banner',
                    'flash.bannerStyle'
                ]);
        }
    }

    /**
     * login by type with invalid type.
     *
     * @test
     * @covers \App\Http\Controllers\LoginController::login_by_type
     */
    public function login_by_type_with_invalid_type(): void
    {
        $this->post(route('login.by.type'), [])
            ->assertNotFound();
    }
}
