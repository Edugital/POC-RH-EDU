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
    ]
];

// Definições para templates
$themeConfig = [
    'primary_color' => '#0d6efd',
    'secondary_color' => '#6c757d',
    'success_color' => '#198754',
    'danger_color' => '#dc3545',
    'warning_color' => '#ffc107',
    'info_color' => '#0dcaf0'
];

// Função para carregar dados do usuário (simulado para POC)
function getUser($userId = null) {
    // Em produção, esta função buscaria os dados do usuário no banco de dados
    return [
        'id' => $userId ?? ($_SESSION['user_id'] ?? 1),
        'name' => $_SESSION['user_name'] ?? 'Administrador',
        'email' => $_SESSION['user_email'] ?? 'admin@vixpar.com',
        'role' => $_SESSION['user_role'] ?? 'admin',
        'avatar' => $_SESSION['user_avatar'] ?? 'A'
    ];
} 