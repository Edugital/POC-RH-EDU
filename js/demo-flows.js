// Gerenciador de Fluxos de Demonstração
class DemoFlowManager {
    constructor() {
        this.currentFlow = null;
        this.currentStep = 0;
        this.flows = {
            recruitment: this.createRecruitmentFlow(),
            onboarding: this.createOnboardingFlow(),
            employee: this.createEmployeeFlow(),
            lms: this.createLMSFlow(),
            evaluation: this.createEvaluationFlow()
        };
    }

    // Fluxo de Recrutamento
    createRecruitmentFlow() {
        return {
            title: 'Processo de Recrutamento',
            steps: [
                {
                    title: 'Criar Nova Vaga',
                    action: () => this.simulateCreateJob(),
                    highlight: '.btn-create-job'
                },
                {
                    title: 'Definir Requisitos',
                    action: () => this.simulateDefineRequirements(),
                    highlight: '.requirements-section'
                },
                {
                    title: 'Publicar Vaga',
                    action: () => this.simulatePublishJob(),
                    highlight: '.publish-section'
                },
                {
                    title: 'Acompanhar Candidatos',
                    action: () => this.simulateTrackCandidates(),
                    highlight: '.candidates-table'
                }
            ]
        };
    }

    // Fluxo de Onboarding
    createOnboardingFlow() {
        return {
            title: 'Processo de Onboarding',
            steps: [
                {
                    title: 'Iniciar Onboarding',
                    action: () => this.simulateStartOnboarding(),
                    highlight: '.onboarding-form'
                },
                {
                    title: 'Configurar Tarefas',
                    action: () => this.simulateConfigureTasks(),
                    highlight: '.tasks-section'
                },
                {
                    title: 'Acompanhar Progresso',
                    action: () => this.simulateTrackProgress(),
                    highlight: '.progress-bar'
                }
            ]
        };
    }

    // Fluxo de Gestão de Colaboradores
    createEmployeeFlow() {
        return {
            title: 'Gestão de Colaboradores',
            steps: [
                {
                    title: 'Visualizar Perfil',
                    action: () => this.simulateViewProfile(),
                    highlight: '.employee-profile'
                },
                {
                    title: 'Atualizar Informações',
                    action: () => this.simulateUpdateInfo(),
                    highlight: '.edit-profile'
                },
                {
                    title: 'Gerenciar Documentos',
                    action: () => this.simulateManageDocuments(),
                    highlight: '.documents-section'
                }
            ]
        };
    }

    // Fluxo de LMS
    createLMSFlow() {
        return {
            title: 'Sistema de Treinamento',
            steps: [
                {
                    title: 'Criar Curso',
                    action: () => this.simulateCreateCourse(),
                    highlight: '.course-creator'
                },
                {
                    title: 'Configurar Conteúdo',
                    action: () => this.simulateConfigureContent(),
                    highlight: '.content-editor'
                },
                {
                    title: 'Gerenciar Matrículas',
                    action: () => this.simulateManageEnrollments(),
                    highlight: '.enrollments-section'
                }
            ]
        };
    }

    // Fluxo de Avaliação
    createEvaluationFlow() {
        return {
            title: 'Processo de Avaliação',
            steps: [
                {
                    title: 'Criar Avaliação',
                    action: () => this.simulateCreateEvaluation(),
                    highlight: '.evaluation-form'
                },
                {
                    title: 'Definir Critérios',
                    action: () => this.simulateDefineCriteria(),
                    highlight: '.criteria-section'
                },
                {
                    title: 'Acompanhar Resultados',
                    action: () => this.simulateTrackResults(),
                    highlight: '.results-dashboard'
                }
            ]
        };
    }

    // Métodos de Simulação
    simulateCreateJob() {
        return new Promise(resolve => {
            setTimeout(() => {
                window.demoData.recruitments.push({
                    id: window.demoData.recruitments.length + 1,
                    position: 'Novo Cargo',
                    department: 'TI',
                    status: 'draft',
                    candidates: 0,
                    interviews: 0,
                    created: new Date().toISOString().split('T')[0],
                    deadline: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                    requirements: []
                });
                window.eventManager.emit('recruitmentCreated');
                resolve();
            }, 1000);
        });
    }

    simulateStartOnboarding() {
        return new Promise(resolve => {
            setTimeout(() => {
                window.demoData.onboarding.push({
                    id: window.demoData.onboarding.length + 1,
                    employee: 'Novo Colaborador',
                    position: 'Cargo',
                    department: 'Departamento',
                    startDate: new Date().toISOString().split('T')[0],
                    status: 'pending',
                    progress: 0,
                    tasks: []
                });
                window.eventManager.emit('onboardingStarted');
                resolve();
            }, 1000);
        });
    }

    simulateViewProfile() {
        return new Promise(resolve => {
            setTimeout(() => {
                window.eventManager.emit('profileViewed');
                resolve();
            }, 500);
        });
    }

    simulateCreateCourse() {
        return new Promise(resolve => {
            setTimeout(() => {
                window.demoData.trainings.push({
                    id: window.demoData.trainings.length + 1,
                    title: 'Novo Curso',
                    instructor: 'Instrutor',
                    duration: '20h',
                    level: 'Iniciante',
                    status: 'draft',
                    enrolled: 0,
                    completion: 0,
                    topics: []
                });
                window.eventManager.emit('courseCreated');
                resolve();
            }, 1000);
        });
    }

    simulateCreateEvaluation() {
        return new Promise(resolve => {
            setTimeout(() => {
                window.demoData.evaluations.push({
                    id: window.demoData.evaluations.length + 1,
                    employee: 'Colaborador',
                    type: 'Desempenho',
                    period: 'Q2 2024',
                    status: 'draft',
                    dueDate: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                    criteria: []
                });
                window.eventManager.emit('evaluationCreated');
                resolve();
            }, 1000);
        });
    }

    // Métodos de Controle
    startFlow(flowName) {
        this.currentFlow = this.flows[flowName];
        this.currentStep = 0;
        this.executeCurrentStep();
    }

    async executeCurrentStep() {
        if (!this.currentFlow || this.currentStep >= this.currentFlow.steps.length) {
            return;
        }

        const step = this.currentFlow.steps[this.currentStep];
        
        // Destaca elemento
        const element = document.querySelector(step.highlight);
        if (element) {
            element.classList.add('highlight');
        }

        // Executa ação
        await step.action();

        // Remove highlight
        if (element) {
            element.classList.remove('highlight');
        }

        // Avança para próximo passo
        this.currentStep++;
        if (this.currentStep < this.currentFlow.steps.length) {
            setTimeout(() => this.executeCurrentStep(), 1000);
        }
    }

    resetFlow() {
        this.currentFlow = null;
        this.currentStep = 0;
    }
}

// Inicializa o gerenciador de fluxos
document.addEventListener('DOMContentLoaded', () => {
    window.demoFlowManager = new DemoFlowManager();
}); 