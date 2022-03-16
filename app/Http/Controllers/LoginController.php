<?php

namespace App\Http\Controllers;

use App\Models\Hr;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * login as page.
     *
     * @return Response
     */
    public function login_as()
    {
        return Inertia::render('Auth/LoginByType');
    }

    /**
     * login by type.
     *
     * @param Request $request
     * @return RedirectResponse|string
     */
    public function login_by_type(Request $request)
    {
        if ($request->input('type') == 'hr_manager') {
            $data = $request->validate([
                'email' => ['email', 'required', 'string'],
                'password' => ['string', 'max:255', 'min:8'],
                'type' => ['string', 'required', 'regex:/^(hr_manager)$/'],
            ]);
            $hr = Hr::where('email', '=', $data['email'])->first();
            if ($hr == null) {
                return abort(404, 'NOT FOUND');
            }

            if (!Hash::check($data['password'], $hr['password'])) {
                return abort(404, 'NOT FOUND');
            }

            session()->put('hr_manager_id', $hr['id']);
            session()->put('hr_manager_name', $hr['name']);
            session()->put('hr_manager_email', $hr['email']);
            session()->put('type_of_user_logged_in', 'Hr');

            session()->flash('flash.banner', 'Welcome');
            session()->flash('flash.bannerStyle', 'success');
            return redirect()->route('hr.manager.dashboard');
        } else if ($request->input('type') == 'project_manager') {
            $data = $request->validate([
                'email' => ['email', 'required', 'string'],
                'password' => ['string', 'max:255', 'min:8'],
                'type' => ['string', 'required', 'regex:/^(project_manager)$/'],
            ]);
            $project_manager = TeamMember::where('email', '=', $data['email'])->where('type', '=', 'project_manager')->first() ?? null;
            if (!$project_manager) {
                return abort(404, 'NOT FOUND');
            }

            if (!Hash::check($data['password'], $project_manager['password'])) {
                return abort(404, 'NOT FOUND');
            }

            session()->put('project_manager_id', $project_manager['id']);
            session()->put('project_manager_name', $project_manager['name']);
            session()->put('project_manager_email', $project_manager['email']);
            session()->put('type_of_user_logged_in', 'TeamMember');

            session()->flash('flash.banner', 'Welcome');
            session()->flash('flash.bannerStyle', 'success');
            return redirect()->route('project.manager.dashboard');
        } else if ($request->input('type') == 'team_member') {
            $data = $request->validate([
                "email" => ['string', 'email', 'max:255'],
                "password" => ['string', 'min:8', 'max:255', 'required'],
                "type" => ['string', 'required', 'regex:/^(team_member)$/'],
            ]);
            $team_member = TeamMember::where('email', '=', $data['email'])->where('type', '=', 'team_member')->first() ?? null;
            if ($team_member == null) {
                return abort(404, 'NOT FOUND');
            }

            if (!Hash::check($data['password'], $team_member['password'])) {
                return abort(404, 'NOT FOUND');
            }

            session()->put('team_member_id', $team_member['id']);
            session()->put('team_member_name', $team_member['name']);
            session()->put('team_member_email', $team_member['email']);
            session()->put('type_of_user_logged_in', 'TeamMember');

            session()->flash('flash.banner', 'Welcome');
            session()->flash('flash.bannerStyle', 'success');
            return redirect()->route('team.member.dashboard');
        }
        return abort(404, 'NOT FOUND');
    }
}
