<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
<body>
    <h1>Registrar Empresa + Admin</h1>

    <form method="POST" action="/registrar">
        @csrf

        <input type="text" name="empresa_nome" placeholder="Nome da Empresa"><br>
        <input type="text" name="empresa_slug" placeholder="Slug ex: escola-xyz"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="text" name="name" placeholder="Seu nome"><br>
        <input type="password" name="password" placeholder="Senha"><br>

        <button type="submit">Criar Conta</button>
    </form>
</body>
</html>
