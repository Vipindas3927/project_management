<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware(['auth'])->group(function () {
        Route::view('projects', 'project')->name('projects');
        Route::get('/projects/{projectId}/tasks', function ($projectId) {
            return view('task', ['projectId' => $projectId]);
        })->name('tasks');
    });

require __DIR__.'/auth.php';
