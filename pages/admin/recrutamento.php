<?php
$pageTitle = 'Recrutamento';
require_once '../config/dashboard.php';

ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Recrutamento</h1>
            <p class="text-muted mb-0">Gerencie vagas e candidatos</p>
        </div>
        <?php if (hasPermission('recrutamento', 'create')): ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novaVagaModal">
            <i class="bi bi-plus-lg me-2"></i>Nova Vaga
        </button>
        <?php endif; ?>
    </div>

    <!-- Pipeline Visual -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">Pipeline de Candidatos</h5>
        </div>
        <div class="card-body">
            <div class="pipeline-container">
                <div class="pipeline-column" data-stage="novos">
                    <div class="pipeline-header">
                        <h6>Novos</h6>
                        <span class="badge bg-secondary">3</span>
                    </div>
                    <div class="pipeline-content" id="novos">
                        <!-- Candidate Cards will be dynamically added here -->
                    </div>
                </div>
                <div class="pipeline-column" data-stage="triagem">
                    <div class="pipeline-header">
                        <h6>Triagem</h6>
                        <span class="badge bg-secondary">2</span>
                    </div>
                    <div class="pipeline-content" id="triagem">
                        <!-- Candidate Cards will be dynamically added here -->
                    </div>
                </div>
                <div class="pipeline-column" data-stage="entrevista">
                    <div class="pipeline-header">
                        <h6>Entrevista</h6>
                        <span class="badge bg-secondary">1</span>
                    </div>
                    <div class="pipeline-content" id="entrevista">
                        <!-- Candidate Cards will be dynamically added here -->
                    </div>
                </div>
                <div class="pipeline-column" data-stage="aprovacao">
                    <div class="pipeline-header">
                        <h6>Aprovação</h6>
                        <span class="badge bg-secondary">1</span>
                    </div>
                    <div class="pipeline-content" id="aprovacao">
                        <!-- Candidate Cards will be dynamically added here -->
                    </div>
                </div>
                <div class="pipeline-column" data-stage="contratacao">
                    <div class="pipeline-header">
                        <h6>Contratação</h6>
                        <span class="badge bg-secondary">0</span>
                    </div>
                    <div class="pipeline-content" id="contratacao">
                        <!-- Candidate Cards will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#novaVagaModal">
                                <i class="bi bi-plus-lg me-2"></i>Nova Vaga
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="candidatos.php" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people me-2"></i>Ver Candidatos
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="entrevistas.php" class="btn btn-outline-primary w-100">
                                <i class="bi bi-calendar-check me-2"></i>Entrevistas
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="relatorios.php" class="btn btn-outline-primary w-100">
                                <i class="bi bi-file-earmark-text me-2"></i>Relatórios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Vagas Ativas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>RP</th>
                                    <th>Cargo</th>
                                    <th>Status</th>
                                    <th>Candidatos</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dashboardData['recrutamento']['vagas_ativas'] as $vaga): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($vaga['id']); ?></td>
                                    <td><?php echo htmlspecialchars($vaga['cargo']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $vaga['status'] === 'Aguardando Aprovação' ? 'warning' : 'info'; ?>">
                                            <?php echo htmlspecialchars($vaga['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?php echo $vaga['candidatos']; ?> candidatos</span>
                                        <span class="text-success ms-2"><?php echo $vaga['aprovados']; ?> aprovados</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" title="Ver candidatos">
                                            <i class="bi bi-people"></i>
                                        </button>
                                        <?php if (hasPermission('recrutamento', 'edit')): ?>
                                        <button class="btn btn-sm btn-outline-warning me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <?php endif; ?>
                                        <?php if (hasPermission('recrutamento', 'delete')): ?>
                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
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

        <!-- Candidate Details Panel -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Detalhes do Candidato</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://via.placeholder.com/100" class="rounded-circle mb-3" alt="Avatar">
                            <?php if (hasPermission('recrutamento', 'edit')): ?>
                            <button class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle p-1">
                                <i class="bi bi-camera"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                        <h5 class="mb-1">João da Silva</h5>
                        <p class="text-muted mb-0">Candidato para Motorista de Carreta</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Informações Pessoais</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted d-block">CPF</small>
                                <span>123.456.789-00</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">RG</small>
                                <span>12.345.678-9</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Data de Nascimento</small>
                                <span>01/01/1980</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Estado Civil</small>
                                <span>Casado(a)</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Contato</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <small class="text-muted d-block">E-mail</small>
                                <span>joao.silva@email.com</span>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Telefone</small>
                                <span>(27) 99999-9999</span>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Endereço</small>
                                <span>Rua das Flores, 123 - Vitória/ES</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Experiência</h6>
                        <div class="timeline">
                            <div class="timeline-item">
                                <small class="text-muted">2020 - Presente</small>
                                <p class="mb-1">Motorista de Carreta - Transportadora XYZ</p>
                            </div>
                            <div class="timeline-item">
                                <small class="text-muted">2015 - 2020</small>
                                <p class="mb-1">Motorista de Caminhão - Empresa ABC</p>
                            </div>
                        </div>
                    </div>

                    <?php if (hasPermission('recrutamento', 'edit')): ?>
                    <div class="d-grid gap-2">
                        <div class="btn-group w-100">
                            <button class="btn btn-success" data-bs-toggle="tooltip" title="Aprovar candidato">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button class="btn btn-warning" data-bs-toggle="tooltip" title="Agendar entrevista">
                                <i class="bi bi-calendar"></i>
                            </button>
                            <button class="btn btn-info" data-bs-toggle="tooltip" title="Enviar e-mail">
                                <i class="bi bi-envelope"></i>
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="tooltip" title="Reprovar candidato">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
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
    padding-bottom: 1rem;
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

.btn-group .btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toast {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1050;
}

.pipeline-container {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding: 1rem 0;
    min-height: 300px;
}

.pipeline-column {
    flex: 1;
    min-width: 280px;
    background: #f8f9fa;
    border-radius: 0.5rem;
    display: flex;
    flex-direction: column;
}

.pipeline-header {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pipeline-content {
    padding: 1rem;
    flex: 1;
    min-height: 200px;
}

.candidate-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 0.5rem;
    cursor: move;
    transition: all 0.2s ease;
}

.candidate-card:hover {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.candidate-card.dragging {
    opacity: 0.5;
    transform: scale(1.02);
}

.pipeline-column.drag-over {
    background: #e9ecef;
    border: 2px dashed #0d6efd;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Initialize modal
    const novaVagaModal = new bootstrap.Modal(document.getElementById('novaVagaModal'), {
        keyboard: false
    });

    // Add click handler for Nova Vaga button
    document.querySelector('[data-bs-target="#novaVagaModal"]').addEventListener('click', function(e) {
        e.preventDefault();
        novaVagaModal.show();
    });

    // Quick action handlers
    document.querySelectorAll('.btn-group .btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.getAttribute('data-bs-toggle');
            const candidateId = '123'; // This should come from your data
            
            switch(action) {
                case 'approve':
                    if(confirm('Deseja aprovar este candidato?')) {
                        // API call would go here
                        showNotification('Candidato aprovado com sucesso!', 'success');
                    }
                    break;
                case 'schedule':
                    // Show scheduling modal
                    showSchedulingModal();
                    break;
                case 'email':
                    // Show email composition modal
                    showEmailModal();
                    break;
                case 'reject':
                    if(confirm('Deseja reprovar este candidato?')) {
                        // API call would go here
                        showNotification('Candidato reprovado.', 'warning');
                    }
                    break;
            }
        });
    });

    // Sample candidate data
    const candidates = [
        {
            id: 1,
            name: 'João Silva',
            position: 'Motorista de Carreta',
            stage: 'novos',
            avatar: 'https://via.placeholder.com/40'
        },
        {
            id: 2,
            name: 'Maria Santos',
            position: 'Auxiliar Administrativo',
            stage: 'triagem',
            avatar: 'https://via.placeholder.com/40'
        },
        // Add more sample candidates as needed
    ];

    // Initialize pipeline with sample data
    function initializePipeline() {
        candidates.forEach(candidate => {
            addCandidateCard(candidate);
        });
        updateColumnCounts();
    }

    function addCandidateCard(candidate) {
        const card = document.createElement('div');
        card.className = 'candidate-card';
        card.draggable = true;
        card.dataset.candidateId = candidate.id;
        
        card.innerHTML = `
            <div class="d-flex align-items-center mb-2">
                <img src="${candidate.avatar}" class="rounded-circle me-2" width="32" height="32">
                <div>
                    <h6 class="mb-0">${candidate.name}</h6>
                    <small class="text-muted">${candidate.position}</small>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">ID: ${candidate.id}</small>
                <button class="btn btn-sm btn-outline-primary" onclick="viewCandidate(${candidate.id})">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        `;

        // Add drag and drop event listeners
        card.addEventListener('dragstart', handleDragStart);
        card.addEventListener('dragend', handleDragEnd);

        document.getElementById(candidate.stage).appendChild(card);
    }

    function updateColumnCounts() {
        document.querySelectorAll('.pipeline-column').forEach(column => {
            const count = column.querySelectorAll('.candidate-card').length;
            column.querySelector('.badge').textContent = count;
        });
    }

    // Drag and Drop functionality
    function handleDragStart(e) {
        e.target.classList.add('dragging');
        e.dataTransfer.setData('text/plain', e.target.dataset.candidateId);
    }

    function handleDragEnd(e) {
        e.target.classList.remove('dragging');
    }

    // Add drag and drop event listeners to columns
    document.querySelectorAll('.pipeline-content').forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault();
            column.parentElement.classList.add('drag-over');
        });

        column.addEventListener('dragleave', e => {
            column.parentElement.classList.remove('drag-over');
        });

        column.addEventListener('drop', e => {
            e.preventDefault();
            column.parentElement.classList.remove('drag-over');
            
            const candidateId = e.dataTransfer.getData('text/plain');
            const card = document.querySelector(`[data-candidate-id="${candidateId}"]`);
            const newStage = column.id;
            
            // Update candidate stage in the data
            const candidate = candidates.find(c => c.id === parseInt(candidateId));
            if (candidate) {
                candidate.stage = newStage;
            }
            
            // Move card to new column
            column.appendChild(card);
            updateColumnCounts();
            
            // Show notification
            showNotification('Candidato movido com sucesso!', 'success');
        });
    });

    // Initialize the pipeline
    initializePipeline();
});

function showNotification(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', function () {
        toast.remove();
    });
}

function showSchedulingModal() {
    // Implementation for scheduling modal
    console.log('Show scheduling modal');
}

function showEmailModal() {
    // Implementation for email modal
    console.log('Show email modal');
}

function viewCandidate(id) {
    // This will be implemented to show candidate details
    console.log('Viewing candidate:', id);
}
</script>

<!-- Modal Nova Vaga -->
<div class="modal fade" id="novaVagaModal" tabindex="-1" aria-labelledby="novaVagaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novaVagaModalLabel">Nova Requisição de Pessoal (RP)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="novaVagaForm">
                    <!-- Informações Básicas -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Informações Básicas</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cargo</label>
                                <input type="text" class="form-control" name="cargo" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Departamento</label>
                                <select class="form-select" name="departamento" required>
                                    <option value="">Selecione...</option>
                                    <option value="operacional">Operacional</option>
                                    <option value="administrativo">Administrativo</option>
                                    <option value="financeiro">Financeiro</option>
                                    <option value="rh">Recursos Humanos</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Contrato</label>
                                <select class="form-select" name="tipo_contrato" required>
                                    <option value="">Selecione...</option>
                                    <option value="clt">CLT</option>
                                    <option value="pj">PJ</option>
                                    <option value="temporario">Temporário</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantidade de Vagas</label>
                                <input type="number" class="form-control" name="quantidade" min="1" required>
                            </div>
                        </div>
                    </div>

                    <!-- Requisitos -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Requisitos</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Escolaridade</label>
                                <select class="form-select" name="escolaridade" required>
                                    <option value="">Selecione...</option>
                                    <option value="fundamental">Fundamental</option>
                                    <option value="medio">Médio</option>
                                    <option value="superior">Superior</option>
                                    <option value="pos_graduacao">Pós-Graduação</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Experiência Mínima</label>
                                <select class="form-select" name="experiencia" required>
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
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competencias[]" value="comunicacao">
                                        <label class="form-check-label">Comunicação</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competencias[]" value="trabalho_equipe">
                                        <label class="form-check-label">Trabalho em Equipe</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competencias[]" value="lideranca">
                                        <label class="form-check-label">Liderança</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="competencias[]" value="resolucao_problemas">
                                        <label class="form-check-label">Resolução de Problemas</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalhes Adicionais -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Detalhes Adicionais</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Descrição da Vaga</label>
                                <textarea class="form-control" name="descricao" rows="3" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Atividades Principais</label>
                                <textarea class="form-control" name="atividades" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Faixa Salarial</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" name="salario_min" placeholder="Mínimo" required>
                                    <span class="input-group-text">até</span>
                                    <input type="number" class="form-control" name="salario_max" placeholder="Máximo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Urgência</label>
                                <select class="form-select" name="urgencia" required>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitNovaVaga()">Criar Vaga</button>
            </div>
        </div>
    </div>
</div>

<script>
// ... existing script ...

function submitNovaVaga() {
    const form = document.getElementById('novaVagaForm');
    if (form.checkValidity()) {
        // Collect form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Here you would typically send this to your backend
        console.log('Nova vaga:', data);
        
        // Show success notification
        showNotification('Vaga criada com sucesso!', 'success');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('novaVagaModal'));
        modal.hide();
        
        // Reset form
        form.reset();
        
        // Refresh job listings (you would implement this)
        // refreshJobListings();
    } else {
        form.reportValidity();
    }
}
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 