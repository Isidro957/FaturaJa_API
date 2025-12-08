@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <!-- Usuário -->
        <div class="col-md-6">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5>Informações do Usuário</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nome:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>ID do Usuário:</strong> {{ $user->id }}</p>
                </div>
            </div>
        </div>

        <!-- Empresa -->
        <div class="col-md-6">
            <div class="card shadow-sm border-success">
                <div class="card-header bg-success text-white">
                    <h5>Informações da Empresa</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nome:</strong> {{ $empresa->nome }}</p>
                    <p><strong>Slug:</strong> {{ $empresa->slug }}</p>
                    <p><strong>Email:</strong> {{ $empresa->email }}</p>
                    <p><strong>Telefone:</strong> {{ $empresa->telefone }}</p>
                    <p><strong>Endereço:</strong> {{ $empresa->endereco }}</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
