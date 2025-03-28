            </div> <!-- content-container -->
        </main> <!-- main-content -->
    </div> <!-- app-container -->
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Debug para verificar se o Bootstrap está carregado
        console.log('Bootstrap disponível:', typeof bootstrap !== 'undefined');
        
        // Debug para verificar se o elemento existe
        const userDropdown = document.getElementById('userDropdown');
        console.log('Elemento userDropdown:', userDropdown);
        
        if (userDropdown) {
            // Adiciona listener de clique para debug
            userDropdown.addEventListener('click', (e) => {
                console.log('Clique no dropdown detectado');
            });
            
            // Inicializa o dropdown
            if (typeof bootstrap !== 'undefined') {
                try {
                    const dropdownInstance = new bootstrap.Dropdown(userDropdown);
                    console.log('Dropdown inicializado com sucesso');
                } catch (e) {
                    console.error('Erro ao inicializar dropdown:', e);
                }
            } else {
                console.error('Bootstrap não está disponível');
            }
        } else {
            console.error('Elemento userDropdown não encontrado');
        }
    });
    </script>
</body>
</html> 