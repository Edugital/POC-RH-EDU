<?php
$pageTitle = 'Gestão de Cargos';
require_once 'admin_check.php';

// Mock data - Cargos
$cargos = [
    [
        'id' => 1,
        'nome' => 'Motorista de Carreta',
        'nivel' => 'Operacional',
        'departamento' => 'Operacional',
        'descricao' => 'Responsável pela condução de veículos de carga pesada, garantindo a entrega de mercadorias conforme rotas estabelecidas.',
        'requisitos' => 'CNH E, curso MOPP, experiência mínima de 2 anos',
        'vagas_ocupadas' => 18,
        'vagas_total' => 20
    ],
    [
        'id' => 2,
        'nome' => 'Analista de RH',
        'nivel' => 'Tático',
        'departamento' => 'Recursos Humanos',
        'descricao' => 'Responsável pelos processos de recrutamento, seleção e rotinas de RH.',
        'requisitos' => 'Ensino superior em Administração, Psicologia ou áreas afins',
        'vagas_ocupadas' => 3,
        'vagas_total' => 4
    ],
    [
        'id' => 3,
        'nome' => 'Gerente de Logística',
        'nivel' => 'Tático',
        'departamento' => 'Operacional',
        'descricao' => 'Responsável pela coordenação da equipe de logística e operações',
        'requisitos' => 'Superior completo em Logística ou Engenharia, experiência mínima de 5 anos',
        'vagas_ocupadas' => 2,
        'vagas_total' => 2
    ],
    [
        'id' => 4,
        'nome' => 'Diretor Operacional',
        'nivel' => 'Estratégico',
        'departamento' => 'Operacional',
        'descricao' => 'Responsável pelo planejamento estratégico e gestão de todas as operações da empresa',
        'requisitos' => 'Pós-graduação em Gestão, experiência mínima de 8 anos em cargos de liderança',
        'vagas_ocupadas' => 1,
        'vagas_total' => 1
    ],
    [
        'id' => 5,
        'nome' => 'Auxiliar Administrativo',
        'nivel' => 'Operacional',
        'departamento' => 'Administrativo',
        'descricao' => 'Responsável pelo suporte às atividades administrativas e controles internos',
        'requisitos' => 'Ensino médio completo, conhecimentos em informática',
        'vagas_ocupadas' => 5,
        'vagas_total' => 6
    ],
    [
        'id' => 6,
        'nome' => 'Analista Financeiro',
        'nivel' => 'Tático',
        'departamento' => 'Financeiro',
        'descricao' => 'Responsável pela análise financeira, contas a pagar e receber',
        'requisitos' => 'Superior em Ciências Contábeis, Administração ou Economia',
        'vagas_ocupadas' => 2,
        'vagas_total' => 3
    ]
];

// Mock data - Níveis
$niveis = [
    ['id' => 1, 'nome' => 'Estratégico'],
    ['id' => 2, 'nome' => 'Tático'],
    ['id' => 3, 'nome' => 'Operacional']
];

// Mock data - Departamentos
$departamentos = [
    ['id' => 1, 'nome' => 'Operacional'],
    ['id' => 2, 'nome' => 'Administrativo'],
    ['id' => 3, 'nome' => 'Recursos Humanos'],
    ['id' => 4, 'nome' => 'Financeiro'],
    ['id' => 5, 'nome' => 'Comercial'],
    ['id' => 6, 'nome' => 'Tecnologia']
];

// Layout content
$content = ob_get_clean();
ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Cargos e Posições</h1>
            <p class="text-muted mb-0">Gestão da Estrutura de Cargos</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novoCargo">
                <i class="fas fa-plus me-2"></i>Novo Cargo
            </button>
            <button class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i>Exportar
            </button>
        </div>
    </div>

    <!-- Tabs para gerenciar os diferentes aspectos -->
    <ul class="nav nav-tabs mb-4" id="cargosTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="cargos-tab" data-bs-toggle="tab" data-bs-target="#cargos-content" type="button" role="tab">
                <i class="fas fa-id-badge me-2"></i>Cargos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="posicoes-tab" data-bs-toggle="tab" data-bs-target="#posicoes-content" type="button" role="tab">
                <i class="fas fa-sitemap me-2"></i>Posições
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#historico-content" type="button" role="tab">
                <i class="fas fa-history me-2"></i>Histórico
            </button>
        </li>
    </ul>

    <div class="tab-content" id="cargosTabsContent">
        <!-- Tab de Cargos -->
        <div class="tab-pane fade show active" id="cargos-content" role="tabpanel">
            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-3" id="filtroCargosForm">
                        <div class="col-md-3">
                            <label class="form-label">Buscar Cargo</label>
                            <input type="text" class="form-control" id="searchCargo" placeholder="Nome do cargo...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Departamento</label>
                            <select class="form-select" id="departamentoFilter">
                                <option value="">Todos</option>
                                <?php foreach ($departamentos as $departamento): ?>
                                <option value="<?php echo $departamento['id']; ?>"><?php echo $departamento['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nível</label>
                            <select class="form-select" id="nivelFilter">
                                <option value="">Todos</option>
                                <?php foreach ($niveis as $nivel): ?>
                                <option value="<?php echo $nivel['id']; ?>"><?php echo $nivel['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Cargos -->
            <div class="row g-4">
                <?php foreach ($cargos as $cargo): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><?php echo htmlspecialchars($cargo['nome']); ?></h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editarCargo<?php echo $cargo['id']; ?>">
                                        <i class="fas fa-edit me-2 text-primary"></i>Editar
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#verPosicoes<?php echo $cargo['id']; ?>">
                                        <i class="fas fa-sitemap me-2 text-info"></i>Ver Posições
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#">
                                        <i class="fas fa-trash-alt me-2"></i>Excluir
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <span class="badge bg-primary me-2"><?php echo $cargo['nivel']; ?></span>
                                <span class="badge bg-secondary"><?php echo $cargo['departamento']; ?></span>
                            </div>
                            
                            <p class="card-text"><?php echo htmlspecialchars($cargo['descricao']); ?></p>
                            
                            <div class="mt-3">
                                <h6 class="small fw-bold">Requisitos</h6>
                                <p class="small text-muted"><?php echo htmlspecialchars($cargo['requisitos']); ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Ocupação:</small>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px; width: 100px;">
                                            <?php 
                                            $porcentagem = ($cargo['vagas_ocupadas'] / $cargo['vagas_total']) * 100;
                                            $barColor = $porcentagem >= 90 ? 'bg-danger' : ($porcentagem >= 70 ? 'bg-warning' : 'bg-success');
                                            ?>
                                            <div class="progress-bar <?php echo $barColor; ?>" role="progressbar" 
                                                 style="width: <?php echo $porcentagem; ?>%" 
                                                 aria-valuenow="<?php echo $porcentagem; ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <span class="small">
                                            <?php echo $cargo['vagas_ocupadas']; ?>/<?php echo $cargo['vagas_total']; ?>
                                        </span>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#verPosicoes<?php echo $cargo['id']; ?>">
                                    Ver Posições
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab de Posições -->
        <div class="tab-pane fade" id="posicoes-content" role="tabpanel">
            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-3" id="filtroPosicaoForm">
                        <div class="col-md-3">
                            <label class="form-label">Cargo</label>
                            <select class="form-select" id="cargoFilter">
                                <option value="">Todos</option>
                                <?php foreach ($cargos as $cargo): ?>
                                <option value="<?php echo $cargo['id']; ?>"><?php echo $cargo['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="statusFilter">
                                <option value="">Todos</option>
                                <option value="1">Ocupado</option>
                                <option value="0">Disponível</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Unidade</label>
                            <select class="form-select" id="unidadeFilter">
                                <option value="">Todas</option>
                                <option>Matriz - Vitória/ES</option>
                                <option>Filial Serra/ES</option>
                                <option>Filial Vila Velha/ES</option>
                                <option>Filial Cariacica/ES</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumo das Posições -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-success-lighter p-3 me-3">
                                <i class="fas fa-layer-group text-success fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Total de Posições</h6>
                                <h3 class="mb-0">36</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-primary-lighter p-3 me-3">
                                <i class="fas fa-user-check text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Posições Ocupadas</h6>
                                <h3 class="mb-0">31</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning-lighter p-3 me-3">
                                <i class="fas fa-user-plus text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Posições Disponíveis</h6>
                                <h3 class="mb-0">5</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-info-lighter p-3 me-3">
                                <i class="fas fa-building text-info fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">Unidades com Vagas</h6>
                                <h3 class="mb-0">3</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Posições -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>CARGO</th>
                                    <th>UNIDADE</th>
                                    <th>OCUPADA POR</th>
                                    <th>STATUS</th>
                                    <th>ÚLTIMA ATUALIZAÇÃO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P001</td>
                                    <td>Motorista de Carreta</td>
                                    <td>Matriz - Vitória/ES</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="initials-avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center" style="background-color: #3498db;">
                                                <span class="initials-sm">JS</span>
                                            </div>
                                            <span>João Silva</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success rounded-pill">Ocupada</span></td>
                                    <td>15/02/2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detalhes
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-edit me-2 text-info"></i>Alterar Ocupante
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-times me-2"></i>Desativar Posição
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P002</td>
                                    <td>Analista de RH</td>
                                    <td>Matriz - Vitória/ES</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="initials-avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center" style="background-color: #e74c3c;">
                                                <span class="initials-sm">MS</span>
                                            </div>
                                            <span>Maria Santos</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success rounded-pill">Ocupada</span></td>
                                    <td>10/01/2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detalhes
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-edit me-2 text-info"></i>Alterar Ocupante
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-times me-2"></i>Desativar Posição
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P003</td>
                                    <td>Analista de RH</td>
                                    <td>Filial Serra/ES</td>
                                    <td class="text-muted">Não ocupada</td>
                                    <td><span class="badge bg-warning rounded-pill">Disponível</span></td>
                                    <td>05/03/2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detalhes
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-plus me-2 text-success"></i>Designar Ocupante
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-times me-2"></i>Desativar Posição
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P004</td>
                                    <td>Gerente de Logística</td>
                                    <td>Matriz - Vitória/ES</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="initials-avatar-sm rounded-circle me-2 d-flex align-items-center justify-content-center" style="background-color: #2ecc71;">
                                                <span class="initials-sm">PC</span>
                                            </div>
                                            <span>Paulo Costa</span>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success rounded-pill">Ocupada</span></td>
                                    <td>08/02/2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detalhes
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-edit me-2 text-info"></i>Alterar Ocupante
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-times me-2"></i>Desativar Posição
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>P005</td>
                                    <td>Auxiliar Administrativo</td>
                                    <td>Filial Vila Velha/ES</td>
                                    <td class="text-muted">Não ocupada</td>
                                    <td><span class="badge bg-warning rounded-pill">Disponível</span></td>
                                    <td>12/03/2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-link" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye me-2 text-primary"></i>Detalhes
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-plus me-2 text-success"></i>Designar Ocupante
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-times me-2"></i>Desativar Posição
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab de Histórico -->
        <div class="tab-pane fade" id="historico-content" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Histórico de Movimentações</h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" placeholder="Buscar...">
                            <select class="form-select form-select-sm" style="width: 150px;">
                                <option value="">Todos os Tipos</option>
                                <option>Criação</option>
                                <option>Atualização</option>
                                <option>Ocupação</option>
                                <option>Desocupação</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="timeline-heading">
                                    <h6 class="mb-0">Posição Ocupada</h6>
                                    <small class="text-muted">12/03/2024 - 14:33</small>
                                </div>
                                <div class="timeline-body">
                                    <p>
                                        <strong>P003 - Analista de RH (Filial Serra/ES)</strong> designada para
                                        <span class="badge bg-light text-dark">Maria Oliveira</span>
                                    </p>
                                    <small class="text-muted">Realizado por: Admin</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <div class="timeline-heading">
                                    <h6 class="mb-0">Nova Posição Criada</h6>
                                    <small class="text-muted">10/03/2024 - 09:15</small>
                                </div>
                                <div class="timeline-body">
                                    <p>
                                        <strong>P005 - Auxiliar Administrativo (Filial Vila Velha/ES)</strong> foi criada.
                                    </p>
                                    <small class="text-muted">Realizado por: Admin</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <div class="timeline-heading">
                                    <h6 class="mb-0">Cargo Atualizado</h6>
                                    <small class="text-muted">05/03/2024 - 11:42</small>
                                </div>
                                <div class="timeline-body">
                                    <p>
                                        <strong>Analista de RH</strong> teve sua descrição e requisitos atualizados.
                                    </p>
                                    <small class="text-muted">Realizado por: Admin</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="timeline-heading">
                                    <h6 class="mb-0">Posição Ocupada</h6>
                                    <small class="text-muted">15/02/2024 - 10:23</small>
                                </div>
                                <div class="timeline-body">
                                    <p>
                                        <strong>P001 - Motorista de Carreta (Matriz)</strong> designada para
                                        <span class="badge bg-light text-dark">João Silva</span>
                                    </p>
                                    <small class="text-muted">Realizado por: Admin</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional para Timeline -->
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    padding-bottom: 25px;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-marker {
    position: absolute;
    left: -30px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    margin-top: 6px;
}
.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: -23px;
    top: 24px;
    width: 2px;
    height: calc(100% - 24px);
    background-color: #e9ecef;
}
.timeline-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.timeline-body {
    background-color: #f8f9fa;
    padding: 12px;
    border-radius: 4px;
}
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 