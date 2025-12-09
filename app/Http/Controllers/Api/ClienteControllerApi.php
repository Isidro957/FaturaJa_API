<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteControllerApi extends Controller
{
    public function __construct()
    {
        // Somente usuários autenticados via Sanctum
        $this->middleware('auth:sanctum');

        // Apenas usuários com role 'empresa' podem acessar
        $this->middleware('role:empresa');
    }

    /**
     * Listar clientes da empresa autenticada
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Cliente::class);

        $empresa = $request->user()->empresa;

        $clientes = Cliente::where('empresa_id', $empresa->id)->get();

        return response()->json([
            'clientes' => $clientes
        ]);
    }

    /**
     * Criar cliente
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cliente::class);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255'
        ]);

        $empresa = $request->user()->empresa;

        $cliente = Cliente::create([
            'empresa_id' => $empresa->id,
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco
        ]);

        return response()->json([
            'message' => 'Cliente criado com sucesso',
            'cliente' => $cliente
        ], 201);
    }

    /**
     * Mostrar cliente específico (opcional)
     */
    public function show(Request $request, Cliente $cliente)
    {
        $this->authorize('view', $cliente);

        return response()->json([
            'cliente' => $cliente
        ]);
    }

    /**
     * Atualizar cliente
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorize('update', $cliente);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255'
        ]);

        $cliente->update($request->only(['nome', 'email', 'telefone', 'endereco']));

        return response()->json([
            'message' => 'Cliente atualizado com sucesso',
            'cliente' => $cliente
        ]);
    }

    /**
     * Deletar cliente
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorize('delete', $cliente);

        $cliente->delete();

        return response()->json([
            'message' => 'Cliente removido com sucesso'
        ]);
    }
}
