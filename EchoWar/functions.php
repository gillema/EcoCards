<?php
session_start();
require('conexao.php');

// Cadastro de usuário
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO cadastro (nome, email, senha, telefone) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $senha, $telefone);
        if ($stmt->execute()) {
            $_SESSION['usuario'] = $email;
            header("Location: comprar.php");
            exit;
        } else {
            echo "Erro ao cadastrar: " . $conexao->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar o SQL: " . $conexao->error;
    }
}

// Login de usuário
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, senha FROM cadastro WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario'] = $email;
                $_SESSION['usuario_id'] = $usuario['id'];
                header("Location: comprar.php");
                exit;
            } else {
                echo "Senha incorreta!";
            }
        } else {
            echo "Usuário não encontrado!";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar o SQL: " . $conexao->error;
    }
}
?>