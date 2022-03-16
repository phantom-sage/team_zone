<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\Project;
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

//TODO: dashboard link check in page.

Route::get('/', WelcomeController::class)->name('welcome.page');

Route::get('login/as', [LoginController::class, 'login_as'])->name('login.as');

Route::post('login/by/type', [LoginController::class, 'login_by_type'])->name('login.by.type');

Route::get('hr/manager/dashboard', [HrController::class, 'dashboard'])->name('hr.manager.dashboard');
Route::delete('hr/logout', [HrController::class, 'logout'])->name('hr.logout');

Route::get('project/manager/dashboard', [TeamMemberController::class, 'project_manager_dashboard'])
    ->name('project.manager.dashboard');
Route::delete('project/manager/logout', [TeamMemberController::class, 'logout_project_manager'])
    ->name('project.manager.logout');

Route::get('reports', function () {
    return Inertia::render('Report', [
        'projects' => Project::all()->load(['manager', 'owner']),
    ]);
})->name('admin.report.page');

Route::get('team-member/dashboard', [TeamMemberController::class, 'team_member_dashboard'])
    ->name('team.member.dashboard');
Route::delete('team-member/logout', [TeamMemberController::class, 'team_member_logout'])
    ->name('team.member.logout');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', DashboardController::class)
    ->name('dashboard');


Route::post('project/add/staff', [ProjectController::class, 'add_staff_to_project'])
    ->name('add.staff.to.project');
Route::post('reports', [UserController::class, 'report'])->name('reports.store');
Route::post('reports/export/pdf', [UserController::class, 'export_report_as_pdf'])
    ->name('reports.export.pdf');
Route::post('reports/send/email', [UserController::class, 'send_report_as_pdf_to_email'])
    ->name('reports.send.email');
Route::put('projects/{project}/rate', [ProjectController::class, 'client_rate_project_after_end'])
    ->name('projects.rate');
Route::put('task/update/status', [TaskController::class, 'update_task_status'])
    ->name('task.status.update');

Route::resources([
    'projects' => ProjectController::class,
    'clients' => ClientController::class,
    'team_members' => TeamMemberController::class,
    'tasks' => TaskController::class,
    'hrs' => HrController::class,
    'messages' => MessageController::class,
    'files' => FileController::class,
]);
