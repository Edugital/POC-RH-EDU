<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/includes/auth.php';

// Verifica se o usuário está autenticado e é colaborador
if (!isAuthenticated()) {
    header('Location: ../login.php');
    exit;
} elseif (isAdmin()) {
    header('Location: ../error.php?code=403&message=Área restrita a colaboradores');
    exit;
}

// Verifica se há um título de página definido
if (!isset($pageTitle)) {
    $pageTitle = 'Portal do Colaborador';
}

// Base path for assets and links
$basePath = '../../';
$currentPage = basename($_SERVER['PHP_SELF']);

$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VixPar - <?php echo $pageTitle ?? 'Dashboard'; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/mobile.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/demo-lms.css">
    
    <!-- Page Specific Styles -->
    <?php if (isset($styles)) echo $styles; ?>
</head>
<body <?php echo isset($bodyDataAttributes) ? $bodyDataAttributes : ''; ?>>
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
            
            <?php include dirname(__DIR__, 2) . '/includes/menu-worker.php'; ?>
            
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
                    
                    <!-- Perfil do usuário com dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center gap-2" 
                              type="button" 
                              data-bs-toggle="dropdown" 
                              aria-expanded="false" 
                              style="text-decoration: none; color: white;">
                            <div class="avatar">
                                <span class="avatar-initials"><?php echo $user['avatar']; ?></span>
                            </div>
                            <div class="user-info">
                                <h4 class="user-name">COLAB</h4>
                                <span class="user-role"><?php echo htmlspecialchars($user['role']); ?></span>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="perfil.php">
                                <i class="fas fa-user me-2"></i>Meu Perfil
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/pages/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo $basePath; ?>assets/js/main.js"></script>
    <script src="<?php echo $basePath; ?>assets/js/demo-lms.js"></script>
</body>
</html> 