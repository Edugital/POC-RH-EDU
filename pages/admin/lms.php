<?php
// Inicia a sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define o charset correto
header('Content-Type: text/html; charset=utf-8');

// Limpa qualquer output existente
if (ob_get_length()) ob_clean();

// Inclui as funções de administração
require_once 'admin-functions.php';
$adminFunctions = new LMSAdminFunctions();

// Define o path base para os assets
$currentPath = dirname($_SERVER['PHP_SELF']);
$isInSubfolder = strpos($currentPath, '/pages') !== false;
$basePath = $isInSubfolder ? '../' : '';

// Verifica se é administrador
$isAdmin = false;
if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
    $isAdmin = $_SESSION['user']['role'] === 'admin';
}

// Se for admin, redireciona ANTES de qualquer output
if ($isAdmin === true) {
    $redirectPath = htmlspecialchars(dirname($_SERVER['PHP_SELF']) . '/relatorios.php?view=education', ENT_QUOTES, 'UTF-8');
    header('Location: ' . $redirectPath);
    exit();
}

// Anti CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Inicia o buffer para o template
ob_start();

// Busca os dados educacionais usando as funções de administração
$educationMetrics = $adminFunctions->getEducationMetrics();

// Obtém o esquema de cores
$colors = $adminFunctions->getColorScheme();

// Adiciona o data attribute ao body
$bodyDataAttributes = 'data-is-admin="' . ($isAdmin ? 'true' : 'false') . '"';
?>

<!-- Conteúdo Principal -->
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header education-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="mb-0">
                        <i class="fas fa-graduation-cap"></i>
                        Gestão de Educação Corporativa
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <section class="content">
        <div class="container-fluid">
            <!-- Painel de Ações Administrativas -->
            <div class="admin-toolbar">
                <div>
                    <button type="button" class="btn btn-success" onclick="window.location.href='relatorios.php?view=education&action=new'">
                        <i class="fas fa-plus"></i> Novo Curso
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='relatorios.php?view=education&action=learningpath'">
                        <i class="fas fa-road"></i> Nova Trilha
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='relatorios.php?view=education&action=users'">
                        <i class="fas fa-users"></i> Gerenciar Usuários
                    </button>
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='relatorios.php?view=education&action=reports'">
                        <i class="fas fa-chart-bar"></i> Relatórios
                    </button>
                </div>
                <button type="button" class="btn btn-primary" id="refreshLMS">
                    <i class="fas fa-sync-alt"></i> Atualizar
                </button>
            </div>

            <!-- Cards de Métricas -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="metric-card bg-info" onclick="window.location.href='relatorios.php?view=education&metric=enrollments'">
                        <div class="inner">
                            <h3><?php echo $educationMetrics['overview']['totalEnrollments']; ?></h3>
                            <p>Matrículas Totais</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="metric-card bg-success" onclick="window.location.href='relatorios.php?view=education&metric=active'">
                        <div class="inner">
                            <h3><?php echo $educationMetrics['overview']['activeUsers']; ?></h3>
                            <p>Usuários Ativos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="metric-card bg-warning" onclick="window.location.href='relatorios.php?view=education&metric=completion'">
                        <div class="inner">
                            <h3><?php echo $educationMetrics['overview']['completionRate']; ?>%</h3>
                            <p>Taxa de Conclusão</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="metric-card bg-danger" onclick="window.location.href='relatorios.php?view=education&metric=progress'">
                        <div class="inner">
                            <h3><?php echo $educationMetrics['overview']['averageProgress']; ?>%</h3>
                            <p>Progresso Médio</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trilhas de Aprendizagem -->
            <div class="row mt-4">
                <?php foreach ($educationMetrics['learningPaths'] as $path): ?>
                <div class="col-md-6">
                    <div class="learning-path-card">
                        <div class="learning-path-header">
                            <h4><?php echo htmlspecialchars($path['title']); ?></h4>
                            <p class="mb-0"><?php echo htmlspecialchars($path['description']); ?></p>
                        </div>
                        <div class="learning-path-body">
                            <div class="progress mb-2">
                                <div class="progress-bar bg-primary" style="width: <?php echo $path['progress']; ?>%"></div>
                            </div>
                            <p class="mb-0"><?php echo $path['progress']; ?>% concluído</p>
                        </div>
                        <div class="learning-path-footer d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary"><?php echo $path['courseCount']; ?> cursos</span>
                            <button type="button" class="btn btn-primary" 
                                   onclick="window.location.href='relatorios.php?view=education&learningPath=<?php echo $path['id']; ?>'">
                                Ver Detalhes
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Cursos -->
            <div class="row mt-4">
                <?php foreach ($educationMetrics['courses'] as $course): ?>
                <div class="col-md-4">
                    <div class="course-card <?php echo $course['type'] === 'Obrigatório' ? 'mandatory' : 'optional'; ?> <?php echo $course['status'] === 'Concluído' ? 'completed' : ''; ?> mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="badge <?php echo $course['type'] === 'Obrigatório' ? 'bg-warning' : 'bg-info'; ?>">
                                <?php echo htmlspecialchars($course['type']); ?>
                            </span>
                            <span class="badge <?php echo $course['status'] === 'Ativo' ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo htmlspecialchars($course['status']); ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p><?php echo htmlspecialchars($course['description']); ?></p>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-users"></i> <?php echo $course['enrollments']; ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo $course['duration']; ?></span>
                            </div>
                            <div class="progress mt-3 mb-1">
                                <div class="progress-bar bg-primary" style="width: <?php echo $course['completionRate']; ?>%"></div>
                            </div>
                            <small><?php echo $course['completionRate']; ?>% concluído</small>
                        </div>
                        <div class="card-footer">
                            <?php if ($course['status'] === 'Ativo'): ?>
                                <div class="btn-group w-100">
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='relatorios.php?view=education&course=<?php echo $course['id']; ?>'">
                                        <i class="fas fa-chart-bar"></i> Relatório
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="lmsHandler.bulkEnrollUsers(<?php echo $course['id']; ?>)">
                                        <i class="fas fa-user-plus"></i> Matrículas
                                    </button>
                                </div>
                            <?php elseif ($course['status'] === 'Concluído'): ?>
                                <button type="button" class="btn btn-outline-success w-100" onclick="showCertificate('<?php echo htmlspecialchars($course['title']); ?>')">
                                    <i class="fas fa-award"></i> Certificados
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div class="d-flex align-items-center w-100">
                    <span class="me-2"><strong>Ações em massa:</strong></span>
                    <select class="form-select me-2">
                        <option selected value="">Selecione</option>
                        <option value="enrollUsers">Matricular usuários</option>
                        <option value="exportReport">Exportar relatório</option>
                        <option value="sendNotifications">Enviar notificações</option>
                        <option value="archiveCourses">Arquivar cursos</option>
                    </select>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-check"></i> Aplicar
                    </button>
                </div>
            </div>

            <!-- Tabela de Cursos -->
            <div class="card courses-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book me-2"></i>
                        Visão Geral dos Cursos
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-details" onclick="window.location.href='relatorios.php?view=education'">
                            Ver Relatório Completo
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap courses-table">
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Tipo</th>
                                <th>Matrículas</th>
                                <th>Conclusão</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($educationMetrics['courses'] as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['title']); ?></td>
                                <td>
                                    <span class="badge <?php echo $course['type'] === 'Obrigatório' ? 'bg-warning' : 'bg-info'; ?>">
                                        <?php echo htmlspecialchars($course['type']); ?>
                                    </span>
                                </td>
                                <td><?php echo $course['enrollments']; ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: <?php echo $course['completionRate']; ?>%"></div>
                                    </div>
                                    <small><?php echo $course['completionRate']; ?>%</small>
                                </td>
                                <td>
                                    <span class="badge <?php echo $course['status'] === 'Ativo' ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo htmlspecialchars($course['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-details" 
                                            onclick="window.location.href='relatorios.php?view=education&course=<?php echo $course['id']; ?>'">
                                        Ver Detalhes
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal de Erro -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Erro
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Certificado -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="certificateModalLabel">Certificado de Conclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h2 class="mb-4">Certificado de Conclusão</h2>
                <p class="mb-3">Este certificado confirma que</p>
                <h3 class="course-title mb-3"></h3>
                <p class="mb-4">foi concluído com sucesso em <span class="completion-date"></span></p>
                <div class="certificate-footer">
                    <img src="../assets/img/logo.svg" alt="VixPar Logo" class="certificate-logo mb-3">
                    <div class="row justify-content-center mt-3">
                        <div class="col-6">
                            <hr class="signature-line">
                            <p class="mb-0">Diretor de Educação</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary download-certificate">
                    <i class="fas fa-download"></i> Baixar Certificado
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container para notificações -->
<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

<!-- Scripts específicos da página -->
<script nonce="<?php echo $_SESSION['csrf_token']; ?>">
document.addEventListener('DOMContentLoaded', function() {
    // Estado inicial da página
    const initialState = <?php echo json_encode($educationMetrics); ?>;
    const colorScheme = <?php echo json_encode($colors); ?>;
    
    // Função para renderizar o conteúdo inicial
    function renderInitialContent() {
        if (!window.lmsHandler) {
            // Usa o estado inicial se o handler não estiver disponível
            return;
        }
        
        try {
            window.lmsHandler.init();
        } catch (error) {
            console.error('Erro ao inicializar conteúdo dinâmico:', error);
            showError('Alguns recursos podem estar indisponíveis. O sistema está funcionando em modo limitado.');
        }
    }

    // Função para exibir erros
    function showError(message) {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.textContent = message;
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    }
    
    // Função para mostrar o certificado
    window.showCertificate = function(courseTitle) {
        document.querySelector('#certificateModal .course-title').textContent = courseTitle;
        document.querySelector('#certificateModal .completion-date').textContent = new Date().toLocaleDateString('pt-BR');
        const certificateModal = new bootstrap.Modal(document.getElementById('certificateModal'));
        certificateModal.show();
    };

    // Inicializa tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Configura o botão de atualização
    document.getElementById('refreshLMS').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Atualizando...';
        
        try {
            if (window.lmsHandler && typeof window.lmsHandler.refreshData === 'function') {
                window.lmsHandler.refreshData()
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-sync-alt"></i> Atualizar';
                    });
            } else {
                throw new Error('Handler de atualização não encontrado');
            }
        } catch (error) {
            console.error('Erro ao atualizar LMS:', error);
            showError('Erro ao atualizar os dados. Por favor, tente novamente.');
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-sync-alt"></i> Atualizar';
        }
    });

    // Inicializa a página
    renderInitialContent();
});
</script>

<!-- Link para os CSS -->
<link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/mobile.css">
<link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/education-admin.css">
<link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/education-admin-optimized.css">

<!-- Scripts específicos da página -->
<script src="<?php echo $basePath; ?>assets/js/lms.js"></script>

<?php
$content = ob_get_clean();

// Inclui o template depois de gerar o conteúdo
$pageTitle = 'Gestão de Educação Corporativa';
require_once 'template.php';

// Log de erros críticos
if (error_get_last()) {
    error_log(print_r(error_get_last(), true), 3, __DIR__ . '/../logs/error.log');
}
?> 