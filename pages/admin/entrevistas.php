<?php
// Error reporting em produção deve ser ajustado
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificação de administrador
require_once dirname(__DIR__, 2) . '/includes/auth.php';

$pageTitle = 'Gestão de Entrevistas';

// Iniciar captura do conteúdo
ob_start();

// Configurações de cabeçalho básicas
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$currentPage = basename($_SERVER['PHP_SELF']);
$user = getCurrentUser();
?>

<div class="container-fluid">
    <!-- Header Otimizado -->
    <div class="header d-flex justify-content-between align-items-center mb-3">
        <h1 class="header-title mb-0">Agenda de Entrevistas</h1>
        <div class="header-actions d-flex gap-2 align-items-center">
            <div class="input-group me-2">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Buscar entrevistas" id="search-interviews">
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaEntrevistaModal">
                <i class="bi bi-calendar-plus"></i> Agendar Entrevista
            </button>
            <button id="toggle-sidebar-btn" class="btn btn-outline-secondary d-md-none">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>
        </div>
    </div>

    <!-- Quick Filter Strip -->
    <div class="quick-filters mb-3">
        <div class="btn-group">
            <button class="btn btn-outline-primary active">Todos</button>
            <button class="btn btn-outline-primary">Hoje</button>
            <button class="btn btn-outline-primary">Esta Semana</button>
            <button class="btn btn-outline-primary">Pendentes</button>
            <button class="btn btn-outline-primary">Confirmados</button>
        </div>
        
        <div class="dropdown ms-2">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Ações em Lote
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="bi bi-check-all"></i> Confirmar Selecionados</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-week"></i> Reagendar Selecionados</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-envelope"></i> Enviar Lembrete</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Cancelar Selecionados</a></li>
            </ul>
        </div>
    </div>

    <!-- Quick Stats Row - Redesigned as compact cards -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm dashboard-stat-card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-calendar-check fs-4 text-danger"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle text-muted mb-0">Entrevistas Hoje</h6>
                            <div class="d-flex align-items-baseline">
                                <h2 class="card-title mb-0 me-2">5</h2>
                                <small class="text-muted">3 motoristas, 2 mecânicos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm dashboard-stat-card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success-subtle rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle text-muted mb-0">Confirmadas</h6>
                            <div class="d-flex align-items-baseline">
                                <h2 class="card-title mb-0 me-2">8</h2>
                                <small class="text-muted">Próximos 7 dias</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm dashboard-stat-card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-exclamation-circle fs-4 text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle text-muted mb-0">Pendentes</h6>
                            <div class="d-flex align-items-baseline">
                                <h2 class="card-title mb-0 me-2">3</h2>
                                <small class="text-muted">Confirmação necessária</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="card border-0 shadow-sm dashboard-stat-card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info-subtle rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-graph-up fs-4 text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-subtitle text-muted mb-0">Taxa de Comparecimento</h6>
                            <div class="d-flex align-items-baseline">
                                <h2 class="card-title mb-0 me-2">92%</h2>
                                <small class="text-muted">Últimos 30 dias</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Main Content Area with Tabs -->
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view" type="button" role="tab">
                                <i class="bi bi-calendar3"></i> Calendário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button" role="tab">
                                <i class="bi bi-list-ul"></i> Lista
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kanban-tab" data-bs-toggle="tab" data-bs-target="#kanban-view" type="button" role="tab">
                                <i class="bi bi-kanban"></i> Kanban
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <!-- Calendar View Tab (Improved) -->
                        <div class="tab-pane fade show active p-3" id="calendar-view" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary"><i class="bi bi-chevron-left"></i></button>
                                        <button class="btn btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
                                    </div>
                                    <button class="btn btn-outline-secondary ms-2">Hoje</button>
                                    <span class="ms-3 fw-bold">Março 2024</span>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary active">Mês</button>
                                    <button class="btn btn-outline-secondary">Semana</button>
                                    <button class="btn btn-outline-secondary">Dia</button>
                                </div>
                            </div>
                            
                            <!-- Improved Calendar with time slots -->
                            <div class="calendar-container">
                                <table class="table table-bordered text-center calendar-table">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Dom</th>
                                            <th>Seg</th>
                                            <th>Ter</th>
                                            <th>Qua</th>
                                            <th>Qui</th>
                                            <th>Sex</th>
                                            <th>Sáb</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">25</td>
                                            <td class="text-muted">26</td>
                                            <td class="text-muted">27</td>
                                            <td class="text-muted">28</td>
                                            <td class="text-muted">29</td>
                                            <td>1</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="position-relative has-event">
                                                <span class="date-number">4</span>
                                                <div class="calendar-event primary-event" data-bs-toggle="tooltip" title="João Silva - Motorista - 14:00">
                                                    <span class="event-time">14:00</span>
                                                    <span class="event-title">João Silva</span>
                                                </div>
                                            </td>
                                            <td>5</td>
                                            <td class="position-relative has-event">
                                                <span class="date-number">6</span>
                                                <div class="calendar-event success-event" data-bs-toggle="tooltip" title="Maria Santos - Mecânico - 10:00">
                                                    <span class="event-time">10:00</span>
                                                    <span class="event-title">Maria Santos</span>
                                                </div>
                                            </td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>9</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- List View Tab (New) -->
                        <div class="tab-pane fade p-3" id="list-view" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th width="40px">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                </div>
                                            </th>
                                            <th>Candidato</th>
                                            <th>Cargo</th>
                                            <th>Data</th>
                                            <th>Hora</th>
                                            <th>Entrevistador</th>
                                            <th>Formato</th>
                                            <th>Status</th>
                                            <th width="100px">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 bg-primary text-white">JS</div>
                                                    <span>João Silva</span>
                                                </div>
                                            </td>
                                            <td>Motorista de Carreta</td>
                                            <td>04/03/2024</td>
                                            <td>14:00</td>
                                            <td>Ana Paula</td>
                                            <td><span class="badge bg-primary">Presencial</span></td>
                                            <td><span class="badge bg-success">Confirmado</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Ações
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Detalhes</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-x"></i> Reagendar</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Cancelar</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 bg-info text-white">MS</div>
                                                    <span>Maria Santos</span>
                                                </div>
                                            </td>
                                            <td>Mecânico de Manutenção</td>
                                            <td>06/03/2024</td>
                                            <td>10:00</td>
                                            <td>Carlos Silva</td>
                                            <td><span class="badge bg-primary">Presencial</span></td>
                                            <td><span class="badge bg-warning">Pendente</span></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Ações
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Detalhes</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-calendar-x"></i> Reagendar</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Cancelar</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Kanban View Tab (New) -->
                        <div class="tab-pane fade p-3" id="kanban-view" role="tabpanel">
                            <div class="kanban-container d-flex gap-3 overflow-auto pb-2">
                                <div class="kanban-column">
                                    <div class="kanban-column-header bg-warning text-white p-2 rounded-top">
                                        <h6 class="mb-0">Pendentes (3)</h6>
                                    </div>
                                    <div class="kanban-items p-2 bg-light rounded-bottom">
                                        <div class="kanban-item card mb-2 cursor-grab">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">Maria Santos</h6>
                                                <p class="card-text small mb-1">Mecânico de Manutenção</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">Presencial</span>
                                                    <small class="text-muted">06/03 - 10:00</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kanban-item card mb-2 cursor-grab">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">Carlos Almeida</h6>
                                                <p class="card-text small mb-1">Auxiliar Administrativo</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-info">Online</span>
                                                    <small class="text-muted">09/03 - 15:30</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="kanban-column">
                                    <div class="kanban-column-header bg-success text-white p-2 rounded-top">
                                        <h6 class="mb-0">Confirmados (8)</h6>
                                    </div>
                                    <div class="kanban-items p-2 bg-light rounded-bottom">
                                        <div class="kanban-item card mb-2 cursor-grab">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">João Silva</h6>
                                                <p class="card-text small mb-1">Motorista de Carreta</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-primary">Presencial</span>
                                                    <small class="text-muted">04/03 - 14:00</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="kanban-column">
                                    <div class="kanban-column-header bg-danger text-white p-2 rounded-top">
                                        <h6 class="mb-0">Realizadas (12)</h6>
                                    </div>
                                    <div class="kanban-items p-2 bg-light rounded-bottom">
                                        <div class="kanban-item card mb-2 cursor-grab">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">Pedro Oliveira</h6>
                                                <p class="card-text small mb-1">Analista de Sistemas</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="badge bg-info">Online</span>
                                                    <small class="text-muted">01/03 - 09:00</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Entrevista (Otimizado) -->
<div class="modal fade" id="novaEntrevistaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agendar Entrevista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="novaEntrevistaForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Candidato</label>
                        <select class="form-select" required>
                            <option value="">Selecione o candidato...</option>
                            <option>João Silva - Motorista de Carreta</option>
                            <option>Maria Santos - Mecânico de Manutenção</option>
                            <option>Pedro Oliveira - Auxiliar de Operações</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Entrevistador</label>
                        <select class="form-select" required>
                            <option value="">Selecione o entrevistador...</option>
                            <option>Ana Paula - Gerente de RH</option>
                            <option>Carlos Silva - Coordenador de Operações</option>
                            <option>Roberto Santos - Supervisor de Manutenção</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Horário</label>
                        <input type="time" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duração</label>
                        <select class="form-select">
                            <option>30 minutos</option>
                            <option selected>1 hora</option>
                            <option>1 hora e 30 minutos</option>
                            <option>2 horas</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Entrevista</label>
                        <select class="form-select" required id="entrevista-tipo">
                            <option value="">Selecione o tipo...</option>
                            <option value="presencial">Presencial</option>
                            <option value="online-meet">Online - Google Meet</option>
                            <option value="online-zoom">Online - Zoom</option>
                            <option value="telefone">Telefone</option>
                        </select>
                    </div>
                    <div class="col-md-6 local-field">
                        <label class="form-label">Local</label>
                        <select class="form-select" required>
                            <option value="">Selecione o local...</option>
                            <option>Matriz - Vitória/ES</option>
                            <option>Filial - São Paulo/SP</option>
                            <option>Filial - Rio de Janeiro/RJ</option>
                        </select>
                    </div>
                    <div class="col-12 link-field d-none">
                        <label class="form-label">Link da Reunião</label>
                        <div class="input-group">
                            <input type="url" class="form-control" placeholder="https://">
                            <button type="button" class="btn btn-outline-secondary">Gerar Link</button>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Observações</label>
                        <textarea class="form-control" rows="3" placeholder="Ex: Necessário trazer documentos, uniforme específico, etc."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="novaEntrevistaForm" class="btn btn-primary">Agendar</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para os cards estatísticos */
.dashboard-stat-card {
    transition: all 0.2s ease;
}
.dashboard-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.stat-icon {
    width: 48px;
    height: 48px;
    min-width: 48px;
}

/* Estilos para o calendário otimizado */
.calendar-table td {
    height: 100px;
    vertical-align: top;
    padding-top: 5px;
    padding-bottom: 5px;
}
.date-number {
    display: block;
    text-align: right;
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 5px;
}
.has-event {
    background-color: rgba(0, 0, 0, 0.025);
}
.calendar-event {
    font-size: 0.7rem;
    padding: 2px 4px;
    margin-bottom: 3px;
    border-radius: 3px;
    cursor: pointer;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    flex-direction: column;
}
.primary-event {
    background-color: rgba(13, 110, 253, 0.1);
    border-left: 3px solid #0d6efd;
}
.success-event {
    background-color: rgba(25, 135, 84, 0.1);
    border-left: 3px solid #198754;
}
.warning-event {
    background-color: rgba(255, 193, 7, 0.1);
    border-left: 3px solid #ffc107;
}
.event-time {
    font-weight: bold;
}
.event-title {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Estilos para o avatar */
.avatar {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: 50%;
}
.avatar-sm {
    width: 28px;
    height: 28px;
    font-size: 0.75rem;
}

/* Estilos para o kanban */
.kanban-container {
    min-height: 400px;
}
.kanban-column {
    min-width: 300px;
    max-width: 300px;
}
.kanban-items {
    min-height: 200px;
}
.cursor-grab {
    cursor: grab;
}
.cursor-grab:active {
    cursor: grabbing;
}

/* Estilos para elementos responsivos */
@media (max-width: 992px) {
    .quick-filters {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 10px;
    }
    .kanban-column {
        min-width: 250px;
    }
}
</style>

<script>
// Alternar entre local físico e link de reunião conforme o tipo de entrevista
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('entrevista-tipo');
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            const localField = document.querySelector('.local-field');
            const linkField = document.querySelector('.link-field');
            
            if (this.value.startsWith('online')) {
                localField.classList.add('d-none');
                linkField.classList.remove('d-none');
            } else {
                localField.classList.remove('d-none');
                linkField.classList.add('d-none');
            }
        });
    }
    
    // Inicializar tooltips
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Controle para sidebar colapsável em dispositivos móveis
    const toggleSidebarBtn = document.getElementById('toggle-sidebar-btn');
    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 