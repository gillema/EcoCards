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
    <title>Home - Project EcoCards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="imagens/eco-icon.png" type="image/png">
</head>
<body>
    <div class="loader">
        <div class="spinner"></div>
    </div>

    <a href="cadastrar.php"><button class="cad-btn">cadastrar</button></a>
    <a href="comprar.php"><button class="com-btn">comprar</button></a>

    <!-- Botão para abrir o menu -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

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
                    <a href="#">
                        <i class="fas fa-home"></i>
                        <span>Início</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Carrinho</span>
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
        <h1>Project EcoCards</h1>
        <p>Clique no ícone no canto superior esquerdo para abrir o menu.</p>
        
        <!-- Novas janelas (cards) adicionadas -->
        <div class="card-container">
            <a href="produto1.php" class="card">
                <img src="imagens/agua.jpg" alt="Produto 1" class="card-image">
                <div class="card-content">
                    <h3 class="card-title">Card ecológico: A Água</h3>
                    <p class="card-description">A Água tem sua função como recurso necessário para a ativação de certas cartas.</p>
                </div>
            </a>
            
            <a href="produto2.php" class="card">
                <img src="imagens/sol.jpg" alt="Produto 2" class="card-image">
                <div class="card-content">
                    <h3 class="card-title">Card ecológico: O Sol</h3>
                    <p class="card-description">O Sol tem sua função como recurso necessário para a ativação de certas cartas.</p>
                </div>
            </a>
            
            <a href="produto3.php" class="card">
                <img src="imagens/vento.jpg" alt="Produto 3" class="card-image">
                <div class="card-content">
                    <h3 class="card-title">Card ecológico: O Vento</h3>
                    <p class="card-description">O Vento tem sua função como recurso necessário para a ativação de certas cartas.</p>
                </div>
            </a>
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

            // Abrir menu
            menuToggle.addEventListener('click', function() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                mainContent.classList.add('shifted');
            });

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

            // Efeito de digitação no título (com verificação de existência)
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
