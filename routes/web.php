<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;

use App\Http\Controllers\Backend\HomeBannerDetailsController;
use App\Http\Controllers\Backend\ProjectsController;
use App\Http\Controllers\Backend\PartnersController;
use App\Http\Controllers\Backend\AssociateController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\HomeServicesController;

// Route::get('/', function () {
//     return view('frontend.home');
// });
  

// Authentication Routes
Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/change-password', [LoginController::class, 'change_password'])->name('admin.changepassword');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('admin.updatepassword');

// Admin Routes with Middleware
Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
    Route::get('/dashboard', function () {
        return view('backend.dashboard'); 
    })->name('admin.dashboard');
});

// ==== Manage Banner Details in Home
Route::resource('home-banner', HomeBannerDetailsController::class);

// ==== Manage Project Details in Home
Route::resource('manage-projects', ProjectsController::class);

// ==== Manage clientele in Home
Route::resource('manage-clientele', PartnersController::class);

// ==== Manage Associates in Home
Route::resource('manage-associates', AssociateController::class);

// ==== Manage Home Services in Home
Route::resource('manage-home-services', HomeServicesController::class);

// ==== Manage services in Home
Route::resource('manage-services', ServicesController::class);
