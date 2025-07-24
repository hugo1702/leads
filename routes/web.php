<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
    Login
*/
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
    Admin
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'show'])->name('admin.dashboard');

    //UserController
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    Route::get('admin/leads/index', [LeadController::class, 'index'])->name('admin.leads.index');
    Route::get('/admin/leads/create', [LeadController::class, 'create'])->name('admin.leads.create');
    Route::post('/admin/leads/store', [LeadController::class, 'store'])->name('admin.lead.store');
});

/*
    Operator
*/

Route::get('/operator/dashboard', [OperatorController::class, 'show'])->name('operator.dashboard');
