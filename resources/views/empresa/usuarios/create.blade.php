@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Cadastrar Usuário da Empresa</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('empresa.usuarios.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Avatar</label>
            <input type="file" name="avatar" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="empresa">Empresa</option>
            </select>
        </div>

        <button class="btn btn-primary">Salvar</button>
        <a href="{{ route('empresa.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
