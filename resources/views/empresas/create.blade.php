<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empresa - FaturaJa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h3>Registrar Empresa e Usuário</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('registrar') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="empresa_nome" class="form-label">Nome da Empresa</label>
                            <input type="text" name="empresa_nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="empresa_slug" class="form-label">Slug da Empresa</label>
                            <input type="text" name="empresa_slug" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Usuário</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrar</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Já tem uma conta? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
