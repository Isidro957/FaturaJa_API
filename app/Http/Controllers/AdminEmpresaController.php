<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminEmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $empresas = Empresa::all();
        return view('admin.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('admin.empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'slug' => 'required|unique:empresas,slug',
            'email_admin' => 'required|email|unique:users,email',
            'nome_admin' => 'required',
            'password_admin' => 'required|min:6'
        ]);

        // Criar empresa
        $empresa = Empresa::create([
            'nome' => $request->nome,
            'slug' => $request->slug,
            'email' => $request->email_admin,
        ]);

        // Criar dono da empresa
        $user = User::create([
            'name' => $request->nome_admin,
            'email' => $request->email_admin,
            'password' => Hash::make($request->password_admin),
            'empresa_id' => $empresa->id
        ]);

        $user->assignRole('empresa');

        return redirect()->route('admin.empresas.index')
            ->with('success', 'Empresa criada com sucesso!');
    }
}
