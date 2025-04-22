<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('home');

    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::get('/workouts/{workout}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit');
    Route::put('/workouts/{workout}', [WorkoutController::class, 'update'])->name('workouts.update');
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route for Favorites page
Route::get('/favorites', function () {
    return view('favorites');
})->middleware('auth')->name('favorites');

require __DIR__.'/auth.php';
