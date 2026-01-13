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
  Route::get('/events/{event}/wedding-details', [\App\Http\Controllers\User\WeddingEventController::class, 'edit'])->name('user.events.wedding-details.edit');
  Route::post('/events/{event}/wedding-details', [\App\Http\Controllers\User\WeddingEventController::class, 'update'])->name('user.events.wedding-details.update');
  Route::post('/events/{event}/invitations/import', [\App\Http\Controllers\User\InvitationController::class, 'import'])->name('user.events.invitations.import');
  Route::resource('events.invitations', \App\Http\Controllers\User\InvitationController::class)->names('user.events.invitations');

  // Manage Event Content Dashboard
  Route::get('/events/{event}/manage', [\App\Http\Controllers\User\EventContentController::class, 'index'])->name('user.events.manage');

  // Event Content Resources (Nested)
  Route::resource('events.journeys', \App\Http\Controllers\User\EventJourneyController::class)->names('user.events.journeys');
  Route::resource('events.galleries', \App\Http\Controllers\User\EventGalleryController::class)->names('user.events.galleries');
  Route::resource('events.locations', \App\Http\Controllers\User\EventLocationController::class)->names('user.events.locations');
});

Route::prefix('admin')->name('admin.')->group(function () {
  // Admin Login/Logout now handled by Global Auth

  Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class)->names('templates');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('users');
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class)->names('events')->only(['index', 'destroy']);
  });
});

// Public Routes (Must be last)
Route::get('/preview/{templateSlug}', [\App\Http\Controllers\FrontendController::class, 'preview'])->name('frontend.preview');
Route::get('/{eventSlug}', [\App\Http\Controllers\FrontendController::class, 'event'])->name('frontend.event');
Route::get('/{eventSlug}/{invitationSlug}', [\App\Http\Controllers\FrontendController::class, 'invitation'])->name('frontend.invitation');
Route::post('/{eventSlug}/{invitationSlug}', [\App\Http\Controllers\FrontendController::class, 'rsvp'])->name('frontend.rsvp');
