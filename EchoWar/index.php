<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <link rel="stylesheet" href="index.css">
    <style>
        /* Estilos para as novas janelas (cards) */
        
    </style>
</head>
<body>
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
                    <span class="user-name">Usuário</span>
                    <span class="user-email">usuario@exemplo.com</span>
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
                    <a href="#">
                        <i class="fas fa-key"></i>
                        <span>Senhas</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
                <li>
                    <a href="#">
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
                    <h3 class="card-title">Card ecológico: Água</h3>
                    <p class="card-description">Descrição do produto ecológico sustentável com benefícios para o meio ambiente.</p>
                </div>
            </a>
            
            <a href="produto2.php" class="card">
                <img src="imagens/sol.jpg" alt="Produto 2" class="card-image">
                <div class="card-content">
                    <h3 class="card-title">Card ecológico: Sol</h3>
                    <p class="card-description">Outro produto sustentável que ajuda a preservar os recursos naturais.</p>
                </div>
            </a>
            
            <a href="produto3.php" class="card">
                <img src="imagens/vento.jpg" alt="Produto 3" class="card-image">
                <div class="card-content">
                    <h3 class="card-title">Card ecológico: Vento</h3>
                    <p class="card-description">Terceiro produto em nossa linha ecológica com certificação verde.</p>
                </div>
            </a>
        </div>
    </main>

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
        });
    </script>
</body>
</html>