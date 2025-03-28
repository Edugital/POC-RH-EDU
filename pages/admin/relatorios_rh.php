<?php
$pageTitle = 'Relatórios RH';
$styles = '
<style>
    .report-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s;
    }
    .report-card:hover {
        transform: translateY(-2px);
    }
    .metric-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
    }
    .metric-label {
        color: #7f8c8d;
        font-size: 0.9rem;
    }
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }
    .report-section {
        margin-bottom: 30px;
    }
    .report-section-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .report-section-title i {
        color: #3498db;
    }
    .table-responsive {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .status-pending {
        background: #fff3e0;
        color: #ef6c00;
    }
    .status-inactive {
        background: #ffebee;
        color: #c62828;
    }
</style>
';

ob_start();
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Relatórios de RH</h1>
        <div class="btn-group">
            <button class="btn btn-outline-primary">
                <i class="fas fa-download me-2"></i>Exportar
            </button>
            <button class="btn btn-outline-primary">
                <i class="fas fa-filter me-2"></i>Filtros
            </button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="report-card">
                <div class="metric-value">1,234</div>
                <div class="metric-label">Total de Colaboradores</div>
                <div class="mt-2">
                    <span class="text-success"><i class="fas fa-arrow-up"></i> 5.2%</span>
                    <span class="text-muted ms-2">vs mês anterior</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="report-card">
                <div class="metric-value">R$ 2.5M</div>
                <div class="metric-label">Folha de Pagamento</div>
                <div class="mt-2">
                    <span class="text-success"><i class="fas fa-arrow-up"></i> 3.8%</span>
                    <span class="text-muted ms-2">vs mês anterior</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="report-card">
                <div class="metric-value">92%</div>
                <div class="metric-label">Satisfação dos Colaboradores</div>
                <div class="mt-2">
                    <span class="text-success"><i class="fas fa-arrow-up"></i> 2.1%</span>
                    <span class="text-muted ms-2">vs mês anterior</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="report-card">
                <div class="metric-value">15</div>
                <div class="metric-label">Vagas Abertas</div>
                <div class="mt-2">
                    <span class="text-danger"><i class="fas fa-arrow-down"></i> 2.3%</span>
                    <span class="text-muted ms-2">vs mês anterior</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="report-card">
                <div class="report-section-title">
                    <i class="fas fa-chart-line"></i>
                    Evolução da Folha de Pagamento
                </div>
                <div class="chart-container">
                    <canvas id="payrollChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="report-card">
                <div class="report-section-title">
                    <i class="fas fa-users"></i>
                    Distribuição por Departamento
                </div>
                <div class="chart-container">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Table -->
    <div class="report-section">
        <div class="report-section-title">
            <i class="fas fa-table"></i>
            Relatório de Colaboradores
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Departamento</th>
                        <th>Cargo</th>
                        <th>Status</th>
                        <th>Data de Admissão</th>
                        <th>Salário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#EMP001</td>
                        <td>João Silva</td>
                        <td>TI</td>
                        <td>Desenvolvedor Senior</td>
                        <td><span class="status-badge status-active">Ativo</span></td>
                        <td>15/01/2023</td>
                        <td>R$ 8.500,00</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-download"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>#EMP002</td>
                        <td>Maria Santos</td>
                        <td>RH</td>
                        <td>Analista de RH</td>
                        <td><span class="status-badge status-active">Ativo</span></td>
                        <td>20/02/2023</td>
                        <td>R$ 6.200,00</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-download"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Payroll Evolution Chart
const payrollCtx = document.getElementById('payrollChart').getContext('2d');
new Chart(payrollCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        datasets: [{
            label: 'Folha de Pagamento (R$)',
            data: [2300000, 2350000, 2400000, 2450000, 2480000, 2500000],
            borderColor: '#3498db',
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(52, 152, 219, 0.1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + (value/1000000).toFixed(1) + 'M';
                    }
                }
            }
        }
    }
});

// Department Distribution Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
new Chart(departmentCtx, {
    type: 'doughnut',
    data: {
        labels: ['TI', 'RH', 'Financeiro', 'Marketing', 'Vendas', 'Operacional'],
        datasets: [{
            data: [300, 150, 200, 180, 250, 154],
            backgroundColor: [
                '#3498db',
                '#2ecc71',
                '#e74c3c',
                '#f1c40f',
                '#9b59b6',
                '#1abc9c'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 