// Configuração dos KPIs Estratégicos
const strategicMetrics = {
    turnover: {
        current: 8.5,
        target: 6.5,
        trend: -0.5,
        historical: [9.2, 8.8, 8.5, 8.2, 7.8, 7.5, 7.2, 7.0],
        projection: [6.8, 6.6, 6.5]
    },
    tenure: {
        current: 3.2,
        target: 4.0,
        trend: 0.2,
        historical: [2.8, 2.9, 3.0, 3.1, 3.2, 3.3, 3.4, 3.5],
        projection: [3.6, 3.8, 4.0]
    },
    absenteeism: {
        current: 4.2,
        target: 3.5,
        trend: -0.3,
        historical: [4.8, 4.6, 4.4, 4.3, 4.2, 4.1, 4.0, 3.9],
        projection: [3.8, 3.6, 3.5]
    },
    engagement: {
        current: 78,
        target: 85,
        trend: 2,
        historical: [72, 73, 74, 75, 76, 77, 78, 79],
        projection: [81, 83, 85]
    }
};

// Função para formatar valores
function formatMetric(value, type) {
    switch(type) {
        case 'percentage':
            return value.toFixed(1) + '%';
        case 'years':
            return value.toFixed(1) + ' anos';
        case 'days':
            return value.toFixed(1) + ' dias';
        default:
            return value;
    }
}

// Função para calcular tendência
function calculateTrend(current, previous) {
    const difference = current - previous;
    const percentage = (difference / previous) * 100;
    return {
        value: difference,
        percentage: percentage.toFixed(1),
        direction: difference >= 0 ? 'up' : 'down'
    };
}

// Função para atualizar cards de métricas
function updateMetricCards() {
    Object.entries(strategicMetrics).forEach(([key, metric]) => {
        const card = document.querySelector(`[data-metric="${key}"]`);
        if (!card) return;

        const currentValue = card.querySelector('.metric-value');
        const trendValue = card.querySelector('.metric-trend');
        const targetValue = card.querySelector('.metric-target');

        if (currentValue) {
            currentValue.textContent = formatMetric(metric.current, key === 'engagement' ? 'percentage' : 'days');
        }

        if (trendValue) {
            const trend = calculateTrend(metric.current, metric.historical[metric.historical.length - 2]);
            trendValue.innerHTML = `
                <i class="fas fa-arrow-${trend.direction}"></i>
                ${Math.abs(trend.percentage)}%
            `;
            trendValue.className = `metric-trend ${trend.direction === 'up' ? 'positive' : 'negative'}`;
        }

        if (targetValue) {
            targetValue.textContent = formatMetric(metric.target, key === 'engagement' ? 'percentage' : 'days');
        }
    });
}

// Função para criar gráfico de tendência
function createTrendChart(metricKey, containerId) {
    const metric = strategicMetrics[metricKey];
    const ctx = document.getElementById(containerId).getContext('2d');
    
    const labels = [...Array(8).keys()].map(i => `Mês ${i + 1}`);
    const data = [...metric.historical, ...metric.projection];
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valor Atual',
                data: data,
                borderColor: '#E31837',
                backgroundColor: 'rgba(227, 24, 55, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }, {
                label: 'Meta',
                data: Array(8).fill(metric.target),
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
                            return formatMetric(context.raw, metricKey === 'engagement' ? 'percentage' : 'days');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatMetric(value, metricKey === 'engagement' ? 'percentage' : 'days');
                        }
                    }
                }
            }
        }
    });
}

// Função para criar gráfico de comparação
function createComparisonChart(containerId) {
    const ctx = document.getElementById(containerId).getContext('2d');
    
    const labels = Object.keys(strategicMetrics);
    const currentData = labels.map(key => strategicMetrics[key].current);
    const targetData = labels.map(key => strategicMetrics[key].target);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(key => {
                switch(key) {
                    case 'turnover': return 'Turnover';
                    case 'tenure': return 'Tempo Médio';
                    case 'absenteeism': return 'Absenteísmo';
                    case 'engagement': return 'Engajamento';
                    default: return key;
                }
            }),
            datasets: [{
                label: 'Atual',
                data: currentData,
                backgroundColor: '#E31837',
                borderWidth: 0
            }, {
                label: 'Meta',
                data: targetData,
                backgroundColor: '#28A745',
                borderWidth: 0
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
                            const metricKey = labels[context.dataIndex];
                            return formatMetric(context.raw, metricKey === 'engagement' ? 'percentage' : 'days');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatMetric(value, 'percentage');
                        }
                    }
                }
            }
        }
    });
}

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    updateMetricCards();
    
    // Criar gráficos de tendência
    createTrendChart('turnover', 'turnoverTrendChart');
    createTrendChart('tenure', 'tenureTrendChart');
    createTrendChart('absenteeism', 'absenteeismTrendChart');
    createTrendChart('engagement', 'engagementTrendChart');
    
    // Criar gráfico de comparação
    createComparisonChart('metricsComparisonChart');
}); 