<?php
$pageTitle = 'Perfil do Colaborador';
require_once '../config/dashboard.php';
require_once '../includes/auth.php';

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
    'status' => 'Ativo',
    'data_admissao' => '2022-03-15',
    'email' => 'ana.silva@empresa.com',
    'telefone' => '(27) 99999-1111',
    'cpf' => '123.456.789-00',
    'rg' => '1234567-ES',
    'data_nascimento' => '1990-05-15',
    'estado_civil' => 'Solteiro(a)',
    'endereco' => 'Rua das Flores, 123 - Centro, Vitória/ES',
    'historico' => [
        [
            'tipo' => 'Promoção',
            'data' => '2023-06-15',
            'descricao' => 'Promovido para Motorista de Carreta Sênior',
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
    ]
];

ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Perfil do Colaborador</h1>
            <p class="text-muted mb-0">Informações e Histórico</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (hasPermission('colaborador', 'edit')): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                <i class="fas fa-pencil-alt me-2"></i>Editar Perfil
            </button>
            <?php endif; ?>
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
                        <?php if (hasPermission('colaborador', 'edit')): ?>
                        <button class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle p-2"
                                title="Alterar foto">
                            <i class="fas fa-camera"></i>
                        </button>
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

            <!-- Estatísticas Rápidas -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Estatísticas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h6 class="mb-1">1.2</h6>
                                <small class="text-muted">Anos na Empresa</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h6 class="mb-1">1</h6>
                                <small class="text-muted">Promoções</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h6 class="mb-1">2</h6>
                                <small class="text-muted">Treinamentos</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded text-center">
                                <h6 class="mb-1">4.8</h6>
                                <small class="text-muted">Avaliação</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna da Direita -->
        <div class="col-md-8">
            <!-- Informações Pessoais -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Informações Pessoais</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
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
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <p class="mb-0"><?php echo htmlspecialchars($colaborador['email']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Telefone</label>
                            <p class="mb-0"><?php echo htmlspecialchars($colaborador['telefone']); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Endereço</label>
                            <p class="mb-0"><?php echo htmlspecialchars($colaborador['endereco']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histórico -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Histórico na Empresa</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <?php foreach ($colaborador['historico'] as $evento): ?>
                        <div class="timeline-item">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0"><?php echo htmlspecialchars($evento['tipo']); ?></h6>
                                <small class="text-muted"><?php echo date('d/m/Y', strtotime($evento['data'])); ?></small>
                            </div>
                            <p class="mb-1"><?php echo htmlspecialchars($evento['descricao']); ?></p>
                            <small class="text-muted"><?php echo htmlspecialchars($evento['detalhes']); ?></small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Documentos -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Documentos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Status</th>
                                    <th>Validade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($colaborador['documentos'] as $documento): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($documento['nome']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $documento['status'] === 'Atualizado' ? 'success' : 'warning'; ?>">
                                            <?php echo htmlspecialchars($documento['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $documento['validade'] ? date('d/m/Y', strtotime($documento['validade'])) : 'N/A'; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <?php if (hasPermission('colaborador', 'edit')): ?>
                                        <button class="btn btn-sm btn-outline-warning" title="Atualizar">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 1.5rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item::after {
    content: '';
    position: absolute;
    left: -1.75rem;
    top: 0.25rem;
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 50%;
    background-color: #0d6efd;
}

.card-body img.rounded-circle {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.badge {
    padding: 0.5em 0.8em;
}

.profile-image {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.initials-avatar {
    width: 150px;
    height: 150px;
    color: white;
    font-size: 3rem;
    font-weight: 500;
}

.initials {
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

@media print {
    .btn, .btn-group {
        display: none !important;
    }
}
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 