<?php
require_once dirname(__DIR__, 2) . '/includes/auth.php';

// Verifica se o usuário está autenticado e é administrador
if (!isAuthenticated()) {
    header('Location: ../login.php');
    exit;
} elseif (!isAdmin()) {
    // Usar a função isAdmin() diretamente do auth.php
    header('Location: ../error.php?code=403&message=Acesso restrito a administradores');
    exit;
}
?> 