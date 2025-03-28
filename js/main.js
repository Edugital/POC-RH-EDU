// Common utility functions
const utils = {
    // Format date to Brazilian format
    formatDate: (date) => {
        return new Date(date).toLocaleDateString('pt-BR');
    },

    // Show notification
    showNotification: (message, type = 'info') => {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    },

    // Handle form submissions
    handleFormSubmit: (formId, callback) => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                callback(formData);
            });
        }
    },

    // Toggle sidebar
    toggleSidebar: () => {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) {
            sidebar.classList.toggle('active');
        }
    }
};

// Core functionality for the application
document.addEventListener('DOMContentLoaded', () => {
    initializeSidebar();
    initializeDropdowns();
    initializeTooltips();

    // Initialize managers
    window.stateManager = new StateManager();
    window.cacheManager = new CacheManager();
    window.eventManager = new EventManager();
    window.Utils = Utils;
});

// Sidebar functionality
function initializeSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const mobileToggle = document.querySelector('.header__toggle');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const navLinks = document.querySelectorAll('.nav-menu .nav-item');

    // Mobile menu toggle
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });
    }

    // Close button in sidebar
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.remove('active');
        });
    }

    // Close sidebar when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && 
            sidebar && 
            sidebar.classList.contains('active') &&
            !sidebar.contains(e.target) && 
            !mobileToggle?.contains(e.target)) {
            sidebar.classList.remove('active');
        }
    });

    // Handle navigation links
    if (navLinks.length > 0) {
        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                
                // Apenas previne navegação se for a página atual
                if (href === '#' || href === window.location.pathname) {
                    e.preventDefault();
                    return;
                }
                
                // Em dispositivos móveis, fecha o sidebar após clicar
                if (window.innerWidth <= 768) {
                    sidebar?.classList.remove('active');
                }
            });
        });
    }

    // Initialize Bootstrap components if available
    if (typeof bootstrap !== 'undefined') {
        // Initialize dropdowns
        const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdowns.forEach(dropdown => {
            new bootstrap.Dropdown(dropdown);
        });

        // Initialize tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });
    }
}

// Dropdown functionality
function initializeDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', (e) => {
            e.preventDefault();
            const menu = dropdown.nextElementSibling;
            if (menu) {
                menu.classList.toggle('show');
                
                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other !== dropdown && other.nextElementSibling) {
                        other.nextElementSibling.classList.remove('show');
                    }
                });
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.matches('.dropdown-toggle')) {
            document.querySelectorAll('.dropdown-menu.show')
                .forEach(menu => menu.classList.remove('show'));
        }
    });
}

// Tooltip functionality
function initializeTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', (e) => {
            const content = tooltip.getAttribute('data-tooltip');
            if (content) {
                const tip = document.createElement('div');
                tip.className = 'tooltip';
                tip.textContent = content;
                document.body.appendChild(tip);
                
                const rect = tooltip.getBoundingClientRect();
                tip.style.top = `${rect.top - tip.offsetHeight - 5}px`;
                tip.style.left = `${rect.left + (rect.width - tip.offsetWidth) / 2}px`;
                
                tooltip.addEventListener('mouseleave', () => tip.remove(), { once: true });
            }
        });
    });
}

// Utilitários
const Utils = {
    showFeedback(message, type = 'info') {
        const feedback = document.createElement('div');
        feedback.className = `feedback feedback-${type}`;
        feedback.innerHTML = `
            <i class="fas fa-${this.getFeedbackIcon(type)}"></i>
            <span>${message}</span>
            <button class="feedback-close">&times;</button>
        `;

        document.body.appendChild(feedback);
        requestAnimationFrame(() => feedback.classList.add('show'));

        const closeBtn = feedback.querySelector('.feedback-close');
        closeBtn.addEventListener('click', () => {
            feedback.classList.remove('show');
            setTimeout(() => feedback.remove(), 300);
        });

        setTimeout(() => {
            feedback.classList.remove('show');
            setTimeout(() => feedback.remove(), 300);
        }, 3000);
    },

    getFeedbackIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'times-circle',
            warning: 'exclamation-circle',
            info: 'info-circle'
        };
        return icons[type] || icons.info;
    },

    async confirm(message) {
        return new Promise((resolve) => {
            const modal = document.createElement('div');
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Confirmar Ação</h3>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-action="cancel">Cancelar</button>
                        <button class="btn btn-primary" data-action="confirm">Confirmar</button>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
            requestAnimationFrame(() => modal.classList.add('show'));

            const handleAction = (action) => {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.remove();
                    resolve(action === 'confirm');
                }, 300);
            };

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    handleAction('cancel');
                }
            });

            modal.querySelector('.modal-close').addEventListener('click', () => {
                handleAction('cancel');
            });

            modal.querySelectorAll('[data-action]').forEach(btn => {
                btn.addEventListener('click', () => {
                    handleAction(btn.dataset.action);
                });
            });
        });
    },

    formatDate(date) {
        return new Intl.DateTimeFormat('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }).format(new Date(date));
    },

    formatNumber(number) {
        return new Intl.NumberFormat('pt-BR').format(number);
    },

    formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    },

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
    },

    throttle(func, limit) {
        let inThrottle;
        return function executedFunction(...args) {
            if (!inThrottle) {
                func(...args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
};

// Gerenciador de Estado
class StateManager {
    constructor() {
        this.state = {};
        this.listeners = new Map();
    }

    set(key, value) {
        this.state[key] = value;
        this.notify(key);
    }

    get(key) {
        return this.state[key];
    }

    subscribe(key, callback) {
        if (!this.listeners.has(key)) {
            this.listeners.set(key, new Set());
        }
        this.listeners.get(key).add(callback);
        return () => this.listeners.get(key).delete(callback);
    }

    notify(key) {
        const value = this.state[key];
        this.listeners.get(key)?.forEach(callback => callback(value));
    }
}

// Gerenciador de Cache
class CacheManager {
    constructor() {
        this.cache = new Map();
    }

    set(key, value, expiration = 3600000) {
        const item = {
            value,
            expiration: Date.now() + expiration
        };
        this.cache.set(key, item);
    }

    get(key) {
        const item = this.cache.get(key);
        if (!item) return null;
        if (Date.now() > item.expiration) {
            this.delete(key);
            return null;
        }
        return item.value;
    }

    delete(key) {
        this.cache.delete(key);
    }

    clear() {
        this.cache.clear();
    }
}

// Gerenciador de Eventos
class EventManager {
    constructor() {
        this.events = new Map();
    }

    on(event, callback) {
        if (!this.events.has(event)) {
            this.events.set(event, new Set());
        }
        this.events.get(event).add(callback);
    }

    off(event, callback) {
        this.events.get(event)?.delete(callback);
    }

    emit(event, data) {
        this.events.get(event)?.forEach(callback => callback(data));
    }
}

// Funções de Componentes
function initializeFormSubmissions() {
    const forms = document.querySelectorAll('form[data-submit="ajax"]');
    
    forms.forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
}

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
                
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    Utils.showFeedback(data.message || 'Operação realizada com sucesso!', 'success');
                    form.reset();
                } else {
                    throw new Error(data.message || 'Erro ao processar a operação.');
                }
            } catch (error) {
                Utils.showFeedback(error.message, 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    });
}

function initializeResponsiveTables() {
    const tables = document.querySelectorAll('.table-container');
    
    tables.forEach(container => {
        const table = container.querySelector('table');
        if (!table) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'table-wrapper';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);

        const scrollIndicator = document.createElement('div');
        scrollIndicator.className = 'scroll-indicator';
        container.appendChild(scrollIndicator);

        const updateScrollIndicator = Utils.throttle(() => {
            const { scrollLeft, scrollWidth, clientWidth } = wrapper;
            const showIndicator = scrollLeft < scrollWidth - clientWidth;
            scrollIndicator.classList.toggle('show', showIndicator);
        }, 100);

        wrapper.addEventListener('scroll', updateScrollIndicator);
        window.addEventListener('resize', updateScrollIndicator);
    });
} 