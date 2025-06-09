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
?>
