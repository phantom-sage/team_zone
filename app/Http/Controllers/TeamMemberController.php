<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Http\Requests\UpdateTeamMemberRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeamMemberRequest $request
     * @return void
     */
    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->safe(['name', 'username', 'password', 'email', 'type']);
        TeamMember::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'type' => $data['type'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function show(TeamMember $teamMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function edit(TeamMember $teamMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamMemberRequest  $request
     * @param TeamMember $teamMember
     * @return void
     */
    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TeamMember $teamMember
     * @return void
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
    }
}
