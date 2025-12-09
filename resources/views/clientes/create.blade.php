@extends('layouts.app')

@section('title', 'Novo Cliente')

@section('content')
<h2>Cadastrar Cliente</h2>

<form method="POST" action="{{ route('clientes.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" class="form-control">
    </div>
    <div class="mb-3">
        <label>Endereço</label>
        <input type="text" name="endereco" class="form-control">
    </div>
    <button class="btn btn-primary">Salvar</button>
</form>
@endsection
