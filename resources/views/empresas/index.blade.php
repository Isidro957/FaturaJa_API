@extends('layouts.app')

@section('title', 'Lista de Empresas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Empresas</h2>

    <a href="{{ route('empresas.create') }}" class="btn btn-primary">
        ➕ Nova Empresa
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Lista de Empresas Registradas</h5>
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Logo</th> <!-- NOVA COLUNA -->
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Email</th>
                    <th width="180px">Ações</th>
                </tr>
            </thead>

            <tbody>
            @forelse($empresas as $empresa)
                <tr>
                    <td>{{ $empresa->id }}</td>

                    <!-- LOGO DA EMPRESA -->
                    <td>
                        @if($empresa->logo)
                            <img src="{{ asset('storage/' . $empresa->logo) }}"
                                 alt="Logo"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                        @else
                            <span class="text-muted">Sem logo</span>
                        @endif
                    </td>

                    <td>{{ $empresa->nome }}</td>
                    <td>{{ $empresa->slug }}</td>
                    <td>{{ $empresa->email }}</td>

                    <td>
                        <a href="{{ route('empresas.edit', $empresa->id) }}" 
                           class="btn btn-sm btn-warning">
                           ✏ Editar
                        </a>

                        <form action="{{ route('empresas.destroy', $empresa->id) }}" 
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" 
                                    onclick="return confirm('Deseja realmente excluir?')"
                                    class="btn btn-sm btn-danger">
                                🗑 Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-3">
                        Nenhuma empresa cadastrada.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
