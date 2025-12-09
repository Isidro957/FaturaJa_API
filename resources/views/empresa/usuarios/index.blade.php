@extends('layouts.app')

@section('title', 'Usuários da Empresa')

@section('content')
<h2>Usuários da Empresa</h2>
<a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">Novo Usuário</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Role</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames()->first() }}</td>
            <td>
                <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('usuarios.destroy', $user) }}" method="POST" class="d-inline">
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
