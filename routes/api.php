<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Registro e login via API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function () {

    // Dashboard API
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
        $user = $request->user();
        $empresa = $user->empresa;

        return response()->json([
            'user' => $user,
            'empresa' => $empresa
        ]);
    });

    // Logout API
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    });
});
