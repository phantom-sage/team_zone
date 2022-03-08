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
use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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

Route::get('reports', function () {
    return Inertia::render('Report', [
        'projects' => Project::all()->load(['manager', 'owner']),
    ]);
})->name('admin.report.page');

Route::get('project/manager/dashboard', function() {
    //TODO: login project manager and store his data to session.
    //TODO: retrieve project manager id from session.
    //TODO: for demonstration using the first project manager from team member table.
    //TODO: avoid use attach in belongs to many relation because it duplicates the rows use something else.
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
            ]);
        }
        return abort(404, 'NOT FOUND');
    }
    return abort(404, 'NOT FOUND');
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

Route::resources([
    'projects' => ProjectController::class,
    'clients' => ClientController::class,
    'team_members' => TeamMemberController::class,
    'tasks' => TaskController::class,
    'hrs' => HrController::class,
    'messages' => MessageController::class,
    'files' => FileController::class,
]);
