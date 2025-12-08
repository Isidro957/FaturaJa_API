@extends('layouts.app')

@section('content')
<h1>Editar Empresa</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nome:</label><br>
    <input type="text" name="nome" value="{{ $empresa->nome }}"><br>

    <label>Slug:</label><br>
    <input type="text" name="slug" value="{{ $empresa->slug }}"><br>

    <label>NIF:</label><br>
    <input type="text" name="nif" value="{{ $empresa->nif }}"><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="{{ $empresa->email }}"><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" value="{{ $empresa->telefone }}"><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" value="{{ $empresa->endereco }}"><br><br>

    <button type="submit">Atualizar</button>
</form>
@endsection
