<?php
// conexao.php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ecocards';

$conexao = new mysqli($host, $user, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Verifica e cria a tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS cadastro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20)
)";

if (!$conexao->query($sql)) {
    die("Erro ao criar tabela: " . $conexao->error);
}
?>
