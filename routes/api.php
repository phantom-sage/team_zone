<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/admin/login', [LoginController::class, 'login_as_admin']);
Route::post('/users/client/login', [LoginController::class, 'login_as_client']);

Route::post('/client/project', [ProjectController::class, 'get_client_project']);

Route::apiResource('projects', ProjectController::class);
