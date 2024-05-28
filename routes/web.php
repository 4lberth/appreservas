<?php

use App\Http\Controllers\ReservationClubController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 

// Rutas para el club de reservas
Route::middleware('auth')->group(function () {
    Route::get('/reservations', [ReservationClubController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationClubController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationClubController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationClubController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{id}/edit', [ReservationClubController::class, 'edit'])->name('reservations.edit');
    Route::patch('/reservations/{id}', [ReservationClubController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}', [ReservationClubController::class, 'destroy'])->name('reservations.destroy');
});

// Rutas para el login de usuarios y administradores
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Ruta para un formulario de administración
Route::middleware('auth', 'admin')->group(function () {
    Route::get('/admin/form', [AdminController::class, 'showForm'])->name('admin.form');
    Route::post('/admin/form', [AdminController::class, 'handleForm'])->name('admin.form.handle');
});
Route::resource('reservas', ReservaController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';

