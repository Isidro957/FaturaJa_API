@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    <div class="row g-4">

        <!-- Usuário -->
        <div class="col-md-6">
            <div class="card shadow-sm border-info h-100">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Usuário</h5>

                    <div>
                        @if($user->getRoleNames()->isNotEmpty())
                            @foreach($user->getRoleNames() as $role)
                                @php
                                    $color = match($role) {
                                        'admin' => 'bg-danger',
                                        'empresa' => 'bg-success',
                                        'cliente' => 'bg-primary',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $color }} me-1">{{ $role }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary">Sem Role</span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Nome:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>ID:</strong> {{ $user->id }}</p>
                    <p><strong>Empresa ID:</strong> {{ $user->empresa_id ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ implode(', ', $user->getRoleNames()->toArray()) }}</p>
                    <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Atualizado em:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

                    @can('gerenciar usuarios')
                        <a href="{{ route('empresa.usuarios.index') }}" class="btn btn-sm btn-primary mt-2">
                            Gerenciar Usuários
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Empresa -->
        <div class="col-md-6">
            <div class="card shadow-sm border-success h-100">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Empresa</h5>
                    @if($empresa)
                        <span class="badge bg-light text-dark">Empresa Associada</span>
                    @else
                        <span class="badge bg-warning text-dark">Sem Empresa</span>
                    @endif
                </div>

                <div class="card-body">
                    @if($empresa)
                        <p><strong>Nome:</strong> {{ $empresa->nome }}</p>
                        <p><strong>Slug:</strong> {{ $empresa->slug }}</p>
                        <p><strong>NIF:</strong> {{ $empresa->nif ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $empresa->email }}</p>
                        <p><strong>Telefone:</strong> {{ $empresa->telefone ?? '-' }}</p>
                        <p><strong>Endereço:</strong> {{ $empresa->endereco ?? '-' }}</p>
                        <p><strong>Criado em:</strong> {{ $empresa->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Atualizado em:</strong> {{ $empresa->updated_at->format('d/m/Y H:i') }}</p>

                        @if($empresa->logo)
                            <p><strong>Logo:</strong></p>
                            <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo {{ $empresa->nome }}" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                        @else
                            <p><strong>Logo:</strong> Sem logo</p>
                        @endif

                        @can('gerenciar empresas')
                            <a href="{{ route('empresas.index') }}" class="btn btn-sm btn-success mt-2">
                                Gerenciar Empresas
                            </a>
                        @endcan
                        @can('gerenciar clientes')
                            <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-primary mt-2">
                                Gerenciar Clientes
                            </a>
                        @endcan
                    @else
                        <p>Nenhuma empresa associada a este usuário.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Estatísticas rápidas -->
    <div class="row mt-4 g-4">

        @can('gerenciar usuarios')
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-people-fill me-2"></i>Usuários</h6>
                        <p class="card-text">{{ \App\Models\User::count() }} cadastrados</p>
                    </div>
                </div>
            </div>
        @endcan

        @can('gerenciar empresas')
            <div class="col-md-4">
                <div class="card text-white bg-success h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-building me-2"></i>Empresas</h6>
                        <p class="card-text">{{ \App\Models\Empresa::count() }} cadastradas</p>
                    </div>
                </div>
            </div>
        @endcan

        @can('gerenciar clientes')
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-person-badge-fill me-2"></i>Clientes</h6>
                        <p class="card-text">{{ \App\Models\Cliente::count() }} cadastrados</p>
                    </div>
                </div>
            </div>
        @endcan

    </div>

</div>
@endsection
