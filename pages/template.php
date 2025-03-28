<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/includes/auth.php';

// Base path for assets and links
$basePath = '../';
$currentPage = basename($_SERVER['PHP_SELF']);

// Require authentication for all pages except login and error
if (!in_array($currentPage, ['login.php', 'error.php'])) {
    if (function_exists('requireAuth')) {
        requireAuth();
    }
}

// Get user data if available
$user = [];
if (function_exists('getCurrentUser')) {
    $user = getCurrentUser();
}
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
    
    <!-- Page Specific Styles -->
    <?php if (isset($styles)) echo $styles; ?>
</head>
<body <?php echo isset($bodyDataAttributes) ? $bodyDataAttributes : ''; ?>>
    <div class="app-container">
        <!-- Main Content -->
        <main class="main-content w-100">
            <div class="content">
                <?php if (isset($content)) echo $content; ?>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $basePath; ?>assets/js/main.js"></script>

    <!-- Page Specific Scripts -->
    <?php if (isset($scripts)) echo $scripts; ?>
</body>
</html> 