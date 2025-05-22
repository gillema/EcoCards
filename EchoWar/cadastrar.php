<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro/Login</title>
    <link rel="stylesheet" href="cadastrar.css">
</head>
<body>
    <div class="form-container">
        <h1>Formulário de Cadastro</h1>
        <form action="functions.php" method="post">
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000">
            </div>
            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>

        <div class="login-section">
            <h2>Já tem uma conta?</h2>
            <form action="functions.php" method="post">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="login_email">E-mail:</label>
                    <input type="email" id="login_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="login_senha">Senha:</label>
                    <input type="password" id="login_senha" name="senha" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>