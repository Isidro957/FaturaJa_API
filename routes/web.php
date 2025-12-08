<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Telas HTML
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ações do formulário
Route::post('/registrar', [AuthController::class, 'register'])->name('registrar');
Route::post('/logar', [AuthController::class, 'login'])->name('logar');

// Middleware auth para proteger dashboard e CRUD de empresas
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        $empresa = $user->empresa;

        return view('dashboard', [
            'user' => $user,
            'empresa' => $empresa
        ]);
    })->name('dashboard');

    // CRUD de empresas
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('empresas', EmpresaController::class);
});

    // Logout
    Route::get('/logout', function(Request $request) {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

});

Route::middleware(['auth', 'role:admin|empresa'])->group(function () {
    Route::resource('clientes', ClienteController::class);
});