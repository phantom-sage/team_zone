<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    /**
     * login as admin.
     *
     * @param Request $request
     * @return UserResource|JsonResponse
     */
    public function login_as_admin(Request $request)
    {
        if ($request->has('username')) {
            $data = $request->validate([
                'username' => ['string', 'required', 'min:3', 'max:255'],
                'password' => ['required', 'min:8', 'max:255', 'string'],
            ]);
            $admin = User::where('username', '=', $data['username'])->first();
            if ($admin) {
                if (Hash::check($data['password'], $admin->password)) {
                    return new UserResource($admin);
                } else {
                    return response()
                        ->json([
                            'message' => 'NOT FOUND',
                        ], 404);
                }
            } else {
                return response()
                    ->json([
                        'message' => 'NOT FOUND',
                    ], 404);
            }
        } elseif ($request->has('email')) {
            $data = $request->validate([
                'email' => ['required', 'string', 'email', 'min:3', 'max:255'],
                'password' => ['required', 'min:8', 'max:255', 'string'],
            ]);
            $admin = User::where('email', '=', $data['email'])->first();
            if ($admin) {
                if (Hash::check($data['password'], $admin->password)) {
                    return new UserResource($admin);
                } else {
                    return response()
                        ->json([
                            'message' => 'NOT FOUND',
                        ], 404);
                }
            } else {
                return response()
                    ->json([
                        'message' => 'NOT FOUND',
                    ], 404);
            }
        }
        return response()
            ->json([
                'message' => 'NOT FOUND',
            ], 404);
    }

    /**
     * login as client.
     *
     * @param Request $request
     * @return ProjectResource|JsonResponse
     */
    public function login_as_client(Request $request)
    {
        if ($request->has('email')) {
            $data = $request->validate([
                'email' => ['required', 'email', 'string', 'max:255'],
                'code' => ['required', 'size:8', 'string'],
            ]);
            $client = Client::where('email', '=', $data['email'])->first();
            $project = Project::where('code', '=', $data['code'])->first();
            if ($client && $project) {
                return new ProjectResource($project);
            } else {
                return response()->json([
                    'message' => 'NOT FOUND',
                ], 404);
            }
        } elseif ($request->has('username')) {
            $data = $request->validate([
                'username' => ['required', 'string', 'min:3', 'max:255'],
                'code' => ['required', 'size:8', 'string'],
            ]);
            $client = Client::where('username', '=', $data['username'])->first();
            $project = Project::where('code', '=', $data['code'])->first();
            if ($client && $project) {
                return new ProjectResource($project);
            } else {
                return response()->json([
                    'message' => 'NOT FOUND',
                ], 404);
            }
        }
        return response()
            ->json([
                'message' => 'NOT FOUND',
            ], 404);
    }
}
