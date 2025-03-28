// Mobile Modal Handler
class MobileModalHandler {
    constructor() {
        this.modals = document.querySelectorAll('.modal');
        this.activeModal = null;
        this.init();
    }
    
    init() {
        this.modals.forEach(modal => {
            this.setupModal(modal);
        });
    }
    
    setupModal(modal) {
        // Add mobile-specific attributes
        this.addMobileAttributes(modal);
        
        // Setup touch interactions
        this.setupTouchInteractions(modal);
        
        // Setup close button
        this.setupCloseButton(modal);
        
        // Setup backdrop
        this.setupBackdrop(modal);
    }
    
    addMobileAttributes(modal) {
        // Add role for accessibility
        if (!modal.hasAttribute('role')) {
            modal.setAttribute('role', 'dialog');
        }
        
        // Add aria-label if missing
        if (!modal.hasAttribute('aria-label')) {
            const title = modal.querySelector('.modal-title');
            if (title) {
                modal.setAttribute('aria-label', title.textContent);
            }
        }
        
        // Add data-mobile attribute for styling
        modal.setAttribute('data-mobile', 'true');
    }
    
    setupTouchInteractions(modal) {
        let touchStartY = 0;
        let touchEndY = 0;
        let isDragging = false;
        let startTransform = 0;
        
        modal.addEventListener('touchstart', (e) => {
            touchStartY = e.touches[0].clientY;
            isDragging = false;
            startTransform = parseFloat(modal.style.transform.replace('translateY(', '').replace('px)', '') || 0);
        }, { passive: true });
        
        modal.addEventListener('touchmove', (e) => {
            touchEndY = e.touches[0].clientY;
            const deltaY = touchEndY - touchStartY;
            
            // Only allow dragging downward
            if (deltaY > 0) {
                isDragging = true;
                this.handleDrag(modal, deltaY);
            }
        }, { passive: true });
        
        modal.addEventListener('touchend', () => {
            if (isDragging) {
                this.finalizeDrag(modal);
            }
        });
    }
    
    setupCloseButton(modal) {
        const closeBtn = modal.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                this.closeModal(modal);
            });
        }
    }
    
    setupBackdrop(modal) {
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', () => {
                this.closeModal(modal);
            });
        }
    }
    
    handleDrag(modal, deltaY) {
        // Apply drag transform
        modal.style.transform = `translateY(${deltaY}px)`;
        modal.style.transition = 'none';
        
        // Update backdrop opacity
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            const opacity = 1 - (deltaY / window.innerHeight);
            backdrop.style.opacity = Math.max(0, opacity);
        }
    }
    
    finalizeDrag(modal) {
        const deltaY = parseFloat(modal.style.transform.replace('translateY(', '').replace('px)', ''));
        
        // If drag distance is greater than threshold, close modal
        if (deltaY > window.innerHeight * 0.3) {
            this.closeModal(modal);
        } else {
            // Reset position
            modal.style.transform = '';
            modal.style.transition = 'transform 0.3s ease';
            
            // Reset backdrop opacity
            const backdrop = modal.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.style.opacity = '';
                backdrop.style.transition = 'opacity 0.3s ease';
            }
        }
    }
    
    openModal(modal) {
        // Store active modal
        this.activeModal = modal;
        
        // Add active class
        modal.classList.add('active');
        
        // Add active class to backdrop
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.classList.add('active');
        }
        
        // Update body state
        document.body.classList.add('modal-open');
        
        // Focus modal
        this.focusModal(modal);
        
        // Add event listeners
        this.addModalEventListeners(modal);
    }
    
    closeModal(modal) {
        // Remove active class
        modal.classList.remove('active');
        
        // Remove active class from backdrop
        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.classList.remove('active');
        }
        
        // Update body state
        document.body.classList.remove('modal-open');
        
        // Clear active modal
        this.activeModal = null;
        
        // Remove event listeners
        this.removeModalEventListeners(modal);
    }
    
    focusModal(modal) {
        // Find focusable elements
        const focusableElements = modal.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        // Focus first focusable element
        if (focusableElements.length > 0) {
            focusableElements[0].focus();
        }
    }
    
    addModalEventListeners(modal) {
        // Handle escape key
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                this.closeModal(modal);
            }
        };
        
        modal.addEventListener('keydown', handleEscape);
        modal._escapeHandler = handleEscape;
    }
    
    removeModalEventListeners(modal) {
        if (modal._escapeHandler) {
            modal.removeEventListener('keydown', modal._escapeHandler);
        }
    }
    
    // Utility methods
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

// Initialize mobile modal handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MobileModalHandler();
}); 