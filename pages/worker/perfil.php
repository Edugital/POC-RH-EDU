<?php
$pageTitle = 'Meu Perfil';

// Initialize user data
$user = array(
    'name' => 'João da Silva',
    'position' => 'Motorista',
    'department' => 'Operações',
    'avatar' => 'JS'
);

ob_start();
?>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header mb-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="profile-avatar">
                    <span class="avatar-initials"><?php echo $user['avatar']; ?></span>
                    <button class="btn btn-sm btn-light avatar-edit" title="Alterar foto">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            <div class="col">
                <h1 class="h3 mb-1"><?php echo htmlspecialchars($user['name']); ?></h1>
                <p class="text-muted mb-0">
                    <?php echo htmlspecialchars($user['position']); ?> - 
                    <?php echo htmlspecialchars($user['department']); ?>
                </p>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="fas fa-edit"></i> Editar Perfil
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações Pessoais</h5>
                </div>
                <div class="card-body">
                    <div class="profile-info">
                        <div class="info-item">
                            <span class="info-label">Matrícula</span>
                            <span class="info-value">12345</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Data de Admissão</span>
                            <span class="info-value">01/01/2022</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">joao.silva@empresa.com</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Telefone</span>
                            <span class="info-value">(27) 99999-9999</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Unidade</span>
                            <span class="info-value">Vitória/ES</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Training History -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Histórico de Treinamentos</h5>
                </div>
                <div class="card-body">
                    <div class="training-history">
                        <div class="training-item completed">
                            <div class="training-status">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="training-info">
                                <h6>Direção Defensiva</h6>
                                <p class="text-muted">Concluído em 15/03/2024</p>
                                <button class="btn btn-link btn-sm p-0">Ver Certificado</button>
                            </div>
                        </div>
                        <div class="training-item completed">
                            <div class="training-status">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="training-info">
                                <h6>Segurança no Trabalho</h6>
                                <p class="text-muted">Concluído em 10/02/2024</p>
                                <button class="btn btn-link btn-sm p-0">Ver Certificado</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Documentos</h5>
                </div>
                <div class="card-body">
                    <div class="documents-list">
                        <div class="document-item">
                            <i class="fas fa-file-pdf"></i>
                            <span>Contrato de Trabalho</span>
                            <button class="btn btn-link btn-sm">Visualizar</button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-file-pdf"></i>
                            <span>Termo de Confidencialidade</span>
                            <button class="btn btn-link btn-sm">Visualizar</button>
                        </div>
                        <div class="document-item">
                            <i class="fas fa-file-pdf"></i>
                            <span>Acordo de PLR</span>
                            <button class="btn btn-link btn-sm">Visualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request History -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Histórico de Solicitações</h5>
                </div>
                <div class="card-body">
                    <div class="request-history">
                        <div class="request-item">
                            <div class="request-status completed">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="request-info">
                                <h6>Férias</h6>
                                <p class="text-muted">Aprovado em 20/03/2024</p>
                                <p>Período: 01/05/2024 a 30/05/2024</p>
                            </div>
                        </div>
                        <div class="request-item">
                            <div class="request-status pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="request-info">
                                <h6>Declaração de Vínculo</h6>
                                <p class="text-muted">Solicitado em 23/03/2024</p>
                                <p>Em análise</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <div class="mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="tel" class="form-control" value="(27) 99999-9999">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="joao.silva@empresa.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha Atual</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Salvar Alterações</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar {
    position: relative;
    width: 100px;
    height: 100px;
    background: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-initials {
    font-size: 2.5rem;
    font-weight: 600;
    color: #495057;
}

.avatar-edit {
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 0.25rem;
    border-radius: 50%;
}

.info-item {
    margin-bottom: 1rem;
}

.info-label {
    display: block;
    color: #6c757d;
    font-size: 0.875rem;
}

.info-value {
    display: block;
    font-weight: 500;
}

.training-item,
.request-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.training-item:last-child,
.request-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.training-status,
.request-status {
    margin-right: 1rem;
    font-size: 1.25rem;
}

.training-status i,
.request-status.completed i {
    color: #28a745;
}

.request-status.pending i {
    color: #ffc107;
}

.training-info,
.request-info {
    flex: 1;
}

.training-info h6,
.request-info h6 {
    margin: 0 0 0.25rem 0;
}

.document-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #dee2e6;
}

.document-item:last-child {
    border-bottom: none;
}

.document-item i {
    margin-right: 1rem;
    color: #6c757d;
}

.document-item span {
    flex: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle profile form submission
    const editProfileForm = document.getElementById('editProfileForm');
    const saveButton = editProfileForm?.closest('.modal')?.querySelector('.btn-primary');

    if (saveButton) {
        saveButton.addEventListener('click', function() {
            if (editProfileForm.checkValidity()) {
                // Submit form
                alert('Perfil atualizado com sucesso!');
                bootstrap.Modal.getInstance(document.getElementById('editProfileModal')).hide();
            } else {
                editProfileForm.reportValidity();
            }
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 