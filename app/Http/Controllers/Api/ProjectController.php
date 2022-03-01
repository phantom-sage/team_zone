<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{

    /**
     * get_client_project.
     *
     * @param Request $request
     * @return ProjectResource|string
     */
    public function get_client_project(Request $request)
    {
        if ($request->has('username')) {
            $data = $request->validate([
                'username' => ['required', 'string', 'max:255', 'min:3'],
                'code' => ['required', 'string', 'size:8'],
            ]);
            if (Client::where('username', '=', $data['username'])->first() == null) {
                return abort(404, 'NOT FOUND');
            }

            $project = Project::where('code', '=', $data['code'])->first();

            if ($project == null) {
                return abort(404, 'NOT FOUND');
            }

            return new ProjectResource($project);
        } elseif ($request->has('email')) {
            $data = $request->validate([
                'email' => ['required', 'string', 'email'],
                'code' => ['required', 'string', 'size:8'],
            ]);

            if (Client::where('email', '=', $data['email'])->first() == null) {
                return abort(404, 'NOT FOUND');
            }

            $project = Project::where('code', '=', $data['code'])->first();

            if ($project == null) {
                return abort(404, 'NOT FOUND');
            }

            return new ProjectResource($project);
        }
        return abort(404, 'NOT FOUND');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        return 'store';
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return ProjectResource
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     * @return string
     */
    public function update(Request $request, Project $project)
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
        return 'destroy';
    }
}
