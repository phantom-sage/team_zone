<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;
use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Foundation\Application;
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
    $project_names = [];
    $project_owners = [];
    $project_managers = [];
    $project_status = [];
    foreach (Project::where('id', '=', 1)->get() as $p) {
        $project_names [] = $p->name;
        $project_owners [] = $p->owner->username;
        $project_managers[] = $p->manager->name;
        $project_status[] = $p->status;
    }
    /*
     *
     *
     * $book = Books::where('id',$request->id)->with('locations')->firstOrFail();
        return Inertia::render('Admin/Books/Edit', ['book' => $book->load('locations')]);
     *
     */
    $p = Project::where('id', '>', 0)->with(['manager', 'owner'])->get();
    return Inertia::render('Report', [
        'projects' => $p->load(['manager', 'owner']),
    ]);
})->name('admin.report.page');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'projectManagers' => TeamMember::all(),
    ]);
})->name('dashboard');

Route::put('projects/{project}/rate', [ProjectController::class, 'client_rate_project_after_end'])
    ->name('projects.rate');

Route::post('reports', [UserController::class, 'report'])->name('reports.store');
Route::post('reports/export/pdf', [UserController::class, 'export_report_as_pdf'])->name('reports.export.pdf');
Route::post('reports/send/email', [UserController::class, 'send_report_as_pdf_to_email'])->name('reports.send.email');

Route::resources([
    'projects' => ProjectController::class,
    'clients' => ClientController::class,
    'team_members' => TeamMemberController::class,
    'tasks' => TaskController::class,
    'hrs' => HrController::class,
    'messages' => MessageController::class,
    'files' => FileController::class,
]);
