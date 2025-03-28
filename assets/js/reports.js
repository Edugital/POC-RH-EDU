// Configuração global do Chart.js
Chart.defaults.font.family = 'Montserrat, sans-serif';
Chart.defaults.color = '#495057';

// Dados mockados para os gráficos
const mockData = {
    payroll: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        data: [2300000, 2350000, 2400000, 2450000, 2480000, 2500000, 2550000, 2600000, 2650000, 2700000, 2750000, 2800000],
        projection: [2850000, 2900000, 2950000]
    },
    departments: {
        labels: ['TI', 'RH', 'Financeiro', 'Marketing', 'Vendas', 'Operacional'],
        data: [300, 150, 200, 180, 250, 154],
        colors: [
            '#E31837', // Vermelho Águia Branca
            '#003B70', // Azul Escuro
            '#28A745', // Verde
            '#FFC107', // Amarelo
            '#17A2B8', // Azul Claro
            '#6C757D'  // Cinza
        ]
    },
    turnover: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        data: [8.5, 8.2, 7.8, 7.5, 7.2, 7.0],
        target: 6.5
    },
    performance: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        data: [4.1, 4.2, 4.3, 4.4, 4.5, 4.6],
        target: 4.8
    }
};

// Função para formatar valores monetários
function formatCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

// Função para formatar percentuais
function formatPercentage(value) {
    return value.toFixed(1) + '%';
}

// Gráfico de Evolução da Folha de Pagamento
function initPayrollChart() {
    const ctx = document.getElementById('payrollChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [...mockData.payroll.labels, 'Proj. Jan', 'Proj. Fev', 'Proj. Mar'],
            datasets: [{
                label: 'Folha de Pagamento',
                data: [...mockData.payroll.data, ...mockData.payroll.projection],
                borderColor: '#E31837',
                backgroundColor: 'rgba(227, 24, 55, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return formatCurrency(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    }
                }
            }
        }
    });
}

// Gráfico de Distribuição por Departamento
function initDepartmentChart() {
    const ctx = document.getElementById('departmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: mockData.departments.labels,
            datasets: [{
                data: mockData.departments.data,
                backgroundColor: mockData.departments.colors,
                borderWidth: 0
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
}

// Gráfico de Turnover
function initTurnoverChart() {
    const ctx = document.getElementById('turnoverChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: mockData.turnover.labels,
            datasets: [{
                label: 'Taxa de Turnover',
                data: mockData.turnover.data,
                borderColor: '#003B70',
                backgroundColor: 'rgba(0, 59, 112, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }, {
                label: 'Meta',
                data: Array(6).fill(mockData.turnover.target),
                borderColor: '#28A745',
                borderDash: [5, 5],
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return formatPercentage(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatPercentage(value);
                        }
                    }
                }
            }
        }
    });
}

// Gráfico de Desempenho
function initPerformanceChart() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: mockData.performance.labels,
            datasets: [{
                label: 'Desempenho Médio',
                data: mockData.performance.data,
                borderColor: '#E31837',
                backgroundColor: 'rgba(227, 24, 55, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }, {
                label: 'Meta',
                data: Array(6).fill(mockData.performance.target),
                borderColor: '#28A745',
                borderDash: [5, 5],
                borderWidth: 2,
                fill: false
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
                    max: 5
                }
            }
        }
    });
}

// Inicialização dos gráficos quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    initPayrollChart();
    initDepartmentChart();
    initTurnoverChart();
    initPerformanceChart();
}); 