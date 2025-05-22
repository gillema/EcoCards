<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: cadastrar.php");
    exit;
}

require('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Compras</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>
    <p>Esta é a página de compras protegida.</p>
    
    <h2>Produtos Disponíveis</h2>
    <!-- Conteúdo da página de compras aqui -->
    
    <a href="logout.php">Sair</a>
</body>
</html>