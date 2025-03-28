// Mobile Handler Class
class MobileHandler {
    constructor() {
        this.init();
    }

    init() {
        this.setupMenu();
        this.setupCards();
        this.setupProcessos();
        this.setupViewport();
        this.setupTouchHandling();
    }

    setupMenu() {
        const menuButton = document.querySelector('.menu-button');
        const menuContainer = document.querySelector('.menu-container');
        const menuClose = document.querySelector('.menu-close');
        const menuContent = document.querySelector('.menu-content');

        if (menuButton && menuContainer) {
            menuButton.addEventListener('click', () => {
                menuContainer.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        if (menuClose) {
            menuClose.addEventListener('click', () => {
                menuContainer.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        // Close menu when clicking outside
        if (menuContainer) {
            menuContainer.addEventListener('click', (e) => {
                if (e.target === menuContainer) {
                    menuContainer.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }

        // Prevent menu content clicks from bubbling
        if (menuContent) {
            menuContent.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
    }

    setupCards() {
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            // Add touch feedback
            card.addEventListener('touchstart', () => {
                card.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', () => {
                card.style.transform = '';
            });

            // Ensure proper spacing on mobile
            this.adjustCardSpacing(card);
        });
    }

    setupProcessos() {
        const processoCards = document.querySelectorAll('.processo-card');
        const btnNovoProcesso = document.querySelector('.btn-novo-processo');

        processoCards.forEach(card => {
            // Add touch feedback
            card.addEventListener('touchstart', () => {
                card.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', () => {
                card.style.transform = '';
            });
        });

        if (btnNovoProcesso) {
            btnNovoProcesso.addEventListener('click', (e) => {
                e.preventDefault();
                // Add ripple effect
                this.addRippleEffect(e, btnNovoProcesso);
            });
        }
    }

    setupViewport() {
        // Prevent unwanted zooming on iOS
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0');
        }

        // Handle orientation changes
        window.addEventListener('orientationchange', () => {
            this.handleOrientationChange();
        });
    }

    setupTouchHandling() {
        let touchStartX = 0;
        let touchStartY = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        document.addEventListener('touchmove', (e) => {
            if (!e.touches[0]) return;

            const touchX = e.touches[0].clientX;
            const touchY = e.touches[0].clientY;
            const deltaX = touchX - touchStartX;
            const deltaY = touchY - touchStartY;

            // Handle horizontal swipes for menu
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 30) {
                const menuContainer = document.querySelector('.menu-container');
                if (deltaX > 0 && !menuContainer.classList.contains('active')) {
                    menuContainer.classList.add('active');
                    document.body.style.overflow = 'hidden';
                } else if (deltaX < 0 && menuContainer.classList.contains('active')) {
                    menuContainer.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        }, { passive: true });
    }

    handleOrientationChange() {
        // Update layout
        this.updateLayout();
        
        // Recalculate dimensions
        setTimeout(() => {
            this.recalculateDimensions();
        }, 150);
    }

    updateLayout() {
        const isLandscape = window.innerWidth > window.innerHeight;
        document.body.classList.toggle('landscape', isLandscape);
        
        // Adjust cards layout
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            this.adjustCardSpacing(card);
        });
    }

    adjustCardSpacing(card) {
        const isLandscape = window.innerWidth > window.innerHeight;
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            card.style.marginBottom = 'var(--spacing-md)';
            if (isLandscape) {
                card.style.maxWidth = '100%';
            }
        }
    }

    addRippleEffect(event, element) {
        const ripple = document.createElement('div');
        ripple.classList.add('ripple');
        
        const rect = element.getBoundingClientRect();
        const x = event.touches ? event.touches[0].clientX - rect.left : event.clientX - rect.left;
        const y = event.touches ? event.touches[0].clientY - rect.top : event.clientY - rect.top;
        
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    recalculateDimensions() {
        // Update card dimensions
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            this.adjustCardSpacing(card);
        });
        
        // Update processo cards
        const processoCards = document.querySelectorAll('.processo-card');
        processoCards.forEach(card => {
            this.adjustCardSpacing(card);
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.mobileHandler = new MobileHandler();
});

document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    // Estado
    let touchStartX = 0;
    let touchEndX = 0;
    const SWIPE_THRESHOLD = 100;

    // Toggle do menu
    menuToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Touch events para gestos
    document.addEventListener('touchstart', handleTouchStart, false);
    document.addEventListener('touchmove', handleTouchMove, false);
    document.addEventListener('touchend', handleTouchEnd, false);

    // Funções principais
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    }

    // Handlers de touch
    function handleTouchStart(event) {
        touchStartX = event.touches[0].clientX;
    }

    function handleTouchMove(event) {
        touchEndX = event.touches[0].clientX;
    }

    function handleTouchEnd() {
        const swipeDistance = touchEndX - touchStartX;
        
        // Swipe da esquerda para direita (abrir menu)
        if (swipeDistance > SWIPE_THRESHOLD && touchStartX < 50) {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            document.body.classList.add('sidebar-open');
        }
        
        // Swipe da direita para esquerda (fechar menu)
        if (swipeDistance < -SWIPE_THRESHOLD && sidebar.classList.contains('active')) {
            closeSidebar();
        }

        // Reset
        touchStartX = 0;
        touchEndX = 0;
    }

    // Ajuste para orientação do dispositivo
    window.addEventListener('orientationchange', () => {
        closeSidebar();
    });

    // Fechar menu em links
    const sidebarLinks = sidebar.querySelectorAll('a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });
}); 