<?php
// Menu items array for worker section
$menuItems = [
    ['icon' => 'home', 'text' => 'Dashboard', 'link' => 'index.php'],
    ['icon' => 'graduation-cap', 'text' => 'Meus Cursos', 'link' => 'cursos.php'],
    ['icon' => 'folder', 'text' => 'Recursos Corporativos', 'link' => 'recursos.php'],
    ['icon' => 'clipboard-list', 'text' => 'Minhas Solicitações', 'link' => 'solicitacoes.php'],
    ['icon' => 'user', 'text' => 'Meu Perfil', 'link' => 'perfil.php'],
    ['icon' => 'bullhorn', 'text' => 'Comunicados', 'link' => 'comunicados.php']
];

// Determine if we're in worker area
$isWorker = strpos($_SERVER['PHP_SELF'], '/worker/') !== false;

// Output menu HTML
echo '<nav class="nav-menu">';
foreach ($menuItems as $item) {
    $link = $isWorker ? $item['link'] : '../worker/' . $item['link'];
    $isActive = basename($_SERVER['PHP_SELF']) === basename($item['link']) ? ' active' : '';
    
    echo '<a href="' . $link . '" class="nav-item' . $isActive . '">';
    echo '<i class="fas fa-' . $item['icon'] . '"></i>';
    echo '<span>' . $item['text'] . '</span>';
    echo '</a>';
}
echo '</nav>'; 