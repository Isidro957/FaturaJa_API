<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * LOGIN (Admin, Empresa e Usuário da Empresa)
     */
    public function login(Request $request)
    {
        $request->validate([
            'empresa_slug' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Encontrar empresa pelo slug
        $empresa = Empresa::where('slug', $request->empresa_slug)->first();
        if (!$empresa) {
            return $this->errorResponse('Empresa não encontrada', $request);
        }

        // Encontrar usuário dentro da empresa
        $user = User::where('email', $request->email)
                    ->where('empresa_id', $empresa->id)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Credenciais inválidas', $request);
        }

        // Clientes não acessam painel web
        if ($user->hasRole('cliente') && !$request->wantsJson()) {
            return redirect('/login')->with('error', 'Clientes apenas podem usar a aplicação.');
        }

        // LOGIN WEB
        if (!$request->wantsJson()) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        // LOGIN API (Sanctum)
        $token = $user->createToken('token-api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'empresa' => $empresa,
            'role' => $user->getRoleNames()->first()
        ]);
    }

    /**
     * LOGOUT (Web + API)
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
            $request->user()->currentAccessToken()->delete();
        }

        Session::flush();

        return redirect('/login');
    }

    /**
     * Resposta formatada para erros
     */
    private function errorResponse($message, Request $request)
    {
        if (!$request->wantsJson()) {
            return redirect('/login')->with('error', $message);
        }

        return response()->json(['message' => $message], 400);
    }
}
