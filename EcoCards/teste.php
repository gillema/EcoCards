<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: cadastrar.php");
    exit;
}

require('conexao.php');

// Valores padrão
$nomeUsuario = "Usuário";
$emailUsuario = "usuario@exemplo.com";

// Consulta o banco de dados para obter os dados do usuário
$email = $_SESSION['usuario'];
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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar - Project EcoCards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/comprar.css">
    <link rel="icon" href="imagens/eco-icon.png" type="image/png">
</head>
<body>
    <div class="loader">
        <div class="spinner"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php" class="navbar-logo"> Project EcoCards </a>
        
        <button class="navbar-menu-toggle" id="navbarMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="navbar-container">
            <div class="navbar-links">
                <a href="index.php" class="navbar-link">Início</a>
                <a href="sobre.php" class="navbar-link">Sobre</a>
                <a href="contato.php" class="navbar-link">Contato</a>
            </div>
            
            <div class="navbar-buttons">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <button class="navbar-sidebar-toggle logged-in" id="navbarSidebarToggle">
                        <i class="fas fa-user"></i>
                    </button>
                <?php else: ?>
                    <div class="navbar-dropdown">
                        <button class="navbar-button">Cadastrar/Login <i class="fas fa-caret-down"></i></button>
                        <div class="navbar-dropdown-content">
                            <a href="cadastrar.php">Cadastrar</a>
                            <a href="login.php">Login</a>
                        </div>
                    </div>
                <?php endif; ?>
               
            </div>
        </div>
    </nav>

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
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Início</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="main-content" id="mainContent">
        <h1>Escolha Seu Plano</h1>
        <p>Selecione o plano que melhor atende às suas necessidades e comece a jogar agora mesmo!</p>
        
        <div class="pricing-container">
            <!-- Plano Básico -->
            <div class="pricing-card basic">
                <div class="pricing-header">
                    <h3 class="pricing-title">Básico</h3>
                    <div class="pricing-price">R$ 29,90</div>
                    <div class="pricing-period">por mês</div>
                </div>
                <div class="pricing-features">
                    <ul>
                        <li><i class="fas fa-check"></i> 50 Cards Ecológicos</li>
                        <li><i class="fas fa-check"></i> 5 Decks Básicos</li>
                        <li><i class="fas fa-check"></i> Acesso a Eventos Mensais</li>
                        <li><i class="fas fa-check"></i> Suporte por E-mail</li>
                        <li><i class="fas fa-check"></i> Atualizações Regulares</li>
                    </ul>
                    <a href="#" class="pricing-button">Assinar Agora</a>
                </div>
            </div>
            
            <!-- Plano Premium (Recomendado) -->
            <div class="pricing-card premium">
                <div class="recommended-badge">Recomendado</div>
                <div class="pricing-header">
                    <h3 class="pricing-title">Premium</h3>
                    <div class="pricing-price">R$ 59,90</div>
                    <div class="pricing-period">por mês</div>
                </div>
                <div class="pricing-features">
                    <ul>
                        <li><i class="fas fa-check"></i> 150 Cards Ecológicos</li>
                        <li><i class="fas fa-check"></i> 15 Decks Exclusivos</li>
                        <li><i class="fas fa-check"></i> Acesso a Eventos Semanais</li>
                        <li><i class="fas fa-check"></i> Suporte Prioritário 24/7</li>
                        <li><i class="fas fa-check"></i> Atualizações Imediatas</li>
                        <li><i class="fas fa-check"></i> Conteúdo Bônus Mensal</li>
                    </ul>
                    <a href="#" class="pricing-button">Assinar Agora</a>
                </div>
            </div>
            
            <!-- Plano Deluxe -->
            <div class="pricing-card deluxe">
                <div class="pricing-header">
                    <h3 class="pricing-title">Deluxe</h3>
                    <div class="pricing-price">R$ 99,90</div>
                    <div class="pricing-period">por mês</div>
                </div>
                <div class="pricing-features">
                    <ul>
                        <li><i class="fas fa-check"></i> 300 Cards Ecológicos</li>
                        <li><i class="fas fa-check"></i> 30 Decks Exclusivos</li>
                        <li><i class="fas fa-check"></i> Acesso a Todos Eventos</li>
                        <li><i class="fas fa-check"></i> Suporte VIP 24/7</li>
                        <li><i class="fas fa-check"></i> Atualizações Antecipadas</li>
                        <li><i class="fas fa-check"></i> Conteúdo Bônus Semanal</li>
                        <li><i class="fas fa-check"></i> Acesso Beta a Novos Recursos</li>
                        <li><i class="fas fa-check"></i> Mentorias Exclusivas</li>
                    </ul>
                    <a href="#" class="pricing-button">Assinar Agora</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>Project EcoCards &copy; <?php echo date('Y'); ?> - Todos os direitos reservados</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
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
            closeSidebar.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                mainContent.classList.remove('shifted');
            });

            // Fechar menu (clicar no overlay)
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                mainContent.classList.remove('shifted');
            });

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

            // Loader
            window.addEventListener('load', function() {
                const loader = document.querySelector('.loader');
                setTimeout(() => {
                    loader.classList.add('hidden');
                }, 1000);
            });

            // Efeito de digitação no título
            const title = document.querySelector('.main-content h1');
            if (title) {
                const originalText = title.textContent;
                title.textContent = '';

                let i = 0;
                const typingEffect = setInterval(() => {
                    title.textContent += originalText[i];
                    i++;
                    if (i >= originalText.length) {
                        clearInterval(typingEffect);
                    }
                }, 100);
            }

            // Verificação de login para o botão comprar (redundante, mas mantido para consistência)
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
        });
    </script>
</body>
</html>