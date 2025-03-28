<?php
$pageTitle = 'Minhas Solicitações';
ob_start();
?>

<div class="requests-container">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?php echo $pageTitle; ?></h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal">
            <i class="fas fa-plus"></i> Nova Solicitação
        </button>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="all">Todos</option>
                        <option value="pending">Pendente</option>
                        <option value="in_progress">Em Análise</option>
                        <option value="completed">Resolvido</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Período</label>
                    <select class="form-select" id="periodFilter">
                        <option value="all">Todos</option>
                        <option value="last_month">Último Mês</option>
                        <option value="last_3months">Últimos 3 Meses</option>
                        <option value="last_6months">Últimos 6 Meses</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select class="form-select" id="typeFilter">
                        <option value="all">Todos</option>
                        <option value="document">Documentos</option>
                        <option value="vacation">Férias</option>
                        <option value="certificate">Certificados</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests List -->
    <div class="requests-list">
        <!-- Request Item 1 -->
        <div class="request-card" data-status="pending" data-type="vacation">
            <div class="request-status pending">
                <i class="fas fa-clock"></i>
                <span>Pendente</span>
            </div>
            <div class="request-content">
                <div class="request-header">
                    <h3>Solicitação de Férias</h3>
                    <span class="request-date">24/03/2024</span>
                </div>
                <div class="request-details">
                    <p>Período solicitado: 01/05/2024 a 30/05/2024</p>
                </div>
                <div class="request-actions">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#requestDetailsModal">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </div>

        <!-- Request Item 2 -->
        <div class="request-card" data-status="in_progress" data-type="document">
            <div class="request-status in-progress">
                <i class="fas fa-sync-alt"></i>
                <span>Em Análise</span>
            </div>
            <div class="request-content">
                <div class="request-header">
                    <h3>Declaração de Vínculo</h3>
                    <span class="request-date">23/03/2024</span>
                </div>
                <div class="request-details">
                    <p>Solicitação de declaração para fins bancários</p>
                </div>
                <div class="request-actions">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#requestDetailsModal">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </div>

        <!-- Request Item 3 -->
        <div class="request-card" data-status="completed" data-type="certificate">
            <div class="request-status completed">
                <i class="fas fa-check-circle"></i>
                <span>Resolvido</span>
            </div>
            <div class="request-content">
                <div class="request-header">
                    <h3>Certificado de Treinamento</h3>
                    <span class="request-date">20/03/2024</span>
                </div>
                <div class="request-details">
                    <p>Certificado do curso de Direção Defensiva</p>
                </div>
                <div class="request-actions">
                    <button class="btn btn-outline-success btn-sm">Download</button>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#requestDetailsModal">
                        Ver Detalhes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Request Modal -->
<div class="modal fade" id="newRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Solicitação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newRequestForm">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Solicitação</label>
                        <select class="form-select" required>
                            <option value="">Selecione...</option>
                            <option value="document">Documentos</option>
                            <option value="vacation">Férias</option>
                            <option value="certificate">Certificados</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Anexos</label>
                        <input type="file" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Enviar Solicitação</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div class="modal fade" id="requestDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes da Solicitação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="request-timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">24/03/2024 10:30</div>
                        <div class="timeline-content">
                            <h6>Solicitação Enviada</h6>
                            <p>Sua solicitação foi recebida e está aguardando análise.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">24/03/2024 11:15</div>
                        <div class="timeline-content">
                            <h6>Em Análise</h6>
                            <p>Sua solicitação está sendo analisada pelo RH.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style>
.request-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
    display: flex;
    overflow: hidden;
}

.request-status {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 120px;
    font-size: 0.9rem;
}

.request-status i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.request-status.pending {
    background: #fff3cd;
    color: #856404;
}

.request-status.in-progress {
    background: #cce5ff;
    color: #004085;
}

.request-status.completed {
    background: #d4edda;
    color: #155724;
}

.request-content {
    flex: 1;
    padding: 1.5rem;
}

.request-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.request-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.request-date {
    color: #6c757d;
    font-size: 0.9rem;
}

.request-details {
    color: #495057;
    margin-bottom: 1rem;
}

.request-actions {
    display: flex;
    gap: 0.5rem;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    padding-bottom: 2rem;
    border-left: 2px solid #dee2e6;
}

.timeline-item:last-child {
    border-left: none;
}

.timeline-date {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 4px;
}

.timeline-content h6 {
    margin: 0 0 0.5rem 0;
    color: #495057;
}

.timeline-content p {
    margin: 0;
    color: #6c757d;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -0.5rem;
    top: 0;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #007bff;
    border: 2px solid #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const periodFilter = document.getElementById('periodFilter');
    const typeFilter = document.getElementById('typeFilter');
    const requestCards = document.querySelectorAll('.request-card');

    function filterRequests() {
        const status = statusFilter.value;
        const type = typeFilter.value;

        requestCards.forEach(card => {
            const statusMatch = status === 'all' || card.dataset.status === status;
            const typeMatch = type === 'all' || card.dataset.type === type;

            card.style.display = statusMatch && typeMatch ? 'flex' : 'none';
        });
    }

    statusFilter.addEventListener('change', filterRequests);
    periodFilter.addEventListener('change', filterRequests);
    typeFilter.addEventListener('change', filterRequests);

    // Form validation
    const newRequestForm = document.getElementById('newRequestForm');
    const submitButton = newRequestForm?.closest('.modal')?.querySelector('.btn-primary');

    if (submitButton) {
        submitButton.addEventListener('click', function() {
            if (newRequestForm.checkValidity()) {
                // Submit form
                alert('Solicitação enviada com sucesso!');
                bootstrap.Modal.getInstance(document.getElementById('newRequestModal')).hide();
            } else {
                newRequestForm.reportValidity();
            }
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 