@extends('layouts.app')

@section('title', 'Usuários da Empresa')

@section('content')
<div class="container-fluid py-4">

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Usuários da Empresa</h3>
        <a href="{{ route('empresa.usuarios.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Novo Usuário
        </a>
    </div>

    @if($users->isEmpty())
        <div class="alert alert-info">
            Nenhum usuário cadastrado.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>
                                @if($usuario->avatar)
                                    <img src="{{ asset('storage/' . $usuario->avatar) }}"
                                         alt="Avatar"
                                         class="rounded-circle"
                                         width="40" height="40"
                                         style="object-fit: cover;">
                                @else
                                    <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                @endif
                            </td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @forelse($usuario->getRoleNames() as $role)
                                    <span class="badge bg-primary">{{ $role }}</span>
                                @empty
                                    <span class="badge bg-secondary">Sem Role</span>
                                @endforelse
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('empresa.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('empresa.usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
