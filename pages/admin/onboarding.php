<?php
$pageTitle = 'Onboarding';
require_once '../config/dashboard.php';

ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Onboarding</h1>
            <p class="text-muted mb-0">Processo de Integração</p>
        </div>
        <?php if (hasPermission('onboarding', 'create')): ?>
        <button class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Novo Onboarding
        </button>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Onboarding List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Processos de Integração</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Colaborador</th>
                                    <th>Cargo</th>
                                    <th>Status</th>
                                    <th>Progresso</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dashboardData['onboarding']['pendentes'] as $onboarding): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/32" class="rounded-circle me-2" alt="Avatar">
                                            <div>
                                                <div class="fw-medium"><?php echo htmlspecialchars($onboarding['nome']); ?></div>
                                                <small class="text-muted">Matrícula: <?php echo htmlspecialchars($onboarding['matricula']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($onboarding['cargo']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $onboarding['status']; ?>">
                                            <?php echo htmlspecialchars($onboarding['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-<?php echo $onboarding['status']; ?>" 
                                                 role="progressbar" 
                                                 style="width: <?php echo $onboarding['progresso']; ?>%"
                                                 aria-valuenow="<?php echo $onboarding['progresso']; ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo $onboarding['progresso']; ?>%</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" title="Ver detalhes">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if (hasPermission('onboarding', 'edit')): ?>
                                        <button class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
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

        <!-- Onboarding Details Panel -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Detalhes do Processo</h5>
                </div>
                <div class="card-body">
                    <!-- Employee Info -->
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="Avatar">
                            <?php if (hasPermission('onboarding', 'edit')): ?>
                            <button class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle p-1">
                                <i class="bi bi-camera"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                        <h5 class="mb-1">João da Silva</h5>
                        <p class="text-muted mb-0">Motorista de Carreta</p>
                        <small class="text-muted">Matrícula: 12345</small>
                    </div>

                    <!-- Checklist Section -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Checklist de Integração</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check1" checked>
                                    <label class="form-check-label" for="check1">
                                        Contrato assinado
                                    </label>
                                </div>
                                <small class="text-success">Concluído em 20/03/2024</small>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check2" checked>
                                    <label class="form-check-label" for="check2">
                                        Documentos pessoais
                                    </label>
                                </div>
                                <small class="text-success">Concluído em 19/03/2024</small>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check3">
                                    <label class="form-check-label" for="check3">
                                        Treinamento inicial
                                    </label>
                                </div>
                                <small class="text-warning">Agendado para 25/03/2024</small>
                            </div>
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check4">
                                    <label class="form-check-label" for="check4">
                                        Acesso aos sistemas
                                    </label>
                                </div>
                                <small class="text-danger">Pendente</small>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Documentos Pendentes</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                        RG
                                    </div>
                                    <span class="badge bg-warning">Pendente</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                        CTPS
                                    </div>
                                    <span class="badge bg-warning">Pendente</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                        Declaração de Escolaridade
                                    </div>
                                    <span class="badge bg-warning">Pendente</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <?php if (hasPermission('onboarding', 'edit')): ?>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-upload me-2"></i>Enviar Documentos
                        </button>
                        <button class="btn btn-success">
                            <i class="bi bi-check-lg me-2"></i>Finalizar Onboarding
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 