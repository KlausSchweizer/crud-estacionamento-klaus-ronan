<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    Route::get('/veiculos', [VehicleController::class, 'view'])->name('vehicles');

    Route::get('/veiculos/cadastrar', [VehicleController::class, 'createPage'])->name('vehicles.createPage');
    Route::post('/veiculos/cadastrar', [VehicleController::class, 'save'])->name('vehicles.create');

    Route::get('/veiculos/editar/{id}', [VehicleController::class, 'editPage'])->name('vehicles.edit');
    Route::post('/veiculos/editar/{id}', [VehicleController::class, 'save'])->name('vehicles.edit');
    Route::post('/veiculos/{id}', [VehicleController::class, 'delete'])->name('vehicles.delete');

    Route::get('/estacionamentos', [MainController::class, 'parking'])->name('parking');
    Route::get('/usuarios', [MainController::class, 'users'])->name('users');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login.authenticate');
});

