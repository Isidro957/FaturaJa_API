<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\Api\ClienteControllerApi;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Login e Registro
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS POR SANCTUM
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Informações do usuário autenticado
    Route::get('/me', fn() => auth('sanctum')->user());

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | ROTAS DO ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('empresas', EmpresaController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | ROTAS DA EMPRESA
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:empresa')->group(function () {
        // Empresa gerencia seus clientes via API
        Route::apiResource('clientes', ClienteControllerApi::class)
            ->except(['create', 'edit']); // API não usa formulários
    });

    /*
    |--------------------------------------------------------------------------
    | ROTAS DO CLIENTE FINAL
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:cliente')->group(function () {
        Route::get('me/faturas', [ClienteControllerApi::class, 'minhasFaturas']);
    });

});
