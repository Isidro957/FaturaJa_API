<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminEmpresaController;
use App\Http\Controllers\EmpresaUserController;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('logar');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas por Autenticação
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function (Request $request) {
        return view('dashboard', [
            'user' => $request->user(),
            'empresa' => $request->user()->empresa
        ]);
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Rotas do Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Admin → gerencia empresas
        Route::resource('empresas', AdminEmpresaController::class);

        // Admin → gerencia clientes
        Route::resource('clientes', ClienteController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas da Empresa
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:empresa|admin')->prefix('empresa')->name('empresa.')->group(function () {

        // Empresa → gerencia seus usuários internos
        Route::resource('usuarios', EmpresaUserController::class);

        // Empresa → gerencia seus clientes
        Route::resource('clientes', ClienteController::class)->except(['show']);
    });
});
