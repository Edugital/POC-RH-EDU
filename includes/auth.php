<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL constant only if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/mocks/rh-edu/vixpar'); // No trailing slash
}

// Mock de permissões para desenvolvimento
$permissions = [
    'Admin' => [
        'colaborador' => ['view', 'create', 'edit', 'delete'],
        'vagas' => ['view', 'create', 'edit', 'delete'],
        'candidatos' => ['view', 'create', 'edit', 'delete'],
        'configuracoes' => ['view', 'edit'] // Garantir que admin tenha acesso a configurações
    ],
    'RH' => [
        'colaborador' => ['view', 'create', 'edit'],
        'vagas' => ['view', 'create', 'edit'],
        'candidatos' => ['view', 'create', 'edit']
    ],
    'Gestor' => [
        'colaborador' => ['view'],
        'vagas' => ['view', 'create'],
        'candidatos' => ['view']
    ]
];

// Se não existir uma sessão de usuário e não estiver na página de login ou erro
if (!isset($_SESSION['user_id']) && 
    !in_array(basename($_SERVER['PHP_SELF']), ['login.php', 'error.php'])) {
    header('Location: ' . BASE_URL . '/pages/login.php');
    exit();
}

function authenticate($username, $password) {
    // Mock de autenticação para desenvolvimento
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_name'] = 'Administrador';
        $_SESSION['user_role'] = 'Admin';
        return true;
    } elseif ($username === 'colab' && $password === 'colab') {
        $_SESSION['user_id'] = 2;
        $_SESSION['user_name'] = 'Colaborador';
        $_SESSION['user_role'] = 'Colab';
        return true;
    }
    return false;
}

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin';
}

function requireAdmin() {
    if (!isAdmin()) {
        // Relative path handling for different directories
        $errorPath = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) 
            ? '../error.php?code=403&message=Acesso restrito a administradores'
            : 'error.php?code=403&message=Acesso restrito a administradores';
            
        header('Location: ' . $errorPath);
        exit();
    }
}

function requireAuth() {
    if (!isset($_SESSION['user_id'])) {
        // Relative path handling for different directories
        $loginPath = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false || 
                     strpos($_SERVER['PHP_SELF'], '/worker/') !== false) 
            ? '../login.php'
            : 'login.php';
            
        header('Location: ' . $loginPath);
        exit();
    }
}

function getUserPermissions() {
    global $permissions;
    
    if (!isAuthenticated()) {
        return [];
    }
    
    $role = $_SESSION['user_role'];
    return $permissions[$role] ?? [];
}

function hasPermission($module, $action) {
    // Verifica se é administrador primeiro
    if (isAdmin()) {
        return true;
    }
    
    // Para outros usuários, verifica as permissões específicas
    $userPermissions = getUserPermissions();
    return isset($userPermissions[$module]) && in_array($action, $userPermissions[$module]);
}

function requirePermission($module, $action) {
    if (!hasPermission($module, $action)) {
        // Relative path handling for different directories
        $errorPath = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false)
            ? '../error.php?code=403'
            : 'error.php?code=403';
            
        header('Location: ' . $errorPath);
        exit();
    }
}

function getCurrentUser() {
    // In a real application, this would get data from database
    if (isAdmin()) {
        return [
            'id' => $_SESSION['user_id'] ?? 1,
            'name' => $_SESSION['user_name'] ?? 'Administrador',
            'role' => $_SESSION['user_role'] ?? 'Admin',
            'department' => 'Tecnologia',
            'position' => 'Administrador do Sistema',
            'avatar' => 'A'
        ];
    }
    
    // Default user data for regular users
    return [
        'id' => $_SESSION['user_id'] ?? 2,
        'name' => $_SESSION['user_name'] ?? 'João da Silva',
        'role' => $_SESSION['user_role'] ?? 'Colaborador',
        'department' => 'Operacional',
        'position' => 'Motorista',
        'avatar' => 'JS'
    ];
}

function logout() {
    // Destroy the session
    session_destroy();
    
    // Build the URL without concatenation to avoid issues
    $loginUrl = BASE_URL . '/pages/login.php';
    header('Location: ' . $loginUrl);
    exit();
}

function getDefaultPage() {
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] === 'Admin') {
            return 'admin/index.php';
        } else {
            return 'colaborador.php';
        }
    }
    return 'login.php';
}

function isWorker() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'worker';
} 