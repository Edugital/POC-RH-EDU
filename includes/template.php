<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'auth.php';
$user = getCurrentUser();

// Redireciona para login se não estiver autenticado
if (!$user && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location: /mocks/rh-edu/vixpar/pages/login.php');
    exit();
}
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
    <link rel="stylesheet" href="/mocks/rh-edu/vixpar/assets/css/main.css">
    <link rel="stylesheet" href="/mocks/rh-edu/vixpar/assets/css/style.css">
    
    <style>
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            background: var(--primary-dark);
            color: white;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .user-details {
            display: flex;
            flex-direction: column;
        }
        .user-name {
            font-weight: bold;
            color: white;
            margin: 0;
        }
        .user-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
        }
        .notification-btn {
            background: transparent;
            border: none;
            color: white;
            position: relative;
            padding: 0.5rem;
            margin-right: 1rem;
        }
        .notification-count {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
            transform: translate(25%, -25%);
        }
        .user-profile {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }
        .user-profile:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.15);
        }
        .dropdown-item {
            padding: 0.75rem 1rem;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .dropdown-item i {
            width: 1.25rem;
            color: #6c757d;
        }
        .search-bar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            gap: 0.5rem;
        }
        .search-bar input {
            background: transparent;
            border: none;
            color: white;
            outline: none;
            width: 300px;
        }
        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .search-bar i {
            color: rgba(255, 255, 255, 0.7);
        }
        .dropdown-toggle::after {
            display: none;
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
                
                <?php if ($user): ?>
                <div class="d-flex align-items-center gap-3">
                    <!-- Notificações -->
                    <div class="position-relative">
                        <i class="fas fa-bell text-white"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </div>

                    <!-- Perfil do Usuário com Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle p-0 border-0 d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                <span class="text-white">JS</span>
                            </div>
                            <div>
                                <div class="text-white text-start">Administrador</div>
                                <div class="text-white-50 small">Admin</div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li>
                                <a class="dropdown-item" href="<?php echo BASE_URL; ?>/pages/logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Content Container -->
            <div class="content-container">
                <?php echo $content ?? ''; ?>
            </div>
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa todos os dropdowns do Bootstrap
        var dropdowns = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        dropdowns.forEach(function (dropdownToggleEl) {
            new bootstrap.Dropdown(dropdownToggleEl)
        })
    });
    </script>
</body>
</html> 