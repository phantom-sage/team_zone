<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Http\Requests\StoreHrRequest;
use App\Http\Requests\UpdateHrRequest;
use Illuminate\Support\Facades\Hash;

class HrController extends Controller
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
     * @param StoreHrRequest $request
     * @return string
     */
    public function store(StoreHrRequest $request)
    {
        $data = $request->safe(['name', 'username', 'email', 'password']);
        Hr::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return 'store';
    }

    /**
     * Display the specified resource.
     *
     * @param Hr $hr
     * @return string
     */
    public function show(Hr $hr)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Hr $hr
     * @return string
     */
    public function edit(Hr $hr)
    {
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateHrRequest $request
     * @param Hr $hr
     * @return string
     */
    public function update(UpdateHrRequest $request, Hr $hr)
    {
        $data = $request->safe(['name', 'username', 'email', 'password']);
        $hr['name'] = $data['name'];
        $hr['username'] = $data['username'];
        $hr['email'] = $data['email'];
        $hr['password'] = Hash::make($data['password']);
        $hr->save();
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hr $hr
     * @return string
     */
    public function destroy(Hr $hr)
    {
        $hr->delete();
        return 'delete';
    }
}
