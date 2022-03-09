<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{

    /**
     * update task status.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update_task_status(Request $request)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:255', 'min:3'],
            'task_id' => ['required', 'integer'],
        ]);
        $task = Task::where('id', '=', $data['task_id'])->first() ?? null;
        $task->status = $data['status'];
        $task->save();
        session()->flash('flash.banner', 'Task status updated successfully');
        session()->flash('flash.bannerStyle', 'success');
        return back();
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
     * @param StoreTaskRequest $request
     * @return string
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->safe(['name', 'duration', 'status', 'description', 'project_id', 'team_member_id']);
        Task::create([
            'name' => $data['name'],
            'duration' => $data['duration'],
            'status' => $data['status'],
            'description' => $data['description'],
            'project_id' => $data['project_id'],
            'team_member_id' => $data['team_member_id'],
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return string
     */
    public function show(Task $task)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return string
     */
    public function edit(Task $task)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return string
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return string
     */
    public function destroy(Task $task)
    {
        return 'destroy';
    }
}
