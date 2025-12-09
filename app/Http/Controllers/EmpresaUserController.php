<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmpresaUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:empresa']);
    }

    public function index()
    {
        $empresa_id = Auth::user()->empresa_id;

        $users = User::where('empresa_id', $empresa_id)
                      ->whereHas('roles', function($q){
                          $q->where('name', 'empresa');
                      })
                      ->get();

        return view('empresa.usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('empresa.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $empresa = Auth::user()->empresa;

        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'empresa_id' => $empresa->id
        ]);

        $user->assignRole('empresa');

        return redirect()->route('empresa.usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }
}
