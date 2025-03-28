<?php
// Error reporting em produção deve ser ajustado
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificação de administrador
require_once dirname(__DIR__, 2) . '/includes/auth.php';

$pageTitle = 'Gestão de Vagas';

// Iniciar captura do conteúdo
ob_start();

// Configurações de cabeçalho básicas
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

define('BASE_PATH', dirname(__DIR__, 2));

$currentPage = basename($_SERVER['PHP_SELF']);
$user = getCurrentUser();
?>

<!-- Adicionar link para Bootstrap Icons no head do documento -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid py-4">
    <!-- Header com melhor hierarquia visual e contraste -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Gestão de Vagas</h1>
            <p class="text-muted mb-0">Gerencie vagas e acompanhe o processo seletivo</p>
        </div>
        <div class="d-flex flex-column flex-sm-row gap-2">
            <div class="position-relative">
                <input type="text" class="form-control" placeholder="Buscar vagas..." id="searchVagas">
                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-2 text-muted"></i>
            </div>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtrosModal">
                <i class="bi bi-funnel-fill me-1"></i>Filtros
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaVagaModal">
                <i class="bi bi-plus-lg me-1"></i>Nova Vaga
            </button>
        </div>
    </div>

    <!-- Cards com melhor hierarquia visual, consistência e espaçamento -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 end-0 bg-primary" style="height:4px;"></div>
                <div class="card-body p-3 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-uppercase fw-bold small text-muted mb-1">Vagas Abertas</h6>
                            <h2 class="card-title h1 fw-bold mb-0">12</h2>
                            <small class="text-success d-flex align-items-center fw-medium">
                                <i class="bi bi-arrow-up-right me-1"></i> 2 novas esta semana
                            </small>
                        </div>
                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center">
                            <i class="bi bi-briefcase-fill fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 end-0 bg-success" style="height:4px;"></div>
                <div class="card-body p-3 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-uppercase fw-bold small text-muted mb-1">Candidatos Ativos</h6>
                            <h2 class="card-title h1 fw-bold mb-0">45</h2>
                            <small class="text-success d-flex align-items-center fw-medium">
                                <i class="bi bi-arrow-up-right me-1"></i> 8 novos hoje
                            </small>
                        </div>
                        <div class="rounded-circle p-3 bg-success bg-opacity-10 d-flex align-items-center justify-content-center">
                            <i class="bi bi-people-fill fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 end-0 bg-warning" style="height:4px;"></div>
                <div class="card-body p-3 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-uppercase fw-bold small text-muted mb-1">Em Processo</h6>
                            <h2 class="card-title h1 fw-bold mb-0">8</h2>
                            <small class="text-warning d-flex align-items-center fw-medium">
                                <i class="bi bi-hourglass-split me-1"></i> 3 aguardando aprovação
                            </small>
                        </div>
                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 d-flex align-items-center justify-content-center">
                            <i class="bi bi-hourglass-top fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 end-0 bg-info" style="height:4px;"></div>
                <div class="card-body p-3 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle text-uppercase fw-bold small text-muted mb-1">Taxa de Conversão</h6>
                            <h2 class="card-title h1 fw-bold mb-0">68%</h2>
                            <small class="text-info d-flex align-items-center fw-medium">
                                <i class="bi bi-graph-up-arrow me-1"></i> +5% este mês
                            </small>
                        </div>
                        <div class="rounded-circle p-3 bg-info bg-opacity-10 d-flex align-items-center justify-content-center">
                            <i class="bi bi-pie-chart-fill fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layout principal com melhor organização e hierarquia -->
    <div class="row g-4">
        <!-- Tabela de vagas com melhor legibilidade e espaçamento -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-3 border-bottom">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                        <h5 class="card-title mb-0 fw-bold">Vagas Ativas</h5>
                        <div class="btn-group shadow-sm">
                            <button type="button" class="btn btn-light active" data-filter="all">
                                <i class="bi bi-grid-fill me-1"></i>Todas
                            </button>
                            <button type="button" class="btn btn-light" data-filter="open">
                                <i class="bi bi-check-circle-fill me-1"></i>Abertas
                            </button>
                            <button type="button" class="btn btn-light" data-filter="process">
                                <i class="bi bi-hourglass-split me-1"></i>Em Processo
                            </button>
                            <button type="button" class="btn btn-light" data-filter="finished">
                                <i class="bi bi-archive-fill me-1"></i>Finalizadas
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="vagasTable">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col" class="ps-3 text-uppercase small fw-bold">Código</th>
                                    <th scope="col" class="text-uppercase small fw-bold">Cargo</th>
                                    <th scope="col" class="text-uppercase small fw-bold">Status</th>
                                    <th scope="col" class="text-uppercase small fw-bold" width="20%">Candidatos</th>
                                    <th scope="col" class="text-uppercase small fw-bold">Data Limite</th>
                                    <th scope="col" class="text-end pe-3 text-uppercase small fw-bold">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <tr data-status="open" class="position-relative">
                                    <td class="ps-3">
                                        <span class="badge bg-light text-dark fw-medium">V001</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 rounded-circle p-2 me-2 bg-primary bg-opacity-10">
                                                <i class="bi bi-briefcase text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Desenvolvedor Full Stack</h6>
                                                <small class="text-muted">TI</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success fw-medium text-white px-2 py-1">Aberta</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="16"></div>
                                            </div>
                                            <span class="fw-medium small">12/16</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">30/04/2024</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end align-items-center gap-1">
                                            <button class="btn btn-icon btn-sm text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar vaga" aria-label="Editar vaga">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver candidatos" aria-label="Ver candidatos">
                                                <i class="bi bi-people-fill"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir vaga" aria-label="Excluir vaga">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr data-status="process" class="position-relative">
                                    <td class="ps-3">
                                        <span class="badge bg-light text-dark fw-medium">V002</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 rounded-circle p-2 me-2 bg-warning bg-opacity-10">
                                                <i class="bi bi-briefcase text-warning"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">Analista de RH</h6>
                                                <small class="text-muted">Recursos Humanos</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning fw-medium text-dark px-2 py-1">Em Processo</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="18"></div>
                                            </div>
                                            <span class="fw-medium small">8/18</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">15/04/2024</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-flex justify-content-end align-items-center gap-1">
                                            <button class="btn btn-icon btn-sm text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar vaga" aria-label="Editar vaga">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver candidatos" aria-label="Ver candidatos">
                                                <i class="bi bi-people-fill"></i>
                                            </button>
                                            <button class="btn btn-icon btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir vaga" aria-label="Excluir vaga">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="d-none" data-status="no-results">
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center py-4">
                                            <i class="bi bi-search fs-1 text-muted mb-2"></i>
                                            <h6 class="fw-normal text-muted">Nenhuma vaga encontrada</h6>
                                            <p class="text-muted small">Tente ajustar seus filtros ou criar uma nova vaga</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2 border-top">
                    <div class="text-muted small">Mostrando 2 de 2 vagas</div>
                    <div class="pagination-sm d-none">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Atividades recentes com design consistente -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white p-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Atividades Recentes</h5>
                        <a href="#" class="btn btn-sm btn-light">Ver todas</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3 border-0 border-bottom">
                            <div class="d-flex">
                                <div class="activity-icon bg-success-subtle rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-plus-fill fs-5 text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-medium">Novo candidato para Desenvolvedor Full Stack</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Há 5 minutos</small>
                                        <a href="#" class="activity-link text-primary text-decoration-none fw-medium">Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 border-0 border-bottom">
                            <div class="d-flex">
                                <div class="activity-icon bg-warning-subtle rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-check-fill fs-5 text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-medium">Entrevista agendada para Analista de RH</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Há 1 hora</small>
                                        <a href="#" class="activity-link text-primary text-decoration-none fw-medium">Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 border-0">
                            <div class="d-flex">
                                <div class="activity-icon bg-info-subtle rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-check-circle-fill fs-5 text-info"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-medium">Vaga de Motorista aprovada pelo gestor</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Há 2 horas</small>
                                        <a href="#" class="activity-link text-primary text-decoration-none fw-medium">Ver</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center py-2 border-top">
                    <button type="button" class="btn btn-sm btn-link text-muted">Carregar mais</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Vaga - Improved with multi-step form and better organization -->
<div class="modal fade" id="novaVagaModal" tabindex="-1" aria-labelledby="novaVagaModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="novaVagaModalLabel">Nova Requisição de Pessoal (RP)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="novaVagaForm">
                    <!-- Steps indicator -->
                    <div class="d-flex mb-4">
                        <div class="flex-fill position-relative">
                            <div class="step-indicator active d-flex align-items-center justify-content-center rounded-circle bg-primary text-white mx-auto">1</div>
                            <div class="text-center mt-1 small">Informações Básicas</div>
                            <div class="step-connector position-absolute bg-light"></div>
                        </div>
                        <div class="flex-fill position-relative">
                            <div class="step-indicator d-flex align-items-center justify-content-center rounded-circle bg-light text-muted mx-auto">2</div>
                            <div class="text-center mt-1 small">Requisitos</div>
                            <div class="step-connector position-absolute bg-light"></div>
                        </div>
                        <div class="flex-fill">
                            <div class="step-indicator d-flex align-items-center justify-content-center rounded-circle bg-light text-muted mx-auto">3</div>
                            <div class="text-center mt-1 small">Detalhes Adicionais</div>
                        </div>
                    </div>

                    <!-- Step 1: Informações Básicas -->
                    <div class="step-content" id="step1">
                        <h6 class="text-muted mb-3 d-flex align-items-center">
                            <i class="bi bi-info-circle me-2"></i>Informações Básicas
                        </h6>
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body py-2">
                                <small class="text-muted">Forneça as informações essenciais sobre a vaga que está sendo aberta.</small>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="cargo">Cargo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cargo" name="cargo" required>
                                <div class="form-text">Nome da posição a ser preenchida</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="departamento">Departamento <span class="text-danger">*</span></label>
                                <select class="form-select" id="departamento" name="departamento" required>
                                    <option value="">Selecione...</option>
                                    <option value="operacional">Operacional</option>
                                    <option value="administrativo">Administrativo</option>
                                    <option value="financeiro">Financeiro</option>
                                    <option value="rh">Recursos Humanos</option>
                                    <option value="ti">TI</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tipo_contrato">Tipo de Contrato <span class="text-danger">*</span></label>
                                <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="">Selecione...</option>
                                    <option value="clt">CLT</option>
                                    <option value="pj">PJ</option>
                                    <option value="temporario">Temporário</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="quantidade">Quantidade de Vagas <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" value="1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Requisitos -->
                    <div class="step-content d-none" id="step2">
                        <h6 class="text-muted mb-3 d-flex align-items-center">
                            <i class="bi bi-list-check me-2"></i>Requisitos
                        </h6>
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body py-2">
                                <small class="text-muted">Defina os requisitos mínimos que os candidatos devem atender.</small>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="escolaridade">Escolaridade <span class="text-danger">*</span></label>
                                <select class="form-select" id="escolaridade" name="escolaridade" required>
                                    <option value="">Selecione...</option>
                                    <option value="fundamental">Fundamental</option>
                                    <option value="medio">Médio</option>
                                    <option value="superior">Superior</option>
                                    <option value="pos_graduacao">Pós-Graduação</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="experiencia">Experiência Mínima <span class="text-danger">*</span></label>
                                <select class="form-select" id="experiencia" name="experiencia" required>
                                    <option value="">Selecione...</option>
                                    <option value="0">Sem experiência</option>
                                    <option value="1">1 ano</option>
                                    <option value="2">2 anos</option>
                                    <option value="3">3 anos</option>
                                    <option value="5">5 anos</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Competências Necessárias</label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="comunicacao" name="competencias[]" value="comunicacao">
                                            <label class="form-check-label" for="comunicacao">Comunicação</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="trabalho_equipe" name="competencias[]" value="trabalho_equipe">
                                            <label class="form-check-label" for="trabalho_equipe">Trabalho em Equipe</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lideranca" name="competencias[]" value="lideranca">
                                            <label class="form-check-label" for="lideranca">Liderança</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="resolucao_problemas" name="competencias[]" value="resolucao_problemas">
                                            <label class="form-check-label" for="resolucao_problemas">Resolução de Problemas</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Detalhes Adicionais -->
                    <div class="step-content d-none" id="step3">
                        <h6 class="text-muted mb-3 d-flex align-items-center">
                            <i class="bi bi-card-text me-2"></i>Detalhes Adicionais
                        </h6>
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body py-2">
                                <small class="text-muted">Complete com informações detalhadas que ajudarão a encontrar o candidato ideal.</small>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="descricao">Descrição da Vaga <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                                <div class="form-text">Descreva brevemente o propósito desta posição</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="atividades">Atividades Principais <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="atividades" name="atividades" rows="3" required></textarea>
                                <div class="form-text">Liste as principais responsabilidades e atividades</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Faixa Salarial <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" id="salario_min" name="salario_min" placeholder="Mínimo" required>
                                    <span class="input-group-text">até</span>
                                    <input type="number" class="form-control" id="salario_max" name="salario_max" placeholder="Máximo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="urgencia">Urgência <span class="text-danger">*</span></label>
                                <select class="form-select" id="urgencia" name="urgencia" required>
                                    <option value="">Selecione...</option>
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" id="prevStep" disabled>Voltar</button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="nextStep">Próximo</button>
                    <button type="button" class="btn btn-success d-none" id="submitVaga">Criar Vaga</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filtros - Improved with better organization and visual design -->
<div class="modal fade" id="filtrosModal" tabindex="-1" aria-labelledby="filtrosModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="filtrosModalLabel">Filtrar Vagas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="filtrosForm">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-funnel me-2 text-primary"></i>
                            <h6 class="fw-semibold mb-0">Status</h6>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="status_aberta" name="status[]" value="aberta" checked>
                                <label class="form-check-label" for="status_aberta">
                                    <span class="badge bg-success">Aberta</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="status_processo" name="status[]" value="em_processo" checked>
                                <label class="form-check-label" for="status_processo">
                                    <span class="badge bg-warning text-dark">Em Processo</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="status_finalizada" name="status[]" value="finalizada">
                                <label class="form-check-label" for="status_finalizada">
                                    <span class="badge bg-secondary">Finalizada</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-building me-2 text-primary"></i>
                            <h6 class="fw-semibold mb-0">Departamento</h6>
                        </div>
                        <select class="form-select" id="filtro_departamento" name="departamento">
                            <option value="">Todos os departamentos</option>
                            <option value="operacional">Operacional</option>
                            <option value="administrativo">Administrativo</option>
                            <option value="financeiro">Financeiro</option>
                            <option value="rh">Recursos Humanos</option>
                            <option value="ti">TI</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-file-text me-2 text-primary"></i>
                            <h6 class="fw-semibold mb-0">Tipo de Contrato</h6>
                        </div>
                        <select class="form-select" id="filtro_tipo_contrato" name="tipo_contrato">
                            <option value="">Todos os tipos</option>
                            <option value="clt">CLT</option>
                            <option value="pj">PJ</option>
                            <option value="temporario">Temporário</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-calendar-event me-2 text-primary"></i>
                            <h6 class="fw-semibold mb-0">Data Limite</h6>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small text-muted">De</label>
                                <input type="date" class="form-control" id="data_limite_inicio" name="data_limite_inicio">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Até</label>
                                <input type="date" class="form-control" id="data_limite_fim" name="data_limite_fim">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-link text-danger" id="limparFiltros">Limpar filtros</button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="aplicarFiltros">Aplicar Filtros</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'template.php';
?>

<!-- JavaScript for form functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips do Bootstrap
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
    
    // Forçar recarga de ícones para garantir renderização
    document.querySelectorAll('.bi').forEach(icon => {
        const iconClass = icon.className;
        icon.className = '';
        setTimeout(() => {
            icon.className = iconClass;
        }, 10);
    });
    
    // Adicionar classes de display flex a todos os containers de ícones
    document.querySelectorAll('.rounded-circle, .activity-icon').forEach(container => {
        if (!container.classList.contains('d-flex')) {
            container.classList.add('d-flex', 'align-items-center', 'justify-content-center');
        }
    });
    
    // Variables for multi-step form
    const steps = ['step1', 'step2', 'step3'];
    let currentStep = 0;
    
    const nextBtn = document.getElementById('nextStep');
    const prevBtn = document.getElementById('prevStep');
    const submitBtn = document.getElementById('submitVaga');
    
    // Next button click handler
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            // Validate current step first
            const currentStepEl = document.getElementById(steps[currentStep]);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                // Show error message
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            
            // Hide current step
            document.getElementById(steps[currentStep]).classList.add('d-none');
            
            // Update step indicator
            document.querySelectorAll('.step-indicator')[currentStep].classList.remove('active', 'bg-primary', 'text-white');
            document.querySelectorAll('.step-indicator')[currentStep].classList.add('bg-success', 'text-white');
            
            // Move to next step
            currentStep++;
            
            // Enable prev button
            prevBtn.disabled = false;
            
            // Show next step
            document.getElementById(steps[currentStep]).classList.remove('d-none');
            document.querySelectorAll('.step-indicator')[currentStep].classList.add('active', 'bg-primary', 'text-white');
            document.querySelectorAll('.step-indicator')[currentStep].classList.remove('bg-light', 'text-muted');
            
            // If last step, show submit button and hide next button
            if (currentStep === steps.length - 1) {
                nextBtn.classList.add('d-none');
                submitBtn.classList.remove('d-none');
            }
        });
    }
    
    // Previous button click handler
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            // Hide current step
            document.getElementById(steps[currentStep]).classList.add('d-none');
            document.querySelectorAll('.step-indicator')[currentStep].classList.remove('active', 'bg-primary', 'text-white');
            document.querySelectorAll('.step-indicator')[currentStep].classList.add('bg-light', 'text-muted');
            
            // Move to previous step
            currentStep--;
            
            // Disable prev button if on first step
            if (currentStep === 0) {
                prevBtn.disabled = true;
            }
            
            // Show next button and hide submit button
            nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
            
            // Show previous step
            document.getElementById(steps[currentStep]).classList.remove('d-none');
            document.querySelectorAll('.step-indicator')[currentStep].classList.add('active', 'bg-primary', 'text-white');
            document.querySelectorAll('.step-indicator')[currentStep].classList.remove('bg-success');
        });
    }
    
    // Submit form handler
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            // Validate last step
            const lastStepEl = document.getElementById(steps[currentStep]);
            const inputs = lastStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Criando...';
            
            // Simulate form submission (in a real app, this would be an AJAX request)
            setTimeout(function() {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('novaVagaModal')).hide();
                
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-success text-white">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong class="me-auto">Sucesso</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Vaga criada com sucesso!
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Reset form
                document.getElementById('novaVagaForm').reset();
                
                // Reset step indicators
                document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                    if (index === 0) {
                        indicator.classList.add('active', 'bg-primary', 'text-white');
                        indicator.classList.remove('bg-success', 'bg-light', 'text-muted');
                    } else {
                        indicator.classList.remove('active', 'bg-primary', 'text-white', 'bg-success');
                        indicator.classList.add('bg-light', 'text-muted');
                    }
                });
                
                // Reset step display
                steps.forEach((step, index) => {
                    if (index === 0) {
                        document.getElementById(step).classList.remove('d-none');
                    } else {
                        document.getElementById(step).classList.add('d-none');
                    }
                });
                
                // Reset buttons
                submitBtn.classList.add('d-none');
                nextBtn.classList.remove('d-none');
                prevBtn.disabled = true;
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Criar Vaga';
                
                // Reset current step
                currentStep = 0;
                
                // Hide toast after 5 seconds
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }, 1500);
        });
    }
    
    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            const rows = document.querySelectorAll('#vagasTable tbody tr');
            
            // Show/hide rows based on filter
            rows.forEach(row => {
                if (filter === 'all' || row.getAttribute('data-status') === filter) {
                    row.classList.remove('d-none');
                } else {
                    row.classList.add('d-none');
                }
            });
            
            // Check if any rows are visible
            const visibleRows = document.querySelectorAll('#vagasTable tbody tr:not(.d-none)');
            const noResultsRow = document.querySelector('[data-status="no-results"]');
            
            if (visibleRows.length === 0 && noResultsRow) {
                noResultsRow.classList.remove('d-none');
            } else if (noResultsRow) {
                noResultsRow.classList.add('d-none');
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchVagas');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#vagasTable tbody tr:not([data-status="no-results"])');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.classList.remove('d-none');
                } else {
                    row.classList.add('d-none');
                }
            });
            
            // Check if any rows are visible
            const visibleRows = document.querySelectorAll('#vagasTable tbody tr:not(.d-none):not([data-status="no-results"])');
            const noResultsRow = document.querySelector('[data-status="no-results"]');
            
            if (visibleRows.length === 0 && noResultsRow) {
                noResultsRow.classList.remove('d-none');
            } else if (noResultsRow) {
                noResultsRow.classList.add('d-none');
            }
        });
    }
    
    // Apply filters
    const aplicarFiltrosBtn = document.getElementById('aplicarFiltros');
    if (aplicarFiltrosBtn) {
        aplicarFiltrosBtn.addEventListener('click', function() {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('filtrosModal')).hide();
            
            // Show loading state
            const tableBody = document.querySelector('#vagasTable tbody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                        <p class="mt-2 text-muted">Aplicando filtros...</p>
                    </td>
                </tr>
            `;
            
            // Simulate loading time (in a real app, this would be an AJAX request)
            setTimeout(function() {
                // Restore original rows (or filtered rows in a real app)
                tableBody.innerHTML = document.getElementById('vagasTable').innerHTML;
                
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-primary text-white">
                            <i class="bi bi-funnel me-2"></i>
                            <strong class="me-auto">Filtros Aplicados</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Os filtros foram aplicados com sucesso!
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Hide toast after 5 seconds
                setTimeout(() => {
                    toast.remove();
                }, 5000);
            }, 1000);
        });
    }
    
    // Clear filters
    const limparFiltrosBtn = document.getElementById('limparFiltros');
    if (limparFiltrosBtn) {
        limparFiltrosBtn.addEventListener('click', function() {
            document.getElementById('filtrosForm').reset();
        });
    }
});
</script>

<!-- CSS for multi-step form -->
<style>
.step-indicator {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-weight: bold;
}

.step-connector {
    height: 2px;
    width: 100%;
    top: 15px;
    right: -50%;
    z-index: -1;
}
</style>

<!-- Estilos visuais específicos para a página de vagas -->
<style>
/* Estilo base para os cards */
.card {
    transition: all 0.2s ease;
    border-radius: 0.5rem;
}

.card:hover {
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.08) !important;
}

/* Status badges com melhor contraste */
.badge.bg-success {
    background-color: #10b981 !important;
    font-weight: 500;
}

.badge.bg-warning {
    background-color: #f59e0b !important;
    color: #1f2937 !important;
    font-weight: 500;
}

.badge.bg-secondary {
    background-color: #6b7280 !important;
    font-weight: 500;
}

/* Estilos para a tabela */
.table {
    font-size: 0.925rem;
    color: #1f2937;
    border-color: #f3f4f6;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.025em;
    color: #4b5563;
}

.table > tbody {
    border-top-width: 0 !important;
}

/* Melhorias nas barras de progresso */
.progress {
    height: 6px;
    background-color: #f3f4f6;
    border-radius: 1rem;
    overflow: hidden;
}

.progress-bar {
    border-radius: 1rem;
}

/* Hover em linhas de tabela */
.table > tbody > tr:hover {
    background-color: rgba(59, 130, 246, 0.04);
}

/* Botões com estilo consistente */
.btn-light {
    background-color: #f9fafb;
    border-color: #e5e7eb;
    color: #4b5563;
}

.btn-light:hover, .btn-light.active {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #1f2937;
}

/* Melhoria de acessibilidade para links */
a.text-decoration-none {
    color: #2563eb;
}

/* Fundo consistente para ícones */
.rounded-circle.p-2, .rounded-circle.p-3 {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Feedback visual para interações */
.btn-sm:hover {
    transform: translateY(-1px);
    transition: transform 0.2s;
}

/* Estilos responsivos */
@media (max-width: 767.98px) {
    .card-header .btn-group {
        width: 100%;
    }
    
    .btn-group .btn {
        flex: 1;
    }
    
    .table .btn-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .table .btn-group .btn {
        border-radius: 0.25rem !important;
        margin-left: 0 !important;
    }
}

/* Estilos dos botões de ações da tabela */
.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background-color: #f8fafc;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-icon:active {
    transform: translateY(0);
}

.btn-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: currentColor;
    border-radius: inherit;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.btn-icon:hover::before {
    opacity: 0.08;
}

.btn-icon i {
    position: relative;
    z-index: 1;
    font-size: 1rem;
}

/* Estilos dos ícones de atividades */
.activity-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-group-item:hover .activity-icon {
    transform: scale(1.1);
}

.activity-link {
    font-size: 0.875rem;
    position: relative;
}

.activity-link::after {
    content: '→';
    opacity: 0;
    margin-left: -5px;
    transition: all 0.2s ease;
}

.activity-link:hover::after {
    opacity: 1;
    margin-left: 3px;
}

/* Tooltip personalizado */
.tooltip {
    --bs-tooltip-bg: #1e293b;
    --bs-tooltip-opacity: 1;
}

/* Responsividade para ações */
@media (max-width: 767.98px) {
    .btn-icon {
        width: 36px;
        height: 36px;
    }
    
    .btn-icon i {
        font-size: 1.1rem;
    }
}

/* Garantir que todos os ícones nos botões tenham um tamanho consistente */
.btn i.bi, 
.btn-icon i.bi {
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-sm i.bi {
    font-size: 0.875rem;
}

.fs-4 {
    font-size: 1.5rem !important;
}

.fs-5 {
    font-size: 1.25rem !important;
}
</style>
?> 