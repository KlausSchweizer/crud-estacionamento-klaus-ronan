<?php

use App\Http\Controllers\ParkingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');

    Route::get('/clientes', [ClientController::class, 'view'])->name('clients');
    Route::get('/clientes/cadastrar', [ClientController::class, 'createPage'])->name('clients.createPage');
    Route::post('/clientes/cadastrar', [ClientController::class, 'save'])->name('clients.create');
    Route::get('/clientes/editar/{id}', [ClientController::class, 'editPage'])->name('clients.edit');
    Route::post('/clientes/editar/{id}', [ClientController::class, 'save'])->name('clients.edit');
    Route::post('/clientes/{id}', [ClientController::class, 'delete'])->name('clients.delete');

    Route::get('/veiculos', [VehicleController::class, 'view'])->name('vehicles');

    Route::get('/veiculos/cadastrar', [VehicleController::class, 'createPage'])->name('vehicles.createPage');
    Route::post('/veiculos/cadastrar', [VehicleController::class, 'save'])->name('vehicles.create');

    Route::get('/veiculos/editar/{id}', [VehicleController::class, 'editPage'])->name('vehicles.edit');
    Route::post('/veiculos/editar/{id}', [VehicleController::class, 'save'])->name('vehicles.edit');
    Route::post('/veiculos/{id}', [VehicleController::class, 'delete'])->name('vehicles.delete');

    Route::get('/estacionamentos', [ParkingController::class, 'view'])
        ->name('parking');
    Route::get('/estacionamentos/cadastrar', [ParkingController::class, 'createPage'])
        ->name('parking.createPage');
    Route::post('/estacionamentos/cadastrar', [ParkingController::class, 'save'])
        ->name('parking.create');
    Route::get('/estacionamentos/editar/{ticket}', [ParkingController::class, 'editPage'])
        ->name('parking.editPage');
    Route::post('/estacionamentos/editar/{ticket}', [ParkingController::class, 'save'])
        ->name('parking.edit');
    Route::post('/estacionamentos/saida/{ticket}', [ParkingController::class, 'registrarSaida'])
        ->name('parking.exit');
    Route::post('/estacionamentos/{ticket}', [ParkingController::class, 'delete'])
        ->name('parking.delete');

    Route::get('/vagas', [SpotController::class, 'view'])
        ->name('spot');
    Route::post('/vagas/cadastrar/{id?}', [SpotController::class, 'save'])
        ->name('spot.create');
    Route::post('/vagas/editar/{ticket}', [SpotController::class, 'save'])
        ->name('spot.edit');
    Route::post('/vagas/{id}', [SpotController::class, 'delete'])
        ->name('spot.delete');

    Route::get('/usuarios', [UserController::class, 'view'])->name('users');

    Route::get('/usuarios/cadastrar', [UserController::class, 'createPage'])->name('users.createPage');
    Route::post('/usuarios/cadastrar', [UserController::class, 'save'])->name('users.create');

    Route::get('/usuarios/editar/{id}', [UserController::class, 'editPage'])->name('users.edit');
    Route::post('/usuarios/editar/{id}', [UserController::class, 'save'])->name('users.edit');
    Route::post('/usuarios/{id}', [UserController::class, 'delete'])->name('users.delete');

    Route::get('/interacoes', [MainController::class, 'logs'])->name('logs');

    Route::get('/veiculos/pdf', [ReportController::class, 'vehicles'])->name('vehicles.pdf');
    Route::get('/interacoes/pdf', [ReportController::class, 'logs'])->name('logs.pdf');
    Route::get('/pagamento/pdf/{ticket}', [ReportController::class, 'payment'])->name('payment.pdf');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login.authenticate');
});

