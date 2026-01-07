<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create')->middleware('organizer');
    Route::post('/events', [EventController::class, 'store'])->name('events.store')->middleware('organizer');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit')->middleware('organizer');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update')->middleware('organizer');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('organizer');

    // Categories (Admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
});

require __DIR__.'/auth.php';
