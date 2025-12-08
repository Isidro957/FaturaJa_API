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
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Registrar Empresa e Usuário</h3>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('registrar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-3">Dados da Empresa</h5>

                        <div class="mb-3">
                            <label class="form-label">Nome da Empresa</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug da Empresa</label>
                            <input type="text" name="slug" class="form-control" placeholder="ex: faturaja" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">NIF</label>
                            <input type="text" name="nif" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email da Empresa</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Endereço</label>
                            <input type="text" name="endereco" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo (Imagem)</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <hr>

                        <h5 class="mb-3">Dados do Usuário</h5>

                        <div class="mb-3">
                            <label class="form-label">Nome do Usuário</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email do Usuário</label>
                            <input type="email" name="user_email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
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
