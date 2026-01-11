<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// ========================================
// ROTA PÚBLICA
// ========================================
Route::get('/', function () {
    return view('welcome');
});

// ========================================
// ROTAS AUTENTICADAS
// ========================================
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================================
    // EVENTS
    // ========================================
    
    // 🔥 ROTAS PROTEGIDAS PRIMEIRO (mais específicas)
    Route::middleware('organizer')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
    
    // ✅ ROTAS PÚBLICAS DEPOIS (com parâmetros)
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    // ========================================
    // REGISTRATIONS (Inscrições)
    // ========================================
    
    // Ver as minhas inscrições (todos os utilizadores autenticados)
    Route::get('/my-registrations', [RegistrationController::class, 'myRegistrations'])
        ->name('registrations.my');
    
    // Inscrever-me num evento
    Route::post('/events/{event}/register', [RegistrationController::class, 'register'])
        ->name('registrations.register');
    
    // Cancelar a minha inscrição
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'cancel'])
        ->name('registrations.cancel');

    // Gestão de inscrições (apenas Organizer e Admin)
    Route::middleware('organizer')->group(function () {
        // Ver todas as inscrições (Admin vê tudo, Organizer vê só dos seus eventos)
        Route::get('/registrations', [RegistrationController::class, 'index'])
            ->name('registrations.index');
        
        // Alterar status de uma inscrição (aprovar/rejeitar)
        Route::patch('/registrations/{registration}/status', [RegistrationController::class, 'updateStatus'])
            ->name('registrations.updateStatus');
    });

    // ========================================
    // CATEGORIES (Admin apenas)
    // ========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
});

// ========================================
// ROTAS DE AUTENTICAÇÃO (Laravel Breeze)
// ========================================
require __DIR__.'/auth.php';