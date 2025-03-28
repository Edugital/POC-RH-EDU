<?php
$pageTitle = 'Comunicados';
ob_start();
?>

<div class="announcements-container">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><?php echo $pageTitle; ?></h1>
        <div class="announcement-filters">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">Todos</button>
                <button type="button" class="btn btn-outline-primary" data-filter="rh">RH</button>
                <button type="button" class="btn btn-outline-primary" data-filter="training">T&D</button>
                <button type="button" class="btn btn-outline-primary" data-filter="safety">Segurança</button>
                <button type="button" class="btn btn-outline-primary" data-filter="events">Eventos</button>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="announcement-timeline">
        <!-- Urgent Announcement -->
        <div class="announcement-card urgent" data-category="safety">
            <div class="announcement-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="announcement-content">
                <div class="announcement-header">
                    <h3>Treinamento de Segurança Obrigatório</h3>
                    <span class="announcement-date">24/03/2024</span>
                </div>
                <div class="announcement-body">
                    <p>Todos os colaboradores devem realizar o treinamento de segurança atualizado até 30/03/2024.</p>
                    <div class="announcement-actions">
                        <button class="btn btn-primary btn-sm">Acessar Treinamento</button>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReadModal">
                            Confirmar Leitura
                        </button>
                    </div>
                </div>
                <div class="announcement-meta">
                    <span class="badge bg-danger">Urgente</span>
                    <span class="badge bg-info">Segurança</span>
                </div>
            </div>
        </div>

        <!-- Regular Announcement -->
        <div class="announcement-card" data-category="rh">
            <div class="announcement-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="announcement-content">
                <div class="announcement-header">
                    <h3>Atualização da Política de Benefícios</h3>
                    <span class="announcement-date">23/03/2024</span>
                </div>
                <div class="announcement-body">
                    <p>Nova política de benefícios disponível para consulta. Principais mudanças incluem melhorias no plano de saúde.</p>
                    <div class="announcement-actions">
                        <button class="btn btn-primary btn-sm">Ver Política</button>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReadModal">
                            Confirmar Leitura
                        </button>
                    </div>
                </div>
                <div class="announcement-meta">
                    <span class="badge bg-primary">RH</span>
                </div>
            </div>
        </div>

        <!-- Event Announcement -->
        <div class="announcement-card" data-category="events">
            <div class="announcement-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="announcement-content">
                <div class="announcement-header">
                    <h3>Confraternização de Equipe</h3>
                    <span class="announcement-date">22/03/2024</span>
                </div>
                <div class="announcement-body">
                    <p>Confraternização mensal será realizada no dia 30/03/2024. Confirme sua presença até 28/03.</p>
                    <div class="announcement-actions">
                        <button class="btn btn-primary btn-sm">Confirmar Presença</button>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReadModal">
                            Confirmar Leitura
                        </button>
                    </div>
                </div>
                <div class="announcement-meta">
                    <span class="badge bg-success">Eventos</span>
                </div>
            </div>
        </div>

        <!-- Training Announcement -->
        <div class="announcement-card" data-category="training">
            <div class="announcement-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="announcement-content">
                <div class="announcement-header">
                    <h3>Novo Curso Disponível</h3>
                    <span class="announcement-date">21/03/2024</span>
                </div>
                <div class="announcement-body">
                    <p>Curso de Excel Avançado disponível na plataforma de treinamentos.</p>
                    <div class="announcement-actions">
                        <button class="btn btn-primary btn-sm">Acessar Curso</button>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#confirmReadModal">
                            Confirmar Leitura
                        </button>
                    </div>
                </div>
                <div class="announcement-meta">
                    <span class="badge bg-info">T&D</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Read Modal -->
<div class="modal fade" id="confirmReadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Leitura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Confirmo que li e estou ciente do conteúdo deste comunicado.</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmCheck">
                    <label class="form-check-label" for="confirmCheck">
                        Li e estou ciente do comunicado
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmButton" disabled>Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<style>
.announcement-timeline {
    position: relative;
    padding: 1rem;
}

.announcement-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    display: flex;
    overflow: hidden;
    transition: transform 0.2s;
}

.announcement-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.announcement-card.urgent {
    border-left: 4px solid #dc3545;
}

.announcement-icon {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #6c757d;
    background: #f8f9fa;
    min-width: 80px;
}

.announcement-content {
    flex: 1;
    padding: 1.5rem;
}

.announcement-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.announcement-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.announcement-date {
    color: #6c757d;
    font-size: 0.9rem;
}

.announcement-body {
    color: #495057;
    margin-bottom: 1rem;
}

.announcement-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.announcement-meta {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    const announcements = document.querySelectorAll('.announcement-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter announcements
            announcements.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Handle confirmation checkbox
    const confirmCheck = document.getElementById('confirmCheck');
    const confirmButton = document.getElementById('confirmButton');

    confirmCheck?.addEventListener('change', function() {
        confirmButton.disabled = !this.checked;
    });

    // Handle confirmation button
    confirmButton?.addEventListener('click', function() {
        alert('Leitura confirmada com sucesso!');
        bootstrap.Modal.getInstance(document.getElementById('confirmReadModal')).hide();
    });
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 