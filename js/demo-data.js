// Dados Simulados para Demonstração
const demoData = {
    stats: {
        vagasAtivas: {
            total: 12,
            novaSemana: 2,
            emProcesso: 8,
            finalizadas: 4
        },
        candidatos: {
            total: 156,
            novaSemana: 23,
            emAnalise: 45,
            aprovados: 12
        },
        onboarding: {
            total: 8,
            emAndamento: 5,
            concluidos: 3,
            pendentes: 0
        },
        avaliacoes: {
            total: 34,
            pendentes: 12,
            realizadas: 22,
            atrasadas: 4
        }
    },
    
    contratacoes: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        datasets: [
            {
                label: 'Contratações',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: '#4CAF50',
                tension: 0.4
            },
            {
                label: 'Desligamentos',
                data: [5, 7, 4, 8, 6, 9],
                borderColor: '#f44336',
                tension: 0.4
            }
        ]
    },
    
    vagas: [
        {
            id: 'RP001',
            cargo: 'Desenvolvedor Full Stack',
            departamento: 'Tecnologia',
            status: 'Em Processo',
            candidatos: 45,
            fase: 'Entrevista Técnica'
        },
        {
            id: 'RP002',
            cargo: 'Analista de RH Sênior',
            departamento: 'Recursos Humanos',
            status: 'Em Processo',
            candidatos: 28,
            fase: 'Análise Curricular'
        },
        {
            id: 'RP003',
            cargo: 'Gerente de Projetos',
            departamento: 'PMO',
            status: 'Finalizada',
            candidatos: 32,
            fase: 'Contratado'
        }
    ]
};

// Configuração e Renderização dos Gráficos
document.addEventListener('DOMContentLoaded', () => {
    // Gráfico de Contratações
    const hiringChart = new Chart(
        document.getElementById('hiringChart'),
        {
            type: 'line',
            data: {
                labels: demoData.contratacoes.labels,
                datasets: demoData.contratacoes.datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                interaction: {
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    );
}); 