<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\Hr;
use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('login/as', function () {
    return Inertia::render('Auth/LoginByType');
})->name('login.by.type');

Route::post('login/as', function (Request $request) {
    if ($request->input('type') == 'hr_manager') {
        $data = $request->validate([
            'email' => ['email', 'required', 'string'],
            'password' => ['string', 'max:255', 'min:8'],
            'type' => ['string', 'required', 'regex:/^(hr_manager|project_manager|team_member)$/'],
        ]);
        $hr = Hr::where('email', '=', $data['email'])->first();
        if ($hr == null) {
            return abort(404, 'NOT FOUND');
        }

        if (!Hash::check($data['password'], $hr['password'])) {
            return abort(404, 'NOT FOUND');
        }

        session()->put('hr_manager_id', $hr['id']);
        session()->put('hr_manager_name', $hr['name']);
        session()->put('hr_manager_email', $hr['email']);

        session()->flash('flash.banner', 'Welcome');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('hr.manager.dashboard');
    } else if ($request->input('type') == 'project_manager') {
        $data = $request->validate([
            'email' => ['email', 'required', 'string'],
            'password' => ['string', 'max:255', 'min:8'],
            'type' => ['string', 'required', 'regex:/^(hr_manager|project_manager|team_member)$/'],
        ]);
        $project_manager = TeamMember::where('email', '=', $data['email'])->first() ?? null;
        if (!$project_manager) {
            return abort(404, 'NOT FOUND');
        }

        if (!Hash::check($data['password'], $project_manager['password'])) {
            return abort(404, 'NOT FOUND');
        }

        session()->put('project_manager_id', $project_manager['id']);
        session()->put('project_manager_name', $project_manager['name']);
        session()->put('project_manager_email', $project_manager['email']);

        session()->flash('flash.banner', 'Welcome');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('project.manager.dashboard');
    } else if ($request->input('type') == 'team_member') {
        $data = $request->validate([
            "email" => ['string', 'email', 'max:255'],
            "password" => ['string', 'min:8', 'max:255', 'required'],
            "type" => ['string', 'required', 'regex:/^(hr_manager|project_manager|team_member)$/'],
        ]);
        $team_member = TeamMember::where('email', '=', $data['email'])->first() ?? null;
        if ($team_member == null) {
            return abort(404, 'NOT FOUND');
        }

        if (!Hash::check($data['password'], $team_member['password'])) {
            return abort(404, 'NOT FOUND');
        }

        session()->put('team_member_id', $team_member['id']);
        session()->put('team_member_name', $team_member['name']);
        session()->put('team_member_email', $team_member['email']);

        session()->flash('flash.banner', 'Welcome');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('team.member.dashboard');
    }
})->name('login.as');

Route::get('hr/manager/dashboard', function () {
    if (session()->has('hr_manager_id') && session()->has('hr_manager_name') && session()->has('hr_manager_email')) {
        return Inertia::render('Hr', [
            'session_hr_manager_id' => session()->get('hr_manager_id'),
        ]);
    }
    return redirect('/');
})->name('hr.manager.dashboard');


Route::delete('project/manager/logout', function (Request $request) {
    $data = $request->validate([
        'project_manager_id' => ['required', 'integer'],
    ]);
    session()->remove($data['project_manager_id']);
    session()->remove('project_manager_name');
    session()->remove('project_manager_email');

    session()->flash('flash.banner', 'Logout');
    session()->flash('flash.bannerStyle', 'success');
    return redirect('/');
})->name('project.manager.logout');

Route::delete('hr/logout', function (Request $request) {
    $data = $request->validate([
        'hr_manager_id' => ['required', 'integer'],
    ]);
    session()->remove($data['hr_manager_id']);
    session()->remove('hr_manager_name');
    session()->remove('hr_manager_email');

    session()->flash('flash.banner', 'Logout');
    session()->flash('flash.bannerStyle', 'success');
    return redirect('/');
})->name('hr.logout');

Route::get('reports', function () {
    return Inertia::render('Report', [
        'projects' => Project::all()->load(['manager', 'owner']),
    ]);
})->name('admin.report.page');

Route::get('team-member/dashboard', function () {
    //TODO: login project manager and store his data to session.
    //TODO: retrieve team member id from session.
    //TODO: for demonstration using the second team member from team member table.
    //TODO: avoid use attach in belongs to many relation because it duplicates the rows use something else.


    $team_member = TeamMember::where('id', '=', 2)->first() ?? null;
    $project_id = $team_member->task->project_id;
    $project = Project::where('id', '=', $project_id)->first() ?? null;
    return Inertia::render('TeamMemberDashboard', [
        'team_member' => $team_member->load('task'),
        'project' => $project
    ]);
})->name('team.member.dashboard');

Route::get('project/manager/dashboard', function () {
    //TODO: login project manager and store his data to session.
    //TODO: retrieve project manager id from session.
    //TODO: for demonstration using the first project manager from team member table.
    //TODO: avoid use attach in belongs to many relation because it duplicates the rows use something else.
    if (session()->get('project_manager_id') && session()->get('project_manager_name') && session()->get('project_manager_email')) {
        $project_manager = TeamMember::first() ?? null;
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
            }
            return abort(404, 'NOT FOUND');
        }
        return abort(404, 'NOT FOUND');
    }
    return redirect('/');
})->name('project.manager.dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'projectManagers' => TeamMember::where('type', '=', 'project_manager')->get(),
        'projects' => Project::all()->load(['manager', 'owner']),
        'logged_in_name' => Auth::user()->name ?? '',
        'tasks_count' => Task::count() ?? 0,
        'enquiries_count' => Message::count() ?? 0,
    ]);
})->name('dashboard');


Route::post('project/add/staff', [ProjectController::class, 'add_staff_to_project'])->name('add.staff.to.project');
Route::post('reports', [UserController::class, 'report'])->name('reports.store');
Route::post('reports/export/pdf', [UserController::class, 'export_report_as_pdf'])->name('reports.export.pdf');
Route::post('reports/send/email', [UserController::class, 'send_report_as_pdf_to_email'])->name('reports.send.email');
Route::put('projects/{project}/rate', [ProjectController::class, 'client_rate_project_after_end'])->name('projects.rate');
Route::put('task/update/status', [TaskController::class, 'update_task_status'])->name('task.status.update');

Route::resources([
    'projects' => ProjectController::class,
    'clients' => ClientController::class,
    'team_members' => TeamMemberController::class,
    'tasks' => TaskController::class,
    'hrs' => HrController::class,
    'messages' => MessageController::class,
    'files' => FileController::class,
]);
