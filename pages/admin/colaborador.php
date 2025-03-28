<?php
// Error reporting em produção deve ser ajustado
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificação de administrador
require_once dirname(__DIR__, 2) . '/includes/auth.php';

$pageTitle = 'Gestão de Colaboradores';

// Verifica se o usuário é administrador
requireAdmin();

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

// Mock data for demonstration
$colaboradores = [
    [
        'id' => '001',
        'nome' => 'Ana Silva',
        'email' => 'ana.silva@empresa.com',
        'cargo' => 'Motorista de Carreta',
        'departamento' => 'Operacional',
        'filial' => 'Vitória/ES',
        'status' => 'Ativo',
        'data_admissao' => '15/03/2022'
    ],
    [
        'id' => '002',
        'nome' => 'João Santos',
        'email' => 'joao.santos@empresa.com',
        'cargo' => 'Supervisor de Logística',
        'departamento' => 'Logística',
        'filial' => 'Serra/ES',
        'status' => 'Ativo',
        'data_admissao' => '20/06/2021'
    ],
    [
        'id' => '003',
        'nome' => 'Maria Oliveira',
        'email' => 'maria.oliveira@empresa.com',
        'cargo' => 'Analista de RH',
        'departamento' => 'Recursos Humanos',
        'filial' => 'Vitória/ES',
        'status' => 'Ativo',
        'data_admissao' => '10/01/2023'
    ],
    [
        'id' => '004',
        'nome' => 'Pedro Costa',
        'email' => 'pedro.costa@empresa.com',
        'cargo' => 'Mecânico',
        'departamento' => 'Manutenção',
        'filial' => 'Cariacica/ES',
        'status' => 'Férias',
        'data_admissao' => '05/11/2020'
    ],
    [
        'id' => '005',
        'nome' => 'Carla Souza',
        'email' => 'carla.souza@empresa.com',
        'cargo' => 'Assistente Administrativo',
        'departamento' => 'Administrativo',
        'filial' => 'Vila Velha/ES',
        'status' => 'Ativo',
        'data_admissao' => '15/08/2023'
    ]
];

ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Colaboradores</h1>
            <p class="text-muted mb-0">Gestão e Informações dos Colaboradores</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (hasPermission('colaborador', 'create')): ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novoColaboradorModal">
                <i class="fas fa-plus me-2"></i>Novo Colaborador
            </button>
            <?php endif; ?>
            <button class="btn btn-success" id="exportarDados">
                <i class="fas fa-file-excel me-2"></i>Exportar
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3" id="filtroForm">
                <div class="col-md-3">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Nome, cargo ou departamento...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Departamento</label>
                    <select class="form-select" id="departamentoFilter">
                        <option value="">Todos</option>
                        <option>Operacional</option>
                        <option>Logística</option>
                        <option>Recursos Humanos</option>
                        <option>Manutenção</option>
                        <option>Administrativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Filial</label>
                    <select class="form-select" id="filialFilter">
                        <option value="">Todas</option>
                        <option>Vitória/ES</option>
                        <option>Serra/ES</option>
                        <option>Vila Velha/ES</option>
                        <option>Cariacica/ES</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Todos</option>
                        <option>Ativo</option>
                        <option>Férias</option>
                        <option>Afastado</option>
                        <option>Inativo</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Colaboradores -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="colaboradoresTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>CARGO</th>
                            <th>DEPARTAMENTO</th>
                            <th>FILIAL</th>
                            <th>STATUS</th>
                            <th>DATA ADMISSÃO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($colaboradores as $colaborador): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($colaborador['id']); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if (isset($colaborador['foto']) && $colaborador['foto']): ?>
                                        <img src="<?php echo htmlspecialchars($colaborador['foto']); ?>" 
                                             class="rounded-circle me-3" 
                                             width="40" height="40" 
                                             alt="Foto do Colaborador">
                                    <?php else: ?>
                                        <div class="initials-avatar-sm rounded-circle me-3 d-flex align-items-center justify-content-center"
                                             style="background-color: <?php echo getColorFromName($colaborador['nome']); ?>">
                                            <span class="initials-sm"><?php echo getInitials($colaborador['nome']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-medium"><?php echo htmlspecialchars($colaborador['nome']); ?></div>
                                        <div class="text-muted small"><?php echo htmlspecialchars($colaborador['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($colaborador['cargo']); ?></td>
                            <td><?php echo htmlspecialchars($colaborador['departamento']); ?></td>
                            <td><?php echo htmlspecialchars($colaborador['filial']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $colaborador['status'] === 'Ativo' ? 'success' : 'info'; ?>">
                                    <?php echo htmlspecialchars($colaborador['status']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($colaborador['data_admissao']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary quick-view-btn" 
                                           data-id="<?php echo htmlspecialchars($colaborador['id']); ?>"
                                           data-nome="<?php echo htmlspecialchars($colaborador['nome']); ?>"
                                           data-email="<?php echo htmlspecialchars($colaborador['email']); ?>"
                                           data-cargo="<?php echo htmlspecialchars($colaborador['cargo']); ?>"
                                           data-departamento="<?php echo htmlspecialchars($colaborador['departamento']); ?>"
                                           data-filial="<?php echo htmlspecialchars($colaborador['filial']); ?>"
                                           data-status="<?php echo htmlspecialchars($colaborador['status']); ?>"
                                           data-admissao="<?php echo htmlspecialchars($colaborador['data_admissao']); ?>"
                                           data-color="<?php echo getColorFromName($colaborador['nome']); ?>"
                                           data-initials="<?php echo getInitials($colaborador['nome']); ?>"
                                           title="Visualização Rápida">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="colaborador_perfil_rh.php?id=<?php echo htmlspecialchars($colaborador['id']); ?>" class="btn btn-sm btn-info" title="Perfil com Estrutura Organizacional">
                                        <i class="fas fa-sitemap me-1"></i> <span class="d-none d-lg-inline">Org</span>
                                    </a>
                                    <?php if (hasPermission('colaborador', 'edit')): ?>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarColaborador<?php echo htmlspecialchars($colaborador['id']); ?>" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php if (hasPermission('colaborador', 'delete')): ?>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#excluirColaborador<?php echo htmlspecialchars($colaborador['id']); ?>" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Novo Colaborador -->
<div class="modal fade" id="novoColaboradorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Colaborador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="novoColaboradorForm" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cargo</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Departamento</label>
                        <select class="form-select" required>
                            <option value="">Selecione...</option>
                            <option>Operacional</option>
                            <option>Logística</option>
                            <option>Recursos Humanos</option>
                            <option>Manutenção</option>
                            <option>Administrativo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Filial</label>
                        <select class="form-select" required>
                            <option value="">Selecione...</option>
                            <option>Vitória/ES</option>
                            <option>Serra/ES</option>
                            <option>Vila Velha/ES</option>
                            <option>Cariacica/ES</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Data de Admissão</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="tel" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="novoColaboradorForm" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visualização Rápida -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes do Colaborador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3">
                    <div id="quickViewAvatar" class="initials-avatar-sm rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 1.25rem;">
                        <span class="initials-sm" id="quickViewInitials"></span>
                    </div>
                    <div>
                        <h5 id="quickViewNome" class="mb-1"></h5>
                        <p id="quickViewEmail" class="text-muted mb-0 small"></p>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">ID</label>
                            <div id="quickViewId" class="fw-medium"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Status</label>
                            <div><span id="quickViewStatus" class="badge"></span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Cargo</label>
                            <div id="quickViewCargo" class="fw-medium"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Departamento</label>
                            <div id="quickViewDepartamento" class="fw-medium"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Filial</label>
                            <div id="quickViewFilial" class="fw-medium"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Data de Admissão</label>
                            <div id="quickViewAdmissao" class="fw-medium"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <a id="quickViewPerfilCompleto" href="#" class="btn btn-primary">Ver Perfil Completo</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa a tabela com DataTables
    const table = new DataTable('#colaboradoresTable', {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
        },
        pageLength: 10,
        order: [[1, 'asc']]
    });

    // Função de busca
    document.getElementById('searchInput').addEventListener('keyup', function() {
        table.search(this.value).draw();
    });

    // Filtros
    document.getElementById('filtroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const departamento = document.getElementById('departamentoFilter').value;
        const filial = document.getElementById('filialFilter').value;
        const status = document.getElementById('statusFilter').value;

        // Aplica os filtros
        table.columns(3).search(departamento);
        table.columns(4).search(filial);
        table.columns(5).search(status);
        table.draw();
    });

    // Exportação
    document.getElementById('exportarDados').addEventListener('click', function() {
        const wb = XLSX.utils.table_to_book(document.getElementById('colaboradoresTable'), {sheet: "Colaboradores"});
        XLSX.writeFile(wb, 'colaboradores.xlsx');
    });

    // Configurar Quick View
    const quickViewModal = new bootstrap.Modal(document.getElementById('quickViewModal'));
    
    document.querySelectorAll('.quick-view-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            const email = this.getAttribute('data-email');
            const cargo = this.getAttribute('data-cargo');
            const departamento = this.getAttribute('data-departamento');
            const filial = this.getAttribute('data-filial');
            const status = this.getAttribute('data-status');
            const admissao = this.getAttribute('data-admissao');
            const color = this.getAttribute('data-color');
            const initials = this.getAttribute('data-initials');
            
            // Preencher os dados no modal
            document.getElementById('quickViewId').textContent = id;
            document.getElementById('quickViewNome').textContent = nome;
            document.getElementById('quickViewEmail').textContent = email;
            document.getElementById('quickViewCargo').textContent = cargo;
            document.getElementById('quickViewDepartamento').textContent = departamento;
            document.getElementById('quickViewFilial').textContent = filial;
            document.getElementById('quickViewAdmissao').textContent = admissao;
            
            // Status com cor apropriada
            const statusEl = document.getElementById('quickViewStatus');
            statusEl.textContent = status;
            statusEl.className = 'badge bg-' + (status === 'Ativo' ? 'success' : 
                                               status === 'Férias' ? 'info' : 
                                               status === 'Afastado' ? 'warning' : 'secondary');
            
            // Configurar avatar
            document.getElementById('quickViewAvatar').style.backgroundColor = color;
            document.getElementById('quickViewInitials').textContent = initials;
            
            // Link para perfil completo
            document.getElementById('quickViewPerfilCompleto').href = 'colaborador_perfil.php?id=' + id;
            
            // Mostrar modal
            quickViewModal.show();
        });
    });
});
</script>

<!-- Adiciona bibliotecas necessárias -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

<style>
.initials-avatar-sm {
    width: 40px;
    height: 40px;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    background-color: #0d6efd;
}

.initials-sm {
    text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.badge {
    font-weight: 500;
}
</style>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 