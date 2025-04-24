<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('home');

    // Workout routes
    Route::resource('workouts', WorkoutController::class);

    // Exercise routes
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create'); // Route toegevoegd
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');     // Route toegevoegd
    Route::resource('exercises', ExerciseController::class)->except(['create', 'store']);

    Route::get('/workout-history', [WorkoutController::class, 'listHistory'])->name('workouts.list'); // <-- NIEUWE ROUTE VOOR LIJST
    Route::resource('workouts', WorkoutController::class)->except(['index']); // Haal index weg uit resource als '/' de dashboard is

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favorites route
    Route::get('/favorites', function () {
        return view('favorites');
    })->name('favorites');
});

require __DIR__.'/auth.php';
