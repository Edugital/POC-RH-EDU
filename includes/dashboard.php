<?php
session_start();

// Configurações gerais
define('BASE_URL', '/mocks/rh-edu/vixpar');
define('SITE_NAME', 'RH Solutions');

// Configurações de banco de dados (quando necessário)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rhsolutions');

// Simulated dashboard data
$dashboardData = [
    'stats' => [
        'vagas' => [
            'total' => 12,
            'novas' => 2,
            'status' => 'success'
        ],
        'candidatos' => [
            'total' => 156,
            'novos' => 23,
            'status' => 'success'
        ],
        'onboarding' => [
            'total' => 8,
            'pendentes' => 3,
            'status' => 'warning'
        ],
        'avaliacoes' => [
            'total' => 45,
            'atrasadas' => 12,
            'status' => 'danger'
        ]
    ],
    'recrutamento' => [
        'vagas_ativas' => [
            [
                'id' => 'RP1321',
                'cargo' => 'Motorista de Carreta',
                'status' => 'Aguardando Aprovação',
                'candidatos' => 37,
                'aprovados' => 3
            ],
            [
                'id' => 'RP1322',
                'cargo' => 'Analista de RH',
                'status' => 'Em Andamento',
                'candidatos' => 45,
                'aprovados' => 5
            ]
        ]
    ],
    'onboarding' => [
        'pendentes' => [
            [
                'nome' => 'João da Silva',
                'cargo' => 'Motorista',
                'docs_pendentes' => ['RG', 'CTPS', 'Declaração'],
                'status' => 'warning'
            ]
        ]
    ],
    'lms' => [
        'cursos' => [
            [
                'nome' => 'Direção Defensiva',
                'tipo' => 'Obrigatório',
                'progresso' => 75,
                'status' => 'warning'
            ],
            [
                'nome' => 'Liderança na Prática',
                'tipo' => 'Opcional',
                'progresso' => 30,
                'status' => 'info'
            ]
        ]
    ],
    'avaliacoes' => [
        'pendentes' => [
            [
                'colaborador' => 'Ana Pereira',
                'cargo' => 'Analista de RH',
                'ciclo' => '2024.1',
                'status' => 'warning'
            ]
        ]
    ]
]; 