<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isInSubfolder = strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== false;
$basePath = $isInSubfolder ? '../' : '';

require_once 'auth.php';
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VixPar - <?php echo $pageTitle ?? 'Dashboard'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS Base -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
    
    <style>
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: var(--primary-dark);
            color: white;
            position: relative;
            z-index: 1030;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-initials {
            background-color: var(--primary);
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .notification-btn {
            background: transparent;
            border: none;
            color: white;
            position: relative;
            padding: 0.5rem;
        }
        .notification-count {
            position: absolute;
            top: 0;
            right: 0;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
            transform: translate(25%, -25%);
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <span class="logo-text">VIX</span>
                    <span class="logo-text-secondary">PAR</span>
                    <div class="logo-bars">
                        <span class="bar bar-green"></span>
                        <span class="bar bar-yellow"></span>
                    </div>
                </div>
            </div>
            
            <nav class="nav-menu">
                <?php include 'menu.php'; ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar...">
                </div>
                
                <div class="user-menu">
                    <button class="btn-icon notification-btn" data-tooltip="Notificações">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">3</span>
                    </button>
                    
                    <?php if ($user): ?>
                    <!-- Dropdown de usuário -->
                    <div class="dropdown">
                      <button class="btn btn-link p-0 dropdown-toggle d-flex align-items-center gap-2" 
                              type="button" 
                              data-bs-toggle="dropdown" 
                              aria-expanded="false" 
                              style="text-decoration: none; color: white;">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                          <span class="text-white"><?php echo strtoupper(substr($user['name'], 0, 2)); ?></span>
                        </div>
                        <div class="text-start">
                          <div class="text-white fw-semibold"><?php echo htmlspecialchars($user['name']); ?></div>
                          <div class="text-white-50 small"><?php echo htmlspecialchars($user['role']); ?></div>
                        </div>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/worker/perfil.php">
                          <i class="fas fa-user me-2"></i>Meu Perfil
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/pages/logout.php">
                          <i class="fas fa-sign-out-alt me-2"></i>Sair
                        </a></li>
                      </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content Container -->
            <div class="content-container"> 
            </div> <!-- content-container -->
        </main>
    </div> <!-- app-container -->
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script de diagnóstico discreto (não afeta funcionalidades) -->
    <script>
    (function() {
        // Executa apenas após a página carregar completamente
        window.addEventListener('load', function() {
            // Verifica se o Bootstrap está disponível
            if (typeof bootstrap === 'undefined') {
                console.log("Diagnóstico: Bootstrap não está disponível");
            }
            
            // Adiciona um ouvinte de evento ao dropdown para diagnosticar problemas
            var dropdown = document.querySelector('.dropdown-toggle');
            if (dropdown) {
                dropdown.addEventListener('click', function() {
                    console.log("Diagnóstico: Clique no dropdown detectado");
                    
                    // Verifica após um pequeno atraso se o menu foi aberto
                    setTimeout(function() {
                        var menu = document.querySelector('.dropdown-menu');
                        if (menu && getComputedStyle(menu).display !== 'none') {
                            console.log("Diagnóstico: Dropdown menu está visível");
                        } else {
                            console.log("Diagnóstico: Dropdown menu não está visível");
                        }
                    }, 100);
                });
            }
        });
    })();
    </script>
</body>
</html> 