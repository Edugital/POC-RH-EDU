<?php
$pageTitle = 'Erro';
require_once '../config/dashboard.php';

$errorCode = $_GET['code'] ?? '404';
$errorMessage = $_GET['message'] ?? '';

$errors = [
    '403' => [
        'title' => 'Acesso Negado',
        'message' => $errorMessage ?: 'Você não tem permissão para acessar esta página.',
        'icon' => 'fas fa-lock',
        'color' => 'danger'
    ],
    '404' => [
        'title' => 'Página não encontrada',
        'message' => 'A página que você está procurando não existe.',
        'icon' => 'fas fa-search',
        'color' => 'warning'
    ],
    '500' => [
        'title' => 'Erro do Servidor',
        'message' => 'Ocorreu um erro interno no servidor.',
        'icon' => 'fas fa-exclamation-triangle',
        'color' => 'danger'
    ]
];

$error = $errors[$errorCode] ?? $errors['404'];

ob_start();
?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="error-page">
                <div class="error-icon mb-4">
                    <i class="<?php echo $error['icon']; ?> fa-4x text-<?php echo $error['color']; ?>"></i>
                </div>
                <h1 class="error-code mb-4">
                    <?php echo htmlspecialchars($errorCode); ?>
                </h1>
                <h2 class="error-title mb-3">
                    <?php echo htmlspecialchars($error['title']); ?>
                </h2>
                <p class="error-message mb-4">
                    <?php echo htmlspecialchars($error['message']); ?>
                </p>
                <div class="error-actions">
                    <a href="login.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Voltar para o Dashboard
                    </a>
                    <button onclick="history.back()" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    padding: 40px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.error-code {
    font-size: 72px;
    font-weight: 700;
    color: #dc3545;
}

.error-title {
    font-size: 24px;
    color: #343a40;
}

.error-message {
    color: #6c757d;
    font-size: 16px;
}

.error-actions {
    margin-top: 30px;
}
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 