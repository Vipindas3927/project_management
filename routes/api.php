<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Projects
    Route::get('projects', [ProjectApiController::class, 'listProjects']);
    Route::post('projects', [ProjectApiController::class, 'createProject']);
    Route::put('projects/{id}', [ProjectApiController::class, 'updateProject']);
    Route::delete('projects/{id}', [ProjectApiController::class, 'deleteProject']);

    // Tasks
    Route::get('projects/{id}/tasks', [ProjectApiController::class, 'listTasks']);
    Route::post('projects/{id}/tasks', [ProjectApiController::class, 'createTask']);
    Route::put('tasks/{id}', [ProjectApiController::class, 'updateTask']);
    Route::delete('tasks/{id}', [ProjectApiController::class, 'deleteTask']);

    // Remarks
    Route::get('tasks/{id}/remarks', [ProjectApiController::class, 'listRemarks']);
    Route::post('tasks/{id}/remarks', [ProjectApiController::class, 'addRemark']);
});
