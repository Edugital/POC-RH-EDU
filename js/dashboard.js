// Dashboard Handler Class
class DashboardHandler {
    constructor() {
        this.charts = {};
        this.init();
    }

    init() {
        this.setupCharts();
        this.setupEventListeners();
        this.setupMobileInteractions();
    }

    setupCharts() {
        // Performance Chart
        const performanceCtx = document.getElementById('performanceChart');
        if (performanceCtx) {
            this.charts.performance = new Chart(performanceCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    datasets: [{
                        label: 'TI',
                        data: [85, 88, 92, 90, 95, 93],
                        borderColor: '#E31837',
                        tension: 0.4
                    }, {
                        label: 'RH',
                        data: [82, 85, 88, 87, 90, 92],
                        borderColor: '#2C3E50',
                        tension: 0.4
                    }, {
                        label: 'Financeiro',
                        data: [88, 90, 92, 91, 94, 96],
                        borderColor: '#27AE60',
                        tension: 0.4
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
                            max: 100
                        }
                    }
                }
            });
        }

        // Roles Chart
        const rolesCtx = document.getElementById('rolesChart');
        if (rolesCtx) {
            this.charts.roles = new Chart(rolesCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['TI', 'RH', 'Financeiro', 'Operacional', 'Administrativo'],
                    datasets: [{
                        data: [30, 20, 15, 25, 10],
                        backgroundColor: [
                            '#E31837',
                            '#2C3E50',
                            '#27AE60',
                            '#F39C12',
                            '#8E44AD'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    }

    setupEventListeners() {
        // Performance Period Select
        const performancePeriod = document.getElementById('performancePeriod');
        if (performancePeriod) {
            performancePeriod.addEventListener('change', (e) => {
                this.updatePerformanceChart(e.target.value);
            });
        }

        // Refresh Button
        const refreshButton = document.querySelector('.btn-primary');
        if (refreshButton) {
            refreshButton.addEventListener('click', () => {
                this.refreshDashboard();
            });
        }
    }

    setupMobileInteractions() {
        // Touch feedback for cards
        const cards = document.querySelectorAll('.card, .metric-card');
        cards.forEach(card => {
            card.addEventListener('touchstart', () => {
                card.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', () => {
                card.style.transform = '';
            });
        });

        // Handle orientation changes
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.updateCharts();
            }, 150);
        });
    }

    updatePerformanceChart(period) {
        if (!this.charts.performance) return;

        // Simulate data update based on period
        const data = this.getPerformanceData(period);
        this.charts.performance.data.labels = data.labels;
        this.charts.performance.data.datasets = data.datasets;
        this.charts.performance.update();
    }

    getPerformanceData(period) {
        // Mock data for different periods
        const data = {
            month: {
                labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
                datasets: [{
                    label: 'TI',
                    data: [92, 95, 93, 96],
                    borderColor: '#E31837',
                    tension: 0.4
                }, {
                    label: 'RH',
                    data: [88, 92, 90, 93],
                    borderColor: '#2C3E50',
                    tension: 0.4
                }, {
                    label: 'Financeiro',
                    data: [94, 96, 95, 97],
                    borderColor: '#27AE60',
                    tension: 0.4
                }]
            },
            quarter: {
                labels: ['Jan', 'Fev', 'Mar'],
                datasets: [{
                    label: 'TI',
                    data: [85, 88, 92],
                    borderColor: '#E31837',
                    tension: 0.4
                }, {
                    label: 'RH',
                    data: [82, 85, 88],
                    borderColor: '#2C3E50',
                    tension: 0.4
                }, {
                    label: 'Financeiro',
                    data: [88, 90, 92],
                    borderColor: '#27AE60',
                    tension: 0.4
                }]
            },
            year: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'TI',
                    data: [85, 88, 92, 90, 95, 93],
                    borderColor: '#E31837',
                    tension: 0.4
                }, {
                    label: 'RH',
                    data: [82, 85, 88, 87, 90, 92],
                    borderColor: '#2C3E50',
                    tension: 0.4
                }, {
                    label: 'Financeiro',
                    data: [88, 90, 92, 91, 94, 96],
                    borderColor: '#27AE60',
                    tension: 0.4
                }]
            }
        };

        return data[period] || data.month;
    }

    updateCharts() {
        Object.values(this.charts).forEach(chart => {
            if (chart) {
                chart.resize();
            }
        });
    }

    refreshDashboard() {
        // Show loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
        document.body.appendChild(loadingOverlay);

        // Simulate data refresh
        setTimeout(() => {
            // Update metrics
            this.updateMetrics();
            
            // Update charts
            this.updateCharts();
            
            // Remove loading overlay
            loadingOverlay.remove();
            
            // Show success message
            this.showToast('Dashboard atualizado com sucesso!', 'success');
        }, 1500);
    }

    updateMetrics() {
        // Simulate metric updates
        const metrics = document.querySelectorAll('.metric-value');
        metrics.forEach(metric => {
            const currentValue = parseFloat(metric.textContent);
            const randomChange = (Math.random() - 0.5) * 2;
            const newValue = currentValue + randomChange;
            metric.textContent = newValue.toFixed(1);
        });
    }

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        const container = document.querySelector('.toast-container') || document.body;
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.dashboardHandler = new DashboardHandler();
}); 