/**
 * LMS Handler
 * 
 * Handles LMS functionality for admin interface
 */
(function() {
    'use strict';

    // LMS Handler Object
    window.lmsHandler = {
        // Initialize the LMS interface
        init: function() {
            console.log('LMS Handler initialized');
            this.setupEventListeners();
            this.applyAccessibilityImprovements();
        },

        // Set up event listeners
        setupEventListeners: function() {
            // Handle bulk actions
            const bulkActionSelect = document.querySelector('.bulk-actions select');
            const bulkActionButton = document.querySelector('.bulk-actions button');
            
            if (bulkActionButton) {
                bulkActionButton.addEventListener('click', function() {
                    if (!bulkActionSelect || !bulkActionSelect.value || bulkActionSelect.selectedIndex === 0) {
                        lmsHandler.showToast('Por favor, selecione uma ação', 'warning');
                        return;
                    }
                    
                    lmsHandler.showToast(`Executando ação: ${bulkActionSelect.value}`, 'info');
                    // In a real implementation, this would call an API endpoint
                });
            }

            // Setup certificate download
            const downloadCertButton = document.querySelector('.download-certificate');
            if (downloadCertButton) {
                downloadCertButton.addEventListener('click', function() {
                    lmsHandler.showToast('Certificado baixado com sucesso', 'success');
                });
            }
        },

        // Apply accessibility improvements
        applyAccessibilityImprovements: function() {
            // Add ARIA labels to improve accessibility
            document.querySelectorAll('button:not([aria-label])').forEach(button => {
                const text = button.textContent.trim();
                if (text) {
                    button.setAttribute('aria-label', text);
                }
            });
            
            // Ensure all interactive elements are keyboard accessible
            document.querySelectorAll('.card, .metric-card').forEach(card => {
                if (card.onclick) {
                    card.setAttribute('tabindex', '0');
                    card.setAttribute('role', 'button');
                    card.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            card.click();
                        }
                    });
                }
            });
        },

        // Show a toast notification
        showToast: function(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) return;
            
            const icons = {
                'success': 'fa-check-circle',
                'warning': 'fa-exclamation-triangle',
                'error': 'fa-times-circle',
                'info': 'fa-info-circle'
            };
            
            const bgClass = {
                'success': 'bg-success',
                'warning': 'bg-warning',
                'error': 'bg-danger',
                'info': 'bg-primary'
            };
            
            const toastId = 'toast-' + new Date().getTime();
            const toastHtml = `
                <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${bgClass[type]} text-white">
                        <i class="fas ${icons[type]} me-2"></i>
                        <strong class="me-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                        <small>Agora</small>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fechar"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            const toast = new bootstrap.Toast(document.getElementById(toastId), {
                autohide: true,
                delay: 3000
            });
            toast.show();
            
            // Remove toast after it's hidden
            document.getElementById(toastId).addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        },

        // Refresh data from server
        refreshData: function() {
            // In a real implementation, this would be an API call
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    this.showToast('Dados atualizados com sucesso', 'success');
                    resolve();
                }, 1000);
            });
        },
        
        // Generate a mock report for a course
        generateCourseReport: function(courseId) {
            this.showToast('Gerando relatório...', 'info');
            
            // In a real implementation, this would be an API call
            setTimeout(() => {
                this.showToast('Relatório gerado com sucesso', 'success');
            }, 1500);
        },
        
        // Enroll users in bulk
        bulkEnrollUsers: function(courseId) {
            // Show a modal to select users (not implemented in this POC)
            this.showToast('Seleção de usuários para matrícula em massa', 'info');
        }
    };

    // Initialize when DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Only initialize if we're on the LMS page
        if (document.querySelector('.metric-card')) {
            window.lmsHandler.init();
        }
    });
})(); 