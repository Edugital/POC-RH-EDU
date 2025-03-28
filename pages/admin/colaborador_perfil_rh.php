<?php
$pageTitle = 'Perfil do Colaborador';
require_once 'admin_check.php';

// Função para gerar iniciais do nome
function getInitials($name) {
    $words = explode(' ', $name);
    if (count($words) >= 2) {
        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
    }
    return mb_strtoupper(mb_substr($name, 0, 2));
}

// Função para gerar cor baseada no nome
function getColorFromName($name) {
    $colors = [
        '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
        '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
        '#f1c40f', '#e67e22', '#e74c3c', '#95a5a6', '#f39c12',
        '#d35400', '#c0392b', '#7f8c8d'
    ];
    return $colors[abs(crc32($name)) % count($colors)];
}

// Mock data for demonstration - In production, this would come from a database
$colaborador = [
    'id' => '001',
    'nome' => 'Ana Silva',
    'cargo' => 'Motorista de Carreta',
    'departamento' => 'Operacional',
    'filial' => 'Vitória/ES',
    'unidade_id' => 1,
    'status' => 'Ativo',
    'data_admissao' => '2022-03-15',
    'email' => 'ana.silva@empresa.com',
    'telefone' => '(27) 99999-1111',
    'cpf' => '123.456.789-00',
    'rg' => '1234567-ES',
    'data_nascimento' => '1990-05-15',
    'estado_civil' => 'Solteiro(a)',
    'endereco' => 'Rua das Flores, 123 - Centro, Vitória/ES',
    'posicao' => [
        'id' => 'P001',
        'cargo_id' => 1,
        'nivel' => 'Operacional',
        'departamento_id' => 1,
        'unidade_id' => 1,
        'data_alocacao' => '2022-03-15',
        'gestor' => 'Carlos Mendes',
        'gestor_id' => '003'
    ],
    'historico' => [
        [
            'tipo' => 'Promoção',
            'data' => '2023-06-15',
            'descricao' => 'Promovido para Motorista de Carreta Sênior',
            'cargo_anterior' => 'Motorista de Carreta',
            'cargo_novo' => 'Motorista de Carreta Sênior',
            'detalhes' => 'Avaliação de desempenho: 4.8/5.0'
        ],
        [
            'tipo' => 'Treinamento',
            'data' => '2023-03-10',
            'descricao' => 'Conclusão do curso de Direção Defensiva',
            'detalhes' => 'Nota final: 95/100'
        ],
        [
            'tipo' => 'Admissão',
            'data' => '2022-03-15',
            'descricao' => 'Contratação como Motorista de Carreta',
            'detalhes' => 'Processo seletivo concluído com sucesso'
        ]
    ],
    'documentos' => [
        [
            'nome' => 'CNH',
            'status' => 'Atualizado',
            'validade' => '2025-12-31'
        ],
        [
            'nome' => 'Carteira de Trabalho Digital',
            'status' => 'Atualizado',
            'validade' => null
        ],
        [
            'nome' => 'Certificado de Curso MOPP',
            'status' => 'Pendente',
            'validade' => '2023-12-31'
        ]
    ],
    'equipe' => [
        ['nome' => 'José Santos', 'cargo' => 'Motorista de Carreta', 'id' => '002'],
        ['nome' => 'Maria Oliveira', 'cargo' => 'Motorista de Carreta', 'id' => '005'],
        ['nome' => 'Pedro Costa', 'cargo' => 'Motorista de Carreta', 'id' => '008']
    ]
];

// Layout content
$content = ob_get_clean();
ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Perfil do Colaborador</h1>
            <p class="text-muted mb-0">Informações Detalhadas e Vínculos Organizacionais</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarPosicaoModal">
                <i class="fas fa-sitemap me-2"></i>Alterar Posição
            </button>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Coluna da Esquerda -->
        <div class="col-md-4">
            <!-- Card do Perfil -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <?php if (isset($colaborador['foto']) && $colaborador['foto']): ?>
                            <img src="<?php echo htmlspecialchars($colaborador['foto']); ?>" 
                                 class="rounded-circle profile-image" 
                                 alt="Foto do Colaborador">
                        <?php else: ?>
                            <div class="initials-avatar rounded-circle profile-image d-flex align-items-center justify-content-center"
                                 style="background-color: <?php echo getColorFromName($colaborador['nome']); ?>">
                                <span class="initials"><?php echo getInitials($colaborador['nome']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h4 class="mb-1"><?php echo htmlspecialchars($colaborador['nome']); ?></h4>
                    <p class="text-muted mb-2"><?php echo htmlspecialchars($colaborador['cargo']); ?></p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge bg-primary">ID: <?php echo htmlspecialchars($colaborador['id']); ?></span>
                        <span class="badge bg-info"><?php echo htmlspecialchars($colaborador['filial']); ?></span>
                        <span class="badge bg-success"><?php echo htmlspecialchars($colaborador['status']); ?></span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="mailto:<?php echo htmlspecialchars($colaborador['email']); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-envelope me-2"></i>Enviar Email
                        </a>
                        <a href="tel:<?php echo htmlspecialchars($colaborador['telefone']); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-phone me-2"></i>Ligar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Posição Organizacional -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Posição Organizacional</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-light p-2 rounded">
                                <i class="fas fa-id-badge text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="small text-muted">Cargo</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($colaborador['cargo']); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-light p-2 rounded">
                                <i class="fas fa-layer-group text-success fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="small text-muted">Departamento</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($colaborador['departamento']); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-light p-2 rounded">
                                <i class="fas fa-building text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="small text-muted">Unidade</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($colaborador['filial']); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="bg-light p-2 rounded">
                                <i class="fas fa-user-tie text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="small text-muted">Gestor</div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($colaborador['posicao']['gestor']); ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light p-2 rounded">
                                <i class="fas fa-calendar-check text-danger fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <div class="small text-muted">Admissão</div>
                            <div class="fw-semibold"><?php echo date('d/m/Y', strtotime($colaborador['data_admissao'])); ?></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#estruturaModal">
                        <i class="fas fa-sitemap me-2"></i>Ver Estrutura Completa
                    </a>
                </div>
            </div>

            <!-- Acesso Rápido aos Módulos -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Acesso Rápido</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-graduation-cap me-2"></i>Treinamentos</span>
                            <span class="badge bg-primary rounded-pill">2</span>
                        </a>
                        <a href="#" class="btn btn-outline-success d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-clipboard-check me-2"></i>Onboarding</span>
                            <span class="badge bg-success rounded-pill">100%</span>
                        </a>
                        <a href="#" class="btn btn-outline-info d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-chart-line me-2"></i>Desempenho</span>
                            <span class="badge bg-info rounded-pill">4.8</span>
                        </a>
                        <a href="#" class="btn btn-outline-warning d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-file-alt me-2"></i>Documentos</span>
                            <span class="badge bg-warning rounded-pill">3</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna do Centro/Direita -->
        <div class="col-md-8">
            <!-- Tabs de Informações -->
            <div class="card mb-4">
                <div class="card-header bg-white p-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-info" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Informações
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-historico" type="button" role="tab">
                                <i class="fas fa-history me-2"></i>Histórico
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-documentos" type="button" role="tab">
                                <i class="fas fa-file-alt me-2"></i>Documentos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-equipe" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>Equipe
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Informações Pessoais -->
                        <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                            <h5 class="fw-bold mb-3">Informações Pessoais</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Nome Completo</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['nome']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Email</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['email']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">CPF</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['cpf']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">RG</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['rg']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Data de Nascimento</label>
                                    <p class="mb-0"><?php echo date('d/m/Y', strtotime($colaborador['data_nascimento'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Estado Civil</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['estado_civil']); ?></p>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted">Endereço</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['endereco']); ?></p>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h5 class="fw-bold mb-3">Dados Profissionais</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">ID da Posição</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['posicao']['id']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Nível</label>
                                    <p class="mb-0"><?php echo htmlspecialchars($colaborador['posicao']['nivel']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Data de Admissão</label>
                                    <p class="mb-0"><?php echo date('d/m/Y', strtotime($colaborador['data_admissao'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Status</label>
                                    <p class="mb-0">
                                        <span class="badge bg-success"><?php echo htmlspecialchars($colaborador['status']); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Histórico -->
                        <div class="tab-pane fade" id="tab-historico" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Histórico Profissional</h5>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus me-2"></i>Adicionar Registro
                                    </button>
                                </div>
                            </div>
                            
                            <div class="timeline">
                                <?php foreach ($colaborador['historico'] as $item): ?>
                                <div class="timeline-item">
                                    <?php 
                                    $markerClass = 'bg-info';
                                    if ($item['tipo'] == 'Promoção') $markerClass = 'bg-success';
                                    elseif ($item['tipo'] == 'Admissão') $markerClass = 'bg-primary';
                                    ?>
                                    <div class="timeline-marker <?php echo $markerClass; ?>"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-heading">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($item['tipo']); ?></h6>
                                            <small class="text-muted"><?php echo date('d/m/Y', strtotime($item['data'])); ?></small>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="mb-1"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                            <?php if (isset($item['cargo_anterior']) && isset($item['cargo_novo'])): ?>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-light text-dark me-2"><?php echo htmlspecialchars($item['cargo_anterior']); ?></span>
                                                <i class="fas fa-arrow-right text-muted mx-2"></i>
                                                <span class="badge bg-success"><?php echo htmlspecialchars($item['cargo_novo']); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <small class="text-muted"><?php echo htmlspecialchars($item['detalhes']); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Documentos -->
                        <div class="tab-pane fade" id="tab-documentos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Documentos</h5>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-upload me-2"></i>Upload
                                    </button>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>DOCUMENTO</th>
                                            <th>STATUS</th>
                                            <th>VALIDADE</th>
                                            <th>AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($colaborador['documentos'] as $documento): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($documento['nome']); ?></td>
                                            <td>
                                                <?php if ($documento['status'] == 'Atualizado'): ?>
                                                <span class="badge bg-success">Atualizado</span>
                                                <?php elseif ($documento['status'] == 'Pendente'): ?>
                                                <span class="badge bg-warning">Pendente</span>
                                                <?php else: ?>
                                                <span class="badge bg-danger">Expirado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($documento['validade']): ?>
                                                <?php echo date('d/m/Y', strtotime($documento['validade'])); ?>
                                                <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-link" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-link" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Equipe -->
                        <div class="tab-pane fade" id="tab-equipe" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Colegas de Equipe</h5>
                                <div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-users me-2"></i>Ver Organograma
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <?php foreach ($colaborador['equipe'] as $membro): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="initials-avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                                         style="background-color: <?php echo getColorFromName($membro['nome']); ?>">
                                                        <span class="initials-sm"><?php echo getInitials($membro['nome']); ?></span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0"><?php echo htmlspecialchars($membro['nome']); ?></h6>
                                                    <small class="text-muted"><?php echo htmlspecialchars($membro['cargo']); ?></small>
                                                </div>
                                                <a href="colaborador_perfil_rh.php?id=<?php echo $membro['id']; ?>" class="btn btn-sm btn-link">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desempenho e Métricas -->
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Desempenho e Vínculo Organizacional</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Relatório Completo</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Histórico de Avaliações</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Tempo na Empresa -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center h-100">
                                <div class="display-4 mb-2">1.2</div>
                                <p class="mb-0">Anos na Empresa</p>
                            </div>
                        </div>
                        
                        <!-- Avaliação Geral -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center h-100">
                                <div class="display-4 mb-2">4.8</div>
                                <p class="mb-0">Avaliação Geral</p>
                                <div class="mt-2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Treinamentos Concluídos -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded text-center h-100">
                                <div class="display-4 mb-2">2</div>
                                <p class="mb-0">Treinamentos</p>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal da Estrutura Organizacional -->
<div class="modal fade" id="estruturaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estrutura Organizacional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="../../assets/img/organizational-chart-demo.png" class="img-fluid" alt="Estrutura Organizacional" style="max-height: 400px;">
                </div>
                
                <h6 class="mb-3">Hierarquia</h6>
                <div class="org-hierarchy mb-4">
                    <div class="d-flex align-items-center p-3 border rounded mb-2">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-2">
                                <i class="fas fa-building fa-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Diretoria Operacional</h6>
                            <small class="text-muted">Diretor: Roberto Santos</small>
                        </div>
                    </div>
                    <div class="ms-4">
                        <div class="d-flex align-items-center p-3 border rounded mb-2">
                            <div class="flex-shrink-0">
                                <div class="bg-light rounded p-2">
                                    <i class="fas fa-sitemap fa-lg text-info"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Gerência de Logística</h6>
                                <small class="text-muted">Gerente: Carlos Mendes</small>
                            </div>
                        </div>
                        <div class="ms-4">
                            <div class="d-flex align-items-center p-3 border rounded mb-2 bg-light">
                                <div class="flex-shrink-0">
                                    <div class="bg-white rounded p-2">
                                        <i class="fas fa-truck fa-lg text-warning"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Motorista de Carreta</h6>
                                    <small class="text-primary">Ana Silva (você está aqui)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-sitemap me-2"></i>Ver Organograma Completo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS Adicional -->
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
.profile-image {
    width: 120px;
    height: 120px;
    font-size: 2.5rem;
}
.initials-avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 1rem;
}
.bg-primary-lighter { background-color: rgba(13, 110, 253, 0.1); }
.bg-success-lighter { background-color: rgba(25, 135, 84, 0.1); }
.bg-warning-lighter { background-color: rgba(255, 193, 7, 0.1); }
.bg-info-lighter { background-color: rgba(13, 202, 240, 0.1); }
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 