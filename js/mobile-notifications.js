// Mobile Notification Handler
class MobileNotificationHandler {
    constructor() {
        this.notifications = document.querySelectorAll('.notification');
        this.notificationContainer = document.querySelector('.notification-container');
        this.init();
    }
    
    init() {
        if (this.notificationContainer) {
            this.setupNotificationContainer();
        }
        
        this.notifications.forEach(notification => {
            this.setupNotification(notification);
        });
    }
    
    setupNotificationContainer() {
        // Add mobile-specific attributes
        this.addMobileAttributes(this.notificationContainer);
        
        // Setup touch interactions
        this.setupTouchInteractions(this.notificationContainer);
        
        // Setup swipe behavior
        this.setupSwipeBehavior(this.notificationContainer);
    }
    
    setupNotification(notification) {
        // Add mobile-specific attributes
        this.addMobileAttributes(notification);
        
        // Setup touch interactions
        this.setupTouchInteractions(notification);
        
        // Setup swipe behavior
        this.setupSwipeBehavior(notification);
        
        // Setup auto-dismiss
        this.setupAutoDismiss(notification);
    }
    
    addMobileAttributes(element) {
        // Add role for accessibility
        if (!element.hasAttribute('role')) {
            element.setAttribute('role', 'alert');
        }
        
        // Add data-mobile attribute for styling
        element.setAttribute('data-mobile', 'true');
    }
    
    setupTouchInteractions(element) {
        let touchStartX = 0;
        let touchStartY = 0;
        let touchEndX = 0;
        let touchEndY = 0;
        
        element.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        element.addEventListener('touchmove', (e) => {
            touchEndX = e.touches[0].clientX;
            touchEndY = e.touches[0].clientY;
        }, { passive: true });
        
        element.addEventListener('touchend', (e) => {
            const deltaX = touchEndX - touchStartX;
            const deltaY = touchEndY - touchStartY;
            
            // If vertical movement is greater than horizontal, consider it a tap
            if (Math.abs(deltaY) > Math.abs(deltaX)) {
                this.handleTap(element);
            }
        });
    }
    
    setupSwipeBehavior(element) {
        let swipeStartX = 0;
        let swipeEndX = 0;
        let isSwiping = false;
        
        element.addEventListener('touchstart', (e) => {
            swipeStartX = e.touches[0].clientX;
            isSwiping = false;
        }, { passive: true });
        
        element.addEventListener('touchmove', (e) => {
            swipeEndX = e.touches[0].clientX;
            const deltaX = swipeEndX - swipeStartX;
            
            // If horizontal movement is detected
            if (Math.abs(deltaX) > 10) {
                isSwiping = true;
                this.handleSwipe(element, deltaX);
            }
        }, { passive: true });
        
        element.addEventListener('touchend', () => {
            if (isSwiping) {
                this.finalizeSwipe(element);
            }
        });
    }
    
    setupAutoDismiss(notification) {
        const duration = notification.getAttribute('data-duration') || 5000;
        
        if (duration > 0) {
            setTimeout(() => {
                this.dismissNotification(notification);
            }, parseInt(duration));
        }
    }
    
    handleTap(element) {
        // Handle tap event
        if (element.classList.contains('notification')) {
            this.handleNotificationTap(element);
        }
    }
    
    handleNotificationTap(notification) {
        // Toggle notification details
        notification.classList.toggle('expanded');
        
        // Update aria-expanded attribute
        const isExpanded = notification.classList.contains('expanded');
        notification.setAttribute('aria-expanded', isExpanded);
        
        // Handle expansion animation
        if (isExpanded) {
            this.expandNotification(notification);
        } else {
            this.collapseNotification(notification);
        }
    }
    
    handleSwipe(element, deltaX) {
        // Apply swipe transform
        element.style.transform = `translateX(${deltaX}px)`;
        element.style.transition = 'none';
    }
    
    finalizeSwipe(element) {
        const deltaX = parseFloat(element.style.transform.replace('translateX(', '').replace('px)', ''));
        
        // If swipe distance is greater than threshold, dismiss
        if (Math.abs(deltaX) > 100) {
            this.dismissNotification(element);
        } else {
            // Reset position
            element.style.transform = '';
            element.style.transition = 'transform 0.3s ease';
        }
    }
    
    expandNotification(notification) {
        // Add expanded class
        notification.classList.add('expanded');
        
        // Update content visibility
        const content = notification.querySelector('.notification-content');
        if (content) {
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    }
    
    collapseNotification(notification) {
        // Remove expanded class
        notification.classList.remove('expanded');
        
        // Reset content visibility
        const content = notification.querySelector('.notification-content');
        if (content) {
            content.style.maxHeight = '0';
        }
    }
    
    dismissNotification(notification) {
        // Add dismiss animation class
        notification.classList.add('dismissing');
        
        // Remove notification after animation
        setTimeout(() => {
            notification.remove();
            
            // Update container if empty
            if (this.notificationContainer && this.notificationContainer.children.length === 0) {
                this.notificationContainer.classList.add('empty');
            }
        }, 300);
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

// Initialize mobile notification handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MobileNotificationHandler();
}); 