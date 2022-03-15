<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Dashboard', [
            'projectManagers' => TeamMember::where('type', '=', 'project_manager')->get(),
            'projects' => Project::all()->load(['manager', 'owner']),
            'logged_in_name' => Auth::user()->name ?? '',
            'tasks_count' => Task::count() ?? 0,
            'enquiries_count' => Message::count() ?? 0,
        ]);
    }
}
