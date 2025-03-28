// LMS Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Inicialização dos filtros
    initializeFilters();
    
    // Inicialização dos tooltips
    initializeTooltips();
    
    // Inicialização das animações
    initializeAnimations();
});

// Funções de Filtro
function initializeFilters() {
    const categoryFilter = document.getElementById('filterCategory');
    const statusFilter = document.getElementById('filterStatus');
    const searchInput = document.querySelector('.input-group input');

    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterCourses);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterCourses);
    }

    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterCourses, 300));
    }
}

function filterCourses() {
    const category = document.getElementById('filterCategory').value;
    const status = document.getElementById('filterStatus').value;
    const searchTerm = document.querySelector('.input-group input').value.toLowerCase();
    const courses = document.querySelectorAll('.course-card');

    courses.forEach(course => {
        const courseCategory = course.dataset.category;
        const courseStatus = course.dataset.status;
        const courseTitle = course.querySelector('.card-title').textContent.toLowerCase();
        const courseDescription = course.querySelector('.card-text').textContent.toLowerCase();

        const matchesCategory = !category || courseCategory === category;
        const matchesStatus = !status || courseStatus === status;
        const matchesSearch = !searchTerm || 
                            courseTitle.includes(searchTerm) || 
                            courseDescription.includes(searchTerm);

        if (matchesCategory && matchesStatus && matchesSearch) {
            course.style.display = 'block';
        } else {
            course.style.display = 'none';
        }
    });
}

// Funções de Tooltip
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Funções de Animação
function initializeAnimations() {
    // Animação de entrada dos cards
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.course-card').forEach(card => {
        observer.observe(card);
    });
}

// Funções de Certificado
function showCertificate(courseId) {
    const modal = new bootstrap.Modal(document.getElementById('certificateModal'));
    modal.show();
}

function downloadCertificate() {
    // Simulação de download
    const toast = new bootstrap.Toast(document.createElement('div'));
    toast.show();
}

// Funções de Curso
function continueCourse(courseId) {
    // Simulação de continuação do curso
    showLoadingOverlay();
    setTimeout(() => {
        hideLoadingOverlay();
        showToast('Carregando módulo do curso...', 'info');
    }, 1500);
}

function startCourse(courseId) {
    // Simulação de início do curso
    showLoadingOverlay();
    setTimeout(() => {
        hideLoadingOverlay();
        showToast('Iniciando novo curso...', 'success');
    }, 1500);
}

// Funções de UI
function showLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    `;
    document.body.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

function showToast(message, type = 'info') {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    toastContainer.innerHTML = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notificação</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    document.body.appendChild(toastContainer);
    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
    toast.show();
}

// Utilitários
function debounce(func, wait) {
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

// LMS Handler Class
class LMSHandler {
    constructor() {
        this.init();
        if (document.getElementById('departmentProgress')) {
            this.initDepartmentChart();
        }
        if (document.getElementById('monthlyCompletions')) {
            this.initMonthlyChart();
        }
    }

    init() {
        this.setupEventListeners();
        this.setupMobileInteractions();
        this.setupAdminFeatures();
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

        // Admin filter
        const adminFilter = document.getElementById('adminFilter');
        if (adminFilter) {
            adminFilter.addEventListener('change', () => this.filterAdminCourses());
        }
    }

    setupMobileInteractions() {
        // Touch feedback for cards
        const cards = document.querySelectorAll('.course-card, .learning-path-item');
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
                this.updateLayout();
            }, 150);
        });
    }

    setupAdminFeatures() {
        // Admin-specific features
        if (document.querySelector('.admin-badge')) {
            this.setupAdminModals();
            this.setupAdminFilters();
        }
    }

    setupAdminModals() {
        // New Course Modal
        const newCourseModal = document.getElementById('newCourseModal');
        if (newCourseModal) {
            newCourseModal.addEventListener('show.bs.modal', () => {
                this.resetNewCourseForm();
            });
        }
    }

    setupAdminFilters() {
        // Additional admin filters
        const adminFilter = document.getElementById('adminFilter');
        if (adminFilter) {
            adminFilter.addEventListener('change', () => {
                this.filterAdminCourses();
            });
        }
    }

    filterCourses() {
        const category = document.getElementById('categoryFilter')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const search = document.getElementById('searchCourse')?.value.toLowerCase();

        const cards = document.querySelectorAll('.course-card');
        cards.forEach(card => {
            const cardCategory = card.classList.contains('mandatory') ? 'mandatory' : 
                               card.classList.contains('optional') ? 'optional' : '';
            const cardStatus = card.classList.contains('in-progress') ? 'in_progress' :
                             card.classList.contains('completed') ? 'completed' : 'pending';
            const cardTitle = card.querySelector('h3')?.textContent.toLowerCase();

            const categoryMatch = !category || cardCategory === category;
            const statusMatch = !status || cardStatus === status;
            const searchMatch = !search || cardTitle?.includes(search);

            card.style.display = categoryMatch && statusMatch && searchMatch ? 'block' : 'none';
        });
    }

    filterAdminCourses() {
        const adminFilter = document.getElementById('adminFilter')?.value;
        if (!adminFilter) return;

        const cards = document.querySelectorAll('.course-card');
        cards.forEach(card => {
            switch (adminFilter) {
                case 'active':
                    card.style.display = !card.classList.contains('expired') ? 'block' : 'none';
                    break;
                case 'inactive':
                    card.style.display = card.classList.contains('inactive') ? 'block' : 'none';
                    break;
                case 'expired':
                    card.style.display = card.classList.contains('expired') ? 'block' : 'none';
                    break;
                default:
                    card.style.display = 'block';
            }
        });
    }

    showNewCourseModal() {
        const modal = new bootstrap.Modal(document.getElementById('newCourseModal'));
        modal.show();
    }

    saveNewCourse() {
        const form = document.getElementById('newCourseForm');
        if (!form) return;

        // Show loading state
        const loadingOverlay = this.createLoadingOverlay();
        document.body.appendChild(loadingOverlay);

        // Simulate API call
        setTimeout(() => {
            loadingOverlay.remove();
            bootstrap.Modal.getInstance(document.getElementById('newCourseModal')).hide();
            this.showToast('Curso criado com sucesso!', 'success');
        }, 1500);
    }

    startCourse(courseId) {
        const loadingOverlay = this.createLoadingOverlay();
        document.body.appendChild(loadingOverlay);

        setTimeout(() => {
            loadingOverlay.remove();
            this.showToast('Curso iniciado com sucesso!', 'success');
        }, 1000);
    }

    continueCourse(courseId) {
        const loadingOverlay = this.createLoadingOverlay();
        document.body.appendChild(loadingOverlay);

        setTimeout(() => {
            loadingOverlay.remove();
            this.showToast('Continuando o curso...', 'info');
        }, 1000);
    }

    showCertificate(courseId) {
        const modal = new bootstrap.Modal(document.getElementById('certificateModal'));
        modal.show();
    }

    downloadCertificate() {
        const loadingOverlay = this.createLoadingOverlay();
        document.body.appendChild(loadingOverlay);

        setTimeout(() => {
            loadingOverlay.remove();
            this.showToast('Certificado baixado com sucesso!', 'success');
        }, 1500);
    }

    refreshLMS() {
        const loadingOverlay = this.createLoadingOverlay();
        document.body.appendChild(loadingOverlay);

        setTimeout(() => {
            loadingOverlay.remove();
            this.showToast('LMS atualizado com sucesso!', 'success');
        }, 1500);
    }

    createLoadingOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
        return overlay;
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

    resetNewCourseForm() {
        const form = document.getElementById('newCourseForm');
        if (form) {
            form.reset();
        }
    }

    updateLayout() {
        // Update any layout-specific elements
        const cards = document.querySelectorAll('.course-card');
        cards.forEach(card => {
            // Reset any transform styles
            card.style.transform = '';
        });
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

    initDepartmentChart() {
        const ctx = document.getElementById('departmentProgress').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Operações', 'Administrativo', 'Manutenção', 'Logística', 'RH'],
                datasets: [{
                    label: 'Progresso (%)',
                    data: [85, 72, 68, 90, 95],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    }

    initMonthlyChart() {
        const ctx = document.getElementById('monthlyCompletions').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Conclusões',
                    data: [65, 78, 82, 75, 92, 88],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.lmsHandler = new LMSHandler();
}); 