@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<h2>Cadastrar Usuário da Empresa</h2>

<form method="POST" action="{{ route('usuarios.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="empresa" selected>Empresa</option>
            <option value="cliente">Cliente</option>
        </select>
    </div>
    <button class="btn btn-primary">Salvar</button>
</form>
@endsection
