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
     * Registrar empresa + usuário admin
     */
    public function register(Request $request)
    {
        $request->validate([
            'empresa_nome' => 'required',
            'empresa_slug' => 'required|unique:empresas,slug',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Criar empresa
        $empresa = Empresa::create([
            'nome' => $request->empresa_nome,
            'slug' => $request->empresa_slug,
            'nif' => '000000000',
            'email' => $request->email,
            'telefone' => $request->telefone ?? null,
            'endereco' => $request->endereco ?? null,
        ]);

        // Criar usuário da empresa com role de "empresa"
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'empresa_id' => $empresa->id
        ]);

        // 👉 ATRIBUIR PAPEL (role)
        $user->assignRole('empresa');

        // Se for formulário web
        if (!$request->wantsJson()) {
            Session::flash('success', 'Conta criada com sucesso');
            return redirect('/login');
        }

        // API
        return response()->json([
            'message' => 'Conta criada com sucesso',
            'empresa' => $empresa,
            'user' => $user
        ]);
    }

    /**
     * Login multi-tenant
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'empresa_slug' => 'required'
        ]);

        $empresa = Empresa::where('slug', $request->empresa_slug)->first();

        if (!$empresa) {
            return $this->errorResponse('Empresa não encontrada', $request);
        }

        $user = User::where('email', $request->email)
            ->where('empresa_id', $empresa->id)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Credenciais inválidas', $request);
        }

        // 👉 IMPEDIR LOGIN DE CLIENTE FINAL NO SISTEMA WEB
        if ($user->hasRole('cliente final') && !$request->wantsJson()) {
            return redirect('/login')->with('error', 'Cliente final não pode acessar o sistema.');
        }

        // LOGIN WEB
        if (!$request->wantsJson()) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        // LOGIN API - criar token via Sanctum
        $token = $user->createToken('token-api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'empresa' => $empresa,
            'role' => $user->getRoleNames()->first()
        ]);
    }

    /**
     * Logout do usuário
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
     * Tratamento de resposta nos erros
     */
    private function errorResponse($message, Request $request)
    {
        if (!$request->wantsJson()) {
            return redirect('/login')->with('error', $message);
        }

        return response()->json(['message' => $message], 400);
    }
}
