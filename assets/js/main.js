// Main JavaScript for RH Solutions Dashboard

// Initialize tooltips
const initTooltips = () => {
  const tooltips = document.querySelectorAll('[data-tooltip]');
  tooltips.forEach(tooltip => {
    tooltip.addEventListener('mouseenter', (e) => {
      const content = e.target.getAttribute('data-tooltip');
      const tooltipEl = document.createElement('div');
      tooltipEl.className = 'tooltip';
      tooltipEl.textContent = content;
      document.body.appendChild(tooltipEl);
      
      const rect = e.target.getBoundingClientRect();
      tooltipEl.style.top = `${rect.top - tooltipEl.offsetHeight - 10}px`;
      tooltipEl.style.left = `${rect.left + (rect.width - tooltipEl.offsetWidth) / 2}px`;
    });
    
    tooltip.addEventListener('mouseleave', () => {
      const tooltip = document.querySelector('.tooltip');
      if (tooltip) tooltip.remove();
    });
  });
};

// Handle search functionality
const initSearch = () => {
  const searchInput = document.querySelector('.search-bar input');
  if (!searchInput) return;
  
  searchInput.addEventListener('input', (e) => {
    const value = e.target.value.toLowerCase();
    // Add your search logic here
    console.log('Searching for:', value);
  });
};

// Handle metric cards animations
const initMetricCards = () => {
  const cards = document.querySelectorAll('.metric-card');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  
  cards.forEach(card => observer.observe(card));
};

// Handle notifications
const initNotifications = () => {
  const notificationBtn = document.querySelector('.notification-btn');
  const notificationCount = document.querySelector('.notification-count');
  
  if (!notificationBtn || !notificationCount) return;
  
  notificationBtn.addEventListener('click', () => {
    // Add your notification logic here
    notificationCount.textContent = '0';
    notificationCount.classList.add('hidden');
  });
};

// Mobile Menu Functionality
const initMobileMenu = () => {
    const menuTrigger = document.querySelector('.mobile-menu-trigger');
    const menuClose = document.querySelector('.mobile-menu-close');
    const menu = document.querySelector('.mobile-menu');
    const overlay = document.querySelector('.mobile-menu-overlay');
    const body = document.body;

    const openMenu = () => {
        menu?.classList.add('active');
        overlay?.classList.add('active');
        body.classList.add('menu-open');
    };

    const closeMenu = () => {
        menu?.classList.remove('active');
        overlay?.classList.remove('active');
        body.classList.remove('menu-open');
    };

    // Event Listeners
    menuTrigger?.addEventListener('click', openMenu);
    menuClose?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    // Handle escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu?.classList.contains('active')) {
            closeMenu();
        }
    });

    // Handle swipe to close
    let touchStartX = 0;
    let touchEndX = 0;

    menu?.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    menu?.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    const handleSwipe = () => {
        const swipeThreshold = 100;
        const swipeDistance = touchEndX - touchStartX;
        
        if (swipeDistance < -swipeThreshold) {
            closeMenu();
        }
    };
};

// Dashboard Charts Initialization
const initDashboardCharts = () => {
    // Recruitment Chart
    const recruitmentChart = document.getElementById('recruitmentChart');
    if (recruitmentChart) {
        new Chart(recruitmentChart, {
            type: 'line',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
                datasets: [{
                    label: 'Candidatos',
                    data: [320, 420, 380, 450, 480, 520],
                    borderColor: '#1B2F6B',
                    backgroundColor: 'rgba(27, 47, 107, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Contratações',
                    data: [28, 35, 40, 42, 45, 48],
                    borderColor: '#00A859',
                    backgroundColor: 'rgba(0, 168, 89, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Jobs Status Chart
    const jobsChart = document.getElementById('jobsStatusChart');
    if (jobsChart) {
        new Chart(jobsChart, {
            type: 'doughnut',
            data: {
                labels: ['Em Processo', 'Finalizadas', 'Novas'],
                datasets: [{
                    data: [45, 32, 23],
                    backgroundColor: ['#1B2F6B', '#00A859', '#E31837'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    }
};

// Initialize all components
const initApp = () => {
    initTooltips();
    initSearch();
    initMetricCards();
    initNotifications();
    initMobileMenu();
    initDashboardCharts();
    
    // Add loading states
    const charts = document.querySelectorAll('.chart-content');
    charts.forEach(chart => {
        chart.classList.add('loading');
        setTimeout(() => chart.classList.remove('loading'), 1000);
    });

    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Initialize tooltips
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.getAttribute('data-tooltip');
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();
            
            tooltip.style.top = `${rect.top - tooltipRect.height - 10}px`;
            tooltip.style.left = `${rect.left + (rect.width - tooltipRect.width) / 2}px`;
        });

        element.addEventListener('mouseleave', function() {
            const tooltip = document.querySelector('.tooltip');
            if (tooltip) {
                tooltip.remove();
            }
        });
    });

    // Notificações
    const notificationBtn = document.querySelector('.notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            console.log('Notificações clicadas');
        });
    }

    // Responsividade do menu em dispositivos móveis
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Calendar navigation
    const prevBtn = document.querySelector('.btn-outline-secondary.me-2');
    const nextBtn = document.querySelector('.btn-outline-secondary:not(.me-2)');
    const monthDisplay = document.querySelector('.ms-3.fw-bold');

    if (prevBtn && nextBtn && monthDisplay) {
        let currentDate = new Date();
        
        function updateMonthDisplay() {
            const options = { month: 'long', year: 'numeric' };
            monthDisplay.textContent = currentDate.toLocaleDateString('pt-BR', options);
        }

        prevBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateMonthDisplay();
        });

        nextBtn.addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateMonthDisplay();
        });

        updateMonthDisplay();
    }

    // View toggle (Month/Week/Day)
    const viewButtons = document.querySelectorAll('.btn-group .btn-outline-secondary');
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            // Here you would typically update the calendar view
            // This is just for demonstration
            console.log('Switched to view:', this.textContent.trim());
        });
    });

    // Interview form handling
    const interviewForm = document.getElementById('novaEntrevistaForm');
    if (interviewForm) {
        interviewForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            
            // Here you would typically send the data to a server
            console.log('Interview data:', data);
            
            // Show success message
            const modal = bootstrap.Modal.getInstance(document.getElementById('novaEntrevistaModal'));
            modal.hide();
            
            // Show toast notification
            const toast = new bootstrap.Toast(document.createElement('div'));
            toast.show();
        });
    }

    // Initialize all modals
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        new bootstrap.Modal(modal);
    });
};

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', initApp);

// Função para formatar números grandes
function formatNumber(num) {
  if (num >= 1000000) {
    return (num / 1000000).toFixed(1) + 'M';
  }
  if (num >= 1000) {
    return (num / 1000).toFixed(1) + 'K';
  }
  return num.toString();
}

// Função para formatar data relativa
function timeAgo(date) {
  const seconds = Math.floor((new Date() - new Date(date)) / 1000);
  
  let interval = seconds / 31536000;
  if (interval > 1) return Math.floor(interval) + ' anos atrás';
  
  interval = seconds / 2592000;
  if (interval > 1) return Math.floor(interval) + ' meses atrás';
  
  interval = seconds / 86400;
  if (interval > 1) return Math.floor(interval) + ' dias atrás';
  
  interval = seconds / 3600;
  if (interval > 1) return Math.floor(interval) + ' horas atrás';
  
  interval = seconds / 60;
  if (interval > 1) return Math.floor(interval) + ' minutos atrás';
  
  return Math.floor(seconds) + ' segundos atrás';
} 