// Mobile Table Handler
class MobileTableHandler {
    constructor() {
        this.tables = document.querySelectorAll('table');
        this.init();
    }
    
    init() {
        this.tables.forEach(table => {
            this.setupTable(table);
        });
    }
    
    setupTable(table) {
        // Add mobile-specific attributes
        this.addMobileAttributes(table);
        
        // Setup responsive layout
        this.setupResponsiveLayout(table);
        
        // Setup touch interactions
        this.setupTouchInteractions(table);
        
        // Setup sorting
        this.setupSorting(table);
        
        // Setup filtering
        this.setupFiltering(table);
        
        // Setup pagination
        this.setupPagination(table);
    }
    
    addMobileAttributes(table) {
        // Add data-mobile attribute for styling
        table.setAttribute('data-mobile', 'true');
        
        // Add role for accessibility
        if (!table.hasAttribute('role')) {
            table.setAttribute('role', 'grid');
        }
        
        // Add aria-label if missing
        if (!table.hasAttribute('aria-label')) {
            const caption = table.querySelector('caption');
            if (caption) {
                table.setAttribute('aria-label', caption.textContent);
            }
        }
    }
    
    setupResponsiveLayout(table) {
        // Create wrapper for horizontal scroll
        const wrapper = document.createElement('div');
        wrapper.className = 'table-responsive';
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
        
        // Create mobile view
        this.createMobileView(table);
    }
    
    createMobileView(table) {
        const headers = Array.from(table.querySelectorAll('th'));
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        
        // Create mobile view container
        const mobileView = document.createElement('div');
        mobileView.className = 'table-mobile-view';
        
        // Create mobile cards for each row
        rows.forEach(row => {
            const card = document.createElement('div');
            card.className = 'table-mobile-card';
            
            // Create card content
            headers.forEach((header, index) => {
                const cell = row.cells[index];
                const item = document.createElement('div');
                item.className = 'table-mobile-item';
                
                const label = document.createElement('div');
                label.className = 'table-mobile-label';
                label.textContent = header.textContent;
                
                const value = document.createElement('div');
                value.className = 'table-mobile-value';
                value.textContent = cell.textContent;
                
                item.appendChild(label);
                item.appendChild(value);
                card.appendChild(item);
            });
            
            mobileView.appendChild(card);
        });
        
        // Add mobile view to wrapper
        const wrapper = table.parentNode;
        wrapper.appendChild(mobileView);
    }
    
    setupTouchInteractions(table) {
        let touchStartX = 0;
        let touchEndX = 0;
        let isDragging = false;
        let startTransform = 0;
        
        const wrapper = table.parentNode;
        
        wrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            isDragging = false;
            startTransform = parseFloat(wrapper.style.transform.replace('translateX(', '').replace('px)', '') || 0);
        }, { passive: true });
        
        wrapper.addEventListener('touchmove', (e) => {
            touchEndX = e.touches[0].clientX;
            const deltaX = touchEndX - touchStartX;
            
            if (Math.abs(deltaX) > 10) {
                isDragging = true;
                this.handleDrag(wrapper, deltaX);
            }
        }, { passive: true });
        
        wrapper.addEventListener('touchend', () => {
            if (isDragging) {
                this.finalizeDrag(wrapper);
            }
        });
    }
    
    handleDrag(wrapper, deltaX) {
        // Apply drag transform
        wrapper.style.transform = `translateX(${deltaX}px)`;
        wrapper.style.transition = 'none';
    }
    
    finalizeDrag(wrapper) {
        const deltaX = parseFloat(wrapper.style.transform.replace('translateX(', '').replace('px)', ''));
        
        // If drag distance is greater than threshold, snap to next/previous view
        if (Math.abs(deltaX) > wrapper.offsetWidth * 0.3) {
            if (deltaX > 0) {
                this.showPreviousView(wrapper);
            } else {
                this.showNextView(wrapper);
            }
        } else {
            // Reset position
            wrapper.style.transform = '';
            wrapper.style.transition = 'transform 0.3s ease';
        }
    }
    
    showNextView(wrapper) {
        wrapper.style.transform = `translateX(-${wrapper.offsetWidth}px)`;
        wrapper.style.transition = 'transform 0.3s ease';
    }
    
    showPreviousView(wrapper) {
        wrapper.style.transform = 'translateX(0)';
        wrapper.style.transition = 'transform 0.3s ease';
    }
    
    setupSorting(table) {
        const headers = table.querySelectorAll('th[data-sortable]');
        
        headers.forEach(header => {
            header.addEventListener('click', () => {
                this.handleSort(table, header);
            });
        });
    }
    
    handleSort(table, header) {
        const column = Array.from(header.parentNode.children).indexOf(header);
        const direction = header.getAttribute('data-sort') === 'asc' ? 'desc' : 'asc';
        
        // Update sort attributes
        header.setAttribute('data-sort', direction);
        
        // Sort rows
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.cells[column].textContent;
            const bValue = b.cells[column].textContent;
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
        
        // Update mobile view
        this.updateMobileView(table);
    }
    
    setupFiltering(table) {
        const filterInput = document.createElement('input');
        filterInput.type = 'text';
        filterInput.className = 'table-filter';
        filterInput.placeholder = 'Filtrar...';
        
        const filterContainer = document.createElement('div');
        filterContainer.className = 'table-filter-container';
        filterContainer.appendChild(filterInput);
        
        table.parentNode.insertBefore(filterContainer, table);
        
        filterInput.addEventListener('input', () => {
            this.handleFilter(table, filterInput.value);
        });
    }
    
    handleFilter(table, query) {
        const rows = table.querySelectorAll('tbody tr');
        const mobileCards = table.parentNode.querySelectorAll('.table-mobile-card');
        
        query = query.toLowerCase();
        
        rows.forEach((row, index) => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(query);
            
            row.style.display = matches ? '' : 'none';
            mobileCards[index].style.display = matches ? '' : 'none';
        });
    }
    
    setupPagination(table) {
        const rows = table.querySelectorAll('tbody tr');
        const mobileCards = table.parentNode.querySelectorAll('.table-mobile-card');
        const itemsPerPage = 10;
        let currentPage = 1;
        
        // Create pagination container
        const paginationContainer = document.createElement('div');
        paginationContainer.className = 'table-pagination';
        
        // Create pagination controls
        const prevButton = document.createElement('button');
        prevButton.className = 'pagination-button';
        prevButton.textContent = 'Anterior';
        
        const nextButton = document.createElement('button');
        nextButton.className = 'pagination-button';
        nextButton.textContent = 'Próximo';
        
        const pageInfo = document.createElement('span');
        pageInfo.className = 'pagination-info';
        
        paginationContainer.appendChild(prevButton);
        paginationContainer.appendChild(pageInfo);
        paginationContainer.appendChild(nextButton);
        
        table.parentNode.appendChild(paginationContainer);
        
        // Handle pagination
        const updatePagination = () => {
            const totalPages = Math.ceil(rows.length / itemsPerPage);
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            
            rows.forEach((row, index) => {
                const show = index >= start && index < end;
                row.style.display = show ? '' : 'none';
                mobileCards[index].style.display = show ? '' : 'none';
            });
            
            pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;
        };
        
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });
        
        nextButton.addEventListener('click', () => {
            const totalPages = Math.ceil(rows.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });
        
        // Initial pagination
        updatePagination();
    }
    
    updateMobileView(table) {
        const mobileView = table.parentNode.querySelector('.table-mobile-view');
        if (!mobileView) return;
        
        const headers = Array.from(table.querySelectorAll('th'));
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        
        // Clear existing cards
        mobileView.innerHTML = '';
        
        // Create new cards
        rows.forEach(row => {
            const card = document.createElement('div');
            card.className = 'table-mobile-card';
            
            headers.forEach((header, index) => {
                const cell = row.cells[index];
                const item = document.createElement('div');
                item.className = 'table-mobile-item';
                
                const label = document.createElement('div');
                label.className = 'table-mobile-label';
                label.textContent = header.textContent;
                
                const value = document.createElement('div');
                value.className = 'table-mobile-value';
                value.textContent = cell.textContent;
                
                item.appendChild(label);
                item.appendChild(value);
                card.appendChild(item);
            });
            
            mobileView.appendChild(card);
        });
    }
}

// Initialize mobile table handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new MobileTableHandler();
}); 