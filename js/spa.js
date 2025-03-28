// Gerenciador de Navegação SPA
class SPA {
    constructor() {
        this.routes = new Map();
        this.currentRoute = null;
        this.contentElement = document.querySelector('#content');
        this.loadingElement = this.createLoadingElement();
        this.breadcrumbElement = this.createBreadcrumbElement();
        
        this.setupNavigation();
        this.setupHistoryListener();
        this.handleRoute(window.location.pathname);
    }

    createLoadingElement() {
        const loading = document.createElement('div');
        loading.className = 'loading-overlay';
        loading.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <p>Carregando...</p>
            </div>
        `;
        document.body.appendChild(loading);
        return loading;
    }

    createBreadcrumbElement() {
        const breadcrumb = document.createElement('nav');
        breadcrumb.className = 'breadcrumb';
        breadcrumb.setAttribute('aria-label', 'breadcrumb');
        document.querySelector('.header').appendChild(breadcrumb);
        return breadcrumb;
    }

    setupNavigation() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[data-spa]');
            if (link) {
                e.preventDefault();
                this.navigate(link.getAttribute('href'));
            }
        });
    }

    setupHistoryListener() {
        window.addEventListener('popstate', () => {
            this.handleRoute(window.location.pathname);
        });
    }

    async navigate(path) {
        window.history.pushState({}, '', path);
        await this.handleRoute(path);
    }

    async handleRoute(path) {
        try {
            this.showLoading();
            this.updateBreadcrumb(path);

            const route = this.findRoute(path);
            if (!route) {
                throw new Error('Rota não encontrada');
            }

            const content = await this.fetchContent(route.path);
            this.renderContent(content);
            this.currentRoute = route;

            // Atualiza título da página
            document.title = `${route.title} | Sistema RH`;

            // Atualiza URL sem recarregar
            if (window.location.pathname !== path) {
                window.history.pushState({}, '', path);
            }
        } catch (error) {
            console.error('Erro ao carregar rota:', error);
            this.showError(error.message);
        } finally {
            this.hideLoading();
        }
    }

    findRoute(path) {
        for (const [pattern, route] of this.routes) {
            if (this.matchRoute(pattern, path)) {
                return {
                    ...route,
                    params: this.extractParams(pattern, path)
                };
            }
        }
        return null;
    }

    matchRoute(pattern, path) {
        const regex = new RegExp('^' + pattern.replace(/:[^/]+/g, '[^/]+') + '$');
        return regex.test(path);
    }

    extractParams(pattern, path) {
        const params = {};
        const patternParts = pattern.split('/');
        const pathParts = path.split('/');

        patternParts.forEach((part, index) => {
            if (part.startsWith(':')) {
                const paramName = part.slice(1);
                params[paramName] = pathParts[index];
            }
        });

        return params;
    }

    async fetchContent(path) {
        try {
            const response = await fetch(path);
            if (!response.ok) {
                throw new Error(`Erro ao carregar conteúdo: ${response.statusText}`);
            }
            return await response.text();
        } catch (error) {
            throw new Error('Erro ao carregar conteúdo da página');
        }
    }

    renderContent(content) {
        if (this.contentElement) {
            this.contentElement.innerHTML = content;
            this.initializePageScripts();
        }
    }

    initializePageScripts() {
        // Inicializa scripts específicos da página
        const scripts = this.contentElement.querySelectorAll('script');
        scripts.forEach(script => {
            const newScript = document.createElement('script');
            Array.from(script.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            newScript.textContent = script.textContent;
            script.parentNode.replaceChild(newScript, script);
        });
    }

    updateBreadcrumb(path) {
        const parts = path.split('/').filter(Boolean);
        const breadcrumb = parts.map((part, index) => {
            const href = '/' + parts.slice(0, index + 1).join('/');
            const title = this.formatBreadcrumbTitle(part);
            return `
                <a href="${href}" data-spa>${title}</a>
                ${index < parts.length - 1 ? '<span class="separator">/</span>' : ''}
            `;
        }).join('');

        this.breadcrumbElement.innerHTML = `
            <a href="/" data-spa>Início</a>
            ${parts.length > 0 ? '<span class="separator">/</span>' : ''}
            ${breadcrumb}
        `;
    }

    formatBreadcrumbTitle(part) {
        return part
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    showLoading() {
        this.loadingElement.classList.add('show');
    }

    hideLoading() {
        this.loadingElement.classList.remove('show');
    }

    showError(message) {
        if (this.contentElement) {
            this.contentElement.innerHTML = `
                <div class="error-container">
                    <h2>Erro</h2>
                    <p>${message}</p>
                    <button class="btn btn-primary" onclick="window.location.reload()">
                        Recarregar Página
                    </button>
                </div>
            `;
        }
    }

    registerRoute(pattern, path, title) {
        this.routes.set(pattern, { path, title });
    }
}

// Inicialização
document.addEventListener('DOMContentLoaded', () => {
    window.spa = new SPA();

    // Registrar rotas
    spa.registerRoute('/', '/pages/dashboard.html', 'Dashboard');
    spa.registerRoute('/recruitment', '/pages/recruitment.html', 'Recrutamento');
    spa.registerRoute('/onboarding', '/pages/onboarding.html', 'Onboarding');
    spa.registerRoute('/employees', '/pages/employees.html', 'Funcionários');
    spa.registerRoute('/employees/:id', '/pages/employee-details.html', 'Detalhes do Funcionário');
    spa.registerRoute('/lms', '/pages/lms.html', 'LMS');
    spa.registerRoute('/evaluations', '/pages/evaluations.html', 'Avaliações');
}); 