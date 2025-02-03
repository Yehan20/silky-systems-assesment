<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    // All routes inside this group require authentication
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/all', [TaskController::class, 'getAll']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);

    //Users
    Route::get('/teams/users', [TeamController::class, 'getAllUsers']); // Fetch all users

    // Teams routes
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/teams/all', [TeamController::class, 'getAll']);
    Route::post('/teams', [TeamController::class, 'store']);
    Route::get('/teams/{id}/users', [TeamController::class, 'getUsers']);
    Route::post('/teams/{id}/users', [TeamController::class, 'addUser']);
});
