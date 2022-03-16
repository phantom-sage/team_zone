<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Http\Requests\StoreHrRequest;
use App\Http\Requests\UpdateHrRequest;
use App\Models\TeamMember;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class HrController extends Controller
{
    /**
     * logout.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        $data = $request->validate([
            'hr_manager_id' => ['required', 'integer'],
        ]);
        session()->remove('hr_manager_id');
        session()->remove('hr_manager_name');
        session()->remove('hr_manager_email');
        session()->remove('type_of_user_logged_in');

        session()->flash('flash.banner', 'Logout');
        session()->flash('flash.bannerStyle', 'success');
        return redirect('/');
    }

    /**
     * dashboard.
     *
     * @return Application|RedirectResponse|Redirector|Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dashboard()
    {
        if (session()->has('hr_manager_id') && session()->has('hr_manager_name') && session()->has('hr_manager_email')) {
            $hr_manager = Hr::where('id', '=', session()->get('hr_manager_id'))->first() ?? null;
            $team_members = TeamMember::all() ?? null;
            return Inertia::render('Hr', [
                'session_hr_manager_id' => session()->get('hr_manager_id'),
                'hr_manager_name' => $hr_manager['name'],
                'team_members' => $team_members->load('project'),
            ]);
        }
        return redirect('/');
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
        session()->flash('flash.banner', 'Hr Added successfully');
        session()->flash('flash.bannerStyle', 'success');
        return back();
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
