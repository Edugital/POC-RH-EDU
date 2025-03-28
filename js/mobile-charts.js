// Mobile Chart Handler
class MobileChartHandler {
    constructor() {
        this.charts = document.querySelectorAll('.chart-container');
        this.init();
    }
    
    init() {
        this.charts.forEach(chart => {
            this.setupChart(chart);
        });
    }
    
    setupChart(chart) {
        // Add mobile-specific attributes
        this.addMobileAttributes(chart);
        
        // Setup responsive behavior
        this.setupResponsiveBehavior(chart);
        
        // Setup touch interactions
        this.setupTouchInteractions(chart);
        
        // Setup legend interactions
        this.setupLegendInteractions(chart);
        
        // Setup tooltip interactions
        this.setupTooltipInteractions(chart);
    }
    
    addMobileAttributes(chart) {
        // Add data-mobile attribute for styling
        chart.setAttribute('data-mobile', 'true');
        
        // Add role for accessibility
        if (!chart.hasAttribute('role')) {
            chart.setAttribute('role', 'img');
        }
        
        // Add aria-label if missing
        if (!chart.hasAttribute('aria-label')) {
            const title = chart.querySelector('.chart-title');
            if (title) {
                chart.setAttribute('aria-label', title.textContent);
            }
        }
    }
    
    setupResponsiveBehavior(chart) {
        // Get chart canvas
        const canvas = chart.querySelector('canvas');
        if (!canvas) return;
        
        // Get chart instance
        const chartInstance = Chart.getChart(canvas);
        if (!chartInstance) return;
        
        // Handle resize
        const handleResize = this.debounce(() => {
            this.updateChartSize(chartInstance);
        }, 250);
        
        window.addEventListener('resize', handleResize);
        
        // Initial size update
        this.updateChartSize(chartInstance);
    }
    
    updateChartSize(chartInstance) {
        const container = chartInstance.canvas.parentNode;
        const width = container.clientWidth;
        const height = container.clientHeight;
        
        // Update chart size
        chartInstance.resize();
        
        // Update responsive options
        chartInstance.options.responsive = true;
        chartInstance.options.maintainAspectRatio = false;
        
        // Update canvas size
        chartInstance.canvas.style.width = `${width}px`;
        chartInstance.canvas.style.height = `${height}px`;
    }
    
    setupTouchInteractions(chart) {
        const canvas = chart.querySelector('canvas');
        if (!canvas) return;
        
        const chartInstance = Chart.getChart(canvas);
        if (!chartInstance) return;
        
        let touchStartX = 0;
        let touchStartY = 0;
        let isDragging = false;
        
        canvas.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            isDragging = false;
        }, { passive: true });
        
        canvas.addEventListener('touchmove', (e) => {
            const touchX = e.touches[0].clientX;
            const touchY = e.touches[0].clientY;
            
            const deltaX = touchX - touchStartX;
            const deltaY = touchY - touchStartY;
            
            if (Math.abs(deltaX) > 10 || Math.abs(deltaY) > 10) {
                isDragging = true;
                this.handleChartDrag(chartInstance, deltaX, deltaY);
            }
        }, { passive: true });
        
        canvas.addEventListener('touchend', (e) => {
            if (!isDragging) {
                const touchX = e.changedTouches[0].clientX;
                const touchY = e.changedTouches[0].clientY;
                
                const element = chartInstance.getElementAtEvent(e);
                if (element.length > 0) {
                    this.handleChartTap(chartInstance, element[0], touchX, touchY);
                }
            }
        });
    }
    
    handleChartDrag(chartInstance, deltaX, deltaY) {
        // Update chart position
        const options = chartInstance.options;
        if (options.scales && options.scales.x) {
            options.scales.x.offset += deltaX;
        }
        if (options.scales && options.scales.y) {
            options.scales.y.offset += deltaY;
        }
        
        chartInstance.update('none');
    }
    
    handleChartTap(chartInstance, element, x, y) {
        // Show tooltip
        const tooltip = chartInstance.tooltip;
        if (tooltip) {
            tooltip.setActiveElement(element, x, y);
            tooltip.update();
        }
    }
    
    setupLegendInteractions(chart) {
        const legend = chart.querySelector('.chart-legend');
        if (!legend) return;
        
        const items = legend.querySelectorAll('.legend-item');
        items.forEach(item => {
            item.addEventListener('click', () => {
                this.handleLegendClick(chart, item);
            });
        });
    }
    
    handleLegendClick(chart, item) {
        const canvas = chart.querySelector('canvas');
        if (!canvas) return;
        
        const chartInstance = Chart.getChart(canvas);
        if (!chartInstance) return;
        
        const datasetIndex = parseInt(item.getAttribute('data-dataset-index'));
        const meta = chartInstance.getDatasetMeta(datasetIndex);
        
        // Toggle dataset visibility
        meta.hidden = !meta.hidden;
        chartInstance.update();
        
        // Update legend item state
        item.classList.toggle('hidden');
    }
    
    setupTooltipInteractions(chart) {
        const canvas = chart.querySelector('canvas');
        if (!canvas) return;
        
        const chartInstance = Chart.getChart(canvas);
        if (!chartInstance) return;
        
        // Customize tooltip
        chartInstance.options.plugins.tooltip = {
            ...chartInstance.options.plugins.tooltip,
            enabled: true,
            mode: 'index',
            intersect: false,
            position: 'nearest',
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: 'rgba(255, 255, 255, 0.2)',
            borderWidth: 1,
            padding: 10,
            displayColors: true,
            boxPadding: 4,
            usePointStyle: true,
            callbacks: {
                label: (context) => {
                    const label = context.dataset.label || '';
                    const value = context.parsed.y || context.parsed;
                    return `${label}: ${value}`;
                }
            }
        };
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

// Initialize mobile chart handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MobileChartHandler();
}); 