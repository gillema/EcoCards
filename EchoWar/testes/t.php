<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <a href="cadastrar.php"><button class="cad-btn">cadastrar</button></a>

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
        <h1>Conteúdo Principal</h1>
        <p>Clique no ícone no canto superior esquerdo para abrir o menu.</p>
    </main>

    <script src="index.js"></script>
</body>
</html>