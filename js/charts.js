// Gerenciador de Gráficos e Visualizações
class ChartManager {
    constructor() {
        this.charts = new Map();
        this.defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: (context) => {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('pt-BR').format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        };
    }

    init() {
        // Inicializa todos os gráficos
        this.initializeCharts();
        
        // Configura listeners para redimensionamento
        this.setupResizeListeners();
        
        // Inicia atualização em tempo real
        this.startRealTimeUpdates();
    }

    initializeCharts() {
        // Gráfico de Distribuição por Departamento
        this.createDepartmentChart();

        // Gráfico de Tendências de Recrutamento
        this.createRecruitmentChart();

        // Gráfico de Progresso do Onboarding
        this.createOnboardingChart();

        // Gráfico de Desempenho em Treinamentos
        this.createTrainingChart();

        // Gráfico de Avaliações por Período
        this.createEvaluationChart();
    }

    createDepartmentChart() {
        const ctx = document.getElementById('departmentChart');
        if (!ctx) return;

        const data = window.demoData.generateChartData('department');
        
        this.charts.set('department', new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(99, 102, 241, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                ...this.defaultOptions,
                plugins: {
                    ...this.defaultOptions.plugins,
                    title: {
                        display: true,
                        text: 'Distribuição por Departamento',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                }
            }
        }));
    }

    createRecruitmentChart() {
        const ctx = document.getElementById('recruitmentChart');
        if (!ctx) return;

        const data = window.demoData.generateChartData('recruitment');
        
        this.charts.set('recruitment', new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Candidatos',
                    data: data.values,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...this.defaultOptions,
                plugins: {
                    ...this.defaultOptions.plugins,
                    title: {
                        display: true,
                        text: 'Tendência de Recrutamento',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => new Intl.NumberFormat('pt-BR').format(value)
                        }
                    }
                }
            }
        }));
    }

    createOnboardingChart() {
        const ctx = document.getElementById('onboardingChart');
        if (!ctx) return;

        const data = window.demoData.generateChartData('onboarding');
        
        this.charts.set('onboarding', new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Progresso',
                    data: data.values,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderRadius: 4
                }]
            },
            options: {
                ...this.defaultOptions,
                plugins: {
                    ...this.defaultOptions.plugins,
                    title: {
                        display: true,
                        text: 'Progresso do Onboarding',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: (value) => `${value}%`
                        }
                    }
                }
            }
        }));
    }

    createTrainingChart() {
        const ctx = document.getElementById('trainingChart');
        if (!ctx) return;

        const data = window.demoData.generateChartData('training');
        
        this.charts.set('training', new Chart(ctx, {
            type: 'radar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Desempenho',
                    data: data.values,
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgb(99, 102, 241)',
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(99, 102, 241)'
                }]
            },
            options: {
                ...this.defaultOptions,
                plugins: {
                    ...this.defaultOptions.plugins,
                    title: {
                        display: true,
                        text: 'Desempenho no Treinamento',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: (value) => `${value}%`
                        }
                    }
                }
            }
        }));
    }

    createEvaluationChart() {
        const ctx = document.getElementById('evaluationChart');
        if (!ctx) return;

        const data = window.demoData.generateChartData('evaluation');
        
        this.charts.set('evaluation', new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Avaliações',
                    data: data.values,
                    backgroundColor: 'rgba(245, 158, 11, 0.8)',
                    borderRadius: 4
                }]
            },
            options: {
                ...this.defaultOptions,
                plugins: {
                    ...this.defaultOptions.plugins,
                    title: {
                        display: true,
                        text: 'Avaliações por Período',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => new Intl.NumberFormat('pt-BR').format(value)
                        }
                    }
                }
            }
        }));
    }

    setupResizeListeners() {
        // Debounce para evitar múltiplas chamadas
        const debouncedResize = window.Utils.debounce(() => {
            this.charts.forEach(chart => chart.resize());
        }, 250);

        window.addEventListener('resize', debouncedResize);
    }

    startRealTimeUpdates() {
        // Atualiza dados a cada 5 segundos
        setInterval(() => {
            this.updateCharts();
        }, 5000);
    }

    updateCharts() {
        this.charts.forEach((chart, key) => {
            const data = window.demoData.generateChartData(key);
            
            if (data) {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.values;
                chart.update('none'); // Atualiza sem animação
            }
        });
    }

    destroy() {
        this.charts.forEach(chart => chart.destroy());
        this.charts.clear();
    }
}

// Inicializa o gerenciador de gráficos
document.addEventListener('DOMContentLoaded', () => {
    window.chartManager = new ChartManager();
    window.chartManager.init();
}); 