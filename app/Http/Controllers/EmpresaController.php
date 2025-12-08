<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;


class EmpresaController extends Controller
{
    public function __construct()
    {
        // Garante que o user esteja autenticado e seja admin
        $this->middleware(['auth', 'role:admin']);
    }

    // Listar todas as empresas
    public function index()
    {
        $this->authorize('viewAny', Empresa::class);

        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $this->authorize('create', Empresa::class);

        return view('empresas.create');
    }

    // Salvar nova empresa
    public function store(Request $request)
    {
        $this->authorize('create', Empresa::class);

        $request->validate([
            'nome'   => 'required',
            'slug'   => 'required|unique:empresas,slug',
            'nif'    => 'required',
            'email'  => 'required|email',
        ]);

        Empresa::create($request->all());

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa criada com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit(Empresa $empresa)
    {
        $this->authorize('update', $empresa);

        return view('empresas.edit', compact('empresa'));
    }

    // Atualizar empresa
    public function update(Request $request, Empresa $empresa)
    {
        $this->authorize('update', $empresa);

        $request->validate([
            'nome'  => 'required',
            'slug'  => 'required|unique:empresas,slug,' . $empresa->id,
            'nif'   => 'required',
            'email' => 'required|email',
        ]);

        $empresa->update($request->all());

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    // Excluir empresa
    public function destroy(Empresa $empresa)
    {
        $this->authorize('delete', $empresa);

        $empresa->delete();

        return redirect()
            ->route('empresas.index')
            ->with('success', 'Empresa excluída com sucesso!');
    }
}
