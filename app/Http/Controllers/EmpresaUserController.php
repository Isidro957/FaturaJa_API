<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpresaUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:empresa']);
    }

    /**
     * Listagem de usuários da empresa
     */
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

    /**
     * Formulário de criação de usuário
     */
    public function create()
    {
        return view('empresa.usuarios.create');
    }

    /**
     * Armazenar usuário
     */
  public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $empresa = Auth::user()->empresa;

    // Se enviou avatar
    if ($request->hasFile('avatar')) {
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    } else {
        // Avatar padrão
        $avatarPath = 'images/avatar_empresa.jpg'; // já deve estar em storage/app/public/images
    }

    $user = User::create([
        'name' => $request->nome,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'empresa_id' => $empresa->id,
        'avatar' => $avatarPath,
        'role' => 'empresa', // garante que o campo role seja preenchido
    ]);

    // Atribui role empresa ao Spatie
    $user->assignRole('empresa');

    return redirect()->route('empresa.usuarios.index')
        ->with('success', 'Usuário criado com sucesso!');
}

    /**
     * Formulário de edição
     */
    public function edit(User $usuario)
    {
        $this->authorize('update', $usuario); // opcional

        return view('empresa.usuarios.edit', compact('usuario'));
    }

    /**
     * Atualizar usuário
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $usuario->name = $request->nome;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        // Atualiza avatar somente se houver upload
        if ($request->hasFile('avatar')) {
            if ($usuario->avatar && Storage::disk('public')->exists($usuario->avatar)) {
                Storage::disk('public')->delete($usuario->avatar);
            }
            $usuario->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $usuario->save();

        return redirect()->route('empresa.usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Deletar usuário
     */
    public function destroy(User $usuario)
    {
        $this->authorize('delete', $usuario); // opcional

        if ($usuario->avatar && $usuario->avatar !== 'avatars/default.png' && Storage::disk('public')->exists($usuario->avatar)) {
            Storage::disk('public')->delete($usuario->avatar);
        }

        $usuario->delete();

        return redirect()->route('empresa.usuarios.index')
            ->with('success', 'Usuário removido com sucesso!');
    }
}
