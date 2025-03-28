// Demo LMS Handler for Águia Branca
class DemoLMSHandler {
    constructor() {
        this.courses = [
            {
                id: 1,
                title: 'Direção Defensiva Avançada',
                category: 'mandatory',
                status: 'in_progress',
                duration: '8h',
                progress: 75,
                description: 'Aprenda técnicas avançadas de direção segura e preventiva.',
                expiryDate: '2024-05-15',
                instructor: 'João Silva',
                enrolled: 150,
                completion: 112
            },
            {
                id: 2,
                title: 'Gestão de Frota',
                category: 'mandatory',
                status: 'pending',
                duration: '12h',
                progress: 0,
                description: 'Fundamentos de gestão de frota e manutenção preventiva.',
                expiryDate: '2024-06-30',
                instructor: 'Maria Santos',
                enrolled: 200,
                completion: 0
            },
            {
                id: 3,
                title: 'Comunicação Efetiva',
                category: 'optional',
                status: 'completed',
                duration: '6h',
                progress: 100,
                description: 'Melhore suas habilidades de comunicação no ambiente de trabalho.',
                expiryDate: '2024-04-30',
                instructor: 'Pedro Oliveira',
                enrolled: 180,
                completion: 180
            }
        ];

        this.learningPaths = [
            {
                id: 1,
                title: 'Formação de Motoristas',
                description: 'Trilha completa para formação de motoristas profissionais',
                progress: 65,
                courses: [1, 2],
                totalCourses: 3
            },
            {
                id: 2,
                title: 'Desenvolvimento de Liderança',
                description: 'Programa de desenvolvimento de habilidades gerenciais',
                progress: 40,
                courses: [3],
                totalCourses: 2
            }
        ];

        this.init();
    }

    init() {
        try {
            this.setupEventListeners();
            this.renderCourses();
            this.renderLearningPaths();
        } catch (error) {
            console.error('Erro ao inicializar LMS:', error);
            this.showError('Erro ao carregar o sistema de educação. Por favor, recarregue a página.');
        }
    }

    setupEventListeners() {
        // Filter listeners
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const searchInput = document.getElementById('searchCourse');

        if (categoryFilter) {
            categoryFilter.addEventListener('change', () => this.filterCourses());
        }
        if (statusFilter) {
            statusFilter.addEventListener('change', () => this.filterCourses());
        }
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => this.filterCourses(), 300));
        }

        // Refresh button
        const refreshBtn = document.getElementById('refreshLMS');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => this.refreshData());
        }
    }

    renderCourses() {
        const coursesList = document.getElementById('coursesList');
        if (!coursesList) {
            console.error('Elemento coursesList não encontrado');
            return;
        }

        try {
            coursesList.innerHTML = this.courses.map(course => `
                <div class="col-md-4 mb-4">
                    <div class="card h-100 course-card ${course.category} ${course.status}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge ${course.category === 'mandatory' ? 'bg-warning' : 'bg-info'}">
                                    ${course.category === 'mandatory' ? 'Obrigatório' : 'Opcional'}
                                </span>
                                <span class="text-muted">${this.escapeHtml(course.duration)}</span>
                            </div>
                            <h4 class="card-title">${this.escapeHtml(course.title)}</h4>
                            <p class="card-text">${this.escapeHtml(course.description)}</p>
                            <div class="progress mb-3" style="height: 5px;">
                                <div class="progress-bar ${course.status === 'completed' ? 'bg-success' : ''}" 
                                     role="progressbar" 
                                     style="width: ${course.progress}%;" 
                                     aria-valuenow="${course.progress}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">${this.getStatusText(course)}</small>
                                <button class="btn btn-${this.getButtonStyle(course)} btn-sm" 
                                        onclick="window.demoLMSHandler.handleCourseAction(${course.id})">
                                    ${this.getButtonText(course)}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            console.error('Erro ao renderizar cursos:', error);
            this.showError('Erro ao carregar os cursos. Por favor, tente novamente.');
        }
    }

    renderLearningPaths() {
        const pathsContainer = document.querySelector('.learning-paths');
        if (!pathsContainer) {
            console.error('Elemento learning-paths não encontrado');
            return;
        }

        try {
            pathsContainer.innerHTML = this.learningPaths.map(path => `
                <div class="learning-path-item">
                    <div class="path-info">
                        <h4>${this.escapeHtml(path.title)}</h4>
                        <p>${this.escapeHtml(path.description)}</p>
                    </div>
                    <div class="path-progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: ${path.progress}%;" 
                                 aria-valuenow="${path.progress}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        <span>${path.progress}% concluído</span>
                    </div>
                </div>
            `).join('');
        } catch (error) {
            console.error('Erro ao renderizar trilhas:', error);
            this.showError('Erro ao carregar as trilhas de aprendizagem. Por favor, tente novamente.');
        }
    }

    filterCourses() {
        try {
            const category = document.getElementById('categoryFilter')?.value;
            const status = document.getElementById('statusFilter')?.value;
            const search = document.getElementById('searchCourse')?.value.toLowerCase();

            const cards = document.querySelectorAll('.course-card');
            cards.forEach(card => {
                const cardCategory = card.classList.contains('mandatory') ? 'mandatory' : 'optional';
                const cardStatus = card.classList.contains('in-progress') ? 'in_progress' :
                                 card.classList.contains('completed') ? 'completed' : 'pending';
                const cardTitle = card.querySelector('h4')?.textContent.toLowerCase();

                const categoryMatch = !category || cardCategory === category;
                const statusMatch = !status || cardStatus === status;
                const searchMatch = !search || cardTitle?.includes(search);

                card.style.display = categoryMatch && statusMatch && searchMatch ? 'block' : 'none';
            });
        } catch (error) {
            console.error('Erro ao filtrar cursos:', error);
            this.showError('Erro ao filtrar os cursos. Por favor, tente novamente.');
        }
    }

    handleCourseAction(courseId) {
        try {
            const course = this.courses.find(c => c.id === courseId);
            if (!course) {
                throw new Error('Curso não encontrado');
            }

            switch (course.status) {
                case 'pending':
                    this.startCourse(courseId);
                    break;
                case 'in_progress':
                    this.continueCourse(courseId);
                    break;
                case 'completed':
                    this.showCertificate(courseId);
                    break;
            }
        } catch (error) {
            console.error('Erro ao executar ação do curso:', error);
            this.showError('Erro ao processar a ação. Por favor, tente novamente.');
        }
    }

    startCourse(courseId) {
        const course = this.courses.find(c => c.id === courseId);
        if (!course) return;

        course.status = 'in_progress';
        course.progress = 0;
        this.renderCourses();
        this.showNotification('Curso iniciado com sucesso!');
    }

    continueCourse(courseId) {
        const course = this.courses.find(c => c.id === courseId);
        if (!course) return;

        // Simulate progress
        course.progress = Math.min(100, course.progress + 25);
        if (course.progress === 100) {
            course.status = 'completed';
        }
        this.renderCourses();
        this.showNotification('Progresso atualizado!');
    }

    showCertificate(courseId) {
        const course = this.courses.find(c => c.id === courseId);
        if (!course) return;

        try {
            // Create and show certificate modal
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Certificado de Conclusão</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="certificate-content text-center">
                                <h3>Certificado de Conclusão</h3>
                                <p>Este certificado confirma que</p>
                                <h4>${this.escapeHtml(course.title)}</h4>
                                <p>foi concluído com sucesso em ${new Date().toLocaleDateString()}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" onclick="window.demoLMSHandler.downloadCertificate(${courseId})">
                                <i class="fas fa-download"></i> Baixar Certificado
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
            modal.addEventListener('hidden.bs.modal', () => modal.remove());
        } catch (error) {
            console.error('Erro ao mostrar certificado:', error);
            this.showError('Erro ao gerar o certificado. Por favor, tente novamente.');
        }
    }

    downloadCertificate(courseId) {
        this.showNotification('Iniciando download do certificado...');
        // Simulate download delay
        setTimeout(() => {
            this.showNotification('Certificado baixado com sucesso!');
        }, 1500);
    }

    refreshData() {
        try {
            // Simulate data refresh
            this.showNotification('Atualizando dados...');
            setTimeout(() => {
                this.renderCourses();
                this.renderLearningPaths();
                this.showNotification('Dados atualizados com sucesso!');
            }, 1000);
        } catch (error) {
            console.error('Erro ao atualizar dados:', error);
            this.showError('Erro ao atualizar os dados. Por favor, tente novamente.');
        }
    }

    showNotification(message) {
        try {
            const notification = document.createElement('div');
            notification.className = 'toast position-fixed bottom-0 end-0 m-3';
            notification.innerHTML = `
                <div class="toast-header">
                    <strong class="me-auto">Notificação</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    ${this.escapeHtml(message)}
                </div>
            `;
            document.body.appendChild(notification);
            const toast = new bootstrap.Toast(notification);
            toast.show();
            notification.addEventListener('hidden.bs.toast', () => notification.remove());
        } catch (error) {
            console.error('Erro ao mostrar notificação:', error);
        }
    }

    showError(message) {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.textContent = message;
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    }

    getStatusText(course) {
        switch (course.status) {
            case 'pending':
                return `Iniciar até ${new Date(course.expiryDate).toLocaleDateString()}`;
            case 'in_progress':
                return `${course.progress}% concluído`;
            case 'completed':
                return 'Concluído';
            default:
                return '';
        }
    }

    getButtonStyle(course) {
        switch (course.status) {
            case 'pending':
                return 'outline-primary';
            case 'in_progress':
                return 'primary';
            case 'completed':
                return 'success';
            default:
                return 'primary';
        }
    }

    getButtonText(course) {
        switch (course.status) {
            case 'pending':
                return 'Começar';
            case 'in_progress':
                return 'Continuar';
            case 'completed':
                return 'Ver Certificado';
            default:
                return 'Iniciar';
        }
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.demoLMSHandler = new DemoLMSHandler();
}); 