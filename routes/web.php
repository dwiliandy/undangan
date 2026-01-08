<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

Route::get('/', function () {
  return view('welcome');
});

// User Routes
Route::middleware('guest')->group(function () {
  Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
  Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
  Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

  Route::resource('events', \App\Http\Controllers\User\EventController::class)->names('user.events');
  Route::resource('events.invitations', \App\Http\Controllers\User\InvitationController::class)->names('user.events.invitations');
});

Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class)->names('templates');
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class)->names('events')->only(['index', 'destroy']);
  });
});

// Public Routes (Must be last)
Route::get('/preview/{templateSlug}', [\App\Http\Controllers\FrontendController::class, 'preview'])->name('frontend.preview');
Route::get('/{eventSlug}', [\App\Http\Controllers\FrontendController::class, 'event'])->name('frontend.event');
Route::get('/{eventSlug}/to/{invitationSlug}', [\App\Http\Controllers\FrontendController::class, 'invitation'])->name('frontend.invitation');
