<?php
session_start();
require('conexao.php');

// Cadastro de usuário
if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $telefone = trim($_POST['telefone']);

    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION['register_error'] = "Por favor, preencha todos os campos obrigatórios!";
        header("Location: cadastrar.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Por favor, insira um e-mail válido!";
        header("Location: cadastrar.php");
        exit;
    }

    if (strlen($senha) < 6) {
        $_SESSION['register_error'] = "A senha deve ter pelo menos 6 caracteres!";
        header("Location: cadastrar.php");
        exit;
    }

    // Verifica se o e-mail já existe
    $sql_check = "SELECT email FROM cadastro WHERE email = ?";
    $stmt_check = $conexao->prepare($sql_check);
    
    if ($stmt_check) {
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $_SESSION['register_error'] = "Este e-mail já está cadastrado!";
            header("Location: cadastrar.php");
            exit;
        }
        $stmt_check->close();
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere no banco de dados
    $sql = "INSERT INTO cadastro (nome, email, senha, telefone) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $telefone);
        if ($stmt->execute()) {
            $_SESSION['usuario'] = $email;
            
            // Obtém o ID do usuário recém-cadastrado
            $user_id = $stmt->insert_id;
            $_SESSION['usuario_id'] = $user_id;
            
            header("Location: comprar.php");
            exit;
        } else {
            $_SESSION['register_error'] = "Erro ao cadastrar: " . $conexao->error;
            header("Location: cadastrar.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['register_error'] = "Erro no sistema. Por favor, tente novamente mais tarde.";
        header("Location: cadastrar.php");
        exit;
    }
}

// Login de usuário
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validações básicas
    if (empty($email) || empty($senha)) {
        $_SESSION['login_error'] = "Por favor, preencha todos os campos!";
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT id, nome, email, senha FROM cadastro WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                header("Location: comprar.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Senha incorreta!";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Usuário não encontrado!";
            header("Location: login.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['login_error'] = "Erro no sistema. Por favor, tente novamente mais tarde.";
        header("Location: login.php");
        exit;
    }
}

// Redirecionamento padrão caso acessem o arquivo diretamente
header("Location: index.php");
exit;
?>