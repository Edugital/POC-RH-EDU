<?php
session_start();

// Verificação de segurança - verifica se o usuário está logado como admin
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ../login.php?redirect=admin/configuracoes");
    exit;
}

// Verificação explícita de permissão de admin - garantindo que admins tenham acesso
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
    header("Location: ../error.php?code=403&message=Acesso restrito a administradores");
    exit;
}

// Configurações de cabeçalho para segurança
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Base path e página atual
$basePath = '../';
$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = 'Configurações';

// Processamento de formulários
$successMsg = $errorMsg = '';

// Processar atualização de perfil
if (isset($_POST['update_profile'])) {
    // Validação básica
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    
    if (empty($nome) || empty($email)) {
        $errorMsg = "Nome e email são obrigatórios";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = "Email inválido";
    } else {
        // Aqui seria a lógica para atualizar no banco de dados
        // Simulando atualização para POC
        $_SESSION['user_name'] = $nome;
        $_SESSION['user_email'] = $email;
        
        if (!empty($senha)) {
            // Simulando atualização de senha
            // Em produção: $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        }
        
        $successMsg = "Perfil atualizado com sucesso!";
    }
}

// Processar preferências de notificação
if (isset($_POST['update_notifications'])) {
    $emailNotif = isset($_POST['email_notif']) ? 1 : 0;
    $browserNotif = isset($_POST['browser_notif']) ? 1 : 0;
    
    // Aqui seria a lógica para atualizar no banco de dados
    // Simulando atualização para POC
    $_SESSION['notif_email'] = $emailNotif;
    $_SESSION['notif_browser'] = $browserNotif;
    
    $successMsg = "Preferências de notificação atualizadas!";
}

// Processar configurações do sistema
if (isset($_POST['update_system'])) {
    $timezone = filter_input(INPUT_POST, 'timezone', FILTER_SANITIZE_SPECIAL_CHARS);
    $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Aqui seria a lógica para atualizar no banco de dados
    // Simulando atualização para POC
    $_SESSION['timezone'] = $timezone;
    $_SESSION['language'] = $language;
    
    $successMsg = "Configurações do sistema atualizadas!";
}

// Dados do usuário (em produção, viriam do banco de dados)
$userData = [
    'nome' => $_SESSION['user_name'] ?? 'Administrador Vixpar',
    'email' => $_SESSION['user_email'] ?? 'admin@vixpar.com',
    'emailNotif' => $_SESSION['notif_email'] ?? 1,
    'browserNotif' => $_SESSION['notif_browser'] ?? 1,
    'timezone' => $_SESSION['timezone'] ?? 'America/Sao_Paulo',
    'language' => $_SESSION['language'] ?? 'pt_BR'
];

// Define a seção ativa (padrão: perfil)
$activeSection = isset($_GET['section']) ? $_GET['section'] : 'perfil';

ob_start();
?>

<div class="settings-container">
    <?php if(!empty($successMsg)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle" aria-hidden="true"></i>
        <span><?php echo $successMsg; ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
            <span class="sr-only">Fechar</span>
        </button>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($errorMsg)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
        <span><?php echo $errorMsg; ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar">
            <span class="sr-only">Fechar</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="settings-layout">
        <nav class="settings-nav" aria-label="Navegação das configurações">
            <ul class="nav-list" role="tablist">
                <li class="nav-header" role="presentation">Configurações Pessoais</li>
                <li class="nav-item <?php echo $activeSection == 'perfil' ? 'active' : ''; ?>" role="presentation">
                    <a href="?section=perfil" role="tab" aria-selected="<?php echo $activeSection == 'perfil' ? 'true' : 'false'; ?>" aria-controls="perfil">
                        <i class="fas fa-user-cog" aria-hidden="true"></i>
                        <span>Perfil de Acesso</span>
                    </a>
                </li>
                <li class="nav-item <?php echo $activeSection == 'notificacoes' ? 'active' : ''; ?>" role="presentation">
                    <a href="?section=notificacoes" role="tab" aria-selected="<?php echo $activeSection == 'notificacoes' ? 'true' : 'false'; ?>" aria-controls="notificacoes">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        <span>Notificações</span>
                    </a>
                </li>
                
                <li class="nav-header" role="presentation">Sistema</li>
                <li class="nav-item <?php echo $activeSection == 'sistema' ? 'active' : ''; ?>" role="presentation">
                    <a href="?section=sistema" role="tab" aria-selected="<?php echo $activeSection == 'sistema' ? 'true' : 'false'; ?>" aria-controls="sistema">
                        <i class="fas fa-cogs" aria-hidden="true"></i>
                        <span>Configurações do Sistema</span>
                    </a>
                </li>
                <li class="nav-item <?php echo $activeSection == 'info' ? 'active' : ''; ?>" role="presentation">
                    <a href="?section=info" role="tab" aria-selected="<?php echo $activeSection == 'info' ? 'true' : 'false'; ?>" aria-controls="info">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <span>Informações do Sistema</span>
                    </a>
                </li>
                
                <li class="nav-header" role="presentation">Suporte</li>
                <li class="nav-item <?php echo $activeSection == 'ajuda' ? 'active' : ''; ?>" role="presentation">
                    <a href="?section=ajuda" role="tab" aria-selected="<?php echo $activeSection == 'ajuda' ? 'true' : 'false'; ?>" aria-controls="ajuda">
                        <i class="fas fa-question-circle" aria-hidden="true"></i>
                        <span>Ajuda e Suporte</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <main class="settings-content">
            <?php if($activeSection == 'perfil'): ?>
                <section class="settings-section" id="perfil" role="tabpanel" aria-labelledby="tab-perfil">
                    <div class="section-header">
                        <h1><i class="fas fa-user-cog" aria-hidden="true"></i> Perfil de Acesso</h1>
                        <p>Gerencie suas informações pessoais e credenciais de acesso</p>
                    </div>
                    
                    <div class="section-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?section=perfil" class="settings-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($userData['nome']); ?>" 
                                               class="form-control" required aria-required="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" 
                                               class="form-control" required aria-required="true">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="senha" class="form-label">
                                    Senha
                                    <span class="text-muted">(deixe em branco para manter a atual)</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" id="senha" name="senha" class="form-control" 
                                           aria-label="Senha" placeholder="Nova senha">
                                    <button class="btn btn-outline-secondary toggle-password" type="button" 
                                            aria-label="Mostrar/Ocultar senha">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" name="update_profile" class="btn btn-primary">
                                    <i class="fas fa-save" aria-hidden="true"></i>
                                    <span>Salvar Alterações</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            
            <?php elseif($activeSection == 'notificacoes'): ?>
                <section class="settings-section" id="notificacoes">
                    <div class="section-header">
                        <h2><i class="fas fa-bell"></i> Notificações</h2>
                        <p class="text-muted">Gerencie como você deseja receber atualizações do sistema</p>
                    </div>
                    
                    <div class="section-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?section=notificacoes" class="settings-form">
                            <div class="notification-settings">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h4 class="settings-subtitle">Canais de Notificação</h4>
                                    </div>
                                </div>
                                
                                <div class="notification-option">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1"><i class="fas fa-envelope me-2"></i> E-mail</h5>
                                            <p class="mb-0 text-muted">Receba notificações via email</p>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="email_notif" id="email_notif" <?php echo $userData['emailNotif'] ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="notification-option">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1"><i class="fas fa-desktop me-2"></i> Navegador</h5>
                                            <p class="mb-0 text-muted">Receba notificações no navegador</p>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="browser_notif" id="browser_notif" <?php echo $userData['browserNotif'] ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" name="update_notifications" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar Preferências
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                
            <?php elseif($activeSection == 'sistema'): ?>
                <section class="settings-section" id="sistema">
                    <div class="section-header">
                        <h2><i class="fas fa-cogs"></i> Configurações do Sistema</h2>
                        <p class="text-muted">Ajuste as configurações regionais e preferências do sistema</p>
                    </div>
                    
                    <div class="section-body">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?section=sistema" class="settings-form">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="timezone" class="form-label">Fuso Horário</label>
                                        <select class="form-select" id="timezone" name="timezone">
                                            <option value="America/Sao_Paulo" <?php echo $userData['timezone'] == 'America/Sao_Paulo' ? 'selected' : ''; ?>>Brasília (GMT-3)</option>
                                            <option value="America/Manaus" <?php echo $userData['timezone'] == 'America/Manaus' ? 'selected' : ''; ?>>Manaus (GMT-4)</option>
                                            <option value="America/Belem" <?php echo $userData['timezone'] == 'America/Belem' ? 'selected' : ''; ?>>Belém (GMT-3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="language" class="form-label">Idioma</label>
                                        <select class="form-select" id="language" name="language">
                                            <option value="pt_BR" <?php echo $userData['language'] == 'pt_BR' ? 'selected' : ''; ?>>Português (Brasil)</option>
                                            <option value="en_US" <?php echo $userData['language'] == 'en_US' ? 'selected' : ''; ?>>English (US)</option>
                                            <option value="es_ES" <?php echo $userData['language'] == 'es_ES' ? 'selected' : ''; ?>>Español</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" name="update_system" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar Configurações
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
                
            <?php elseif($activeSection == 'info'): ?>
                <section class="settings-section" id="info">
                    <div class="section-header">
                        <h2><i class="fas fa-info-circle"></i> Informações do Sistema</h2>
                        <p class="text-muted">Detalhes sobre a versão e licença do sistema</p>
                    </div>
                    
                    <div class="section-body">
                        <div class="system-info-card">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Versão</div>
                                        <div class="info-value">1.0.2</div>
                                    </div>
                                    
                                    <div class="info-group">
                                        <div class="info-label">Última Atualização</div>
                                        <div class="info-value"><?php echo date('d/m/Y'); ?></div>
                                    </div>
                                    
                                    <div class="info-group">
                                        <div class="info-label">Licença</div>
                                        <div class="info-value">Vixpar Enterprise</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="info-group">
                                        <div class="info-label">Servidor</div>
                                        <div class="info-value"><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Apache'); ?></div>
                                    </div>
                                    
                                    <div class="info-group">
                                        <div class="info-label">PHP</div>
                                        <div class="info-value"><?php echo htmlspecialchars(PHP_VERSION); ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-sync-alt me-2"></i> Verificar Atualizações
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                
            <?php elseif($activeSection == 'ajuda'): ?>
                <section class="settings-section" id="ajuda">
                    <div class="section-header">
                        <h2><i class="fas fa-question-circle"></i> Ajuda e Suporte</h2>
                        <p class="text-muted">Acesse recursos de ajuda ou entre em contato com o suporte</p>
                    </div>
                    
                    <div class="section-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="support-card">
                                    <div class="support-icon">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <div class="support-content">
                                        <h3>Recursos de Ajuda</h3>
                                        <p>Acesse recursos de ajuda ou entre em contato com o suporte</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </main>
    </div>
</div>

<!-- Modal de Suporte Otimizado -->
<div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportModalLabel">
                    <i class="fas fa-headset" aria-hidden="true"></i>
                    <span>Contato com Suporte</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="supportForm">
                    <div class="form-group">
                        <label for="supportSubject" class="form-label">Assunto</label>
                        <select class="form-select" id="supportSubject" required>
                            <option value="">Selecione uma opção</option>
                            <option value="bug">Reportar um Bug</option>
                            <option value="feature">Solicitar Recurso</option>
                            <option value="question">Dúvida Técnica</option>
                            <option value="other">Outro</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione um assunto.</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="supportMessage" class="form-label">Mensagem</label>
                        <textarea class="form-control" id="supportMessage" rows="4" required 
                                  placeholder="Descreva sua questão ou problema em detalhes..."></textarea>
                        <div class="invalid-feedback">Por favor, escreva uma mensagem.</div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="supportAttachment" class="form-label">
                            Anexar Arquivo <span class="text-muted">(opcional)</span>
                        </label>
                        <input class="form-control" type="file" id="supportAttachment">
                        <div class="form-text">Formatos suportados: PDF, PNG, JPG (max. 5MB)</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times" aria-hidden="true"></i>
                    <span>Cancelar</span>
                </button>
                <button type="button" class="btn btn-primary" id="sendSupportBtn">
                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                    <span>Enviar Mensagem</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    /* Paleta de cores profissional e harmônica */
    --navy-50: #f0f4fa;
    --navy-100: #d9e2f5;
    --navy-200: #b3c5eb;
    --navy-300: #8da9e0;
    --navy-400: #668cd6;
    --navy-500: #4070cc;
    --navy-600: #3358a3;
    --navy-700: #26417a;
    --navy-800: #1a2b52;
    --navy-900: #0d1529;
    
    /* Cores neutras refinadas */
    --neutral-50: #f9fafb;
    --neutral-100: #f2f4f7;
    --neutral-200: #e4e7ec;
    --neutral-300: #d0d5dd;
    --neutral-400: #9aa2b1;
    --neutral-500: #697586;
    --neutral-600: #4b5565;
    --neutral-700: #364152;
    --neutral-800: #202939;
    --neutral-900: #121926;
    
    /* Cores de status */
    --success: #10b981;
    --error: #ef4444;
    --warning: #f59e0b;
    --info: #0ea5e9;
    
    /* Tipografia otimizada */
    --font-sans: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    --font-size-xs: 0.75rem;
    --font-size-sm: 0.875rem;
    --font-size-base: 1rem;
    --font-size-lg: 1.125rem;
    --font-size-xl: 1.25rem;
    --font-size-2xl: 1.5rem;
    
    /* Espaçamentos densos e eficientes */
    --space-1: 0.25rem;
    --space-2: 0.5rem;
    --space-3: 0.75rem;
    --space-4: 1rem;
    --space-6: 1.5rem;
    --space-8: 2rem;
    --space-12: 3rem;
    
    /* Bordas e sombras refinadas */
    --radius-sm: 0.25rem;
    --radius-md: 0.375rem;
    --radius-lg: 0.5rem;
    --shadow-sm: 0 1px 2px rgba(16, 24, 40, 0.04);
    --shadow-md: 0 2px 4px rgba(16, 24, 40, 0.06);
    --shadow-lg: 0 4px 8px rgba(16, 24, 40, 0.1);
    
    /* Transições suaves */
    --transition-fast: 150ms cubic-bezier(0.16, 1, 0.3, 1);
    --transition-normal: 250ms cubic-bezier(0.16, 1, 0.3, 1);
}

/* Reset global para elementos de formulário */
button, input, select, textarea {
    font-family: var(--font-sans);
    font-size: var(--font-size-base);
    line-height: 1.5;
    margin: 0;
}

/* Layout Base Otimizado */
.settings-container {
    width: 100%;
    max-width: 100%;
    height: 100vh;
    margin: 0;
    padding: 0;
    font-family: var(--font-sans);
    color: var(--neutral-800);
    background-color: var(--neutral-100);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.settings-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: var(--space-6);
    flex: 1;
    overflow: hidden;
    height: calc(100vh - 60px);
}

/* Navegação lateral eficiente */
.settings-nav {
    background-color: white;
    border-radius: 0;
    box-shadow: var(--shadow-md);
    overflow: auto;
    border-right: 1px solid var(--neutral-200);
    border-top: none;
    border-bottom: none;
    border-left: none;
    position: sticky;
    top: 0;
    height: 100%;
    padding: var(--space-4) 0;
}

.nav-list {
    list-style: none;
    margin: 0;
    padding: var(--space-2);
}

.nav-header {
    color: var(--neutral-600);
    font-size: var(--font-size-xs);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: var(--space-4) var(--space-4) var(--space-2);
    margin-top: var(--space-2);
}

.nav-item {
    margin-bottom: var(--space-1);
}

.nav-item a {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    color: var(--neutral-700);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: var(--transition-fast);
    font-size: var(--font-size-sm);
}

.nav-item a:hover {
    background-color: var(--neutral-100);
    color: var(--navy-600);
}

.nav-item.active a {
    background-color: var(--navy-50);
    color: var(--navy-700);
    font-weight: 600;
}

.nav-item i {
    width: 16px;
    text-align: center;
    font-size: var(--font-size-base);
    color: var(--neutral-500);
}

.nav-item.active i {
    color: var(--navy-600);
}

/* Conteúdo principal otimizado */
.settings-content {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
    overflow: auto;
    padding: var(--space-6);
}

.settings-section {
    background-color: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
    border: 1px solid var(--neutral-200);
}

.section-header {
    padding: var(--space-4) var(--space-6);
    background: var(--navy-700);
    background: linear-gradient(to right, var(--navy-700), var(--navy-600));
    color: white;
    border-bottom: 1px solid var(--navy-800);
}

.section-header h1,
.section-header h2 {
    margin: 0;
    font-size: var(--font-size-xl);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-3);
    line-height: 1.4;
}

.section-header p {
    margin: var(--space-2) 0 0;
    opacity: 0.85;
    font-size: var(--font-size-sm);
}

.section-body {
    padding: var(--space-6);
}

/* Formulários densos e eficientes */
.settings-form {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.form-group {
    margin-bottom: var(--space-4);
}

.form-label {
    display: block;
    margin-bottom: var(--space-2);
    color: var(--neutral-800);
    font-weight: 500;
    font-size: var(--font-size-sm);
}

.text-muted {
    color: var(--neutral-500);
    font-weight: normal;
    font-size: var(--font-size-xs);
}

.form-control {
    width: 100%;
    padding: var(--space-2) var(--space-3);
    border: 1px solid var(--neutral-300);
    border-radius: var(--radius-md);
    background-color: white;
    transition: var(--transition-fast);
    height: 38px;
    font-size: var(--font-size-sm);
}

.form-control:hover {
    border-color: var(--neutral-400);
}

.form-control:focus {
    border-color: var(--navy-400);
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 140, 214, 0.15);
}

.form-select {
    width: 100%;
    padding: var(--space-2) var(--space-3);
    border: 1px solid var(--neutral-300);
    border-radius: var(--radius-md);
    background-color: white;
    transition: var(--transition-fast);
    height: 38px;
    font-size: var(--font-size-sm);
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right var(--space-3) center;
    background-size: 16px;
    padding-right: var(--space-8);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.form-select:hover {
    border-color: var(--neutral-400);
}

.form-select:focus {
    border-color: var(--navy-400);
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 140, 214, 0.15);
}

.input-group {
    display: flex;
    position: relative;
}

.input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: none;
    flex: 1;
}

.input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Botões otimizados */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-4);
    font-size: var(--font-size-sm);
    font-weight: 500;
    border-radius: var(--radius-md);
    transition: var(--transition-fast);
    border: 1px solid transparent;
    cursor: pointer;
    height: 38px;
    white-space: nowrap;
}

.btn-primary {
    background-color: var(--navy-600);
    color: white;
    border-color: var(--navy-700);
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
}

.btn-primary:hover {
    background-color: var(--navy-700);
    border-color: var(--navy-800);
}

.btn-primary:active {
    background-color: var(--navy-800);
}

.btn-outline-secondary {
    background-color: white;
    color: var(--neutral-700);
    border-color: var(--neutral-300);
    box-shadow: 0 1px 2px rgba(16, 24, 40, 0.05);
}

.btn-outline-secondary:hover {
    background-color: var(--neutral-100);
    border-color: var(--neutral-400);
}

.btn-outline-primary {
    background-color: white;
    color: var(--navy-600);
    border-color: var(--navy-600);
}

.btn-outline-primary:hover {
    background-color: var(--navy-50);
    color: var(--navy-700);
}

.btn-close {
    background: transparent;
    border: none;
    padding: var(--space-1);
    color: currentColor;
    opacity: 0.7;
    transition: var(--transition-fast);
    cursor: pointer;
}

.btn-close:hover {
    opacity: 1;
}

/* Alertas redesenhados */
.alert {
    padding: var(--space-3) var(--space-4);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
    display: flex;
    align-items: center;
    gap: var(--space-3);
    font-size: var(--font-size-sm);
    position: relative;
}

.alert i {
    font-size: var(--font-size-lg);
}

.alert-success {
    background-color: rgba(16, 185, 129, 0.1);
    color: #065f46;
    border-left: 4px solid var(--success);
}

.alert-danger {
    background-color: rgba(239, 68, 68, 0.1);
    color: #991b1b;
    border-left: 4px solid var(--error);
}

.alert-dismissible {
    padding-right: var(--space-12);
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 50%;
    right: var(--space-3);
    transform: translateY(-50%);
}

/* Cards de informação */
.info-group {
    padding: var(--space-4);
    background-color: var(--neutral-50);
    border-radius: var(--radius-md);
    border: 1px solid var(--neutral-200);
    margin-bottom: var(--space-4);
}

.info-label {
    color: var(--neutral-600);
    font-size: var(--font-size-xs);
    font-weight: 500;
    margin-bottom: var(--space-1);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.info-value {
    color: var(--neutral-900);
    font-weight: 500;
    font-size: var(--font-size-sm);
}

/* Switches redesenhados */
.form-switch {
    display: inline-block;
    position: relative;
}

.form-check-input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 44px;
    height: 24px;
    border-radius: 12px;
    background-color: var(--neutral-300);
    position: relative;
    cursor: pointer;
    transition: var(--transition-normal);
    margin: 0;
}

.form-check-input[type="checkbox"]::before {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    top: 3px;
    left: 3px;
    background-color: white;
    transition: var(--transition-normal);
    box-shadow: var(--shadow-sm);
}

.form-check-input[type="checkbox"]:checked {
    background-color: var(--navy-600);
}

.form-check-input[type="checkbox"]:checked::before {
    left: 23px;
}

/* Customização Modais */
.modal-content {
    border-radius: var(--radius-lg);
    border: 1px solid var(--neutral-200);
    box-shadow: var(--shadow-lg), 0 24px 48px -12px rgba(16, 24, 40, 0.25);
    overflow: hidden;
}

.modal-header {
    padding: var(--space-4) var(--space-6);
    background: var(--navy-700);
    background: linear-gradient(to right, var(--navy-700), var(--navy-600));
    color: white;
    border: none;
}

.modal-body {
    padding: var(--space-6);
}

.modal-footer {
    padding: var(--space-4) var(--space-6);
    background-color: var(--neutral-50);
    border-top: 1px solid var(--neutral-200);
}

/* Correções para acessibilidade e densidade de informação */
.row {
    display: flex;
    flex-wrap: wrap;
    margin: -0.5rem;
}

.row > [class^="col-"] {
    padding: 0.5rem;
}

.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}

.g-4 {
    margin: -0.5rem;
}

.g-4 > [class^="col-"] {
    padding: 0.5rem;
}

.mt-2 {
    margin-top: var(--space-2);
}

.mt-3 {
    margin-top: var(--space-3);
}

.mt-4 {
    margin-top: var(--space-4);
}

.mb-0 {
    margin-bottom: 0;
}

.text-center {
    text-align: center;
}

.d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.align-items-center {
    align-items: center;
}

/* Notificações redesenhadas */
.notification-option {
    padding: var(--space-4);
    background-color: var(--neutral-50);
    border-radius: var(--radius-md);
    border: 1px solid var(--neutral-200);
    margin-bottom: var(--space-4);
}

.notification-option h5 {
    margin: 0 0 var(--space-1);
    font-size: var(--font-size-sm);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.notification-option p {
    margin: 0;
    font-size: var(--font-size-xs);
    color: var(--neutral-600);
}

/* Ajustes responsivos */
@media (max-width: 991px) {
    .settings-layout {
        grid-template-columns: 1fr;
    }
    
    .settings-nav {
        position: static;
        margin-bottom: var(--space-4);
    }
    
    .nav-list {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-2);
    }
    
    .nav-header {
        flex-basis: 100%;
    }
    
    .nav-item {
        margin-bottom: 0;
    }
    
    .nav-item a {
        white-space: nowrap;
    }
}

@media (max-width: 767px) {
    .settings-container {
        padding: var(--space-3);
    }
    
    .section-body {
        padding: var(--space-4);
    }
    
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .nav-list {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: var(--space-3);
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: var(--neutral-400) transparent;
    }
    
    .nav-list::-webkit-scrollbar {
        height: 6px;
    }
    
    .nav-list::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .nav-list::-webkit-scrollbar-thumb {
        background-color: var(--neutral-400);
        border-radius: 20px;
    }
}

/* Acessibilidade */
@media (prefers-reduced-motion: reduce) {
    * {
        transition-duration: 0.01ms !important;
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
    }
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

:focus-visible {
    outline: 2px solid var(--navy-500);
    outline-offset: 2px;
}

/* Otimização específica para este projeto */
.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: var(--space-6);
}

.settings-subtitle {
    font-size: var(--font-size-lg);
    font-weight: 600;
    margin: 0 0 var(--space-4);
    color: var(--neutral-800);
    padding-bottom: var(--space-2);
    border-bottom: 1px solid var(--neutral-200);
}

.system-info-card {
    display: flex;
    flex-direction: column;
    gap: var(--space-6);
}

.support-card {
    display: flex;
    align-items: flex-start;
    gap: var(--space-4);
    padding: var(--space-4);
    background-color: var(--neutral-50);
    border-radius: var(--radius-md);
    border: 1px solid var(--neutral-200);
}

.support-icon {
    width: 40px;
    height: 40px;
    background-color: var(--navy-50);
    color: var(--navy-600);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: var(--font-size-lg);
    flex-shrink: 0;
}

.support-content h3 {
    margin: 0 0 var(--space-1);
    font-size: var(--font-size-base);
    font-weight: 600;
    color: var(--neutral-800);
}

.support-content p {
    margin: 0;
    font-size: var(--font-size-sm);
    color: var(--neutral-600);
}

/* Cards clicáveis */
.config-card {
    background-color: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--neutral-200);
    padding: var(--space-6);
    transition: var(--transition-fast);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.config-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--navy-300);
}

.config-card::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(to right, var(--navy-500), var(--navy-700));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.config-card:hover::after {
    transform: scaleX(1);
}

.config-card-title {
    font-size: var(--font-size-lg);
    font-weight: 600;
    color: var(--navy-700);
    margin-bottom: var(--space-3);
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.config-card-title i {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--navy-50);
    color: var(--navy-600);
    border-radius: 50%;
    font-size: var(--font-size-xl);
}

.config-card-description {
    color: var(--neutral-600);
    font-size: var(--font-size-sm);
    margin-bottom: 0;
}

.config-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-6);
    width: 100%;
}

/* Modal Full-screen */
.modal-fullscreen {
    padding: 0 !important; 
}

.modal-fullscreen .modal-dialog {
    max-width: 100%;
    width: 100%;
    height: 100%;
    margin: 0;
}

.modal-fullscreen .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
}

.modal-fullscreen .modal-body {
    overflow-y: auto;
}

.modal-fullscreen .modal-header {
    border-radius: 0;
}

/* Header da página */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-4) var(--space-6);
    background: var(--navy-800);
    color: white;
}

.page-title {
    font-size: var(--font-size-xl);
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--space-3);
}

.page-actions {
    display: flex;
    gap: var(--space-3);
}

/* Overlay para carregamento */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(26, 43, 82, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.loading-overlay.active {
    opacity: 1;
    visibility: visible;
}

.loading-spinner {
    width: 48px;
    height: 48px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility - otimizado
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            const isVisible = input.type === 'text';
            
            // Toggle estado
            input.type = isVisible ? 'password' : 'text';
            
            // Atualizar ícone
            icon.classList.remove(isVisible ? 'fa-eye-slash' : 'fa-eye');
            icon.classList.add(isVisible ? 'fa-eye' : 'fa-eye-slash');
            
            // Feedback visual
            this.setAttribute('aria-label', isVisible ? 'Mostrar senha' : 'Ocultar senha');
            
            // Foco no campo após toggle
            input.focus();
        });
    });
    
    // Auto-dismiss alerts com animação suave
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out, height 0.3s ease-out 0.3s';
                alert.style.opacity = '0';
                alert.style.overflow = 'hidden';
                
                setTimeout(() => {
                    alert.style.height = '0';
                    alert.style.margin = '0';
                    alert.style.padding = '0';
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 500);
            }, 5000);
        });
    }
    
    // Demo do formulário de suporte com validação
    const supportBtn = document.getElementById('sendSupportBtn');
    const supportForm = document.getElementById('supportForm');
    
    if (supportBtn && supportForm) {
        supportBtn.addEventListener('click', function() {
            // Validação básica
            const subject = document.getElementById('supportSubject');
            const message = document.getElementById('supportMessage');
            let hasError = false;
            
            // Reset de estilos de erro
            subject.classList.remove('is-invalid');
            message.classList.remove('is-invalid');
            
            // Verificações
            if (!subject.value) {
                subject.classList.add('is-invalid');
                hasError = true;
            }
            
            if (!message.value) {
                message.classList.add('is-invalid');
                hasError = true;
            }
            
            if (hasError) {
                // Evitar envio se houver erros
                return;
            }
            
            // Feedback de envio
            supportBtn.disabled = true;
            supportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
            
            // Simulação de envio para POC (com delay para feedback)
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('supportModal'));
                modal.hide();
                
                // Reset form
                supportForm.reset();
                supportBtn.disabled = false;
                supportBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Mensagem';
                
                // Notificação de sucesso
                const container = document.querySelector('.settings-container');
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show';
                successAlert.innerHTML = `
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span>Sua mensagem foi enviada com sucesso! Um agente entrará em contato em breve.</span>
                    <button type="button" class="btn-close" aria-label="Fechar"></button>
                `;
                
                container.insertBefore(successAlert, container.firstChild);
                
                // Configurar botão de fechar
                const closeBtn = successAlert.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        successAlert.remove();
                    });
                }
                
                // Auto-dismiss
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease-out, height 0.3s ease-out 0.3s';
                    successAlert.style.opacity = '0';
                    successAlert.style.overflow = 'hidden';
                    
                    setTimeout(() => {
                        successAlert.style.height = '0';
                        successAlert.style.margin = '0';
                        successAlert.style.padding = '0';
                        
                        setTimeout(() => {
                            successAlert.remove();
                        }, 300);
                    }, 500);
                }, 5000);
            }, 1000);
        });
    }
    
    // Adicionar estilo para campos inválidos
    document.head.insertAdjacentHTML('beforeend', `
        <style>
        .is-invalid {
            border-color: var(--error) !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ef4444' width='24' height='24'%3E%3Cpath fill-rule='evenodd' d='M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-2V7h2v6h-2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            padding-right: calc(1.5em + 0.75rem) !important;
        }
        </style>
    `);
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 