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
        this.setupEventListeners();
        this.renderCourses();
        this.renderLearningPaths();
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
        if (!coursesList) return;

        coursesList.innerHTML = this.courses.map(course => `
            <div class="col-md-4 mb-4">
                <div class="card h-100 course-card ${course.category} ${course.status}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge ${course.category === 'mandatory' ? 'bg-warning' : 'bg-info'}">
                                ${course.category === 'mandatory' ? 'Obrigatório' : 'Opcional'}
                            </span>
                            <span class="text-muted">${course.duration}</span>
                        </div>
                        <h4 class="card-title">${course.title}</h4>
                        <p class="card-text">${course.description}</p>
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
                                    onclick="demoLMSHandler.handleCourseAction(${course.id})">
                                ${this.getButtonText(course)}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderLearningPaths() {
        const pathsContainer = document.querySelector('.learning-paths');
        if (!pathsContainer) return;

        pathsContainer.innerHTML = this.learningPaths.map(path => `
            <div class="learning-path-item">
                <div class="path-info">
                    <h4>${path.title}</h4>
                    <p>${path.description}</p>
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
    }

    filterCourses() {
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
    }

    handleCourseAction(courseId) {
        const course = this.courses.find(c => c.id === courseId);
        if (!course) return;

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
                            <h4>${course.title}</h4>
                            <p>foi concluído com sucesso em ${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" onclick="demoLMSHandler.downloadCertificate(${courseId})">
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
    }

    downloadCertificate(courseId) {
        this.showNotification('Iniciando download do certificado...');
        // Simulate download delay
        setTimeout(() => {
            this.showNotification('Certificado baixado com sucesso!');
        }, 1500);
    }

    refreshData() {
        // Simulate data refresh
        this.showNotification('Atualizando dados...');
        setTimeout(() => {
            this.renderCourses();
            this.renderLearningPaths();
            this.showNotification('Dados atualizados com sucesso!');
        }, 1000);
    }

    showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'toast position-fixed bottom-0 end-0 m-3';
        notification.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">Notificação</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        document.body.appendChild(notification);
        const toast = new bootstrap.Toast(notification);
        toast.show();
        notification.addEventListener('hidden.bs.toast', () => notification.remove());
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