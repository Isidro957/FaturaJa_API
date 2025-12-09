@extends('layouts.app')

@section('title', 'Empresas')

@section('content')
<h2>Empresas</h2>
<a href="{{ route('empresas.create') }}" class="btn btn-success mb-3">Nova Empresa</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Slug</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($empresas as $empresa)
        <tr>
            <td>{{ $empresa->nome }}</td>
            <td>{{ $empresa->slug }}</td>
            <td>{{ $empresa->email }}</td>
            <td>{{ $empresa->telefone }}</td>
            <td>
                <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('empresas.destroy', $empresa) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Deseja remover?')">Apagar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
