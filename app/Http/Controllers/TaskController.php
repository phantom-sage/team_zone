<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Response;

class TaskController extends Controller
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
     * @param StoreTaskRequest $request
     * @return void
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->safe(['name', 'duration', 'status', 'description']);
        Task::create([
            'name' => $data['name'],
            'duration' => $data['duration'],
            'status' => $data['status'],
            'description' => $data['description'],
        ]);
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
