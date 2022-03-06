<?php

namespace App\Http\Controllers;

use App\Events\NewProjectCreated;
use App\Models\Client;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    /**
     * client rate project after end.
     * @param Request $request
     * @param Project $project
     * @return string
     */
    public function client_rate_project_after_end(Request $request, Project $project)
    {
        $data = $request->validate([
            'rate' => ['integer', 'required', 'min:0'],
        ]);
        $project->update([
            'rate' => $data['rate'],
        ]);
        return 'rate';
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
     * @param StoreProjectRequest $request
     * @return string
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->safe(['name', 'deadline', 'client_username', 'client_email', 'status', 'project_manager_id']);
        $client = new Client();
        $client['username'] = $data['client_username'];
        $client['email'] = $data['client_email'];
        $client->save();

        $project = new Project();
        $project['name'] = $data['name'];
        $project['deadline'] = $data['deadline'];
        $project['code'] = Str::random(8);
        $project['client_id'] = $client['id'] ?? null;
        $project['status'] = $data['status'];
        $project->save();

        $project_manager = TeamMember::find($data['project_manager_id']) ?? null;
        if ($project_manager != null) {
            $project_manager['project_id'] = $project['id'];
            $project_manager->save();
        }

        NewProjectCreated::dispatch($project);
        return 'store';
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Project
     */
    public function show(Project $project)
    {
        return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return string
     */
    public function edit(Project $project)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return string
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return string
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return 'destroy';
    }
}
