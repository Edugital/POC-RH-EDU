<?php
// Menu items array
$menuItems = [
    ['icon' => 'chart-pie', 'text' => 'Dashboard', 'link' => 'index.php'],
    ['icon' => 'sitemap', 'text' => 'Estrutura', 'link' => 'estrutura_organizacional.php'],
    ['icon' => 'id-badge', 'text' => 'Cargos', 'link' => 'cargos.php'],
    ['icon' => 'users', 'text' => 'Candidatos', 'link' => 'candidatos.php'],
    ['icon' => 'user-tie', 'text' => 'Colaboradores', 'link' => 'colaborador.php'],
    ['icon' => 'briefcase', 'text' => 'Vagas', 'link' => 'vagas.php'],
    ['icon' => 'calendar-check', 'text' => 'Entrevistas', 'link' => 'entrevistas.php'],
    ['icon' => 'graduation-cap', 'text' => 'Educação', 'link' => 'lms.php'],
    ['icon' => 'file-alt', 'text' => 'Relatórios', 'link' => 'relatorios.php'],
    ['icon' => 'cog', 'text' => 'Configurações', 'link' => 'configuracoes.php']
];

// Determine if we're in admin area
$isAdmin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;

// Output menu HTML
echo '<nav class="nav-menu">';
foreach ($menuItems as $item) {
    $link = $isAdmin ? $item['link'] : '../admin/' . $item['link'];
    $isActive = basename($_SERVER['PHP_SELF']) === basename($item['link']) ? ' active' : '';
    
    echo '<a href="' . $link . '" class="nav-item' . $isActive . '">';
    echo '<i class="fas fa-' . $item['icon'] . '"></i>';
    echo '<span>' . $item['text'] . '</span>';
    echo '</a>';
}
echo '</nav>'; 