// Gerenciador da Interface de Demonstração
class DemoUI {
    constructor() {
        this.panel = null;
        this.overlay = null;
        this.currentFlow = null;
        this.currentStep = 0;
        this.isActive = false;
        
        this.init();
    }

    init() {
        this.createPanel();
        this.createOverlay();
        this.setupEventListeners();
    }

    createPanel() {
        this.panel = document.createElement('div');
        this.panel.className = 'demo-panel';
        this.panel.innerHTML = `
            <div class="demo-header">
                <h3>Demonstração</h3>
                <button class="btn-toggle-demo">
                    <i class="icon">×</i>
                </button>
            </div>
            <div class="demo-content">
                <div class="demo-flows">
                    <h4>Fluxos Disponíveis</h4>
                    <div class="flow-buttons">
                        <button class="btn-flow" data-flow="recruitment">
                            <i class="icon">👥</i>
                            Recrutamento
                        </button>
                        <button class="btn-flow" data-flow="onboarding">
                            <i class="icon">📋</i>
                            Onboarding
                        </button>
                        <button class="btn-flow" data-flow="employee">
                            <i class="icon">👤</i>
                            Funcionários
                        </button>
                        <button class="btn-flow" data-flow="lms">
                            <i class="icon">📚</i>
                            LMS
                        </button>
                        <button class="btn-flow" data-flow="evaluation">
                            <i class="icon">📊</i>
                            Avaliações
                        </button>
                    </div>
                </div>
                <div class="demo-controls">
                    <h4>Controles</h4>
                    <div class="control-buttons">
                        <button class="btn-control" data-action="start">
                            <i class="icon">▶️</i>
                            Iniciar
                        </button>
                        <button class="btn-control" data-action="next">
                            <i class="icon">⏭️</i>
                            Próximo
                        </button>
                        <button class="btn-control" data-action="reset">
                            <i class="icon">🔄</i>
                            Reiniciar
                        </button>
                    </div>
                </div>
                <div class="demo-progress">
                    <h4>Progresso</h4>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                    <div class="progress-text">0/0 passos</div>
                </div>
            </div>
        `;
        document.body.appendChild(this.panel);
    }

    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'demo-overlay';
        document.body.appendChild(this.overlay);
    }

    setupEventListeners() {
        // Toggle panel
        this.panel.querySelector('.btn-toggle-demo').addEventListener('click', () => {
            this.togglePanel();
        });

        // Flow buttons
        this.panel.querySelectorAll('.btn-flow').forEach(btn => {
            btn.addEventListener('click', () => {
                const flow = btn.dataset.flow;
                this.startFlow(flow);
            });
        });

        // Control buttons
        this.panel.querySelectorAll('.btn-control').forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.dataset.action;
                this.handleControl(action);
            });
        });
    }

    togglePanel() {
        this.isActive = !this.isActive;
        this.panel.classList.toggle('active', this.isActive);
        this.overlay.style.pointerEvents = this.isActive ? 'all' : 'none';
    }

    startFlow(flowType) {
        this.currentFlow = DemoFlowManager.getFlow(flowType);
        this.currentStep = 0;
        this.updateProgress();
        this.executeCurrentStep();
    }

    handleControl(action) {
        switch (action) {
            case 'start':
                if (this.currentFlow) {
                    this.currentStep = 0;
                    this.updateProgress();
                    this.executeCurrentStep();
                }
                break;
            case 'next':
                if (this.currentFlow && this.currentStep < this.currentFlow.steps.length - 1) {
                    this.currentStep++;
                    this.updateProgress();
                    this.executeCurrentStep();
                }
                break;
            case 'reset':
                this.resetFlow();
                break;
        }
    }

    async executeCurrentStep() {
        if (!this.currentFlow) return;

        const step = this.currentFlow.steps[this.currentStep];
        if (!step) return;

        // Remove previous highlights
        document.querySelectorAll('.highlight').forEach(el => {
            el.classList.remove('highlight');
        });

        // Add highlight to current element
        const element = document.querySelector(step.highlight);
        if (element) {
            element.classList.add('highlight');
        }

        // Execute step action
        await step.action();
    }

    updateProgress() {
        if (!this.currentFlow) return;

        const progressBar = this.panel.querySelector('.progress-fill');
        const progressText = this.panel.querySelector('.progress-text');
        const totalSteps = this.currentFlow.steps.length;
        const progress = ((this.currentStep + 1) / totalSteps) * 100;

        progressBar.style.width = `${progress}%`;
        progressText.textContent = `${this.currentStep + 1}/${totalSteps} passos`;
    }

    resetFlow() {
        this.currentFlow = null;
        this.currentStep = 0;
        this.updateProgress();
        document.querySelectorAll('.highlight').forEach(el => {
            el.classList.remove('highlight');
        });
    }
}

// Initialize DemoUI when document is ready
document.addEventListener('DOMContentLoaded', () => {
    window.demoUI = new DemoUI();
}); 