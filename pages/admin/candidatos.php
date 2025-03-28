<?php
$pageTitle = 'Banco de Talentos';

// Adiciona os estilos específicos da página
ob_start();
?>

<!-- Adiciona os estilos específicos da página no head -->
<style>
/* Reset e Variáveis */
:root {
    --primary: #1a237e;
    --primary-light: #534bae;
    --primary-dark: #000051;
    --success: #2e7d32;
    --warning: #f9a825;
    --info: #0288d1;
    --danger: #c62828;
    --gray-100: #f8f9fa;
    --gray-200: #e9ecef;
    --gray-300: #dee2e6;
    --gray-400: #ced4da;
    --gray-500: #adb5bd;
    --gray-600: #6c757d;
    --gray-700: #495057;
    --gray-800: #343a40;
    --gray-900: #212529;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
    --avatar-size: 48px;
    --avatar-size-sm: 32px;
}

/* Layout Principal */
.header {
    margin-bottom: var(--spacing-xl);
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid var(--gray-200);
}

.header-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: var(--spacing-md);
}

.header-actions {
    display: flex;
    gap: var(--spacing-sm);
}

.header-actions .btn {
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.header-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Pipeline */
.pipeline-container {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: 300px;
    gap: var(--spacing-md);
    overflow-x: auto;
    padding: var(--spacing-md);
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}

.pipeline-container::-webkit-scrollbar {
    height: 8px;
}

.pipeline-container::-webkit-scrollbar-track {
    background: var(--gray-200);
    border-radius: var(--radius-sm);
}

.pipeline-container::-webkit-scrollbar-thumb {
    background: var(--gray-400);
    border-radius: var(--radius-sm);
}

.pipeline-container::-webkit-scrollbar-thumb:hover {
    background: var(--gray-500);
}

.pipeline-column {
    background: var(--gray-100);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    scroll-snap-align: start;
    border: 1px solid var(--gray-200);
}

.pipeline-column:hover {
    box-shadow: var(--shadow-lg);
}

.pipeline-header {
    padding: var(--spacing-md);
    border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pipeline-header h6 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

.pipeline-header .badge {
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5em 1em;
}

.pipeline-candidates {
    padding: var(--spacing-md);
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

/* Cards */
.candidate-card {
    background: white;
    border-radius: var(--radius-md);
    padding: var(--spacing-md);
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    transition: all 0.2s ease;
    border: 1px solid var(--gray-200);
}

.candidate-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-light);
}

.candidate-avatar {
    position: relative;
    width: var(--avatar-size);
    height: var(--avatar-size);
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: calc(var(--avatar-size) * 0.4);
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.candidate-avatar.female {
    background: #e91e63;
}

.candidate-avatar.male {
    background: #1976d2;
}

.candidate-avatar.design {
    background: #9c27b0;
}

.candidate-avatar.product {
    background: #00796b;
}

.candidate-avatar img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.candidate-info {
    flex: 1;
    min-width: 0;
}

.candidate-info h6 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: var(--gray-900);
}

.candidate-info small {
    font-size: 0.875rem;
    color: var(--gray-600);
    display: block;
    margin-top: var(--spacing-xs);
}

.candidate-meta {
    display: flex;
    flex-wrap: wrap;
    gap: var(--spacing-xs);
    margin-top: var(--spacing-xs);
}

.candidate-meta .badge {
    font-size: 0.75rem;
    font-weight: 500;
    padding: 0.4em 0.8em;
    border-radius: var(--radius-sm);
}

.candidate-actions {
    display: flex;
    gap: var(--spacing-xs);
}

.candidate-actions .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    transition: all 0.2s ease;
}

.candidate-actions .btn:hover {
    transform: scale(1.1);
}

/* Status Badges */
.badge.bg-primary {
    background-color: var(--primary) !important;
}

.badge.bg-success {
    background-color: var(--success) !important;
}

.badge.bg-warning {
    background-color: var(--warning) !important;
    color: var(--gray-900) !important;
}

.badge.bg-info {
    background-color: var(--info) !important;
}

/* Job Cards */
.job-card {
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
}

/* Promotion Cards Styles */
.border-warning {
    border-color: var(--warning) !important;
    border-width: 2px;
}

.border-info {
    border-color: var(--info) !important;
    border-width: 2px;
}

.border-primary {
    border-color: var(--primary) !important;
    border-width: 2px;
}

.promotion-details .progress {
    background-color: var(--gray-200);
    border-radius: var(--radius-sm);
    overflow: hidden;
}

.promotion-details .progress-bar {
    transition: width 0.6s ease;
}

.candidate-avatar[style*="--avatar-size: 40px"] {
    font-size: 1rem;
    border-width: 2px;
}

.job-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.job-card .card-body {
    padding: var(--spacing-lg);
}

.job-meta {
    color: var(--gray-600);
}

.job-meta .d-flex {
    margin-bottom: var(--spacing-sm);
}

.job-meta i {
    width: 20px;
    color: var(--gray-500);
}

/* Filtros */
.filter-form {
    background: white;
    border-radius: var(--radius-lg);
    padding: var(--spacing-lg);
    box-shadow: var(--shadow-sm);
}

.filter-form .form-label {
    font-weight: 500;
    color: var(--gray-700);
}

.filter-form .form-control,
.filter-form .form-select {
    border-radius: var(--radius-md);
    border-color: var(--gray-300);
    padding: 0.625rem 1rem;
}

.filter-form .form-control:focus,
.filter-form .form-select:focus {
    border-color: var(--primary-light);
    box-shadow: 0 0 0 0.2rem rgba(26, 35, 126, 0.25);
}

/* Table */
.table-responsive {
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.table {
    margin-bottom: 0;
}

.table th {
    font-weight: 600;
    color: var(--gray-700);
    border-bottom-width: 1px;
    padding: var(--spacing-md) var(--spacing-md);
}

.table td {
    padding: var(--spacing-md) var(--spacing-md);
    vertical-align: middle;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: var(--gray-100);
}

/* Modais */
.modal-content {
    border-radius: var(--radius-lg);
    border: none;
    box-shadow: var(--shadow-lg);
}

.modal-header {
    border-bottom: 1px solid var(--gray-200);
    padding: var(--spacing-lg);
}

.modal-body {
    padding: var(--spacing-lg);
}

.modal-footer {
    border-top: 1px solid var(--gray-200);
    padding: var(--spacing-lg);
}

.modal-title {
    font-weight: 600;
    color: var(--gray-900);
}

/* Animações */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: slideIn 0.3s ease-out;
}

/* Loading States */
.loading {
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.8);
    backdrop-filter: blur(4px);
    border-radius: inherit;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 24px;
    height: 24px;
    border: 3px solid var(--gray-200);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 1;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

/* Responsividade */
@media (max-width: 768px) {
    .header {
        margin-bottom: var(--spacing-lg);
    }

    .header-title {
        font-size: 1.5rem;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
    }

    .pipeline-container {
        grid-auto-columns: 280px;
        padding: var(--spacing-sm);
    }

    .candidate-card {
        flex-direction: column;
        text-align: center;
        padding: var(--spacing-md);
    }

    .candidate-meta {
        justify-content: center;
    }

    .candidate-actions {
        width: 100%;
        justify-content: center;
        margin-top: var(--spacing-sm);
    }

    .job-card .card-body {
        padding: var(--spacing-md);
    }

    .table-responsive {
        margin: 0 calc(-1 * var(--spacing-md));
        width: calc(100% + (var(--spacing-md) * 2));
        border-radius: 0;
    }
}

/* Avatar Styles */
.candidate-avatar {
    position: relative;
    width: var(--avatar-size);
    height: var(--avatar-size);
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: calc(var(--avatar-size) * 0.4);
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.candidate-avatar.female {
    background: #e91e63;
}

.candidate-avatar.male {
    background: #1976d2;
}

.candidate-avatar.design {
    background: #9c27b0;
}

.candidate-avatar.product {
    background: #00796b;
}

.table .candidate-avatar {
    width: var(--avatar-size-sm);
    height: var(--avatar-size-sm);
    font-size: calc(var(--avatar-size-sm) * 0.4);
}
</style>

<?php
$styles = ob_get_clean();

// Inicia o conteúdo principal
ob_start();
?>

<div class="container-fluid">
    <!-- Header -->
    <div class="header">
        <h1 class="header-title">
            Banco de Talentos
        </h1>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaRPModal">
                <i class="fas fa-file-earmark-plus"></i> Nova RP
            </button>
            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#novoCandidatoModal">
                <i class="fas fa-user-plus"></i> Novo Candidato
            </button>
        </div>
    </div>

    <!-- Pipeline Visual -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Pipeline de Candidatos</h5>
                <div class="pipeline-stats">
                    <span class="badge bg-primary me-2">Total: 22</span>
                    <span class="badge bg-success me-2">Aprovados: 2</span>
                    <span class="badge bg-warning">Em Processo: 20</span>
                </div>
            </div>
            <div class="pipeline-container">
                <div class="pipeline-column">
                    <div class="pipeline-header bg-primary text-white">
                        <h6>CV Recebido</h6>
                        <span class="badge bg-light text-primary">12</span>
                    </div>
                    <div class="pipeline-candidates">
                        <div class="candidate-card">
                            <div class="candidate-avatar male">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="candidate-info">
                                <h6>João Silva</h6>
                                <small>Desenvolvedor Full Stack</small>
                                <div class="candidate-meta">
                                    <span class="badge bg-light text-dark">5 anos exp.</span>
                                    <span class="badge bg-light text-dark">TI</span>
                                </div>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pipeline-column">
                    <div class="pipeline-header bg-warning text-white">
                        <h6>Em Entrevista</h6>
                        <span class="badge bg-light text-warning">5</span>
                    </div>
                    <div class="pipeline-candidates">
                        <div class="candidate-card">
                            <div class="candidate-avatar female">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="candidate-info">
                                <h6>Maria Santos</h6>
                                <small>Analista de RH</small>
                                <div class="candidate-meta">
                                    <span class="badge bg-light text-dark">3 anos exp.</span>
                                    <span class="badge bg-light text-dark">RH</span>
                                </div>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pipeline-column">
                    <div class="pipeline-header bg-info text-white">
                        <h6>Testes</h6>
                        <span class="badge bg-light text-info">3</span>
                    </div>
                    <div class="pipeline-candidates">
                        <div class="candidate-card">
                            <div class="candidate-avatar design">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div class="candidate-info">
                                <h6>Pedro Oliveira</h6>
                                <small>UX Designer</small>
                                <div class="candidate-meta">
                                    <span class="badge bg-light text-dark">4 anos exp.</span>
                                    <span class="badge bg-light text-dark">Design</span>
                                </div>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pipeline-column">
                    <div class="pipeline-header bg-success text-white">
                        <h6>Aprovados</h6>
                        <span class="badge bg-light text-success">2</span>
                    </div>
                    <div class="pipeline-candidates">
                        <div class="candidate-card">
                            <div class="candidate-avatar product">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="candidate-info">
                                <h6>Ana Costa</h6>
                                <small>Product Manager</small>
                                <div class="candidate-meta">
                                    <span class="badge bg-light text-dark">6 anos exp.</span>
                                    <span class="badge bg-light text-dark">Produto</span>
                                </div>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Aprovar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Movimentações Internas e Promoções -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Movimentações Internas e Promoções</h5>
                <div class="actions">
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-plus"></i> Nova Movimentação
                    </button>
                </div>
            </div>
            <div class="row g-3">
                <!-- Promoção Pendente -->
                <div class="col-md-4">
                    <div class="card h-100 job-card border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar product me-2" style="--avatar-size: 40px">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Carlos Mendes</h6>
                                        <small class="text-muted">Analista de Projetos Sr</small>
                                    </div>
                                </div>
                                <span class="badge bg-warning">Pendente</span>
                            </div>
                            <div class="promotion-details mb-3">
                                <div class="d-flex align-items-center text-success mb-2">
                                    <i class="fas fa-arrow-up me-2"></i>
                                    <span>Promoção para Coordenador</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                                </div>
                            </div>
                            <div class="job-meta mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>Previsto: Abril/2024</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>4/5 requisitos atendidos</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="fas fa-eye me-1"></i> Detalhes
                                </button>
                                <button class="btn btn-sm btn-success flex-grow-1">
                                    <i class="fas fa-check me-1"></i> Aprovar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Movimentação Lateral -->
                <div class="col-md-4">
                    <div class="card h-100 job-card border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar female me-2" style="--avatar-size: 40px">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Ana Paula</h6>
                                        <small class="text-muted">Analista de RH</small>
                                    </div>
                                </div>
                                <span class="badge bg-info">Em Análise</span>
                            </div>
                            <div class="promotion-details mb-3">
                                <div class="d-flex align-items-center text-info mb-2">
                                    <i class="fas fa-exchange-alt me-2"></i>
                                    <span>Transferência para T&D</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                                </div>
                            </div>
                            <div class="job-meta mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>Previsto: Maio/2024</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span>Aguardando avaliação</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="fas fa-eye me-1"></i> Detalhes
                                </button>
                                <button class="btn btn-sm btn-info flex-grow-1">
                                    <i class="fas fa-clock me-1"></i> Acompanhar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sucessão -->
                <div class="col-md-4">
                    <div class="card h-100 job-card border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar male me-2" style="--avatar-size: 40px">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <h6 class="card-title mb-0">Roberto Alves</h6>
                                        <small class="text-muted">Tech Lead</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary">Sucessão</span>
                            </div>
                            <div class="promotion-details mb-3">
                                <div class="d-flex align-items-center text-primary mb-2">
                                    <i class="fas fa-level-up-alt me-2"></i>
                                    <span>Plano de Sucessão - CTO</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 40%"></div>
                                </div>
                            </div>
                            <div class="job-meta mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>Preparação: 12 meses</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-tasks me-2"></i>
                                    <span>2/5 etapas concluídas</span>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="fas fa-eye me-1"></i> Detalhes
                                </button>
                                <button class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="fas fa-chart-line me-1"></i> Progresso
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vagas em Destaque -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100 job-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Desenvolvedor Full Stack</h5>
                        <span class="badge bg-primary">Urgente</span>
                    </div>
                    <p class="card-text">Vaga para desenvolvimento de aplicações web com React e Node.js</p>
                    <div class="job-meta mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-building me-2"></i>
                            <span>TI</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-briefcase me-2"></i>
                            <span>Pleno</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users me-2"></i>
                            <span>5 candidatos em processo</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i> Ver Detalhes
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-user-plus me-1"></i> Novo Candidato
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 job-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Analista de RH</h5>
                        <span class="badge bg-success">Em Andamento</span>
                    </div>
                    <p class="card-text">Vaga para gestão de recrutamento e seleção</p>
                    <div class="job-meta mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-building me-2"></i>
                            <span>RH</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-briefcase me-2"></i>
                            <span>Pleno</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users me-2"></i>
                            <span>3 candidatos em processo</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i> Ver Detalhes
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-user-plus me-1"></i> Novo Candidato
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 job-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">UX Designer</h5>
                        <span class="badge bg-warning">Em Análise</span>
                    </div>
                    <p class="card-text">Vaga para design de interfaces e experiência do usuário</p>
                    <div class="job-meta mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-building me-2"></i>
                            <span>Design</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-briefcase me-2"></i>
                            <span>Sênior</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users me-2"></i>
                            <span>2 candidatos em processo</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i> Ver Detalhes
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="fas fa-user-plus me-1"></i> Novo Candidato
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" id="filterForm">
                <div class="col-md-4">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" placeholder="Nome, cargo ou habilidades...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Área de Interesse</label>
                    <select class="form-select">
                        <option value="">Todas</option>
                        <option>TI</option>
                        <option>Recursos Humanos</option>
                        <option>Financeiro</option>
                        <option>Comercial</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option>Disponível</option>
                        <option>Em Processo</option>
                        <option>Contratado</option>
                        <option>Arquivado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Candidatos Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Área de Interesse</th>
                            <th>Experiência</th>
                            <th>Status</th>
                            <th>Última Atualização</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar male me-2">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">João Silva</div>
                                        <div class="small text-muted">joao.silva@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Desenvolvimento</td>
                            <td>5 anos</td>
                            <td><span class="badge bg-success">Disponível</span></td>
                            <td>25/03/2024</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Agendar">
                                    <i class="fas fa-calendar-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Arquivar">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="candidate-avatar female me-2">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Maria Santos</div>
                                        <div class="small text-muted">maria.santos@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td>Recursos Humanos</td>
                            <td>3 anos</td>
                            <td><span class="badge bg-warning">Em Processo</span></td>
                            <td>24/03/2024</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Agendar">
                                    <i class="fas fa-calendar-check"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" title="Arquivar">
                                    <i class="fas fa-archive"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova RP -->
<div class="modal fade" id="novaRPModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Requisição de Pessoal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="novaRPForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cargo</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Área</label>
                            <select class="form-select" required>
                                <option value="">Selecione...</option>
                                <option>TI</option>
                                <option>Recursos Humanos</option>
                                <option>Financeiro</option>
                                <option>Comercial</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nível</label>
                            <select class="form-select" required>
                                <option value="">Selecione...</option>
                                <option>Júnior</option>
                                <option>Pleno</option>
                                <option>Sênior</option>
                                <option>Especialista</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prioridade</label>
                            <select class="form-select" required>
                                <option value="">Selecione...</option>
                                <option>Baixa</option>
                                <option>Média</option>
                                <option>Alta</option>
                                <option>Urgente</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição da Vaga</label>
                            <textarea class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Requisitos</label>
                            <textarea class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="novaRPForm" class="btn btn-primary">Criar RP</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novo Candidato -->
<div class="modal fade" id="novoCandidatoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Candidato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="novoCandidatoForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-mail</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefone</label>
                            <input type="tel" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Área de Interesse</label>
                            <select class="form-select" required>
                                <option value="">Selecione...</option>
                                <option>TI</option>
                                <option>Recursos Humanos</option>
                                <option>Financeiro</option>
                                <option>Comercial</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Experiência Profissional</label>
                            <textarea class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Currículo</label>
                            <input type="file" class="form-control" accept=".pdf,.doc,.docx">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="novoCandidatoForm" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Loading States
    const buttons = document.querySelectorAll('button[type="submit"]');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            if (form) {
                form.classList.add('loading');
                setTimeout(() => {
                    form.classList.remove('loading');
                }, 1000);
            }
        });
    });

    // Pipeline Scroll
    const pipeline = document.querySelector('.pipeline-container');
    if (pipeline) {
        pipeline.addEventListener('wheel', function(e) {
            e.preventDefault();
            pipeline.scrollLeft += e.deltaY;
        });
    }
});
</script>

<?php
$content = ob_get_clean();

// Inclui o template depois de definir $styles e $content
require_once 'template.php';
?> 