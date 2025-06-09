<?php
session_start();
require('conexao.php');

// Valores padrão
$nomeUsuario = "Usuário";
$emailUsuario = "usuario@exemplo.com";

// Verifica se o usuário está logado
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
    <title>Contato - Project EcoCards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/contato.css">
    <link rel="icon" href="imagens/logo.png" type="imagens/logo.png">
   
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php" class="navbar-logo"> Project EcoCards </a>
        
        <button class="navbar-menu-toggle" id="navbarMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-buttons">
            <div class="navbar-links">
                <a href="index.php" class="navbar-link">Início</a>
                <a href="sobre.php" class="navbar-link">Sobre</a>
                <a href="contato.php" class="navbar-link active">Contato</a>
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
                    <i class="fas fa-user"></i>
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

    <!-- Conteúdo Principal -->
    <main class="main-content" id="mainContent">
        <h1>Fale Conosco</h1>
        <p>Tem dúvidas, sugestões ou precisa de ajuda? Entre em contato conosco!</p>
        
        <div class="card-detail-container">
            <div class="card-detail-image">
                <img src="imagens/sobre.png" alt="Entre em contato com a Project EcoCards" style="border-radius: 10px;">
            </div>
            
            <div class="card-detail-content">
                <h2>Nossos Canais de Atendimento</h2>
                
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>E-mail</h3>
                            <p><a href="mailto:ecocards@gmail.com">ecocards@gmail.com</a></p>
                            <p>Resposta em até 24 horas</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Telefone/WhatsApp</h3>
                            <p><a href="tel:558597692504">(85) 9769-2504</a></p>
                            <p>Atendimento: Segunda a Sexta, 9h às 18h</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Endereço</h3>
                            <p>EEEP Walter Ramos de Araújo</p>
                            <p>São Gonçalo do Amarante - CE</p>
                            <p><a href="https://maps.google.com" target="_blank">Ver no mapa</a></p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Horário de Funcionamento</h3>
                            <p>Segunda a Sexta: 9h às 18h</p>
                            <p>Sábado: 9h às 12h</p>
                        </div>
                    </div>
                </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Project EcoCards</h3>
                <p>Educação ambiental através de cartas colecionáveis.</p>
            </div>
            <div class="footer-section">
                <h3>Contato Rápido</h3>
                <p><i class="fas fa-phone"></i> (85) 9769-2504</p>
                <p><i class="fas fa-envelope"></i> ecocards@gmail.com</p>
            </div>
            <div class="footer-section">
                <h3>Redes Sociais</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Project EcoCards &copy; <?php echo date('Y'); ?> - Todos os direitos reservados</p>
        </div>
    </footer>

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