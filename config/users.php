<?php
// Mock users for demonstration
$users = [
    'admin@vixpar.com' => [
        'id' => 1,
        'name' => 'João da Silva',
        'role' => 'admin',
        'email' => 'admin@vixpar.com',
        'avatar' => null
    ],
    'rh@vixpar.com' => [
        'id' => 2,
        'name' => 'Maria Santos',
        'role' => 'rh',
        'email' => 'rh@vixpar.com',
        'avatar' => null
    ]
];

// Mock permissions
$permissions = [
    'admin' => [
        'dashboard' => ['view', 'edit'],
        'candidates' => ['view', 'edit', 'delete'],
        'jobs' => ['view', 'edit', 'delete'],
        'interviews' => ['view', 'edit', 'delete'],
        'lms' => ['view', 'edit', 'delete'],
        'reports' => ['view', 'export'],
        'settings' => ['view', 'edit']
    ],
    'rh' => [
        'dashboard' => ['view'],
        'candidates' => ['view', 'edit'],
        'jobs' => ['view', 'edit'],
        'interviews' => ['view', 'edit'],
        'lms' => ['view'],
        'reports' => ['view']
    ]
];

// Mock session user for demonstration
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = $users['admin@vixpar.com'];
} 