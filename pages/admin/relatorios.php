<?php
session_start();

// Configurações de cabeçalho básicas
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// Base path e página atual
$basePath = '../';
$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = 'Relatórios';

// Iniciar captura do conteúdo
ob_start();
?>

<!-- Importações CSS específicas para relatórios -->
<link rel="stylesheet" href="../../css/reports.css">

<!-- Reports Content -->
<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="report-title"><?php echo htmlspecialchars($pageTitle); ?></h1>
        <div class="export-buttons">
            <button class="btn btn-primary" data-export="pdf">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button class="btn btn-success" data-export="excel">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button class="btn btn-secondary" data-export="csv">
                <i class="fas fa-file-csv"></i> CSV
            </button>
        </div>
    </div>
    
    <!-- Abas de relatórios -->
    <div class="report-tabs">
        <button class="report-tab active" data-report="employee">
            <i class="fas fa-users"></i> Colaboradores
        </button>
        <button class="report-tab" data-report="recruitment">
            <i class="fas fa-user-plus"></i> Recrutamento
        </button>
        <button class="report-tab" data-report="performance">
            <i class="fas fa-chart-line"></i> Desempenho
        </button>
        <button class="report-tab" data-report="training">
            <i class="fas fa-graduation-cap"></i> Treinamentos
        </button>
    </div>

    <!-- Filtros -->
    <div class="report-filters">
        <div class="filter-group">
            <label for="period">Período</label>
            <select id="period" class="form-select">
                <option value="today">Hoje</option>
                <option value="week">Esta Semana</option>
                <option value="month" selected>Este Mês</option>
                <option value="quarter">Este Trimestre</option>
                <option value="year">Este Ano</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="department">Departamento</label>
            <select id="department" class="form-select">
                <option value="all">Todos</option>
                <option value="rh">RH</option>
                <option value="ti">TI</option>
                <option value="operacoes">Operações</option>
                <option value="financas">Finanças</option>
                <option value="marketing">Marketing</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="metric">Métrica</label>
            <select id="metric" class="form-select">
                <option value="all">Todas</option>
                <option value="recruitment">Recrutamento</option>
                <option value="performance">Desempenho</option>
                <option value="engagement">Engajamento</option>
                <option value="training">Treinamentos</option>
            </select>
        </div>
    </div>

    <!-- KPIs Estratégicos -->
    <div class="report-section scroll-reveal">
        <h2 class="report-subtitle">
            <i class="icon fas fa-chart-bar"></i>
            KPIs Estratégicos
        </h2>
        <div class="reports-grid">
            <div class="metric-card primary" data-metric="turnover_rate" data-tooltip="Taxa de rotatividade de pessoal">
                <div class="metric-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="metric-info">
                    <h3>Turnover</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend negative">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                    <div class="metric-target">
                        Meta: <span>6.5%</span>
                    </div>
                </div>
            </div>
            <div class="metric-card secondary" data-metric="avg_tenure" data-tooltip="Tempo médio na empresa">
                <div class="metric-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="metric-info">
                    <h3>Tempo Médio</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                    <div class="metric-target">
                        Meta: <span>4.0 anos</span>
                    </div>
                </div>
            </div>
            <div class="metric-card success" data-metric="satisfaction_score" data-tooltip="Índice de satisfação">
                <div class="metric-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <div class="metric-info">
                    <h3>Satisfação</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                    <div class="metric-target">
                        Meta: <span>4.5</span>
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="engagement_score" data-tooltip="Nível de engajamento dos colaboradores">
                <div class="metric-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="metric-info">
                    <h3>Engajamento</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                    <div class="metric-target">
                        Meta: <span>85%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="reports-grid">
            <div class="chart-container">
                <div class="chart-header">
                    <h3>Evolução no Tempo</h3>
                    <div class="chart-actions">
                        <button class="btn-icon" data-tooltip="Filtrar">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button class="btn-icon" data-tooltip="Exportar">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-content">
                    <canvas id="timeSeriesChart"></canvas>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <h3>Distribuição por Departamento</h3>
                </div>
                <div class="chart-content">
                    <canvas id="departmentsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Comparação -->
        <div class="chart-container large">
            <div class="chart-header">
                <h3>Comparativo de Métricas</h3>
            </div>
            <div class="chart-content">
                <canvas id="comparisonChart"></canvas>
            </div>
        </div>
        
        <!-- Características Demográficas -->
        <div class="chart-container">
            <div class="chart-header">
                <h3>Distribuição Etária</h3>
            </div>
            <div class="chart-content">
                <canvas id="demographicsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Métricas de Recrutamento -->
    <div class="report-section scroll-reveal">
        <h2 class="report-subtitle">
            <i class="icon fas fa-user-plus"></i>
            Métricas de Recrutamento
        </h2>
        <div class="reports-grid">
            <div class="metric-card standard" data-metric="total_candidates" data-tooltip="Total de candidatos ativos">
                <div class="metric-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="metric-info">
                    <h3>Candidatos Ativos</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="active_vacancies" data-tooltip="Vagas abertas">
                <div class="metric-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="metric-info">
                    <h3>Vagas Abertas</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend">
                        --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="hiring_rate" data-tooltip="Taxa de contratação">
                <div class="metric-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="metric-info">
                    <h3>Taxa de Contratação</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="avg_time_to_hire" data-tooltip="Tempo médio de contratação">
                <div class="metric-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="metric-info">
                    <h3>Tempo de Contratação</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend negative">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas de Desempenho -->
    <div class="report-section scroll-reveal">
        <h2 class="report-subtitle">
            <i class="icon fas fa-chart-line"></i>
            Métricas de Desempenho
        </h2>
        <div class="reports-grid">
            <div class="metric-card standard" data-metric="avg_performance" data-tooltip="Média de desempenho">
                <div class="metric-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="metric-info">
                    <h3>Desempenho Médio</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="goals_achievement" data-tooltip="Metas alcançadas">
                <div class="metric-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="metric-info">
                    <h3>Metas Alcançadas</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="high_performers" data-tooltip="Alto desempenho">
                <div class="metric-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="metric-info">
                    <h3>Alto Desempenho</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card warning" data-metric="skill_gaps" data-tooltip="Lacunas de habilidades">
                <div class="metric-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="metric-info">
                    <h3>Lacunas de Habilidades</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend negative">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Lacunas de Habilidades -->
        <div class="chart-container large">
            <div class="chart-header">
                <h3>Lacunas de Habilidades Identificadas</h3>
            </div>
            <div class="chart-content">
                <canvas id="skillGapsChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Métricas de Treinamento -->
    <div class="report-section scroll-reveal">
        <h2 class="report-subtitle">
            <i class="icon fas fa-graduation-cap"></i>
            Métricas de Treinamento
        </h2>
        <div class="reports-grid">
            <div class="metric-card success" data-metric="training_completion" data-tooltip="Taxa de conclusão de treinamentos">
                <div class="metric-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="metric-info">
                    <h3>Conclusão de Treinamentos</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
            <div class="metric-card standard" data-metric="certification_rate" data-tooltip="Taxa de certificação">
                <div class="metric-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="metric-info">
                    <h3>Taxa de Certificação</h3>
                    <div class="metric-value">--</div>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i> --
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráficos de Treinamento -->
        <div class="reports-grid">
            <div class="chart-container">
                <div class="chart-header">
                    <h3>Taxa de Conclusão por Tipo</h3>
                </div>
                <div class="chart-content">
                    <canvas id="completionChart"></canvas>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <h3>Efetividade do Treinamento</h3>
                </div>
                <div class="chart-content">
                    <canvas id="effectivenessChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts específicos para relatórios -->
<script src="../../js/reports-api.js"></script>
<script src="../../js/reports-ui.js"></script>

<!-- Script para inicializar animações de scroll -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configura animações baseadas em scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        
        // Adiciona todas as seções ao observer
        document.querySelectorAll('.scroll-reveal').forEach(section => {
            observer.observe(section);
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 