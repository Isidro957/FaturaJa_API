@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<h2>Editar Usuário da Empresa</h2>

<form method="POST" action="{{ route('empresa.usuarios.update', $user->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" value="{{ old('nome', $user->name) }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="mb-3">
        <label>Senha (deixe em branco para manter a atual)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="empresa" {{ $user->role === 'empresa' ? 'selected' : '' }}>Empresa</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Avatar (opcional)</label><br>
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-2" width="80" height="80" style="object-fit: cover;">
        @endif
        <input type="file" name="avatar" class="form-control">
    </div>

    <button class="btn btn-primary">Atualizar</button>
</form>
@endsection
