<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Theme
    Route::post('/theme/update', [ThemeController::class, 'update'])->name('theme.update');

    // Subjects
    Route::resource('subjects', SubjectController::class);

    // Chapters (nested under subjects)
    Route::get('subjects/{subject}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('subjects/{subject}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('chapters/{chapter}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
    Route::put('chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
    Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');

    // Lectures (nested under subjects)
    Route::get('subjects/{subject}/lectures/create', [LectureController::class, 'create'])->name('lectures.create');
    Route::post('subjects/{subject}/lectures', [LectureController::class, 'store'])->name('lectures.store');
    Route::get('lectures/{lecture}/edit', [LectureController::class, 'edit'])->name('lectures.edit');
    Route::put('lectures/{lecture}', [LectureController::class, 'update'])->name('lectures.update');
    Route::delete('lectures/{lecture}', [LectureController::class, 'destroy'])->name('lectures.destroy');

    // Projects (nested under subjects)
    Route::get('subjects/{subject}/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('subjects/{subject}/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('projects/{project}/progress', [ProjectController::class, 'updateProgress'])->name('projects.progress');
});

require __DIR__.'/auth.php';