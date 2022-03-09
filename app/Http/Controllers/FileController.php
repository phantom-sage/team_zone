<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use Illuminate\Http\UploadedFile;

class FileController extends Controller
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
     * @param  StoreFileRequest  $request
     * @return string
     */
    public function store(StoreFileRequest $request)
    {
        $data = $request->safe(['title', 'description', 'project_id']);
        $file = $request->file('path') ?? null;

        if ($file instanceof UploadedFile) {
            $file_path = $file->store('projects', 'public');
            File::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'path' => $file_path,
                'project_id' => $data['project_id'],
            ]);
        }
        session()->flash('flash.banner', 'Uploaded successfully');
        session()->flash('flash.bannerStyle', 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  File  $file
     * @return string
     */
    public function show(File $file)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File  $file
     * @return string
     */
    public function edit(File $file)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFileRequest $request
     * @param File $file
     * @return string
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param File $file
     * @return string
     */
    public function destroy(File $file)
    {
        return 'destroy';
    }
}
