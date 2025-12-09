@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<h2>Clientes</h2>
<a href="{{ route('clientes.create') }}" class="btn btn-success mb-3">Novo Cliente</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->nome }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->telefone }}</td>
            <td>{{ $cliente->endereco }}</td>
            <td>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
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
