<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    // Listar todas as empresas
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('empresas.create');
    }

    // Salvar nova empresa
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'slug' => 'required|unique:empresas,slug',
            'nif' => 'required',
            'email' => 'required|email',
        ]);

        Empresa::create($request->all());

        return redirect()->route('empresas.index')->with('success', 'Empresa criada com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    // Atualizar empresa
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nome' => 'required',
            'slug' => 'required|unique:empresas,slug,' . $empresa->id,
            'nif' => 'required',
            'email' => 'required|email',
        ]);

        $empresa->update($request->all());

        return redirect()->route('empresas.index')->with('success', 'Empresa atualizada com sucesso!');
    }

    // Excluir empresa
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa excluída com sucesso!');
    }
}
