<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/movie', [MovieController::class, 'index'])->name('movie.index');
    Route::post('/movie', [MovieController::class, 'store'])->name('movie.store');
    Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
    Route::put('/{id}/update', [MovieController::class, 'update'])->name('movie.update');
    Route::delete('{id}/delete', [MovieController::class, 'destroy'])->name('movie.delete');
   
});

require __DIR__.'/auth.php';
