<?php
session_start();
require('conexao.php');

// Valores padrão modificados para sempre mostrar a sidebar
$nomeUsuario = "Visitante";
$emailUsuario = "visitante@ecocards.com";

// Verifica se o usuário está logado e atualiza os valores
if (isset($_SESSION['usuario'])) {
    $email = $_SESSION['usuario'];
    
    // Consulta o banco de dados para obter os dados do usuário
    $sql = "SELECT nome, email FROM cadastro WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            $nomeUsuario = $usuario['nome'];
            $emailUsuario = $usuario['email'];
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Sol - Project EcoCards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imagens/logo.png" type="imagens/logo.png">
</head>
<body>
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
            <!-- Sempre mostrar o botão do usuário -->
            <button class="navbar-sidebar-toggle" id="navbarSidebarToggle">
                <i class="fas fa-<?php echo isset($_SESSION['usuario']) ? 'user' : 'user-circle'; ?>"></i>
            </button>
        </div>
    </nav>

    <div class="loader">
        <div class="spinner"></div>
    </div>

    <!-- Overlay (fundo escuro) -->
    <div class="overlay" id="overlay"></div>

    <!-- Menu Lateral -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-<?php echo isset($_SESSION['usuario']) ? 'user' : 'user-circle'; ?>"></i>
                </div>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($nomeUsuario); ?></span>
                    <span class="user-email"><?php echo htmlspecialchars($emailUsuario); ?></span>
                </div>
            </div>
            <button class="close-btn" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <ul>
                <li>
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Início</span>
                    </a>
                </li>
                <?php if(isset($_SESSION['usuario'])): ?>
                    <li>
                        <a href="logout.php" id="logoutLink">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="login.php">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="cadastrar.php">
                            <i class="fas fa-user-plus"></i>
                            <span>Cadastrar</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </aside>
    <main class="main-content" id="mainContent">
        <h1>Card Ecológico: O Sol</h1>
        
        <div class="card-detail-container">
            <div class="card-detail-image">
                <img src="imagens/sol.png" alt="Card Sol">
            </div>
            
            <div class="card-detail-content">
                <h2>Fonte de Energia</h2>
                <p>O Sol é a principal fonte de energia no jogo EcoCards, permitindo que cartas de plantas realizem fotossíntese e gerem recursos.</p>
                
                <h3>Mecânica de Jogo:</h3>
                <ul>
                    <li><strong>Geração de Energia:</strong> Cartas de plantas podem usar o Sol para gerar tokens de energia a cada turno.</li>
                    <li><strong>Limitação Diária:</strong> Você só pode jogar um card de Sol por turno, simulando o ciclo dia-noite.</li>
                    <li><strong>Combinações:</strong> Quando combinado com Água, permite que cartas de planta cresçam e se reproduzam.</li>
                </ul>
                
                <h3>Impacto Ecológico:</h3>
                <p>Este card ensina sobre a importância da energia solar para todos os ecossistemas terrestres e o processo de fotossíntese.</p>
                
                <div class="card-stats">
                    <div class="stat">
                        <span class="stat-label">Raridade</span>
                        <span class="stat-value">Comum</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Tipo</span>
                        <span class="stat-value">Recurso</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Poder</span>
                        <span class="stat-value">2</span>
                    </div>
                </div>
                
                <a href="index.php" class="detail-button">Voltar</a>
            </div>
        </div>
    </main>

      <footer class="footer">
        <p>Project EcoCards &copy; <?php echo date('Y'); ?> - Todos os direitos reservados</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <script>
        // Mesmo script do index.php
        document.addEventListener('DOMContentLoaded', function() {
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            const navbarMenuToggle = document.getElementById('navbarMenuToggle');
            const navbarSidebarToggle = document.getElementById('navbarSidebarToggle');

            if (navbarSidebarToggle) {
                navbarSidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                    mainContent.classList.add('shifted');
                });
            }

            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    mainContent.classList.remove('shifted');
                }
            });

            if (navbarMenuToggle) {
                navbarMenuToggle.addEventListener('click', function() {
                    document.querySelector('.navbar').classList.toggle('active');
                });
            }

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

        window.addEventListener('load', function() {
            const loader = document.querySelector('.loader');
            setTimeout(() => {
                loader.classList.add('hidden');
            }, 1000);
        });
    </script>
</body>
</html>