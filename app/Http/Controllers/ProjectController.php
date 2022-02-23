<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
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
     * @return void
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->safe(['name', 'deadline', 'client_id']);
        Project::create([
            'name' => $data['name'],
            'deadline' => $data['deadline'],
            'client_id' => $data['client_id'],
        ]);
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
