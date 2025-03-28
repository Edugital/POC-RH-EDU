<?php
$pageTitle = 'Recursos Corporativos';
ob_start();

// Mock data for resources
$resources = array(
    'policies' => array(
        array(
            'id' => 1,
            'title' => 'Código de Conduta',
            'type' => 'pdf',
            'size' => '2.5 MB',
            'requires_confirmation' => true
        ),
        array(
            'id' => 2,
            'title' => 'Política de Segurança',
            'type' => 'pdf',
            'size' => '1.8 MB',
            'requires_confirmation' => true
        )
    ),
    'hr_docs' => array(
        array(
            'id' => 3,
            'title' => 'Manual do Colaborador',
            'type' => 'pdf',
            'size' => '5.2 MB'
        ),
        array(
            'id' => 4,
            'title' => 'Formulário de Férias',
            'type' => 'docx',
            'size' => '250 KB'
        )
    ),
    'forms' => array(
        array(
            'id' => 5,
            'title' => 'Reembolso de Despesas',
            'type' => 'xlsx',
            'size' => '180 KB'
        ),
        array(
            'id' => 6,
            'title' => 'Atualização Cadastral',
            'type' => 'docx',
            'size' => '150 KB'
        )
    )
);

$links = array(
    array(
        'title' => 'Portal de Benefícios',
        'url' => '#',
        'icon' => 'fas fa-heart'
    ),
    array(
        'title' => 'Holerite Online',
        'url' => '#',
        'icon' => 'fas fa-file-invoice-dollar'
    )
);
?>

<div class="resources-container">
    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control" id="resourceSearch" placeholder="Buscar recursos...">
            </div>
        </div>
    </div>

    <!-- Resources Grid -->
    <div class="row g-4">
        <!-- Company Policies -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book text-primary me-2"></i>
                        Políticas da Empresa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <?php foreach ($resources['policies'] as $policy): ?>
                        <div class="resource-item">
                            <div class="resource-icon">
                                <i class="fas fa-file-pdf text-danger"></i>
                            </div>
                            <div class="resource-info">
                                <h6><?php echo htmlspecialchars($policy['title']); ?></h6>
                                <small class="text-muted"><?php echo $policy['size']; ?></small>
                            </div>
                            <div class="resource-actions">
                                <button class="btn btn-primary btn-sm" onclick="viewDocument(<?php echo $policy['id']; ?>)">
                                    <i class="fas fa-eye"></i> Ler
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- HR Documents -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-folder text-warning me-2"></i>
                        Documentos RH
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <?php foreach ($resources['hr_docs'] as $doc): ?>
                        <div class="resource-item">
                            <div class="resource-icon">
                                <?php if ($doc['type'] === 'pdf'): ?>
                                <i class="fas fa-file-pdf text-danger"></i>
                                <?php else: ?>
                                <i class="fas fa-file-word text-primary"></i>
                                <?php endif; ?>
                            </div>
                            <div class="resource-info">
                                <h6><?php echo htmlspecialchars($doc['title']); ?></h6>
                                <small class="text-muted"><?php echo $doc['size']; ?></small>
                            </div>
                            <div class="resource-actions">
                                <button class="btn btn-outline-primary btn-sm" onclick="downloadDocument(<?php echo $doc['id']; ?>)">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link text-success me-2"></i>
                        Links Úteis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="quick-links">
                        <?php foreach ($links as $link): ?>
                        <a href="<?php echo $link['url']; ?>" class="quick-link-item" target="_blank">
                            <i class="<?php echo $link['icon']; ?>"></i>
                            <span><?php echo htmlspecialchars($link['title']); ?></span>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt text-info me-2"></i>
                        Formulários
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <?php foreach ($resources['forms'] as $form): ?>
                        <div class="resource-item">
                            <div class="resource-icon">
                                <?php if ($form['type'] === 'xlsx'): ?>
                                <i class="fas fa-file-excel text-success"></i>
                                <?php else: ?>
                                <i class="fas fa-file-word text-primary"></i>
                                <?php endif; ?>
                            </div>
                            <div class="resource-info">
                                <h6><?php echo htmlspecialchars($form['title']); ?></h6>
                                <small class="text-muted"><?php echo $form['size']; ?></small>
                            </div>
                            <div class="resource-actions">
                                <button class="btn btn-outline-primary btn-sm" onclick="downloadDocument(<?php echo $form['id']; ?>)">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Document Reader Modal -->
<div class="modal fade" id="documentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualizar Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="document-viewer">
                    <!-- Document content will be loaded here -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-check me-auto">
                    <input class="form-check-input" type="checkbox" id="confirmRead">
                    <label class="form-check-label" for="confirmRead">
                        Li e estou ciente do conteúdo deste documento
                    </label>
                </div>
                <button type="button" class="btn btn-primary" id="confirmButton" disabled>Confirmar Leitura</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style>
.resource-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.resource-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    transition: transform 0.2s;
}

.resource-item:hover {
    transform: translateY(-2px);
    background: #e9ecef;
}

.resource-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.resource-info {
    flex: 1;
}

.resource-info h6 {
    margin: 0 0 0.25rem 0;
}

.quick-links {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quick-link-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #495057;
    transition: transform 0.2s;
}

.quick-link-item:hover {
    transform: translateY(-2px);
    background: #e9ecef;
    color: #0d6efd;
}

.quick-link-item i:first-child {
    font-size: 1.25rem;
    margin-right: 1rem;
    width: 1.5rem;
    text-align: center;
}

.quick-link-item span {
    flex: 1;
}

.quick-link-item i:last-child {
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.document-viewer {
    min-height: 400px;
    background: #f8f9fa;
    border-radius: 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('resourceSearch');
    const resourceItems = document.querySelectorAll('.resource-item, .quick-link-item');

    searchInput?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        resourceItems.forEach(item => {
            const title = item.querySelector('h6, span').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Document confirmation
    const confirmCheck = document.getElementById('confirmRead');
    const confirmButton = document.getElementById('confirmButton');

    confirmCheck?.addEventListener('change', function() {
        confirmButton.disabled = !this.checked;
    });

    confirmButton?.addEventListener('click', function() {
        alert('Leitura confirmada com sucesso!');
        bootstrap.Modal.getInstance(document.getElementById('documentModal')).hide();
    });
});

function viewDocument(documentId) {
    const modal = new bootstrap.Modal(document.getElementById('documentModal'));
    modal.show();
    // In a real implementation, we would load the document content here
}

function downloadDocument(documentId) {
    alert('Iniciando download do documento ' + documentId);
}
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 