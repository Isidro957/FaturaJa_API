<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function __construct()
    {
        // Qualquer usuário autenticado pode ver clientes
        $this->middleware('auth');

        // Apenas usuários com role=empresa podem acessar
        // Admin não acessa este fluxo
        $this->middleware('role:empresa');
    }

    /**
     * Listar os clientes da empresa autenticada
     */
    public function index()
    {
        $this->authorize('viewAny', Cliente::class);

        $empresa = Auth::user()->empresa;

        $clientes = Cliente::where('empresa_id', $empresa->id)->get();

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Formulário de criação
     */
    public function create()
    {
        $this->authorize('create', Cliente::class);

        return view('clientes.create');
    }

    /**
     * Criar cliente para a empresa autenticada
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cliente::class);

        $request->validate([
            'nome' => 'required',
            'email' => 'nullable|email'
        ]);

        $empresa = Auth::user()->empresa;

        Cliente::create([
            'empresa_id' => $empresa->id,
            'nome'       => $request->nome,
            'email'      => $request->email,
            'telefone'   => $request->telefone,
            'endereco'   => $request->endereco
        ]);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    /**
     * Editar cliente da própria empresa
     */
    public function edit(Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualizar cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $request->validate([
            'nome' => 'required',
            'email' => 'nullable|email'
        ]);

        $cliente->update($request->only(['nome', 'email', 'telefone', 'endereco']));

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Excluir cliente
     * → Se quiser que somente admin apague, deixe na policy
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente removido com sucesso.');
    }
}
