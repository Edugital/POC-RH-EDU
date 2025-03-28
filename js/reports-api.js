/**
 * API de Relatórios - Interface para obtenção e manipulação de dados
 */
class ReportsAPI {
    constructor() {
        this.endpoints = {
            recruitment: '/api/reports/recruitment',
            performance: '/api/reports/performance',
            employee: '/api/reports/employee',
            training: '/api/reports/training'
        };
        
        // Para demonstração, usamos dados simulados
        this.mockData = true;
    }

    /**
     * Obtém dados de relatório conforme os parâmetros
     * @param {string} reportType - Tipo de relatório (recruitment, performance, employee, training)
     * @param {Object} filters - Filtros a serem aplicados
     * @returns {Promise} Promise com os dados do relatório
     */
    async getReportData(reportType, filters = {}) {
        if (this.mockData) {
            return this._getMockData(reportType, filters);
        }
        
        // Implementação real usaria fetch para API
        try {
            const endpoint = this.endpoints[reportType] || this.endpoints.employee;
            const response = await fetch(`${endpoint}?${new URLSearchParams(filters)}`);
            
            if (!response.ok) {
                throw new Error(`Erro ao buscar dados: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Erro na API de relatórios:', error);
            return this._getMockData(reportType, filters); // Fallback para dados mockados
        }
    }
    
    /**
     * Exporta relatório para o formato especificado
     * @param {string} format - Formato de exportação (pdf, excel, csv)
     * @param {string} reportType - Tipo de relatório
     * @param {Object} filters - Filtros aplicados
     * @returns {Promise} Promise com URL do arquivo ou blob
     */
    async exportReport(format, reportType, filters = {}) {
        if (this.mockData) {
            return this._mockExport(format, reportType);
        }
        
        try {
            const endpoint = `/api/export/${format}/${reportType}`;
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(filters)
            });
            
            if (!response.ok) {
                throw new Error(`Erro na exportação: ${response.status}`);
            }
            
            // Dependendo do backend, pode retornar um blob ou url para download
            if (format === 'pdf') {
                return await response.blob();
            }
            return await response.json();
        } catch (error) {
            console.error('Erro na exportação:', error);
            return this._mockExport(format, reportType);
        }
    }
    
    /**
     * Dados simulados para demonstração
     */
    _getMockData(reportType, filters = {}) {
        // Simula latência de rede
        return new Promise(resolve => {
            setTimeout(() => {
                const mockDatasets = {
                    recruitment: this._generateRecruitmentData(filters),
                    performance: this._generatePerformanceData(filters),
                    employee: this._generateEmployeeData(filters),
                    training: this._generateTrainingData(filters)
                };
                
                resolve(mockDatasets[reportType] || mockDatasets.employee);
            }, 300);
        });
    }
    
    /**
     * Simula exportação de relatório
     */
    _mockExport(format, reportType) {
        return new Promise(resolve => {
            setTimeout(() => {
                // Em um ambiente real, isto retornaria um blob ou URL para download
                console.log(`Exportando ${reportType} em formato ${format}`);
                
                // Simulação de resposta
                resolve({
                    success: true,
                    message: `Relatório de ${reportType} exportado em ${format}`,
                    downloadUrl: `#mock-download-${reportType}-${format}`
                });
                
                // Normalmente aqui triggaria um download real
                this._triggerMockDownload(format, reportType);
            }, 800);
        });
    }
    
    /**
     * Simula download de arquivo
     */
    _triggerMockDownload(format, reportType) {
        // Apenas para efeito visual em demonstração
        const mockElement = document.createElement('div');
        mockElement.className = 'mock-download-notification';
        mockElement.innerHTML = `<i class="fas fa-download"></i> Download de ${reportType}.${format} iniciado`;
        document.body.appendChild(mockElement);
        
        setTimeout(() => {
            mockElement.classList.add('show');
            setTimeout(() => {
                mockElement.classList.remove('show');
                setTimeout(() => {
                    mockElement.remove();
                }, 500);
            }, 3000);
        }, 100);
    }
    
    /**
     * Geradores de dados mockados para cada tipo de relatório
     */
    _generateRecruitmentData(filters) {
        const period = filters.period || 'month';
        const department = filters.department || 'all';
        
        // Ajusta dados conforme filtros
        let factor = 1;
        if (department !== 'all') factor = 0.8;
        if (period === 'week') factor = 0.5;
        if (period === 'year') factor = 1.5;
        
        return {
            metrics: {
                total_candidates: Math.round(150 * factor),
                active_vacancies: Math.round(12 * factor),
                hiring_rate: Math.round(75 * factor),
                avg_time_to_hire: Math.round(45 * factor),
                cost_per_hire: Math.round(2500 * factor),
                candidate_quality: Math.round(85 * factor),
                interview_success: Math.round(68 * factor),
                offer_acceptance: Math.round(92 * factor)
            },
            chart_data: {
                time_series: this._generateTimeSeriesData(period, {
                    candidates: [120, 135, 150, 145, 160, 175],
                    hired: [8, 12, 15, 10, 18, 22]
                }),
                departments: this._generateDepartmentData(department),
                comparison: {
                    labels: ['Tempo de Contratação', 'Custo', 'Qualidade', 'Aceitação'],
                    datasets: [
                        {
                            label: 'Atual',
                            data: [45, 2500, 85, 92],
                        },
                        {
                            label: 'Meta',
                            data: [30, 2000, 90, 95],
                        }
                    ]
                }
            }
        };
    }
    
    _generatePerformanceData(filters) {
        const period = filters.period || 'month';
        
        return {
            metrics: {
                avg_performance: 4.1,
                goals_achievement: 78,
                high_performers: 35,
                development_plans: 120,
                feedback_completion: 92,
                succession_readiness: 45,
                skill_gaps: 12,
                training_effectiveness: 88
            },
            chart_data: {
                time_series: this._generateTimeSeriesData(period, {
                    performance: [3.8, 3.9, 4.0, 4.1, 4.2, 4.1],
                    goals: [70, 73, 75, 78, 80, 78]
                }),
                departments: {
                    labels: ['RH', 'TI', 'Operações', 'Finanças', 'Marketing'],
                    datasets: [
                        {
                            label: 'Desempenho Médio',
                            data: [4.3, 4.0, 3.8, 4.2, 4.1],
                        }
                    ]
                },
                skill_gaps: {
                    labels: ['Liderança', 'Técnico', 'Comunicação', 'Inovação', 'Colaboração'],
                    datasets: [
                        {
                            label: 'Lacunas Identificadas',
                            data: [18, 12, 15, 22, 8],
                        }
                    ]
                }
            }
        };
    }
    
    _generateEmployeeData(filters) {
        const period = filters.period || 'month';
        const department = filters.department || 'all';
        
        // Ajusta dados conforme filtros
        let factor = 1;
        if (department !== 'all') factor = 0.7;
        
        return {
            metrics: {
                total_employees: Math.round(450 * factor),
                turnover_rate: 8.5,
                avg_tenure: 3.2,
                satisfaction_score: 4.2,
                training_completion: 85,
                engagement_score: 78,
                diversity_index: 65,
                internal_mobility: 15
            },
            chart_data: {
                time_series: this._generateTimeSeriesData(period, {
                    turnover: [9.2, 8.9, 8.7, 8.5, 8.3, 8.5],
                    engagement: [75, 76, 78, 77, 79, 78]
                }),
                departments: this._generateDepartmentData(department),
                demographics: {
                    labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
                    datasets: [
                        {
                            label: 'Distribuição',
                            data: [10, 35, 30, 20, 5],
                        }
                    ]
                }
            }
        };
    }
    
    _generateTrainingData(filters) {
        return {
            metrics: {
                total_trainings: 24,
                avg_completion: 85,
                certification_rate: 72,
                satisfaction_score: 4.3
            },
            chart_data: {
                completion: {
                    labels: ['Onboarding', 'Técnico', 'Compliance', 'Liderança', 'Soft Skills'],
                    datasets: [
                        {
                            label: 'Taxa de Conclusão',
                            data: [95, 82, 88, 75, 80],
                        }
                    ]
                },
                effectiveness: {
                    labels: ['Conhecimento', 'Aplicação', 'Impacto', 'ROI'],
                    datasets: [
                        {
                            label: 'Efetividade',
                            data: [85, 72, 68, 60],
                        }
                    ]
                }
            }
        };
    }
    
    /**
     * Utilitários para geração de dados
     */
    _generateTimeSeriesData(period, datasets) {
        // Mapeia período para labels corretas
        const labels = {
            'week': ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            'month': ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            'quarter': ['Q1', 'Q2', 'Q3', 'Q4'],
            'year': ['2018', '2019', '2020', '2021', '2022', '2023']
        }[period] || ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
        
        // Formata datasets para resposta
        const result = { labels };
        result.datasets = Object.entries(datasets).map(([key, values]) => {
            return {
                label: key.charAt(0).toUpperCase() + key.slice(1),
                data: values.slice(0, labels.length)
            };
        });
        
        return result;
    }
    
    _generateDepartmentData(department) {
        const allDepartments = {
            labels: ['RH', 'TI', 'Operações', 'Finanças', 'Marketing'],
            datasets: [
                {
                    label: 'Colaboradores',
                    data: [45, 120, 180, 65, 40],
                }
            ]
        };
        
        // Se filtrando por departamento específico, retorna apenas ele
        if (department !== 'all') {
            const index = allDepartments.labels.findIndex(d => 
                d.toLowerCase() === department.toLowerCase());
            
            if (index !== -1) {
                return {
                    labels: [allDepartments.labels[index]],
                    datasets: [
                        {
                            label: 'Colaboradores',
                            data: [allDepartments.datasets[0].data[index]]
                        }
                    ]
                };
            }
        }
        
        return allDepartments;
    }
}

// Exporta instância global
window.reportsAPI = new ReportsAPI(); 