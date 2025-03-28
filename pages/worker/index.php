<?php
// Error reporting em produção deve ser ajustado
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir constantes do sistema
define('BASE_PATH', dirname(__DIR__, 2));
define('IS_PRODUCTION', false); // Mudar para true em produção

// Verificar se o sistema está configurado corretamente
$includesPath = dirname(__DIR__, 2) . '/includes';
if (!file_exists($includesPath . '/auth.php')) {
    die('Erro crítico: Arquivos do sistema não encontrados');
}

$pageTitle = 'Dashboard';

// Iniciar captura do conteúdo
ob_start();

// Initialize user data
$user = array(
    'name' => 'João da Silva',
    'position' => 'Motorista',
    'department' => 'Operações',
    'avatar' => 'JS'
);

// Mock data for dashboard
$courseProgress = array(
    'completed' => 3,
    'total' => 5,
    'percentage' => 60
);

$pendingItems = array(
    'documents' => 2,
    'trainings' => 1
);
?>

<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-4">
        <div class="row align-items-center g-3">
            <div class="col-auto">
                <div class="welcome-avatar">
                    <span class="avatar-initials"><?php echo $user['avatar']; ?></span>
                </div>
            </div>
            <div class="col">
                <h1 class="h3 mb-1">Bem-vindo, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p class="text-muted mb-0"><?php echo htmlspecialchars($user['position']); ?> - <?php echo htmlspecialchars($user['department']); ?></p>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="row g-3 mb-4">
        <!-- Course Progress -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Progresso nos Cursos</h6>
                        </div>
                    </div>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $courseProgress['percentage']; ?>%"></div>
                    </div>
                    <p class="mb-0"><?php echo $courseProgress['completed']; ?> de <?php echo $courseProgress['total']; ?> cursos concluídos</p>
                </div>
            </div>
        </div>

        <!-- Pending Items -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Pendências</h6>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-file-alt text-muted me-2"></i>
                            <?php echo $pendingItems['documents']; ?> documentos pendentes
                        </li>
                        <li>
                            <i class="fas fa-chalkboard-teacher text-muted me-2"></i>
                            <?php echo $pendingItems['trainings']; ?> treinamentos obrigatórios
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bolt fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Acesso Rápido</h6>
                        </div>
                    </div>
                    <div class="quick-access-grid">
                        <a href="cursos.php" class="quick-access-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Meus Cursos</span>
                        </a>
                        <a href="recursos.php" class="quick-access-item">
                            <i class="fas fa-book"></i>
                            <span>Recursos</span>
                        </a>
                        <a href="solicitacoes.php" class="quick-access-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Solicitações</span>
                        </a>
                        <a href="perfil.php" class="quick-access-item">
                            <i class="fas fa-user"></i>
                            <span>Meu Perfil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Notifications -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Notificações Recentes</h5>
        </div>
        <div class="card-body">
            <div class="notification-list">
                <div class="notification-item">
                    <div class="notification-icon bg-primary">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="notification-content">
                        <h6>Novo curso disponível</h6>
                        <p>O curso "Direção Defensiva 2024" já está disponível para você.</p>
                        <small class="text-muted">Há 2 horas</small>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="notification-content">
                        <h6>Solicitação aprovada</h6>
                        <p>Sua solicitação de férias foi aprovada.</p>
                        <small class="text-muted">Há 1 dia</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Events -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Próximos Eventos</h5>
        </div>
        <div class="card-body">
            <div class="event-list">
                <div class="event-item">
                    <div class="event-date">
                        <span class="event-day">25</span>
                        <span class="event-month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h6>Treinamento de Segurança</h6>
                        <p>09:00 - 11:00 | Sala de Treinamento</p>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-date">
                        <span class="event-day">30</span>
                        <span class="event-month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h6>Reunião de Equipe</h6>
                        <p>14:00 - 15:00 | Sala de Reuniões</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-avatar {
    width: 80px;
    height: 80px;
    background: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-initials {
    font-size: 2rem;
    font-weight: 600;
    color: #495057;
}

.quick-access-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.quick-access-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #495057;
    transition: all 0.2s;
}

.quick-access-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.quick-access-item i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: #0d6efd;
}

.notification-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notification-item {
    display: flex;
    gap: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.notification-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.notification-content {
    flex: 1;
}

.notification-content h6 {
    margin: 0 0 0.25rem 0;
}

.notification-content p {
    margin: 0 0 0.25rem 0;
}

.event-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.event-item {
    display: flex;
    gap: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.event-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.event-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 60px;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.event-day {
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1;
}

.event-month {
    font-size: 0.875rem;
    color: #6c757d;
}

.event-content {
    flex: 1;
}

.event-content h6 {
    margin: 0 0 0.25rem 0;
}

.event-content p {
    margin: 0;
    color: #6c757d;
}
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 