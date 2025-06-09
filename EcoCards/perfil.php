<?php
session_start();
require('conexao.php');

// Redirecionar se não estiver logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Obter dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$nome = $email = $telefone = '';
$erro = $sucesso = '';

// Buscar dados atuais do usuário
$sql = "SELECT nome, email, telefone FROM cadastro WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $usuario = $result->fetch_assoc();
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $telefone = $usuario['telefone'];
}
$stmt->close();

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_nome = trim($_POST['nome']);
    $novo_email = trim($_POST['email']);
    $novo_telefone = trim($_POST['telefone']);
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validações básicas
    if (empty($novo_nome) || empty($novo_email)) {
        $erro = "Nome e e-mail são obrigatórios!";
    } elseif (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um e-mail válido!";
    } else {
        // Verificar se o email já existe (exceto para o usuário atual)
        $sql_check = "SELECT id FROM cadastro WHERE email = ? AND id != ?";
        $stmt_check = $conexao->prepare($sql_check);
        $stmt_check->bind_param("si", $novo_email, $usuario_id);
        $stmt_check->execute();
        $stmt_check->store_result();
        
        if ($stmt_check->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado por outro usuário!";
        } else {
            // Atualizar informações básicas
            $sql_update = "UPDATE cadastro SET nome = ?, email = ?, telefone = ? WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);
            $stmt_update->bind_param("sssi", $novo_nome, $novo_email, $novo_telefone, $usuario_id);
            
            if ($stmt_update->execute()) {
                $_SESSION['usuario'] = $novo_email;
                $_SESSION['usuario_nome'] = $novo_nome;
                $sucesso = "Informações atualizadas com sucesso!";
                $nome = $novo_nome;
                $email = $novo_email;
                $telefone = $novo_telefone;
            } else {
                $erro = "Erro ao atualizar informações: " . $conexao->error;
            }
            $stmt_update->close();
            
            // Atualizar senha se fornecida
            if (!empty($senha_atual) && !empty($nova_senha) && !empty($confirmar_senha)) {
                if ($nova_senha !== $confirmar_senha) {
                    $erro = "As novas senhas não coincidem!";
                } else {
                    // Verificar senha atual
                    $sql_senha = "SELECT senha FROM cadastro WHERE id = ?";
                    $stmt_senha = $conexao->prepare($sql_senha);
                    $stmt_senha->bind_param("i", $usuario_id);
                    $stmt_senha->execute();
                    $result_senha = $stmt_senha->get_result();
                    
                    if ($result_senha->num_rows == 1) {
                        $usuario_senha = $result_senha->fetch_assoc();
                        if (password_verify($senha_atual, $usuario_senha['senha'])) {
                            // Atualizar senha
                            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                            $sql_update_senha = "UPDATE cadastro SET senha = ? WHERE id = ?";
                            $stmt_update_senha = $conexao->prepare($sql_update_senha);
                            $stmt_update_senha->bind_param("si", $nova_senha_hash, $usuario_id);
                            
                            if ($stmt_update_senha->execute()) {
                                $sucesso = "Informações e senha atualizadas com sucesso!";
                            } else {
                                $erro = "Erro ao atualizar senha: " . $conexao->error;
                            }
                            $stmt_update_senha->close();
                        } else {
                            $erro = "Senha atual incorreta!";
                        }
                    }
                    $stmt_senha->close();
                }
            }
        }
        $stmt_check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Project EcoCards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="icon" href="imagens/logo.png" type="imagens/logo.png">
</head>
<body>
    <!-- Navbar (mesma do index.php) -->
    <nav class="navbar">
        <a href="index.php" class="navbar-logo"> Project EcoCards </a>
        
        <button class="navbar-menu-toggle" id="navbarMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-buttons">
           <div class="navbar-links">
                <a href="index.php" class="navbar-link">Início</a>
                <a href="sobre.php" class="navbar-link">Sobre</a>
                <a href="contato.php" class="navbar-link">Contato</a>
            </div>

            <?php if(!isset($_SESSION['usuario'])): ?>
                <div class="navbar-dropdown">
                    <button class="navbar-button">Cadastrar/Login <i class="fas fa-caret-down"></i></button>
                    <div class="navbar-dropdown-content">
                        <a href="cadastrar.php">Cadastrar</a>
                        <a href="login.php">Login</a>
                    </div>
                </div>
            <?php endif; ?>
            
            <button class="navbar-button" id="navbarComprarBtn">Comprar</button>
            <?php if(isset($_SESSION['usuario'])): ?>
                <button class="navbar-sidebar-toggle logged-in" id="navbarSidebarToggle">
                    <i class="fas fa-user"></i>
                </button>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Loader -->
    <div class="loader">
        <div class="spinner"></div>
    </div>

    <!-- Overlay (fundo escuro) -->
    <div class="overlay" id="overlay"></div>

    <!-- Menu Lateral (mesmo do index.php) -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></span>
                    <span class="user-email"><?php echo htmlspecialchars($_SESSION['usuario'] ?? 'usuario@exemplo.com'); ?></span>
                </div>
            </div>
            <button class="close-btn" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="perfil.php">
                        <i class="fas fa-user"></i>
                        <span>Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Início</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" id="logoutLink">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-content" id="mainContent">
        <h1>Meu Perfil</h1>
        <p>Gerencie suas informações pessoais e preferências de conta.</p>
        
        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success"><?php echo $sucesso; ?></div>
        <?php endif; ?>

        <div class="profile-container">
            <form action="perfil.php" method="POST" class="profile-form">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>">
                </div>
                
                <h3>Alterar Senha</h3>
                <div class="form-group">
                    <label for="senha_atual">Senha Atual</label>
                    <input type="password" id="senha_atual" name="senha_atual">
                </div>
                
                <div class="form-group">
                    <label for="nova_senha">Nova Senha</label>
                    <input type="password" id="nova_senha" name="nova_senha">
                </div>
                
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Nova Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha">
                </div>
                
                <button type="submit" class="profile-button">Atualizar Perfil</button>
            </form>
            
            <div class="profile-sidebar">
                <div class="profile-card">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($nome); ?></h3>
                    <p><?php echo htmlspecialchars($email); ?></p>
                    <p><?php echo htmlspecialchars($telefone ?: 'Telefone não cadastrado'); ?></p>
                </div>
                
                <div class="profile-actions">
                    <h3>Ações</h3>
                    <a href="logout.php" class="action-button logout">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer (mesmo do index.php) -->
    <footer class="footer">
        <p>Project EcoCards &copy; <?php echo date('Y'); ?> - Todos os direitos reservados</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <!-- Scripts (mesmos do index.php) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            const navbarMenuToggle = document.getElementById('navbarMenuToggle');
            const navbarSidebarToggle = document.getElementById('navbarSidebarToggle');

            // Abrir menu (botão na navbar)
            if (navbarSidebarToggle) {
                navbarSidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                    mainContent.classList.add('shifted');
                });
            }

            // Fechar menu (botão X)
            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                });
            }

            // Fechar menu (clicar no overlay)
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                });
            }

            // Fechar ao pressionar ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                }
            });

            // Menu mobile navbar
            if (navbarMenuToggle) {
                navbarMenuToggle.addEventListener('click', function() {
                    document.querySelector('.navbar').classList.toggle('active');
                });
            }

            // Verificação de login para o botão comprar
            const navbarComprarBtn = document.getElementById('navbarComprarBtn');
            if (navbarComprarBtn) {
                navbarComprarBtn.addEventListener('click', function() {
                    <?php if(isset($_SESSION['usuario'])): ?>
                        window.location.href = 'comprar.php';
                    <?php else: ?>
                        const confirmar = confirm('É necessário fazer login, deseja realizar?');
                        if (confirmar) {
                            window.location.href = 'cadastrar.php';
                        }
                    <?php endif; ?>
                });
            }

            // Confirmação para sair
            const logoutLink = document.getElementById('logoutLink');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const confirmar = confirm('Tem certeza que deseja sair?');
                    if (confirmar) {
                        window.location.href = 'logout.php';
                    }
                });
            }
        });

        // Loader
        window.addEventListener('load', function() {
            const loader = document.querySelector('.loader');
            setTimeout(() => {
                loader.classList.add('hidden');
            }, 1000);
        });
    </script>
</body>
</html>