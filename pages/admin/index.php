<?php
// Error reporting em produção deve ser ajustado
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificação de administrador
require_once 'admin_check.php';

// Definir constantes do sistema
define('BASE_PATH', dirname(__DIR__, 2));
define('IS_PRODUCTION', false); // Mudar para true em produção

// Verificar se o sistema está configurado corretamente
if (!file_exists(BASE_PATH . '/includes/auth.php')) {
    die('Erro crítico: Arquivos do sistema não encontrados');
}

// Resumo de dados para o dashboard principal
// Estatísticas gerais
$resumoDashboard = [
    'colaboradores' => [
        'total' => 103,
        'ativos' => 98,
        'afastados' => 5,
        'novos_30d' => 7,
        'desligados_30d' => 2
    ],
    'recrutamento' => [
        'vagas_abertas' => 7,
        'em_processo' => 4,
        'candidatos_ativos' => 156,
        'entrevistas_agendadas' => 12
    ],
    'estrutura' => [
        'unidades' => 4,
        'departamentos' => 6,
        'cargos' => 30,
        'posicoes' => 110,
        'posicoes_vagas' => 7
    ],
    'treinamentos' => [
        'cursos_ativos' => 15,
        'colaboradores_inscritos' => 84,
        'horas_realizadas' => 1280,
        'prox_treinamento' => 'Direção Defensiva (23/07)'
    ]
];

// Alertas e notificações para o dashboard
$alertas = [
    ['tipo' => 'warning', 'texto' => '3 colaboradores com documentos pendentes', 'link' => 'colaborador.php?filter=pendencias'],
    ['tipo' => 'info', 'texto' => '2 novas inscrições em cursos aguardando aprovação', 'link' => 'lms.php?view=inscricoes'],
    ['tipo' => 'danger', 'texto' => '1 vaga em atraso no processo seletivo', 'link' => 'vagas.php?filter=atrasadas'],
    ['tipo' => 'success', 'texto' => '5 novos candidatos qualificados para análise', 'link' => 'candidatos.php?filter=novos']
];

// Atividades recentes para o feed
$atividades = [
    ['timestamp' => '2023-07-15 09:23', 'tipo' => 'contratacao', 'descricao' => 'João da Silva contratado como Motorista', 'icone' => 'user-plus', 'cor' => 'success'],
    ['timestamp' => '2023-07-14 16:45', 'tipo' => 'entrevista', 'descricao' => 'Entrevista agendada para Analista Fiscal', 'icone' => 'calendar-check', 'cor' => 'primary'],
    ['timestamp' => '2023-07-14 11:30', 'tipo' => 'treinamento', 'descricao' => 'Curso de Direção Defensiva concluído por 15 colaboradores', 'icone' => 'graduation-cap', 'cor' => 'info'],
    ['timestamp' => '2023-07-13 15:20', 'tipo' => 'documento', 'descricao' => 'Novas certidões da unidade Matriz emitidas', 'icone' => 'file-alt', 'cor' => 'warning'],
    ['timestamp' => '2023-07-12 10:15', 'tipo' => 'vaga', 'descricao' => 'Nova vaga aberta para Contador', 'icone' => 'briefcase', 'cor' => 'danger']
];

$pageTitle = 'Dashboard';

// Iniciar captura do conteúdo
ob_start();
?>

<!-- Dashboard Content -->
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-muted mb-0">Visão geral do sistema de RH</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="refreshDashboard">
                <i class="fas fa-sync-alt me-2"></i>Atualizar
            </button>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-file-export me-2"></i>Exportar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>PDF</a></li>
                    <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Imprimir</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Métricas Principais (4 cards com resumo das áreas principais) -->
    <div class="row mb-4">
        <!-- Colaboradores (RH) -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted fw-normal mb-0">Total de Colaboradores</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?php echo $resumoDashboard['colaboradores']['total']; ?></h2>
                            <span class="badge <?php echo $resumoDashboard['colaboradores']['novos_30d'] > 0 ? 'bg-success' : 'bg-secondary'; ?> mt-2">
                                <i class="fas fa-user-plus me-1"></i><?php echo $resumoDashboard['colaboradores']['novos_30d']; ?> novos
                            </span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: rgba(52, 152, 219, 0.1);">
                            <i class="fas fa-users fa-lg" style="color: #3498db;"></i>
                        </div>
                    </div>
                    <a href="colaborador.php" class="btn btn-sm btn-outline-primary w-100 mt-3">
                        <i class="fas fa-external-link-alt me-1"></i>Gestão de Colaboradores
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recrutamento e Seleção -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted fw-normal mb-0">Vagas Abertas</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?php echo $resumoDashboard['recrutamento']['vagas_abertas']; ?></h2>
                            <span class="badge bg-primary mt-2">
                                <i class="fas fa-user-tie me-1"></i><?php echo $resumoDashboard['recrutamento']['em_processo']; ?> em processo
                            </span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: rgba(231, 76, 60, 0.1);">
                            <i class="fas fa-briefcase fa-lg" style="color: #e74c3c;"></i>
                        </div>
                    </div>
                    <a href="vagas.php" class="btn btn-sm btn-outline-danger w-100 mt-3">
                        <i class="fas fa-external-link-alt me-1"></i>Gestão de Vagas
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Estrutura Organizacional -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted fw-normal mb-0">Estrutura Organizacional</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?php echo $resumoDashboard['estrutura']['unidades']; ?></h2>
                            <span class="badge bg-success mt-2">
                                <i class="fas fa-sitemap me-1"></i><?php echo $resumoDashboard['estrutura']['departamentos']; ?> departamentos
                            </span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: rgba(46, 204, 113, 0.1);">
                            <i class="fas fa-building fa-lg" style="color: #2ecc71;"></i>
                        </div>
                    </div>
                    <a href="estrutura_organizacional.php" class="btn btn-sm btn-outline-success w-100 mt-3">
                        <i class="fas fa-external-link-alt me-1"></i>Ver Organograma
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Treinamento e Desenvolvimento -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted fw-normal mb-0">Cursos Ativos</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?php echo $resumoDashboard['treinamentos']['cursos_ativos']; ?></h2>
                            <span class="badge bg-info mt-2">
                                <i class="fas fa-user-graduate me-1"></i><?php echo $resumoDashboard['treinamentos']['colaboradores_inscritos']; ?> inscritos
                            </span>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: rgba(52, 152, 219, 0.1);">
                            <i class="fas fa-graduation-cap fa-lg" style="color: #3498db;"></i>
                        </div>
                    </div>
                    <a href="lms.php" class="btn btn-sm btn-outline-info w-100 mt-3">
                        <i class="fas fa-external-link-alt me-1"></i>Ambiente de Aprendizagem
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda linha: Gráficos e Alertas -->
    <div class="row g-4 mb-4">
        <!-- Gráficos de Resumo -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Indicadores</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary active" data-chart-period="week">Semanal</button>
                        <button class="btn btn-outline-secondary" data-chart-period="month">Mensal</button>
                        <button class="btn btn-outline-secondary" data-chart-period="quarter">Trimestral</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Gráficos Principais -->
                    <div class="row">
                        <div class="col-md-6">
                            <div style="height: 250px;">
                                <canvas id="recruitmentChart"></canvas>
                            </div>
                            <div class="text-center mt-1">
                                <small class="text-muted">Processo de Recrutamento</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="height: 250px;">
                                <canvas id="employeeChart"></canvas>
                            </div>
                            <div class="text-center mt-1">
                                <small class="text-muted">Evolução do Quadro</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top pt-3 pb-3">
                    <div class="row text-center">
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold mb-0">Candidatos</h6>
                            <p class="small mb-0">
                                <span class="text-success fw-bold">+48</span> esta semana
                            </p>
                        </div>
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold mb-0">Contratações</h6>
                            <p class="small mb-0">
                                <span class="text-success fw-bold">+7</span> este mês
                            </p>
                        </div>
                        <div class="col-md-3 border-end">
                            <h6 class="fw-bold mb-0">Turnover</h6>
                            <p class="small mb-0">
                                <span class="text-danger fw-bold">2.3%</span> mensal
                            </p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="fw-bold mb-0">Horas Treinamento</h6>
                            <p class="small mb-0">
                                <span class="text-success fw-bold">12.4h</span> por colab.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alertas e Ações Pendentes -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="fas fa-bell me-2 text-warning"></i>Alertas e Pendências</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($alertas as $alerta): ?>
                        <a href="<?php echo htmlspecialchars($alerta['link']); ?>" class="list-group-item list-group-item-action py-3">
                            <div class="d-flex w-100 align-items-center">
                                <div class="flex-shrink-0">
                                    <span class="badge rounded-circle p-2 bg-<?php echo $alerta['tipo']; ?>">
                                        <i class="fas fa-exclamation"></i>
                                    </span>
                                </div>
                                <div class="ms-3 me-auto">
                                    <div><?php echo htmlspecialchars($alerta['texto']); ?></div>
                                </div>
                                <div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-top text-center py-3">
                    <a href="alertas.php" class="btn btn-warning">
                        <i class="fas fa-tasks me-2"></i>Ver Todas as Pendências
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Terceira linha: Acessos Rápidos e Atividades Recentes -->
    <div class="row g-4">
        <!-- Acessos Rápidos -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="fas fa-th me-2 text-success"></i>Acessos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="candidatos.php" class="btn btn-light w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-users mb-2 fa-lg text-primary"></i>
                                <span>Candidatos</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="entrevistas.php" class="btn btn-light w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-calendar-check mb-2 fa-lg text-success"></i>
                                <span>Entrevistas</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="cargos.php" class="btn btn-light w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-id-badge mb-2 fa-lg text-danger"></i>
                                <span>Cargos</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="relatorios.php" class="btn btn-light w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-bar mb-2 fa-lg text-info"></i>
                                <span>Relatórios</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Atividades Recentes -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-history me-2 text-primary"></i>Atividades Recentes</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-1"></i>Filtrar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Todas</a></li>
                            <li><a class="dropdown-item" href="#">Recrutamento</a></li>
                            <li><a class="dropdown-item" href="#">Colaboradores</a></li>
                            <li><a class="dropdown-item" href="#">Treinamentos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="activity-timeline position-relative px-4 py-3">
                        <?php foreach ($atividades as $index => $atividade): ?>
                        <div class="activity-item d-flex pb-3 <?php echo $index < count($atividades) - 1 ? 'border-bottom mb-3' : ''; ?>">
                            <div class="activity-icon me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background-color: rgba(<?php echo $atividade['cor'] === 'primary' ? '52, 152, 219' : ($atividade['cor'] === 'success' ? '46, 204, 113' : ($atividade['cor'] === 'warning' ? '243, 156, 18' : ($atividade['cor'] === 'danger' ? '231, 76, 60' : '52, 152, 219'))); ?>, 0.1);">
                                    <i class="fas fa-<?php echo $atividade['icone']; ?> text-<?php echo $atividade['cor']; ?>"></i>
                                </div>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0 fw-medium"><?php echo htmlspecialchars($atividade['descricao']); ?></h6>
                                    <small class="text-muted"><?php echo date('d/m H:i', strtotime($atividade['timestamp'])); ?></small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    <?php 
                                    $tipoText = '';
                                    switch($atividade['tipo']) {
                                        case 'contratacao': $tipoText = 'Contratação'; break;
                                        case 'entrevista': $tipoText = 'Entrevista'; break;
                                        case 'treinamento': $tipoText = 'Treinamento'; break;
                                        case 'documento': $tipoText = 'Documento'; break;
                                        case 'vaga': $tipoText = 'Nova Vaga'; break;
                                        default: $tipoText = 'Outros';
                                    }
                                    echo $tipoText;
                                    ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-top text-center py-3">
                    <a href="atividades.php" class="btn btn-primary">
                        <i class="fas fa-list-ul me-2"></i>Ver Histórico Completo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para os gráficos do dashboard -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de recrutamento - processo seletivo
    const recruitmentCtx = document.getElementById('recruitmentChart').getContext('2d');
    const recruitmentChart = new Chart(recruitmentCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
            datasets: [{
                label: 'Candidatos',
                data: [65, 78, 52, 91, 43, 87, 62],
                backgroundColor: '#3498db',
                barPercentage: 0.6,
                categoryPercentage: 0.7
            }, {
                label: 'Contratações',
                data: [12, 15, 8, 13, 7, 14, 9],
                backgroundColor: '#2ecc71',
                barPercentage: 0.6,
                categoryPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                }
            }
        }
    });
    
    // Gráfico de colaboradores - evolução do quadro
    const employeeCtx = document.getElementById('employeeChart').getContext('2d');
    const employeeChart = new Chart(employeeCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
            datasets: [{
                label: 'Total Colaboradores',
                data: [89, 92, 94, 97, 99, 101, 103],
                borderColor: '#9b59b6',
                backgroundColor: 'rgba(155, 89, 182, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                }
            }
        }
    });
    
    // Alternar período dos gráficos
    document.querySelectorAll('[data-chart-period]').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('[data-chart-period]').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Em produção: Aqui teria uma requisição AJAX para atualizar os dados do gráfico
            const period = this.getAttribute('data-chart-period');
            updateChartData(period);
        });
    });
    
    // Função simulada para atualizar os dados do gráfico
    function updateChartData(period) {
        // Em produção: Aqui seria implementada a lógica real de atualização
        console.log(`Atualizando gráficos para o período: ${period}`);
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 