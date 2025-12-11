@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">

    {{-- Linha do usuário e empresa --}}
    <div class="row g-4">

        {{-- CARD DO USUÁRIO --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100">

                <div class="card-header bg-info text-white rounded-top-4 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i> Dados do Usuário
                    </h5>

                    {{-- Exibir Roles --}}
                    <div>
                        @forelse($user->getRoleNames() as $role)
                            @php
                                $color = match($role) {
                                    'admin' => 'bg-danger',
                                    'empresa' => 'bg-success',
                                    'cliente' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $color }}">{{ ucfirst($role) }}</span>
                        @empty
                            <span class="badge bg-secondary">Sem Role</span>
                        @endforelse
                    </div>
                </div>

                <div class="card-body">

                    {{-- Avatar do Usuário --}}
                    <div class="text-center mb-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}"
                                 alt="Avatar"
                                 class="rounded-circle shadow"
                                 width="110" height="110"
                                 style="object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle text-secondary" style="font-size: 80px;"></i>
                        @endif
                    </div>

                    <p><strong>Nome:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Empresa ID:</strong> {{ $user->empresa_id ?? '-' }}</p>
                    <p><strong>Role:</strong> {{ implode(', ', $user->getRoleNames()->toArray()) }}</p>

                    <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Atualizado em:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

                    @can('gerenciar usuarios')
                        <a href="{{ route('empresa.usuarios.index') }}" class="btn btn-primary btn-sm mt-3 w-100">
                            <i class="bi bi-gear"></i> Gerenciar Usuários
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        {{-- CARD DA EMPRESA --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 h-100">

                <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i> Empresa
                    </h5>

                    <span class="badge bg-light text-dark">
                        {{ $empresa ? 'Empresa Associada' : 'Sem Empresa' }}
                    </span>
                </div>

                <div class="card-body">
                    @if($empresa)

                        {{-- LOGO DA EMPRESA --}}
                        <div class="text-center mb-3">
                            @if($empresa->logo)
                                <img src="{{ asset('storage/' . $empresa->logo) }}"
                                     alt="Logo"
                                     class="rounded shadow"
                                     style="max-height: 120px;">
                            @else
                                <i class="bi bi-image text-muted" style="font-size: 70px;"></i>
                            @endif
                        </div>

                        <p><strong>Nome:</strong> {{ $empresa->nome }}</p>
                        <p><strong>Slug:</strong> {{ $empresa->slug }}</p>
                        <p><strong>NIF:</strong> {{ $empresa->nif ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $empresa->email }}</p>
                        <p><strong>Telefone:</strong> {{ $empresa->telefone ?? '-' }}</p>
                        <p><strong>Endereço:</strong> {{ $empresa->endereco ?? '-' }}</p>

                        <p><strong>Criado em:</strong> {{ $empresa->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Atualizado em:</strong> {{ $empresa->updated_at->format('d/m/Y H:i') }}</p>

                        {{-- BOTÕES --}}
                        <div class="mt-3 d-flex gap-2 flex-wrap">

                            @can('gerenciar empresas')
                                <a href="{{ route('empresas.index') }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-gear"></i> Gerenciar Empresas
                                </a>
                            @endcan

                            @can('gerenciar clientes')
                                <a href="{{ route('clientes.index') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-person-badge"></i> Gerenciar Clientes
                                </a>
                            @endcan

                        </div>

                    @else
                        <p class="text-muted">Nenhuma empresa associada.</p>
                    @endif
                </div>

            </div>
        </div>

    </div>

    {{-- ESTATÍSTICAS --}}
    <div class="row mt-4 g-4">

        @can('gerenciar usuarios')
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow border-0 rounded-4 h-100">
                    <div class="card-body">
                        <h6><i class="bi bi-people fs-5 me-2"></i>Usuários</h6>
                        <h3>{{ \App\Models\User::count() }}</h3>
                    </div>
                </div>
            </div>
        @endcan

        @can('gerenciar empresas')
            <div class="col-md-4">
                <div class="card bg-success text-white shadow border-0 rounded-4 h-100">
                    <div class="card-body">
                        <h6><i class="bi bi-building fs-5 me-2"></i>Empresas</h6>
                        <h3>{{ \App\Models\Empresa::count() }}</h3>
                    </div>
                </div>
            </div>
        @endcan

        @can('gerenciar clientes')
            <div class="col-md-4">
                <div class="card bg-warning text-dark shadow border-0 rounded-4 h-100">
                    <div class="card-body">
                        <h6><i class="bi bi-person-badge fs-5 me-2"></i>Clientes</h6>
                        <h3>{{ \App\Models\Cliente::count() }}</h3>
                    </div>
                </div>
            </div>
        @endcan

    </div>

</div>
@endsection
