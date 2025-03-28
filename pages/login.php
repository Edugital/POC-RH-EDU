<?php
session_start();
require_once '../includes/auth.php';

// Se já estiver autenticado, redireciona para o dashboard
if (isAuthenticated()) {
    header('Location: ' . getDefaultPage());
    exit;
}

// Mock authentication - replace with real authentication later
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Mock credentials - replace with real authentication
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'Administrador';
        $_SESSION['user_role'] = 'Admin';
        header('Location: admin/');
        exit();
    } elseif ($username === 'colab' && $password === 'colab') {
        $_SESSION['user_id'] = 2;
        $_SESSION['user_name'] = 'Colaborador';
        $_SESSION['user_role'] = 'Colab';
        header('Location: worker/');
        exit();
    } else {
        $error = 'Usuário ou senha inválidos';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal RH</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
    }
    
    .login-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 2rem;
    }
    
    .logo {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .logo-text {
        font-size: 2rem;
        font-weight: 700;
    }
    
    .logo-text-vix {
        color: #1a237e;
    }
    
    .logo-text-par {
        color: #d32f2f;
    }
    
    .logo-bars {
        display: inline-flex;
        gap: 4px;
        margin-left: 8px;
    }
    
    .bar {
        width: 4px;
        height: 24px;
        border-radius: 2px;
    }
    
    .bar-green {
        background-color: #4caf50;
    }
    
    .bar-yellow {
        background-color: #ffc107;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        border-radius: 5px;
    }
    
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    
    .btn-primary {
        padding: 0.75rem 1rem;
        font-weight: 500;
        background-color: #1a237e;
        border-color: #1a237e;
    }
    
    .btn-primary:hover {
        background-color: #0d1757;
        border-color: #0d1757;
    }
    
    .demo-users {
        margin-top: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 5px;
        font-size: 0.85rem;
    }
    
    .demo-users h6 {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .alert {
        border-radius: 5px;
        font-size: 0.9rem;
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-text">
                    <span class="logo-text-vix">VIX</span>
                    <span class="logo-text-par">PAR</span>
                    <div class="logo-bars">
                        <span class="bar bar-green"></span>
                        <span class="bar bar-yellow"></span>
                    </div>
                </div>
                <h4 class="text-center mt-3 text-primary">Portal RH</h4>
            </div>

            <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                    </button>
                </div>
            </form>

            <div class="demo-users">
                <h6 class="text-center">Usuários de demonstração:</h6>
                <p class="text-muted text-center mb-0">
                    admin / admin (Administrador)<br>
                    colab / colab (Colaborador)
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 