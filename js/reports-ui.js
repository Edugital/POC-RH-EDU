/**
 * Interface de Usuário para Relatórios
 * Gerencia a exibição e interação com os relatórios
 */
class ReportsUI {
    constructor() {
        this.activeReport = 'employee';
        this.filters = {
            period: 'month',
            department: 'all',
            metric: 'all'
        };
        this.charts = new Map();
        this.isLoading = false;
    }
    
    /**
     * Inicializa a interface de relatórios
     */
    init() {
        this._setupEventListeners();
        this._setupExportButtons();
        this.loadReport(this.activeReport, this.filters);
    }
    
    /**
     * Carrega um relatório com os filtros especificados
     * @param {string} reportType - Tipo de relatório a carregar
     * @param {Object} filters - Filtros a aplicar
     */
    async loadReport(reportType, filters) {
        this.activeReport = reportType;
        this.filters = { ...this.filters, ...filters };
        
        this._startLoading();
        
        try {
            // Obtém dados via API
            const data = await window.reportsAPI.getReportData(reportType, this.filters);
            
            // Atualiza métricas na interface
            this._updateMetrics(data.metrics);
            
            // Renderiza ou atualiza gráficos
            this._renderCharts(data.chart_data);
            
            // Atualiza UI para refletir filtros ativos
            this._updateActiveFilters();
            
        } catch (error) {
            console.error('Erro ao carregar relatório:', error);
            this._showError('Não foi possível carregar os dados do relatório.');
        } finally {
            this._stopLoading();
        }
    }
    
    /**
     * Exporta o relatório atual
     * @param {string} format - Formato de exportação (pdf, excel, csv)
     */
    async exportReport(format) {
        if (this.isLoading) return;
        
        const exportButton = document.querySelector(`[data-export="${format}"]`);
        if (exportButton) {
            const originalText = exportButton.innerHTML;
            exportButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
            exportButton.disabled = true;
            
            try {
                const result = await window.reportsAPI.exportReport(
                    format, 
                    this.activeReport, 
                    this.filters
                );
                
                if (result.success) {
                    // Se for um blob, cria um link de download
                    if (result instanceof Blob) {
                        const url = URL.createObjectURL(result);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `relatorio-${this.activeReport}.${format}`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    }
                    // Se for uma URL de download, redireciona
                    else if (result.downloadUrl && !result.downloadUrl.startsWith('#mock')) {
                        window.location.href = result.downloadUrl;
                    }
                }
                
            } catch (error) {
                console.error('Erro na exportação:', error);
                this._showError('Não foi possível exportar o relatório.');
            } finally {
                setTimeout(() => {
                    exportButton.innerHTML = originalText;
                    exportButton.disabled = false;
                }, 1000);
            }
        }
    }
    
    /**
     * Configura listeners de eventos para a interface
     */
    _setupEventListeners() {
        // Filtros de período
        const periodFilter = document.getElementById('period');
        if (periodFilter) {
            periodFilter.addEventListener('change', (e) => {
                this.loadReport(this.activeReport, { period: e.target.value });
            });
        }
        
        // Filtros de departamento
        const departmentFilter = document.getElementById('department');
        if (departmentFilter) {
            departmentFilter.addEventListener('change', (e) => {
                this.loadReport(this.activeReport, { department: e.target.value });
            });
        }
        
        // Filtros de métrica
        const metricFilter = document.getElementById('metric');
        if (metricFilter) {
            metricFilter.addEventListener('change', (e) => {
                this.loadReport(this.activeReport, { metric: e.target.value });
            });
        }
        
        // Abas de relatórios
        const reportTabs = document.querySelectorAll('[data-report]');
        reportTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const reportType = tab.dataset.report;
                
                // Remove classe ativa de todas as abas
                reportTabs.forEach(t => t.classList.remove('active'));
                // Adiciona classe ativa à aba clicada
                tab.classList.add('active');
                
                this.loadReport(reportType, this.filters);
            });
        });
    }
    
    /**
     * Configura botões de exportação
     */
    _setupExportButtons() {
        const exportButtons = document.querySelectorAll('[data-export]');
        exportButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const format = button.dataset.export;
                this.exportReport(format);
            });
        });
    }
    
    /**
     * Atualiza cartões de métricas
     * @param {Object} metrics - Dados de métricas do relatório
     */
    _updateMetrics(metrics) {
        // Para cada métrica, atualiza os elementos correspondentes
        Object.entries(metrics).forEach(([key, value]) => {
            const elements = document.querySelectorAll(`[data-metric="${key}"] .metric-value`);
            elements.forEach(el => {
                // Formata valor com base no tipo
                let formattedValue = value;
                
                // Adiciona % para taxas
                if (key.includes('rate') || key.includes('percentage') || key.includes('index')) {
                    formattedValue = `${value}%`;
                }
                // Formata valores monetários
                else if (key.includes('cost') || key.includes('salary')) {
                    formattedValue = `R$ ${value.toLocaleString('pt-BR')}`;
                }
                // Formata valores decimais
                else if (typeof value === 'number' && !Number.isInteger(value)) {
                    formattedValue = value.toFixed(1);
                }
                
                el.textContent = formattedValue;
                
                // Anima o valor para chamar atenção para mudanças
                el.classList.add('updated');
                setTimeout(() => {
                    el.classList.remove('updated');
                }, 1000);
            });
        });
    }
    
    /**
     * Renderiza ou atualiza gráficos com os novos dados
     * @param {Object} chartData - Dados para os gráficos
     */
    _renderCharts(chartData) {
        // Verifica quais gráficos existem nos dados e renderiza cada um
        
        // Gráfico de série temporal
        if (chartData.time_series) {
            this._renderTimeSeriesChart(chartData.time_series);
        }
        
        // Gráfico de departamentos
        if (chartData.departments) {
            this._renderDepartmentsChart(chartData.departments);
        }
        
        // Gráfico de comparação
        if (chartData.comparison) {
            this._renderComparisonChart(chartData.comparison);
        }
        
        // Gráfico de demographics (se existir)
        if (chartData.demographics) {
            this._renderDemographicsChart(chartData.demographics);
        }
        
        // Gráficos específicos por tipo de relatório
        if (chartData.skill_gaps) {
            this._renderSkillGapsChart(chartData.skill_gaps);
        }
        
        if (chartData.completion) {
            this._renderCompletionChart(chartData.completion);
        }
        
        if (chartData.effectiveness) {
            this._renderEffectivenessChart(chartData.effectiveness);
        }
    }
    
    /**
     * Renderiza gráfico de série temporal
     */
    _renderTimeSeriesChart(data) {
        const ctx = document.getElementById('timeSeriesChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('timeSeries')) {
            this.charts.get('timeSeries').destroy();
        }
        
        // Configura datasets com cores adequadas
        const datasets = data.datasets.map((dataset, index) => {
            const colors = [
                { line: 'rgb(59, 130, 246)', fill: 'rgba(59, 130, 246, 0.1)' },
                { line: 'rgb(16, 185, 129)', fill: 'rgba(16, 185, 129, 0.1)' },
                { line: 'rgb(245, 158, 11)', fill: 'rgba(245, 158, 11, 0.1)' }
            ];
            const color = colors[index % colors.length];
            
            return {
                ...dataset,
                borderColor: color.line,
                backgroundColor: color.fill,
                tension: 0.4,
                fill: true
            };
        });
        
        // Cria novo gráfico
        this.charts.set('timeSeries', new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }));
    }
    
    /**
     * Renderiza gráfico de departamentos 
     */
    _renderDepartmentsChart(data) {
        const ctx = document.getElementById('departmentsChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('departments')) {
            this.charts.get('departments').destroy();
        }
        
        // Adiciona cores aos datasets
        const datasets = data.datasets.map(dataset => {
            return {
                ...dataset,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(99, 102, 241, 0.8)'
                ],
                borderWidth: 0
            };
        });
        
        // Cria novo gráfico
        this.charts.set('departments', new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: datasets.length > 1,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }));
    }
    
    /**
     * Renderiza gráfico de comparação
     */
    _renderComparisonChart(data) {
        const ctx = document.getElementById('comparisonChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('comparison')) {
            this.charts.get('comparison').destroy();
        }
        
        // Adiciona cores aos datasets
        const datasets = data.datasets.map((dataset, index) => {
            const colors = [
                'rgba(59, 130, 246, 0.7)',
                'rgba(16, 185, 129, 0.7)'
            ];
            
            return {
                ...dataset,
                backgroundColor: colors[index % colors.length],
                borderWidth: 0
            };
        });
        
        // Cria novo gráfico
        this.charts.set('comparison', new Chart(ctx, {
            type: 'radar',
            data: {
                labels: data.labels,
                datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true
                    }
                }
            }
        }));
    }
    
    /**
     * Renderiza gráfico de características demográficas
     */
    _renderDemographicsChart(data) {
        const ctx = document.getElementById('demographicsChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('demographics')) {
            this.charts.get('demographics').destroy();
        }
        
        // Adiciona cores aos datasets
        const datasets = data.datasets.map(dataset => {
            return {
                ...dataset,
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(99, 102, 241, 0.7)'
                ],
                borderWidth: 0
            };
        });
        
        // Cria novo gráfico
        this.charts.set('demographics', new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets
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
        }));
    }
    
    /**
     * Renderiza gráfico de lacunas de habilidades
     */
    _renderSkillGapsChart(data) {
        const ctx = document.getElementById('skillGapsChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('skillGaps')) {
            this.charts.get('skillGaps').destroy();
        }
        
        // Cria novo gráfico
        this.charts.set('skillGaps', new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    ...data.datasets[0],
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        }));
    }
    
    /**
     * Renderiza gráfico de taxas de conclusão
     */
    _renderCompletionChart(data) {
        const ctx = document.getElementById('completionChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('completion')) {
            this.charts.get('completion').destroy();
        }
        
        // Cria novo gráfico
        this.charts.set('completion', new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    ...data.datasets[0],
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        }));
    }
    
    /**
     * Renderiza gráfico de efetividade
     */
    _renderEffectivenessChart(data) {
        const ctx = document.getElementById('effectivenessChart');
        if (!ctx) return;
        
        // Destrói gráfico anterior se existir
        if (this.charts.has('effectiveness')) {
            this.charts.get('effectiveness').destroy();
        }
        
        // Cria novo gráfico
        this.charts.set('effectiveness', new Chart(ctx, {
            type: 'radar',
            data: {
                labels: data.labels,
                datasets: [{
                    ...data.datasets[0],
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgb(99, 102, 241)',
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(99, 102, 241)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        }));
    }
    
    /**
     * Atualiza a interface para refletir os filtros ativos
     */
    _updateActiveFilters() {
        // Atualiza seletores
        const periodFilter = document.getElementById('period');
        if (periodFilter) {
            periodFilter.value = this.filters.period;
        }
        
        const departmentFilter = document.getElementById('department');
        if (departmentFilter) {
            departmentFilter.value = this.filters.department;
        }
        
        const metricFilter = document.getElementById('metric');
        if (metricFilter) {
            metricFilter.value = this.filters.metric;
        }
        
        // Atualiza abas
        const reportTabs = document.querySelectorAll('[data-report]');
        reportTabs.forEach(tab => {
            if (tab.dataset.report === this.activeReport) {
                tab.classList.add('active');
            } else {
                tab.classList.remove('active');
            }
        });
        
        // Atualiza título da página se necessário
        const reportTitle = document.querySelector('.report-title');
        if (reportTitle) {
            const titles = {
                'employee': 'Relatórios de Colaboradores',
                'recruitment': 'Relatórios de Recrutamento',
                'performance': 'Relatórios de Desempenho',
                'training': 'Relatórios de Treinamento'
            };
            reportTitle.textContent = titles[this.activeReport] || 'Relatórios';
        }
    }
    
    /**
     * Exibe estado de carregamento
     */
    _startLoading() {
        this.isLoading = true;
        
        // Adiciona overlay de carregamento
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = `
            <div class="spinner-container">
                <div class="spinner"></div>
                <p>Carregando dados...</p>
            </div>
        `;
        document.querySelector('.dashboard-content').appendChild(loadingOverlay);
        
        // Desabilita controles durante carregamento
        document.querySelectorAll('select, button').forEach(el => {
            el.disabled = true;
        });
    }
    
    /**
     * Remove estado de carregamento
     */
    _stopLoading() {
        this.isLoading = false;
        
        // Remove overlay de carregamento
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.classList.add('fade-out');
            setTimeout(() => {
                loadingOverlay.remove();
            }, 300);
        }
        
        // Reabilita controles
        document.querySelectorAll('select, button').forEach(el => {
            el.disabled = false;
        });
    }
    
    /**
     * Exibe mensagem de erro
     */
    _showError(message) {
        const errorEl = document.createElement('div');
        errorEl.className = 'alert alert-danger';
        errorEl.textContent = message;
        
        const content = document.querySelector('.dashboard-content');
        content.insertBefore(errorEl, content.firstChild);
        
        setTimeout(() => {
            errorEl.classList.add('fade-out');
            setTimeout(() => {
                errorEl.remove();
            }, 300);
        }, 5000);
    }
}

// Inicializa a interface de relatórios quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.reportsUI = new ReportsUI();
    window.reportsUI.init();
}); 