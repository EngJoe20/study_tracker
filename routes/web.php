<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Theme Management
    Route::post('/theme/update', [ThemeController::class, 'update'])->name('theme.update');

    // Subjects Resource
    Route::resource('subjects', SubjectController::class);

    // Chapters (nested under subjects)
    Route::prefix('subjects/{subject}')->group(function () {
        Route::get('chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
        Route::post('chapters', [ChapterController::class, 'store'])->name('chapters.store');
    });
    
    Route::prefix('chapters/{chapter}')->group(function () {
        Route::get('edit', [ChapterController::class, 'edit'])->name('chapters.edit');
        Route::put('/', [ChapterController::class, 'update'])->name('chapters.update');
        Route::delete('/', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    });

    // Lectures (nested under subjects)
    Route::prefix('subjects/{subject}')->group(function () {
        Route::get('lectures/create', [LectureController::class, 'create'])->name('lectures.create');
        Route::post('lectures', [LectureController::class, 'store'])->name('lectures.store');
    });
    
    Route::prefix('lectures/{lecture}')->group(function () {
        Route::get('edit', [LectureController::class, 'edit'])->name('lectures.edit');
        Route::put('/', [LectureController::class, 'update'])->name('lectures.update');
        Route::delete('/', [LectureController::class, 'destroy'])->name('lectures.destroy');
    });

    // Projects (nested under subjects)
    Route::prefix('subjects/{subject}')->group(function () {
        Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    });
    
    Route::prefix('projects/{project}')->group(function () {
        Route::get('edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('progress', [ProjectController::class, 'updateProgress'])->name('projects.progress');
    });
});

require __DIR__.'/auth.php';