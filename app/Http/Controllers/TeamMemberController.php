<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\TeamMember;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TeamMemberController extends Controller
{
    /**
     * team member logout.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function team_member_logout(Request $request)
    {
        $data = $request->validate([
            'team_member_id' => ['required', 'integer'],
        ]);
        session()->remove('team_member_id');
        session()->remove('team_member_name');
        session()->remove('team_member_email');
        session()->remove('type_of_user_logged_in');

        session()->flash('flash.banner', 'Logout');
        session()->flash('flash.bannerStyle', 'success');
        return redirect('/');
    }

    /**
     * team member dashboard.
     *
     * @return Response|string
     */
    public function team_member_dashboard()
    {
        //TODO: avoid use attach in belongs to many relation because it duplicates the rows use something else.
        if (session()->has('team_member_id') && session()->has('team_member_name') && session()->has('team_member_email')) {
            try {
                $team_member = TeamMember::where('id', '=', session()->get('team_member_id'))->first() ?? null;
                if ($team_member != null) {
                    $project_id = $team_member->task->project_id;
                    $project = Project::where('id', '=', $project_id)->first() ?? null;
                    return Inertia::render('TeamMemberDashboard', [
                        'team_member' => $team_member->load('task'),
                        'project' => $project
                    ]);
                }
                return abort(404, 'NOT FOUND');
            } catch (NotFoundExceptionInterface $e) {
                abort(500);
            } catch (ContainerExceptionInterface $e) {
                abort(500);
            }
        }
        return abort(404, 'NOT FOUND');
    }

    /**
     * logout project manager.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function logout_project_manager(Request $request)
    {
        $data = $request->validate([
            'project_manager_id' => ['required', 'integer'],
        ]);
        session()->remove('project_manager_id');
        session()->remove('project_manager_name');
        session()->remove('project_manager_email');
        session()->remove('type_of_user_logged_in');

        session()->flash('flash.banner', 'Logout');
        session()->flash('flash.bannerStyle', 'success');
        return redirect('/');
    }
    /**
     * project manager dashboard.
     *
     * @return Application|RedirectResponse|Redirector|Response|string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function project_manager_dashboard()
    {
        //TODO: avoid use attach in belongs to many relation because it duplicates the rows use something else.
        if (session()->has('project_manager_id') && session()->has('project_manager_name') && session()->has('project_manager_email')) {
            $project_manager = TeamMember::where('id', '=', session()->get('project_manager_id'))->first() ?? null;
            if ($project_manager != null) {
                $client = Client::where('id', '=', $project_manager->project->client_id)->first() ?? null;
                $project = Project::where('id', '=', $project_manager['project_id'] ?? null)->first() ?? null;
                $legitimate_team_members = TeamMember::where('project_id', '=', null)->where('type', '!=', 'project_manager')->get() ?? null;
                $legitimate_team_members_for_task_assignment = TeamMember::all()->filter(function ($team_member) {
                    return $team_member->task == null;
                });
                if ($client != null) {
                    return Inertia::render('ProjectManagerDashboard', [
                        'project_manager' => $project_manager->load('project'),
                        'client' => $client,
                        'project' => $project->load(['staff', 'tasks']),
                        'project_tasks' => $project->tasks->load('master'),
                        'legitimate_team_members' => $legitimate_team_members,
                        'legitimate_team_members_for_task_assignment' => $legitimate_team_members_for_task_assignment,
                        'session_project_manager_id' => session()->get('project_manager_id'),
                    ]);
                } else {
                    return abort(404, 'NOT FOUND');
                }
            }
            return abort(404, 'NOT FOUND');
        }
        return redirect('/');
    }


    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return string
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeamMemberRequest $request
     * @return void
     */
    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->safe(['name', 'username', 'password', 'email', 'type']);
        TeamMember::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'type' => $data['type'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param TeamMember $teamMember
     * @return string
     */
    public function show(TeamMember $teamMember)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TeamMember $teamMember
     * @return string
     */
    public function edit(TeamMember $teamMember)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTeamMemberRequest $request
     * @param TeamMember $teamMember
     * @return string
     */
    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
    }
}
