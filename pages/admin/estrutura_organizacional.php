<?php
$pageTitle = 'Estrutura Organizacional';
require_once 'admin_check.php';

// Função para gerar iniciais do nome
function getInitials($name) {
    $words = explode(' ', $name);
    if (count($words) >= 2) {
        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr(end($words), 0, 1));
    }
    return mb_strtoupper(mb_substr($name, 0, 2));
}

// Função para gerar cor baseada no nome
function getColorFromName($name) {
    $colors = [
        '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
        '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
        '#f1c40f', '#e67e22', '#e74c3c', '#95a5a6', '#f39c12',
        '#d35400', '#c0392b', '#7f8c8d'
    ];
    return $colors[abs(crc32($name)) % count($colors)];
}

// Mock data - Unidades
$unidades = [
    ['id' => 1, 'nome' => 'Matriz', 'cidade' => 'Vitória', 'estado' => 'ES', 'total_colaboradores' => 45, 'latitude' => -20.2976, 'longitude' => -40.2957],
    ['id' => 2, 'nome' => 'Filial Serra', 'cidade' => 'Serra', 'estado' => 'ES', 'total_colaboradores' => 28, 'latitude' => -20.1275, 'longitude' => -40.3076],
    ['id' => 3, 'nome' => 'Filial Vila Velha', 'cidade' => 'Vila Velha', 'estado' => 'ES', 'total_colaboradores' => 18, 'latitude' => -20.3404, 'longitude' => -40.2928],
    ['id' => 4, 'nome' => 'Filial Cariacica', 'cidade' => 'Cariacica', 'estado' => 'ES', 'total_colaboradores' => 12, 'latitude' => -20.2632, 'longitude' => -40.4165]
];

// Mock data - Departamentos
$departamentos = [
    ['id' => 1, 'nome' => 'Operacional', 'total_cargos' => 5, 'total_colaboradores' => 38],
    ['id' => 2, 'nome' => 'Administrativo', 'total_cargos' => 8, 'total_colaboradores' => 25],
    ['id' => 3, 'nome' => 'Recursos Humanos', 'total_cargos' => 4, 'total_colaboradores' => 12],
    ['id' => 4, 'nome' => 'Financeiro', 'total_cargos' => 6, 'total_colaboradores' => 15],
    ['id' => 5, 'nome' => 'Comercial', 'total_cargos' => 3, 'total_colaboradores' => 8],
    ['id' => 6, 'nome' => 'Tecnologia', 'total_cargos' => 4, 'total_colaboradores' => 5]
];

// Mock data - Níveis hierárquicos 
$niveis = [
    ['id' => 1, 'nome' => 'Estratégico', 'total_posicoes' => 8, 'total_colaboradores' => 7],
    ['id' => 2, 'nome' => 'Tático', 'total_posicoes' => 24, 'total_colaboradores' => 22],
    ['id' => 3, 'nome' => 'Operacional', 'total_posicoes' => 78, 'total_colaboradores' => 74]
];

// Mock data - Resumo da estrutura
$resumo = [
    'total_unidades' => count($unidades),
    'total_departamentos' => count($departamentos),
    'total_cargos' => 30,
    'total_posicoes' => array_sum(array_column($niveis, 'total_posicoes')),
    'total_colaboradores' => array_sum(array_column($unidades, 'total_colaboradores')),
    'vagas_abertas' => 7
];

// Mock data - Colaboradores (novo)
$colaboradores = [
    ['id' => 1, 'nome' => 'João Silva', 'cargo' => 'Diretor Geral', 'departamento_id' => 2, 'nivel_id' => 1, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2018-04-15', 'gestor_id' => null],
    ['id' => 2, 'nome' => 'Maria Oliveira', 'cargo' => 'Diretora Administrativa', 'departamento_id' => 2, 'nivel_id' => 1, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2018-05-20', 'gestor_id' => 1],
    ['id' => 3, 'nome' => 'Pedro Santos', 'cargo' => 'Diretor Operacional', 'departamento_id' => 1, 'nivel_id' => 1, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2019-01-10', 'gestor_id' => 1],
    ['id' => 4, 'nome' => 'Ana Costa', 'cargo' => 'Gerente de RH', 'departamento_id' => 3, 'nivel_id' => 2, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2019-03-22', 'gestor_id' => 2],
    ['id' => 5, 'nome' => 'Carlos Mendes', 'cargo' => 'Gerente Financeiro', 'departamento_id' => 4, 'nivel_id' => 2, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2019-06-05', 'gestor_id' => 2],
    ['id' => 6, 'nome' => 'Fernanda Lima', 'cargo' => 'Gerente de Logística', 'departamento_id' => 1, 'nivel_id' => 2, 'unidade_id' => 2, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2020-02-15', 'gestor_id' => 3],
    ['id' => 7, 'nome' => 'Ricardo Souza', 'cargo' => 'Gerente de Manutenção', 'departamento_id' => 1, 'nivel_id' => 2, 'unidade_id' => 3, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2020-04-10', 'gestor_id' => 3],
    ['id' => 8, 'nome' => 'Amanda Ferreira', 'cargo' => 'Analista de RH Sênior', 'departamento_id' => 3, 'nivel_id' => 3, 'unidade_id' => 1, 'status' => 'ativo', 'foto' => '', 'data_admissao' => '2020-08-20', 'gestor_id' => 4]
];

// Mock data - Posições (novo)
$posicoes = [
    ['id' => 1, 'titulo' => 'Diretor Geral', 'departamento_id' => 2, 'nivel_id' => 1, 'status' => 'ocupada', 'colaborador_id' => 1, 'vagas' => 1],
    ['id' => 2, 'titulo' => 'Diretor Administrativo', 'departamento_id' => 2, 'nivel_id' => 1, 'status' => 'ocupada', 'colaborador_id' => 2, 'vagas' => 1],
    ['id' => 3, 'titulo' => 'Diretor Operacional', 'departamento_id' => 1, 'nivel_id' => 1, 'status' => 'ocupada', 'colaborador_id' => 3, 'vagas' => 1],
    ['id' => 4, 'titulo' => 'Gerente de RH', 'departamento_id' => 3, 'nivel_id' => 2, 'status' => 'ocupada', 'colaborador_id' => 4, 'vagas' => 1],
    ['id' => 5, 'titulo' => 'Gerente Financeiro', 'departamento_id' => 4, 'nivel_id' => 2, 'status' => 'ocupada', 'colaborador_id' => 5, 'vagas' => 1],
    ['id' => 6, 'titulo' => 'Gerente de Logística', 'departamento_id' => 1, 'nivel_id' => 2, 'status' => 'ocupada', 'colaborador_id' => 6, 'vagas' => 1],
    ['id' => 7, 'titulo' => 'Gerente de Manutenção', 'departamento_id' => 1, 'nivel_id' => 2, 'status' => 'ocupada', 'colaborador_id' => 7, 'vagas' => 1],
    ['id' => 8, 'titulo' => 'Analista de RH Sênior', 'departamento_id' => 3, 'nivel_id' => 3, 'status' => 'ocupada', 'colaborador_id' => 8, 'vagas' => 2],
    ['id' => 9, 'titulo' => 'Analista Fiscal', 'departamento_id' => 4, 'nivel_id' => 3, 'status' => 'vaga', 'colaborador_id' => null, 'vagas' => 1],
    ['id' => 10, 'titulo' => 'Contador', 'departamento_id' => 4, 'nivel_id' => 3, 'status' => 'recrutamento', 'colaborador_id' => null, 'vagas' => 1],
    ['id' => 11, 'titulo' => 'Analista de T&D', 'departamento_id' => 3, 'nivel_id' => 3, 'status' => 'recrutamento', 'colaborador_id' => null, 'vagas' => 1]
];

// Helper function para obter colaborador por ID
function getColaboradorById($id, $colaboradores) {
    foreach ($colaboradores as $colaborador) {
        if ($colaborador['id'] == $id) {
            return $colaborador;
        }
    }
    return null;
}

// Helper function para obter posições por departamento
function getPosicoesByDepartamento($departamento_id, $posicoes) {
    $result = [];
    foreach ($posicoes as $posicao) {
        if ($posicao['departamento_id'] == $departamento_id) {
            $result[] = $posicao;
        }
    }
    return $result;
}

// Helper function para obter colaboradores por unidade
function getColaboradoresByUnidade($unidade_id, $colaboradores) {
    $result = [];
    foreach ($colaboradores as $colaborador) {
        if ($colaborador['unidade_id'] == $unidade_id) {
            $result[] = $colaborador;
        }
    }
    return $result;
}

// Helper para estatísticas avançadas
function getEstatisticasDepartamento($departamento_id, $colaboradores, $posicoes) {
    $estatisticas = [
        'ocupacao' => 0, 
        'vagas' => 0,
        'crescimento' => 0,
        'rotatividade' => 0
    ];
    
    $totalPosicoes = 0;
    $posicoesOcupadas = 0;
    
    foreach ($posicoes as $posicao) {
        if ($posicao['departamento_id'] == $departamento_id) {
            $totalPosicoes += $posicao['vagas'];
            if ($posicao['status'] == 'ocupada') {
                $posicoesOcupadas++;
            }
        }
    }
    
    $estatisticas['ocupacao'] = $totalPosicoes > 0 ? round(($posicoesOcupadas / $totalPosicoes) * 100) : 0;
    $estatisticas['vagas'] = $totalPosicoes - $posicoesOcupadas;
    
    // Valores simulados para demonstração
    $estatisticas['crescimento'] = rand(0, 15);
    $estatisticas['rotatividade'] = rand(1, 8);
    
    return $estatisticas;
}

// Adiciona script específico para página
$styles = '
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<style>
    /* Estilos específicos para o organograma */
    .org-chart-container {
        width: 100%;
        overflow-x: auto;
        padding: 10px;
        position: relative;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transform-origin: top center;
    }
    
    .org-level {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-bottom: 20px;
        width: 100%;
    }
    
    .org-level-group {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }
    
    .org-sublevel {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 180px;
    }
    
    .org-micro-level {
        display: flex;
        justify-content: space-around;
        width: 100%;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .org-box {
        position: relative;
        background-color: #fff;
        border-radius: 8px;
        padding: 10px 8px 15px;
        min-width: 160px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        text-align: center;
        margin: 0 5px 15px;
        transition: all 0.3s ease;
        border-left: 3px solid #ccc;
        z-index: 2;
    }
    
    .org-box:hover {
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
    
    .org-box.root {
        border-left-color: #e74c3c;
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.2);
    }
    
    .org-box.status-ocupada {
        border-left-color: #2ecc71;
        background-color: rgba(46, 204, 113, 0.05);
    }
    
    .org-box.status-vaga {
        border-left-color: #e74c3c;
        background-color: rgba(231, 76, 60, 0.05);
    }
    
    .org-box.status-recrutamento {
        border-left-color: #f39c12;
        background-color: rgba(243, 156, 18, 0.05);
    }
    
    .org-box.highlight-box {
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.5);
        animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(52, 152, 219, 0); }
        100% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0); }
    }
    
    .org-connector {
        width: 2px;
        height: 25px;
        background-color: #ccc;
        margin: 0 auto 6px;
    }
    
    .org-connector-vertical {
        width: 2px;
        height: 25px;
        background-color: #ccc;
        margin: 0 auto 6px;
    }
    
    .org-connector-down {
        width: 2px;
        height: 20px;
        background-color: #ccc;
        margin: 5px auto;
    }
    
    .org-connectors-wrapper {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-bottom: 6px;
    }
    
    .org-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #3498db;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        margin: 0 auto 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        border: 2px solid #fff;
        position: relative;
        z-index: 2;
    }
    
    .org-avatar-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        margin: 0 auto 8px;
        border: 2px solid #fff;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    
    .org-details {
        margin-bottom: 6px;
    }
    
    .org-name {
        font-weight: 600;
        margin-bottom: 2px;
        font-size: 13px;
    }
    
    .org-title {
        color: #666;
        font-size: 11px;
    }
    
    .org-actions {
        margin-top: 6px;
        display: flex;
        justify-content: center;
        gap: 4px;
    }
    
    /* Legend colors */
    .legend-color {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 4px;
    }
    
    .legend-color.status-ocupada {
        background-color: rgba(46, 204, 113, 0.7);
    }
    
    .legend-color.status-vaga {
        background-color: rgba(231, 76, 60, 0.7);
    }
    
    .legend-color.status-recrutamento {
        background-color: rgba(243, 156, 18, 0.7);
    }
    
    /* Responsividade para o organograma */
    @media (max-width: 1199.98px) {
        .org-level-group {
            flex-direction: column;
            align-items: center;
        }
        
        .org-sublevel {
            margin-bottom: 20px;
        }
        
        .content-area-main {
            width: 70%;
        }
        
        .content-area-sidebar {
            width: 30%;
        }
        
        .org-box {
            min-width: 150px;
            margin: 0 3px 12px;
        }
    }
    
    @media (max-width: 991.98px) {
        .content-area-main, .content-area-sidebar {
            width: 100%;
        }
        
        .org-chart-container {
            min-height: 350px;
        }
        
        .org-box {
            min-width: 140px;
            padding: 8px 6px 12px;
        }
    }
    
    @media (max-width: 767.98px) {
        .org-box {
            min-width: 130px;
            padding: 8px 5px 10px;
            margin: 0 2px 10px;
        }
        
        .org-actions {
            margin-top: 3px;
        }
        
        .org-actions .btn {
            padding: 0.15rem 0.3rem;
            font-size: 0.7rem;
        }
        
        .org-avatar, .org-avatar-img {
            width: 35px;
            height: 35px;
            font-size: 14px;
            margin-bottom: 6px;
        }
        
        .org-name {
            font-size: 12px;
        }
        
        .org-title {
            font-size: 10px;
        }
        
        .org-connector, .org-connector-vertical, .org-connector-down {
            height: 15px;
            margin-bottom: 4px;
        }
    }
    
    /* Estilos para Mobile */
    @media (max-width: 575.98px) {
        .org-chart-container {
            padding: 5px 3px;
        }
        
        .org-box {
            min-width: 120px;
            padding: 5px 3px 8px;
            margin: 0 2px 8px;
        }
        
        .org-avatar, .org-avatar-img {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
        
        .position-filters-container .btn {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
            font-size: 0.7rem;
        }
        
        .card-footer {
            padding: 0.3rem;
        }
        
        #unidadesMap {
            height: 180px;
        }
    }
    
    /* Estilos para Mapa */
    #unidadesMap {
        height: 220px;
        border-radius: 8px;
        z-index: 1;
    }
    
    /* Cards animados */
    .unidade-card, .dept-card {
        transition: all 0.3s ease;
    }
    
    .unidade-card:hover, .dept-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Responsividade para posições */
    .position-item {
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }
    
    .position-item .position-actions {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .position-item:hover .position-actions {
        opacity: 1;
    }
    
    /* Melhorias para filtros de posições */
    .position-filters-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }
    
    .position-filters-container .btn {
        flex: 1;
        padding-left: 0.4rem;
        padding-right: 0.4rem;
        white-space: nowrap;
        font-size: 0.8rem;
    }
    
    /* Melhorias para filtros de posições em mobile */
    @media (max-width: 767.98px) {
        .position-filters-container {
            overflow-x: auto;
            margin-bottom: 10px;
            padding-bottom: 5px;
            max-width: 100%;
        }
        
        .position-filters-container .btn {
            padding-left: 0.4rem;
            padding-right: 0.4rem;
        }
    }
    
    /* Aprimoramentos para navegação mobile */
    @media (max-width: 767.98px) {
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            flex-direction: row;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
        }
        
        .nav-tabs::-webkit-scrollbar {
            display: none;
        }
        
        .nav-tabs .nav-item {
            flex: 0 0 auto;
        }
        
        .nav-tabs .nav-link {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }
    }
    
    /* Melhoria para o footer dos cards em mobile */
    @media (max-width: 767.98px) {
        .card-footer {
            padding: 0.5rem;
        }
        
        .card-footer .d-flex {
            flex-direction: column;
            align-items: center;
        }
        
        .card-footer .btn-group {
            margin-top: 0.5rem;
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Status badges */
    .status-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 30px;
        z-index: 3;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
    }
    
    .status-ocupada {
        background-color: rgba(46, 204, 113, 0.15);
        color: #27ae60;
    }
    
    .status-vaga {
        background-color: rgba(231, 76, 60, 0.15);
        color: #c0392b;
    }
    
    .status-recrutamento {
        background-color: rgba(243, 156, 18, 0.15);
        color: #d35400;
    }
    
    /* Tooltip personalizado */
    .custom-tooltip {
        position: absolute;
        background: white;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.2);
        z-index: 1000;
        max-width: 300px;
        display: none;
    }
    
    /* Tooltips do organograma */
    .org-tooltip {
        background: white;
        border-radius: 6px;
        box-shadow: 0 3px 14px rgba(0,0,0,0.4);
        padding: 15px;
        max-width: 250px;
    }
    
    /* Timeline */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: "";
        position: absolute;
        width: 2px;
        background-color: #e0e0e0;
        top: 0;
        bottom: 0;
        left: 20px;
    }
    
    .timeline-item {
        padding: 10px 40px 10px 10px;
        position: relative;
        margin-bottom: 15px;
    }
    
    .timeline-item::after {
        content: "";
        position: absolute;
        width: 14px;
        height: 14px;
        background-color: white;
        border: 2px solid #3498db;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
        left: 14px;
        margin-left: -14px;
    }
    
    /* Melhorias na responsividade geral */
    @media (max-width: 575.98px) {
        .card-header .btn-group {
            margin-top: 0.5rem;
        }
        
        .card-header {
            flex-direction: column;
            align-items: start;
        }
        
        .btn-group-sm > .btn {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }
        
        .nav-tabs .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
        
        .row.g-2 .col-3 {
            padding: 0 0.25rem;
        }
        
        .row.g-2 .text-center.border {
            padding: 0.25rem 0 !important;
        }
        
        .d-flex.gap-2 {
            flex-wrap: wrap;
        }
        
        .d-flex.gap-2 .btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
        
        .d-flex.gap-3 {
            gap: 0.5rem !important;
        }
    }
    
    /* Estilos para scroll personalizado */
    .position-list::-webkit-scrollbar,
    .unidades-list::-webkit-scrollbar,
    .departamentos-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .position-list::-webkit-scrollbar-track,
    .unidades-list::-webkit-scrollbar-track,
    .departamentos-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .position-list::-webkit-scrollbar-thumb,
    .unidades-list::-webkit-scrollbar-thumb,
    .departamentos-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    
    .position-list::-webkit-scrollbar-thumb:hover,
    .unidades-list::-webkit-scrollbar-thumb:hover,
    .departamentos-list::-webkit-scrollbar-thumb:hover {
        background: #999;
    }
    
    /* Animações */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate__fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }
    
    /* Ajustes para ícones do topo e controles do organograma */
    .org-box .org-actions {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    .org-box .org-actions .btn {
        width: 28px;
        height: 28px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    
    .org-box .org-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
    }
    
    /* Reduzir espaço em branco entre organograma e resumo por nível */
    .row.g-4 {
        --bs-gutter-x: 1rem;
    }
    
    .col-lg-8 {
        padding-right: 0.75rem;
    }
    
    .col-lg-4 {
        padding-left: 0.75rem;
    }
    
    /* Otimização de layout para melhor uso do espaço */
    @media (min-width: 992px) {
        .org-chart-container {
            min-height: 450px;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        
        .card.h-100 {
            margin-bottom: 0;
        }
        
        /* Layout mais compacto para o resumo por nível hierárquico */
        .card-footer .row.g-2 .col-4 {
            padding: 0 0.25rem;
        }
        
        .card-footer .row.g-2 {
            margin: 0 -0.25rem;
        }
    }
    
    /* Ajustes específicos para os ícones de ação no organograma */
    .org-box .btn-light {
        border: 1px solid #e9ecef;
        background-color: rgba(255,255,255,0.9);
    }
    
    .org-box .btn-danger, 
    .org-box .btn-warning {
        color: #fff;
    }
    
    /* Reduzir o espaço vertical no layout geral */
    .card-body {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .card-footer {
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    /* Estilos para os controles de exportar/tela cheia */
    .org-controls {
        position: absolute;
        bottom: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
        z-index: 10;
    }
    
    .org-controls .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        background-color: white;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Ajustar altura do sidebar direito */
    @media (min-width: 1200px) {
        #posicoesTab .position-list {
            max-height: 300px;
        }
    }
    
    /* Adicionar classes utilitárias para tamanhos de fonte */
    .fs-7 {
        font-size: 0.75rem !important;
    }
    
    .fs-sm {
        font-size: 0.85rem !important;
    }
    
    /* Melhorar ícones e botões de ação no organograma */
    .org-actions {
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        background-color: white;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        padding: 2px;
        z-index: 3;
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    .org-box:hover .org-actions {
        opacity: 1;
        transform: translateX(-50%) translateY(-3px);
    }
    
    .org-actions .btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        padding: 0;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .org-avatar {
        position: relative;
        z-index: 2;
    }
    
    /* Ajustar espaçamento geral */
    .org-box {
        margin-bottom: 25px;
        padding-bottom: 20px;
    }
    
    /* Classes para otimizar a visualização de departamentos por cores */
    .dept-color-1 { background-color: rgba(52, 152, 219, 0.1); border-left-color: #3498db; }
    .dept-color-2 { background-color: rgba(46, 204, 113, 0.1); border-left-color: #2ecc71; }
    .dept-color-3 { background-color: rgba(155, 89, 182, 0.1); border-left-color: #9b59b6; }
    .dept-color-4 { background-color: rgba(241, 196, 15, 0.1); border-left-color: #f1c40f; }
    .dept-color-5 { background-color: rgba(231, 76, 60, 0.1); border-left-color: #e74c3c; }
    .dept-color-6 { background-color: rgba(26, 188, 156, 0.1); border-left-color: #1abc9c; }
    
    /* Badge de filial melhorado */
    .filial-badge {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #00BCD4;
        color: white;
        border-radius: 30px;
        padding: 3px 10px;
        font-size: 0.7rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        z-index: 3;
        white-space: nowrap;
    }
    
    .filial-badge i {
        margin-right: 3px;
        font-size: 0.65rem;
    }
    
    /* Conectores visíveis */
    .connector-line {
        background-color: #ccc;
        position: absolute;
        z-index: 0;
    }
    
    .connector-vertical {
        width: 2px;
        height: 20px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .connector-horizontal {
        height: 2px;
    }
    
    /* Melhorias para o tab de posições */
    .position-list {
        max-height: 350px !important;
        overflow-y: auto;
        padding-right: 5px;
        padding-left: 5px;
    }
    
    .position-item {
        transition: all 0.3s ease;
        margin-bottom: 15px;
        position: relative;
    }
    
    .position-item .card {
        overflow: visible;
        transition: all 0.2s ease;
        border: 1px solid transparent !important;
        border-left: 3px solid #ddd !important;
        height: auto;
    }
    
    .position-item[data-status="ocupada"] .card {
        border-left-color: #2ecc71 !important;
    }
    
    .position-item[data-status="vaga"] .card {
        border-left-color: #e74c3c !important;
    }
    
    .position-item[data-status="recrutamento"] .card {
        border-left-color: #f39c12 !important;
    }
    
    .position-item .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08) !important;
        border-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .position-item .card-body {
        padding: 0.85rem;
    }
    
    .position-item h6 {
        font-size: 0.95rem;
        line-height: 1.4;
        word-break: normal;
        white-space: normal;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 6px;
    }
    
    .position-item .small {
        font-size: 0.8rem;
        white-space: normal;
        line-height: 1.4;
        display: block;
        margin-bottom: 4px;
    }
    
    .position-item .text-muted {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    .position-item .text-truncate {
        max-width: none;
        overflow: visible;
        text-overflow: clip;
        white-space: normal;
    }
    
    .position-item .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
        white-space: normal;
        max-width: 100%;
        word-break: normal;
        margin-top: 4px;
        display: inline-block;
    }
    
    .position-item .d-flex.align-items-start {
        align-items: flex-start !important;
    }
    
    .position-item .position-status {
        margin-top: 4px;
    }
    
    .position-item .flex-grow-1 {
        min-width: 0;
        padding-right: 5px;
    }
    
    .position-item .d-flex.flex-column.flex-md-row {
        flex-wrap: wrap;
    }
    
    .position-item .position-actions {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .position-item .position-actions .btn {
        white-space: nowrap;
    }
    
    /* Ajustes específicos para telas menores */
    @media (max-width: 767.98px) {
        .position-item .d-flex.flex-column.flex-md-row {
            flex-direction: column !important;
        }
        
        .position-item .mt-0.mt-md-0 {
            margin-top: 5px !important;
        }
        
        .position-item h6 {
            font-size: 0.9rem;
        }
        
        .position-item .small {
            font-size: 0.75rem;
        }
    }
    
    /* Aumentar contraste e legibilidade */
    .position-item .text-success {
        color: #198754 !important;
        font-weight: 500;
    }
    
    .position-item .position-status {
        flex-shrink: 0;
    }
    
    /* Otimização para evitar vazamento em telas muito pequenas */
    @media (max-width: 575.98px) {
        .position-item .flex-grow-1 {
            width: calc(100% - 50px);
        }
        
        .position-item .text-truncate {
            max-width: 120px;
        }
        
        .position-item h6 {
            font-size: 0.85rem;
        }
        
        .position-item .badge {
            max-width: 100px;
            font-size: 0.7rem;
        }
    }
    
    /* Melhorias para display de posições em telas pequenas */
    @media (max-width: 991.98px) {
        .position-list {
            max-height: 300px !important;
        }
        
        #posicoesTab .position-list {
            max-height: 300px !important;
        }
        
        .position-item .rounded-circle {
            width: 35px !important;
            height: 35px !important;
            min-width: 35px;
        }
    }
    
    /* Melhorias para tablets */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .position-item .flex-grow-1.ms-md-3 {
            margin-left: 0.5rem !important;
        }
        
        .position-item .d-flex.flex-column.flex-md-row.justify-content-between {
            flex-direction: column !important;
        }
        
        .position-item .mt-2.mt-md-0 {
            margin-top: 0.5rem !important;
        }
    }
    
    /* Improved layout proportions */
    .content-area-main {
        width: 65%;
    }
    
    .content-area-sidebar {
        width: 35%;
    }
    
    /* Better organogram layout */
    .org-chart-container {
        padding: 8px;
        min-height: 450px;
    }
    
    .org-box {
        margin: 0 4px 15px;
        min-width: 160px;
        padding: 10px 8px 15px;
    }
    
    /* Compact department display */
    .dept-card {
        margin-bottom: 0.5rem;
        padding: 0.6rem;
    }
    
    /* Position list optimization */
    .position-list {
        border-radius: 6px;
        background-color: #f9f9f9;
        padding: 0.4rem;
    }
    
    .position-item .card {
        margin-bottom: 0.4rem;
    }
    
    .position-item .card-body {
        padding: 0.6rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .content-area-main {
        width: 60%;
    }
    
    .content-area-sidebar {
        width: 40%;
    }
    
        .org-box {
            min-width: 160px;
            margin: 0 4px 15px;
        }
    }
    
    @media (max-width: 991.98px) {
        .content-area-main, .content-area-sidebar {
            width: 100%;
        }
        
        .org-chart-container {
            min-height: 400px;
        }
    }
    
    /* Tab content spacing */
    .tab-content {
        min-height: 480px;
    }
    
    .tab-pane {
        height: 100%;
        padding: 10px 5px;
    }
    
    /* Unidades section improvements */
    #unidadesTab {
        display: flex;
        flex-direction: column;
    }
    
    .unidade-card {
        margin-bottom: 12px;
        padding: 12px;
    }
    
    .unidade-card h6 {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .unidade-details {
        margin-bottom: 10px;
    }
    
    #unidadesMap {
        height: 250px;
        margin-bottom: 15px;
    }
    
    /* Departamentos section improvements */
    #departamentosTab {
        display: flex;
        flex-direction: column;
    }
    
    .dept-card {
        margin-bottom: 12px;
        padding: 12px;
    }
    
    .dept-card h6 {
        font-size: 1rem;
        margin-bottom: 8px;
    }
    
    .dept-stats {
        margin-top: 10px;
    }
    
    #departmentDistributionChart {
        height: 220px !important;
        margin-bottom: 15px;
    }
    
    /* Posições section improvements */
    #posicoesTab {
        display: flex;
        flex-direction: column;
    }
    
    .position-filters-container {
        margin-bottom: 12px;
    }
    
    .position-list {
        max-height: 450px;
        overflow-y: auto;
        padding: 10px;
        margin-bottom: 15px;
    }
    
    .position-item {
        margin-bottom: 12px;
    }
    
    .position-item .card-body {
        padding: 12px;
    }
    
    .position-item h6 {
        font-size: 0.95rem;
        line-height: 1.4;
        margin-bottom: 6px;
    }
    
    .position-item .text-truncate {
        max-width: 180px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .content-area-main {
            width: 60%;
        }
        
        .content-area-sidebar {
            width: 40%;
        }
        
        .position-item .text-truncate {
            max-width: 160px;
        }
    }
    
    /* Definir estilo para os painéis de estrutura na direita */
    .estrutura-panel {
        position: fixed;
        right: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        z-index: 100;
        width: 350px;
        height: auto;
        max-height: 450px;
        overflow-y: auto;
        padding: 15px;
        display: none;
    }
    
    /* Estilos para a área de tabs de conteúdo no sidebar */
    .card-body {
        padding: 0 !important;
    }
    
    .card-body .tab-content {
        display: flex;
        flex-direction: column;
        height: 100%;
        flex: 1;
    }
    
    /* Garantir que abas inativas fiquem ocultas */
    .card-body .tab-pane {
        display: none;
        height: 100%;
    }
    
    /* Aba ativa ocupa toda a altura disponível */
    .card-body .tab-pane.active {
        display: flex !important;
        flex-direction: column;
        height: 100%;
    }
    
    /* Remover borda inferior das abas */
    .card-body .nav-tabs {
        margin-bottom: 0 !important;
        border-bottom: none;
    }
    
    /* Ajuste específico para os links das abas */
    .card-body .nav-tabs .nav-link {
        border-bottom: 0;
    }
    
    .card-body .nav-tabs .nav-link.active {
        border-bottom-color: transparent;
    }
    
    /* Conteúdo de cada aba */
    .estrutura-detalhes-content {
        padding: 0.75rem 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    /* Ajustes para o gráfico de departamentos */
    .dept-chart-container {
        flex-shrink: 0;
        margin-top: 0;
        margin-bottom: 0.5rem;
        height: 150px;
    }
    
    #departmentDistributionChart {
        height: 100% !important;
        max-height: 150px !important;
    }
    
    /* Listas dentro das abas */
    .card-body .unidades-list, 
    .card-body .departments-list, 
    .card-body .position-list {
        overflow-y: auto;
        padding-right: 5px;
        flex: 1;
    }
    
    /* Espaçamento de títulos */
    .d-flex.justify-content-between.align-items-center.mb-3 {
        margin-bottom: 0.5rem !important;
    }
    
    /* Tamanho da fonte dos títulos */
    .tab-pane h6.mb-0 {
        font-size: 0.95rem;
    }
    
    /* Garantir que o tab-content ocupe toda a altura disponível */
    .tab-content {
        flex: 1;
    }
    
    /* Posicionar o conteúdo da aba imediatamente abaixo das tabs */
    .nav-tabs {
        border-bottom: none;
    }
    
    /* Ajuste específico para as abas */
    .nav-tabs .nav-link {
        border-bottom: 0;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: transparent;
    }
    
    /* Estilo consistente para o conteúdo da aba */
    .estrutura-detalhes-content {
        padding: 0.75rem 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    /* Ajuste para garantir que o conteúdo apareça logo abaixo das abas */
    .tab-pane.active .estrutura-detalhes-content {
        padding-top: 0.75rem;
    }
    
    /* Ensure consistent styling for chart containers */
    .dept-chart-container {
        flex-shrink: 0;
        margin-top: 0;
        margin-bottom: 0.5rem;
        height: 150px;
    }
    
    #departmentDistributionChart {
        height: 100% !important;
        max-height: 150px !important;
    }
    
    /* Make list containers consistent */
    .card-body .unidades-list, 
    .card-body .departments-list, 
    .card-body .position-list {
        overflow-y: auto;
        padding-right: 5px;
        flex: 1;
    }
    
    /* Adjust padding on tab panes to be consistent and minimal at top */
    .card-body .tab-pane {
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
    
    /* Reduce spacing around headings */
    .d-flex.justify-content-between.align-items-center.mb-3 {
        margin-bottom: 0.5rem !important;
    }
    
    /* More compact heading style */
    .tab-pane h6.mb-0 {
        font-size: 0.95rem;
    }
    
    /* Remover margens e paddings extras */
    .card-body {
        padding: 0 !important;
    }
    
    /* Garantir que o tab-content ocupe toda a altura disponível */
    .tab-content {
        flex: 1;
    }
    
    /* Posicionar o conteúdo da aba imediatamente abaixo das tabs */
    .nav-tabs {
        border-bottom: none;
    }
    
    /* Ajuste específico para as abas */
    .nav-tabs .nav-link {
        border-bottom: 0;
    }
    
    .nav-tabs .nav-link.active {
        border-bottom-color: transparent;
    }
    
    /* Estilo consistente para o conteúdo da aba */
    .estrutura-detalhes-content {
        padding: 0.75rem 1rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* Section content styles */
    .section-content {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .section-content h5 {
        color: #2c3e50;
        font-weight: 600;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f1f1f1;
    }

    /* Content area styles */
    .content-area-sidebar {
        height: 100%;
        overflow-y: auto;
    }

    .estrutura-detalhes-content {
        height: 100%;
        overflow-y: auto;
        padding: 1rem;
    }

    /* List containers */
    .unidades-list,
    .departamentos-list,
    .position-list {
        max-height: 300px;
        overflow-y: auto;
        padding: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .section-content {
            margin-bottom: 1rem;
        }
    }
</style>';

// Layout content
$content = ob_get_clean();
ob_start();
?>

<div class="container-fluid py-4">
    <!-- Page Header com animação sutil de entrada -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
        <div>
            <h1 class="h3 mb-1">Estrutura Organizacional</h1>
            <p class="text-muted mb-0">Visualização dinâmica do organograma e distribuição de colaboradores</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ajudaEstruturaModal">
                <i class="fas fa-question-circle me-2"></i>Ajuda
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportarModal">
                <i class="fas fa-file-export me-2"></i>Exportar
            </button>
            <button class="btn btn-success" id="printEstruturaBtn">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
        </div>
    </div>

    <!-- KPIs redesenhados com efeito de entrada -->
    <div class="row g-3 mb-4 animate__animated animate__fadeInUp" style="--animate-delay: 0.1s">
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(52, 152, 219, 0.1);">
                        <i class="fas fa-users" style="color: #3498db;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo $resumo['total_colaboradores']; ?></h4>
                            <span class="d-block small">Colaboradores</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(46, 204, 113, 0.1);">
                        <i class="fas fa-id-badge" style="color: #2ecc71;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo $resumo['total_cargos']; ?></h4>
                            <span class="d-block small">Cargos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(52, 152, 219, 0.1);">
                        <i class="fas fa-building" style="color: #3498db;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo $resumo['total_unidades']; ?></h4>
                            <span class="d-block small">Unidades</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(243, 156, 18, 0.1);">
                        <i class="fas fa-sitemap" style="color: #f39c12;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo $resumo['total_posicoes']; ?></h4>
                            <span class="d-block small">Posições</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(231, 76, 60, 0.1);">
                        <i class="fas fa-layer-group" style="color: #e74c3c;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo count($departamentos); ?></h4>
                            <span class="d-block small">Departamentos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background-color: rgba(155, 89, 182, 0.1);">
                        <i class="fas fa-briefcase" style="color: #9b59b6;"></i>
                    </div>
                        <div>
                            <h6 class="text-muted mb-0 small">Total de</h6>
                            <h4 class="mb-0 fw-bold"><?php echo $resumo['vagas_abertas']; ?></h4>
                            <span class="d-block small">Vagas Abertas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros melhorados -->
    <div class="card mb-4 border-0 shadow-sm animate__animated animate__fadeInUp" style="--animate-delay: 0.2s">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="fas fa-filter me-2 text-primary"></i>Filtros Avançados</h5>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="true">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
        <div class="collapse show" id="filtrosCollapse">
        <div class="card-body">
            <form class="row g-3" id="filtroEstruturaForm">
                <div class="col-md-3">
                    <label class="form-label fw-medium">Unidade</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-building text-primary"></i></span>
                        <select class="form-select" id="unidadeFilter">
                            <option value="">Todas as Unidades</option>
                            <?php foreach ($unidades as $unidade): ?>
                            <option value="<?php echo $unidade['id']; ?>"><?php echo htmlspecialchars($unidade['nome']); ?> (<?php echo $unidade['total_colaboradores']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Departamento</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-layer-group text-success"></i></span>
                        <select class="form-select" id="departamentoFilter">
                            <option value="">Todos os Departamentos</option>
                            <?php foreach ($departamentos as $departamento): ?>
                            <option value="<?php echo $departamento['id']; ?>"><?php echo htmlspecialchars($departamento['nome']); ?> (<?php echo $departamento['total_colaboradores']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Nível Hierárquico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-chart-line text-warning"></i></span>
                        <select class="form-select" id="nivelFilter">
                            <option value="">Todos os Níveis</option>
                            <?php foreach ($niveis as $nivel): ?>
                            <option value="<?php echo $nivel['id']; ?>"><?php echo htmlspecialchars($nivel['nome']); ?> (<?php echo $nivel['total_colaboradores']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Status da Posição</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user-check text-info"></i></span>
                        <select class="form-select" id="statusFilter">
                            <option value="">Todos os Status</option>
                            <option value="ocupada">Ocupadas</option>
                            <option value="vaga">Vagas</option>
                            <option value="recrutamento">Em Recrutamento</option>
                        </select>
                    </div>
                </div>
                    <div class="col-12 mt-3">
                    <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-filter me-2"></i>Aplicar Filtros
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-2"></i>Limpar
                        </button>
                            <div class="ms-auto d-flex align-items-center gap-3">
                                <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="filtroAutomatico">
                                <label class="form-check-label" for="filtroAutomatico">Atualização automática</label>
                            </div>
                                <a href="#" class="text-muted small" data-bs-toggle="tooltip" title="Salvar Visualização Atual">
                                    <i class="fas fa-save me-1"></i>Salvar Configuração
                                </a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Organograma e Detalhes -->
    <div class="row g-3">
        <div class="col-lg-8 content-area-main">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-sitemap me-2 text-primary"></i>Organograma Funcional</h5>
                    <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary active" data-view="hierarchy">
                                <i class="fas fa-sitemap me-1"></i>Hierárquico
                        </button>
                        <button class="btn btn-sm btn-outline-primary" data-view="network">
                                <i class="fas fa-project-diagram me-1"></i>Rede
                        </button>
                    </div>
                        <div class="btn-group ms-2">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Aproximar" id="zoomIn">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Afastar" id="zoomOut">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Redefinir zoom" id="zoomReset">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body position-relative" style="min-height: 550px;">
                    <div id="organogramChart" style="width: 100%; height: 100%; min-height: 550px;" class="overflow-auto"></div>
                    <div id="orgLoadingOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75">
                        <div class="text-center">
                            <div class="spinner-border text-primary mb-3" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <p class="mb-0">Carregando organograma...</p>
                        </div>
                    </div>
                    
                    <!-- Controles do organograma -->
                    <div class="org-controls">
                        <button class="btn btn-sm" id="downloadOrgChart" data-bs-toggle="tooltip" title="Exportar">
                            <i class="fas fa-download"></i>
                            </button>
                        <button class="btn btn-sm" id="fullscreenOrgChart" data-bs-toggle="tooltip" title="Tela Cheia">
                            <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                        </div>
                    </div>
                <div class="card-footer bg-white border-top py-2">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center">
                                <span class="legend-color status-ocupada me-1"></span>
                                <small>Ocupada</small>
                </div>
                            <div class="d-flex align-items-center">
                                <span class="legend-color status-vaga me-1"></span>
                                <small>Vaga</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="legend-color status-recrutamento me-1"></span>
                                <small>Em Recrutamento</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhes da Estrutura Aprimorados -->
        <div class="col-lg-4 content-area-sidebar d-flex flex-column h-100">
            <div class="card border-0 shadow-sm flex-grow-1 d-flex flex-column">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Detalhes da Estrutura</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary" id="editarEstruturaBtn">
                        <i class="fas fa-edit me-1"></i>Editar
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="estrutura-detalhes-content">
                        <!-- Unidades Section -->
                        <div class="section-content mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Unidades Operacionais</h6>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="toggleMapView">
                                    <label class="form-check-label small" for="toggleMapView">Visualizar no Mapa</label>
                                </div>
                            </div>
                            
                            <!-- Map Container -->
                            <div id="unidadesMapContainer" style="display: none; margin-bottom: 15px;">
                                <div id="unidadesMap"></div>
                            </div>
                            
                            <!-- Unidades List -->
                            <div class="unidades-list">
                                <?php foreach ($unidades as $unidade): ?>
                                <div class="card unidade-card mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="card-title mb-2"><?php echo htmlspecialchars($unidade['nome']); ?></h6>
                                            <span class="badge bg-primary rounded-pill"><?php echo $unidade['total_colaboradores']; ?></span>
                                        </div>
                                        <div class="unidade-details mb-2">
                                            <div class="d-flex align-items-center text-muted small mb-1">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                <?php echo htmlspecialchars($unidade['cidade'] . '/' . $unidade['estado']); ?>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="#" class="btn btn-sm btn-outline-primary show-unit-detail" data-unit-id="<?php echo $unidade['id']; ?>">
                                                Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Departamentos Section -->
                        <div class="section-content mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Departamentos</h6>
                            </div>
                            
                            <div class="dept-chart-container mb-3">
                                <canvas id="departmentDistributionChart"></canvas>
                            </div>
                            
                            <div class="departamentos-list">
                                <?php foreach ($departamentos as $departamento): 
                                    $estatisticas = getEstatisticasDepartamento($departamento['id'], $colaboradores, $posicoes);
                                ?>
                                <div class="card dept-card mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="card-title mb-2"><?php echo htmlspecialchars($departamento['nome']); ?></h6>
                                            <span class="badge bg-primary rounded-pill"><?php echo $departamento['total_colaboradores']; ?></span>
                                        </div>
                                        <div class="dept-stats">
                                            <div class="row g-2 text-center">
                                                <div class="col-3">
                                                    <div class="small fw-bold"><?php echo $departamento['total_cargos']; ?></div>
                                                    <div class="small text-muted">Cargos</div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="small fw-bold"><?php echo $estatisticas['ocupacao']; ?>%</div>
                                                    <div class="small text-muted">Ocupação</div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="small fw-bold"><?php echo $estatisticas['vagas']; ?></div>
                                                    <div class="small text-muted">Vagas</div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="small fw-bold">+<?php echo $estatisticas['crescimento']; ?>%</div>
                                                    <div class="small text-muted">Cresc.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Posições Section -->
                        <div class="section-content">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Posições</h6>
                            </div>
                            
                            <!-- Filters -->
                            <div class="position-filters-container mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm" placeholder="Filtrar posições..." id="filterPositions">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" data-filter="all">Todas</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="vacant">Vagas Abertas</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="filled">Posições Ocupadas</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="#" data-filter="active">Status: Ativo</a></li>
                                        <li><a class="dropdown-item" href="#" data-filter="inactive">Status: Inativo</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Positions Legend -->
                            <div class="d-flex justify-content-between align-items-center position-legend mb-3">
                                <div class="d-flex gap-3">
                                    <div class="d-flex align-items-center">
                                        <span class="legend-color status-ocupada me-1"></span>
                                        <small>Ocupada</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="legend-color status-vaga me-1"></span>
                                        <small>Vaga</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="legend-color status-recrutamento me-1"></span>
                                        <small>Recrutando</small>
                                    </div>
                                </div>
                                <div class="position-count">
                                    <small class="text-muted"><span id="positionCount">0</span> posições</small>
                                </div>
                            </div>
                            
                            <!-- Positions List -->
                            <div class="position-list">
                                <?php foreach ($posicoes as $posicao): 
                                    $colaborador = isset($posicao['colaborador_id']) ? getColaboradorById($posicao['colaborador_id'], $colaboradores) : null;
                                    $departamento = '';
                                    foreach ($departamentos as $dept) {
                                        if ($dept['id'] == $posicao['departamento_id']) {
                                            $departamento = $dept['nome'];
                                            break;
                                        }
                                    }
                                    
                                    // Get nivel name
                                    $nivelNome = '';
                                    foreach ($niveis as $nivel) {
                                        if ($nivel['id'] == $posicao['nivel_id']) {
                                            $nivelNome = $nivel['nome'];
                                            break;
                                        }
                                    }
                                ?>
                                <div class="position-item" data-status="<?php echo $posicao['status']; ?>" data-department="<?php echo $posicao['departamento_id']; ?>" data-level="<?php echo $posicao['nivel_id']; ?>">
                                    <div class="card">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-start">
                                                <?php if ($posicao['status'] == 'ocupada' && $colaborador): ?>
                                                <div class="position-status rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                    <?php
                                                    $iniciais = getInitials($colaborador['nome']);
                                                    echo '<span class="text-white fw-bold">' . $iniciais . '</span>';
                                                    ?>
                                                </div>
                                                <?php elseif ($posicao['status'] == 'vaga'): ?>
                                                <div class="position-status rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                    <i class="fas fa-user-plus text-white"></i>
                                                </div>
                                                <?php else: ?>
                                                <div class="position-status rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                    <i class="fas fa-hourglass-half text-white"></i>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <div class="flex-grow-1 ms-3">
                                                    <!-- Título e status da posição -->
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($posicao['titulo']); ?></h6>
                                                        <div class="ms-2">
                                                            <?php if ($posicao['status'] == 'vaga'): ?>
                                                            <span class="badge bg-danger">Vaga Aberta</span>
                                                            <?php elseif ($posicao['status'] == 'recrutamento'): ?>
                                                            <span class="badge bg-warning text-dark">Em Recrutamento</span>
                                                            <?php else: ?>
                                                            <span class="badge bg-success">Ocupada</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Departamento e nível hierárquico -->
                                                    <div class="small text-muted mb-1">
                                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                                            <div>
                                                                <i class="fas fa-layer-group me-1"></i>
                                                                <?php echo htmlspecialchars($departamento); ?>
                                                            </div>
                                                            
                                                            <?php if (!empty($nivelNome)): ?>
                                                            <div>
                                                                <i class="fas fa-chart-line me-1"></i>
                                                                <?php echo htmlspecialchars($nivelNome); ?>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Ocupante da posição, se houver -->
                                                    <?php if ($posicao['status'] == 'ocupada' && $colaborador): ?>
                                                    <div class="small text-success mb-2">
                                                        <i class="fas fa-user me-1"></i>
                                                        <?php echo htmlspecialchars($colaborador['nome']); ?>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Botões de ação -->
                                                    <div class="position-actions">
                                                        <?php if ($posicao['status'] == 'ocupada' && $colaborador): ?>
                                                        <button class="btn btn-sm btn-outline-primary view-profile" data-employee-id="<?php echo $colaborador['id']; ?>">
                                                            <i class="fas fa-user me-1"></i>Ver Perfil
                                                        </button>
                                                        <?php elseif ($posicao['status'] == 'vaga'): ?>
                                                        <button class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-plus-circle me-1"></i>Iniciar Recrutamento
                                                        </button>
                                                        <?php else: ?>
                                                        <button class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-tasks me-1"></i>Ver Processo
                                                        </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Exportar Estrutura -->
    <div class="modal fade" id="exportarModal" tabindex="-1" aria-labelledby="exportarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportarModalLabel">Exportar Estrutura Organizacional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Selecione o formato e as informações que deseja incluir no arquivo exportado:</p>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Formato</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="formatoExport" id="formatoPdf" checked>
                                <label class="form-check-label" for="formatoPdf">
                                    <i class="far fa-file-pdf text-danger me-1"></i> PDF
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="formatoExport" id="formatoExcel">
                                <label class="form-check-label" for="formatoExcel">
                                    <i class="far fa-file-excel text-success me-1"></i> Excel
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="formatoExport" id="formatoImage">
                                <label class="form-check-label" for="formatoImage">
                                    <i class="far fa-file-image text-primary me-1"></i> Imagem
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Conteúdo</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeOrganograma" checked>
                            <label class="form-check-label" for="includeOrganograma">
                                Incluir Organograma
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeUnidades" checked>
                            <label class="form-check-label" for="includeUnidades">
                                Incluir Dados das Unidades
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeDepartamentos" checked>
                            <label class="form-check-label" for="includeDepartamentos">
                                Incluir Dados dos Departamentos
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeColaboradores">
                            <label class="form-check-label" for="includeColaboradores">
                                Incluir Lista de Colaboradores
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Aplicar filtros atuais</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="aplicarFiltrosExport">
                            <label class="form-check-label" for="aplicarFiltrosExport">
                                Usar filtros aplicados na visualização atual
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-file-export me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Ajuda -->
    <div class="modal fade" id="ajudaEstruturaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        Ajuda - Estrutura Organizacional
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="card-title">
                                        <i class="fas fa-sitemap text-success me-1"></i>
                                        Organograma
                                    </h6>
                                    <p class="text-muted small mb-1">O organograma permite visualizar a hierarquia completa da empresa.</p>
                                    <ul class="list-unstyled small mb-0">
                                        <li class="mb-1">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Use as ferramentas de zoom para navegar
                                        </li>
                                        <li class="mb-1">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Clique em qualquer posição para ver detalhes
                                        </li>
                                        <li>
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Alterne entre visualização hierárquica e de rede
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="card-title">
                                        <i class="fas fa-filter text-primary me-1"></i>
                                        Filtros
                                    </h6>
                                    <p class="text-muted small mb-1">Os filtros permitem personalizar a visualização da estrutura.</p>
                                    <ul class="list-unstyled small mb-0">
                                        <li class="mb-1">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Filtre por unidade, departamento ou nível
                                        </li>
                                        <li class="mb-1">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Visualize apenas posições com status específico
                                        </li>
                                        <li>
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Salve configurações de visualização para futuro acesso
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info py-1 px-2 small mb-0 mt-1">
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>Dica:</strong> Para ver detalhes de um colaborador, clique na posição ocupada no organograma ou na lista de posições.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Entendi</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Perfil de Colaborador -->
    <div class="modal fade" id="employeeProfileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Perfil do Colaborador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <!-- Conteúdo carregado via JavaScript -->
                    <div id="employeeProfileContent">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Carregando...</span>
                            </div>
                            <p class="mt-1 small text-muted">Carregando perfil do colaborador...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para o Organograma e interações -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing organogram components');
        
        // Force hide loading overlay immediately
        const loadingOverlay = document.getElementById('orgLoadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
            console.log('Force hide loading overlay');
        }
        
        // Initialize components in sequence
        initializeMap();
        initializeDepartmentChart();
        loadPositions();
        setupPositionFilters();
        
        // Initialize the organogram with a slight delay to ensure DOM is ready
        setTimeout(function() {
            console.log('Loading organogram after delay');
            try {
                loadOrganogram();
            } catch (e) {
                console.error('Error in initial organogram load:', e);
                // Show error message
                const container = document.getElementById('organogramChart');
                if (container) {
                    container.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Erro ao carregar o organograma: ${e.message}
                        </div>
                    `;
                }
            }
        }, 300);
        
        // Initialize UI elements
        const toggleMapView = document.getElementById('toggleMapView');
        const mapContainer = document.getElementById('unidadesMapContainer');
        
        if (toggleMapView && mapContainer) {
            toggleMapView.addEventListener('change', function() {
                mapContainer.style.display = this.checked ? 'block' : 'none';
                if (this.checked && typeof unidadesMap !== 'undefined') {
                    setTimeout(() => unidadesMap.invalidateSize(), 100);
                }
            });
        }
        
        // Adjust content heights
        adjustContentHeights();
        window.addEventListener('resize', adjustContentHeights);
    });

    // Load and render organization chart
    function loadOrganogram() {
        console.log('loadOrganogram called');
        const container = document.getElementById('organogramChart');
        const loadingOverlay = document.getElementById('orgLoadingOverlay');
        
        if (!container) {
            console.error('Organogram container not found');
            return;
        }
        
        try {
            // Clear existing content
            container.innerHTML = '';
            
            // Show loading state
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }
            
            // Get colaboradores data
            const colaboradores = <?php echo json_encode($colaboradores); ?>;
            
            // Verify data
            if (!Array.isArray(colaboradores) || colaboradores.length === 0) {
                throw new Error('Dados de colaboradores inválidos ou vazios');
            }
            
            console.log('Building hierarchy tree with', colaboradores.length, 'colaboradores');
            const rootNode = buildHierarchyTree(colaboradores);
            
            if (!rootNode) {
                throw new Error('Não foi possível construir a árvore hierárquica');
            }
            
            // Render after short delay to show loading
            setTimeout(function() {
                try {
                    console.log('Rendering organogram');
                    renderOrganogram(rootNode, container);
                    console.log('Organogram rendered successfully');
                    
                    // Set up controls after rendering
                    setupZoomControls();
                    setupExtraControls();
                    
                    // Make buttons work by directly adding event listeners to visible buttons
                    setupOrganogramButtonListeners();
                } catch (error) {
                    console.error('Error rendering organogram:', error);
                    container.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Erro ao renderizar o organograma: ${error.message}
                        </div>
                    `;
                } finally {
                    // Always hide loading overlay
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'none';
                        console.log('Hiding loading overlay after render attempt');
                    }
                }
            }, 500);
        } catch (error) {
            console.error('Error preparing organogram data:', error);
            
            // Hide loading and show error
            if (loadingOverlay) {
                loadingOverlay.style.display = 'none';
            }
            
            container.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Erro ao preparar dados do organograma: ${error.message}
                </div>
            `;
        }
    }

    // Make sure buttons work by directly attaching listeners
    function setupOrganogramButtonListeners() {
        console.log('Setting up direct button listeners');
        
        // Query all buttons in the organogram area
        document.querySelectorAll('#organogramChart button, .organogram-controls button').forEach(button => {
            console.log('Found button:', button.textContent, button.className);
            
            // Add click logging
            button.addEventListener('click', function(e) {
                console.log('Button clicked:', this.textContent, this.className, e);
            });
        });
        
        // Zoom controls
        const zoomInButtons = document.querySelectorAll('[data-action="zoom-in"], #zoomIn, .btn-zoom-in');
        const zoomOutButtons = document.querySelectorAll('[data-action="zoom-out"], #zoomOut, .btn-zoom-out');
        const zoomResetButtons = document.querySelectorAll('[data-action="zoom-reset"], #zoomReset, .btn-zoom-reset');
        
        console.log('Zoom buttons found:', zoomInButtons.length, zoomOutButtons.length, zoomResetButtons.length);
        
        const orgChart = document.querySelector('.org-chart-container');
        if (orgChart) {
            // Initialize scale if needed
            if (!orgChart.style.transform) {
                orgChart.style.transform = 'scale(1)';
            }
            
            let currentScale = 1;
            
            // Zoom in
            zoomInButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentScale += 0.1;
                    orgChart.style.transform = `scale(${currentScale})`;
                    console.log('Zoom in activated, scale:', currentScale);
                });
            });
            
            // Zoom out
            zoomOutButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentScale = Math.max(0.5, currentScale - 0.1);
                    orgChart.style.transform = `scale(${currentScale})`;
                    console.log('Zoom out activated, scale:', currentScale);
                });
            });
            
            // Reset zoom
            zoomResetButtons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentScale = 1;
                    orgChart.style.transform = `scale(${currentScale})`;
                    console.log('Zoom reset activated');
                });
            });
        }
        
        // Download and fullscreen
        document.querySelectorAll('[data-action="download"], #downloadOrgChart, .btn-download').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Funcionalidade de exportação será implementada em breve.');
                console.log('Download activated');
            });
        });
        
        document.querySelectorAll('[data-action="fullscreen"], #fullscreenOrgChart, .btn-fullscreen').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const orgChartContainer = document.getElementById('organogramChart');
                try {
                    if (document.fullscreenElement) {
                        document.exitFullscreen();
                    } else if (orgChartContainer) {
                        orgChartContainer.requestFullscreen();
                    }
                    console.log('Fullscreen toggled');
                } catch (err) {
                    console.error('Fullscreen error:', err);
                    alert('Não foi possível ativar o modo de tela cheia.');
                }
            });
        });
    }

    // Keep existing setupZoomControls and setupExtraControls for compatibility
</script>

<!-- Additional organogram implementation -->
<script>
    // Build hierarchy tree from flat employee data
    function buildHierarchyTree(colaboradores) {
        console.log('Building hierarchy tree');
        
        // Create nodes map with employee ID as key
        const nodesMap = {};
        
        // First pass: create node objects for all employees
        colaboradores.forEach(employee => {
            nodesMap[employee.id] = {
                ...employee,
                children: []
            };
        });
        
        // Find the root node (employee with no manager/gestor)
        let rootNode = null;
        
        // Second pass: build parent-child relationships
        colaboradores.forEach(employee => {
            const node = nodesMap[employee.id];
            
            if (!employee.gestor_id) {
                // This is the CEO/root node
                rootNode = node;
            } else if (nodesMap[employee.gestor_id]) {
                // Add this employee as a child to their manager
                nodesMap[employee.gestor_id].children.push(node);
            }
        });
        
        // If no explicit root was found, take the first employee as root
        if (!rootNode && colaboradores.length > 0) {
            rootNode = nodesMap[colaboradores[0].id];
        }
        
        return rootNode;
    }

    // Render the organogram with HTML
    function renderOrganogram(rootNode, container) {
        if (!rootNode) {
            throw new Error('Root node is null or undefined');
        }
        
        // Create main container
        const chartContainer = document.createElement('div');
        chartContainer.className = 'org-chart-container';
        container.appendChild(chartContainer);
        
        // Recursively render organization chart starting from the root
        renderOrgLevel(rootNode, chartContainer, 0);
        
        // Add event listeners to all org boxes after rendering
        setupOrgBoxEvents();
        
        return chartContainer;
    }

    // Render a single level of the organogram
    function renderOrgLevel(node, parentContainer, level) {
        // Create level container
        const levelDiv = document.createElement('div');
        levelDiv.className = 'org-level';
        parentContainer.appendChild(levelDiv);
        
        // Create box for current node
        const nodeDiv = createOrgBox(node, level === 0);
        levelDiv.appendChild(nodeDiv);
        
        // If this node has children, render them
        if (node.children && node.children.length > 0) {
            // Create connector from parent to children
            const connectorDiv = document.createElement('div');
            connectorDiv.className = 'org-connector-vertical';
            levelDiv.appendChild(connectorDiv);
            
            // Create level group for children
            const childrenLevel = document.createElement('div');
            childrenLevel.className = 'org-level-group';
            
            // If many children, create a sublevel for better organization
            if (node.children.length > 3) {
                // Create multiple rows as needed
                const rows = Math.ceil(node.children.length / 3);
                for (let r = 0; r < rows; r++) {
                    const rowDiv = document.createElement('div');
                    rowDiv.className = 'org-micro-level';
                    
                    // Add children to this row (max 3 per row)
                    const startIdx = r * 3;
                    const endIdx = Math.min(startIdx + 3, node.children.length);
                    
                    for (let i = startIdx; i < endIdx; i++) {
                        const childNode = node.children[i];
                        const childBox = createOrgBox(childNode, false);
                        rowDiv.appendChild(childBox);
                        
                        // Recursively render children of this node if any
                        if (childNode.children && childNode.children.length > 0) {
                            renderOrgLevel(childNode, childBox, level + 1);
                        }
                    }
                    
                    childrenLevel.appendChild(rowDiv);
                }
            } else {
                // Fewer children, render them directly
                node.children.forEach(childNode => {
                    const subLevel = document.createElement('div');
                    subLevel.className = 'org-sublevel';
                    
                    const childBox = createOrgBox(childNode, false);
                    subLevel.appendChild(childBox);
                    
                    // Recursively render children of this node if any
                    if (childNode.children && childNode.children.length > 0) {
                        renderOrgLevel(childNode, subLevel, level + 1);
                    }
                    
                    childrenLevel.appendChild(subLevel);
                });
            }
            
            levelDiv.appendChild(childrenLevel);
        }
    }

    // Create an organization box for an employee
    function createOrgBox(employee, isRoot = false) {
        // Get department color class
        const deptClass = `dept-color-${employee.departamento_id}`;
        
        // Create box
        const box = document.createElement('div');
        box.className = `org-box ${isRoot ? 'root' : ''} ${deptClass}`;
        box.dataset.employeeId = employee.id;
        
        // Create avatar/initials
        const avatar = document.createElement('div');
        avatar.className = 'org-avatar';
        
        // Use dynamic color from employee name (style is in CSS)
        const initials = getInitials(employee.nome);
        avatar.textContent = initials;
        avatar.style.backgroundColor = getColorFromName(employee.nome);
        
        // Employee details
        const details = document.createElement('div');
        details.className = 'org-details';
        
        const name = document.createElement('div');
        name.className = 'org-name';
        name.textContent = employee.nome;
        
        const title = document.createElement('div');
        title.className = 'org-title';
        title.textContent = employee.cargo;
        
        // Action buttons
        const actions = document.createElement('div');
        actions.className = 'org-actions';
        
        const viewBtn = document.createElement('button');
        viewBtn.className = 'btn btn-sm btn-light';
        viewBtn.innerHTML = '<i class="fas fa-eye"></i>';
        viewBtn.title = 'Ver detalhes';
        
        // Append all elements
        details.appendChild(name);
        details.appendChild(title);
        
        actions.appendChild(viewBtn);
        
        box.appendChild(avatar);
        box.appendChild(details);
        box.appendChild(actions);
        
        return box;
    }

    // Initialize event listeners for org boxes
    function setupOrgBoxEvents() {
        document.querySelectorAll('.org-box').forEach(box => {
            // Click on box to show details
            box.addEventListener('click', function(e) {
                const employeeId = this.dataset.employeeId;
                if (employeeId) {
                    showEmployeeDetails(employeeId);
                }
            });
            
            // Click on view button
            box.querySelector('.btn').addEventListener('click', function(e) {
                e.stopPropagation();
                const employeeId = box.dataset.employeeId;
                if (employeeId) {
                    showEmployeeDetails(employeeId);
                }
            });
        });
    }

    // Show employee details (mock implementation)
    function showEmployeeDetails(employeeId) {
        // Find employee data
        const colaboradores = <?php echo json_encode($colaboradores); ?>;
        const employee = colaboradores.find(e => e.id == employeeId);
        
        if (!employee) {
            console.error('Employee not found:', employeeId);
            return;
        }
        
        // Show modal with employee details
        const modal = document.getElementById('employeeProfileModal');
        const content = document.getElementById('employeeProfileContent');
        
        if (modal && content) {
            // Fill content with employee data
            content.innerHTML = `
                <div class="p-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 50px; height: 50px; background-color: ${getColorFromName(employee.nome)}; color: white; font-weight: bold;">
                            ${getInitials(employee.nome)}
                        </div>
                        <div>
                            <h5 class="mb-0">${employee.nome}</h5>
                            <p class="text-muted mb-0">${employee.cargo}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Departamento:</strong> ${getDepartmentName(employee.departamento_id)}</p>
                            <p class="mb-1"><strong>Unidade:</strong> ${getUnitName(employee.unidade_id)}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Data de Admissão:</strong> ${formatDate(employee.data_admissao)}</p>
                            <p class="mb-1"><strong>Status:</strong> <span class="badge bg-success">Ativo</span></p>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <a href="colaborador_perfil_rh.php?id=${employee.id}" class="btn btn-primary">
                            <i class="fas fa-user me-1"></i> Ver Perfil Completo
                        </a>
                    </div>
                </div>
            `;
            
            // Show modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    }

    // Helper functions for data lookups
    function getDepartmentName(departmentId) {
        const departamentos = <?php echo json_encode($departamentos); ?>;
        const dept = departamentos.find(d => d.id == departmentId);
        return dept ? dept.nome : 'N/A';
    }
    
    function getUnitName(unitId) {
        const unidades = <?php echo json_encode($unidades); ?>;
        const unit = unidades.find(u => u.id == unitId);
        return unit ? unit.nome : 'N/A';
    }
    
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        return date.toLocaleDateString('pt-BR');
    }

    // Setup zoom controls
    function setupZoomControls() {
        const container = document.querySelector('.org-chart-container');
        if (!container) return;
        
        let scale = 1;
        
        // Zoom in button
        document.getElementById('zoomIn')?.addEventListener('click', function() {
            scale += 0.1;
            container.style.transform = `scale(${scale})`;
        });
        
        // Zoom out button
        document.getElementById('zoomOut')?.addEventListener('click', function() {
            scale = Math.max(0.5, scale - 0.1);
            container.style.transform = `scale(${scale})`;
        });
        
        // Reset zoom button
        document.getElementById('zoomReset')?.addEventListener('click', function() {
            scale = 1;
            container.style.transform = `scale(${scale})`;
        });
    }

    // Setup extra controls
    function setupExtraControls() {
        // Fullscreen button
        document.getElementById('fullscreenOrgChart')?.addEventListener('click', function() {
            const elem = document.getElementById('organogramChart');
            if (!elem) return;
            
            if (document.fullscreenElement) {
                document.exitFullscreen()
                    .catch(err => console.error('Error exiting fullscreen:', err));
            } else {
                elem.requestFullscreen()
                    .catch(err => console.error('Error requesting fullscreen:', err));
            }
        });
        
        // Download button (mock)
        document.getElementById('downloadOrgChart')?.addEventListener('click', function() {
            alert('Função de exportação será implementada em breve.');
        });
    }

    // Initialize department chart
    function initializeDepartmentChart() {
        const ctx = document.getElementById('departmentDistributionChart');
        if (!ctx) return;
        
        const departamentos = <?php echo json_encode($departamentos); ?>;
        
        // Extract data for chart
        const labels = departamentos.map(d => d.nome);
        const data = departamentos.map(d => d.total_colaboradores);
        const colors = [
            'rgba(52, 152, 219, 0.7)',
            'rgba(46, 204, 113, 0.7)',
            'rgba(155, 89, 182, 0.7)',
            'rgba(241, 196, 15, 0.7)',
            'rgba(231, 76, 60, 0.7)',
            'rgba(26, 188, 156, 0.7)'
        ];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors.slice(0, departamentos.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }

    // Initialize map for units
    function initializeMap() {
        const mapContainer = document.getElementById('unidadesMap');
        if (!mapContainer) return;
        
        // Create map
        const map = L.map('unidadesMap').setView([-20.2976, -40.2957], 11);
        
        // Add OSM layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add markers for each unit
        const unidades = <?php echo json_encode($unidades); ?>;
        
        unidades.forEach(unidade => {
            if (unidade.latitude && unidade.longitude) {
                const marker = L.marker([unidade.latitude, unidade.longitude]).addTo(map);
                marker.bindPopup(`
                    <strong>${unidade.nome}</strong><br>
                    ${unidade.cidade}/${unidade.estado}<br>
                    <span class="badge bg-primary">${unidade.total_colaboradores} colaboradores</span>
                `);
            }
        });
        
        // Make map available globally
        window.unidadesMap = map;
    }

    // Initialize position filters
    function setupPositionFilters() {
        console.log('Setting up position filters');
        const filterInput = document.getElementById('filterPositions');
        const positionItems = document.querySelectorAll('.position-item');
        const positionCount = document.getElementById('positionCount');
        
        if (!filterInput || !positionItems.length) {
            console.warn('Position filter elements not found', { filterInput, positionItems: positionItems.length });
            return;
        }
        
        // Update count initially
        if (positionCount) {
            positionCount.textContent = positionItems.length;
        }
        
        // Filter positions based on input
        filterInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            let visibleCount = 0;
            
            positionItems.forEach(item => {
                const title = item.querySelector('h6')?.textContent.toLowerCase() || '';
                const dept = item.querySelector('.text-truncate')?.textContent.toLowerCase() || '';
                const employee = item.querySelector('.text-success')?.textContent.toLowerCase() || '';
                
                const shouldShow = title.includes(query) || 
                                   dept.includes(query) || 
                                   employee.includes(query);
                
                item.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });
            
            // Update counter
            if (positionCount) {
                positionCount.textContent = visibleCount;
            }
        });
        
        // Filter dropdown actions
        document.querySelectorAll('.dropdown-item[data-filter]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                const filter = this.dataset.filter;
                let visibleCount = 0;
                
                positionItems.forEach(item => {
                    let shouldShow = true;
                    
                    if (filter === 'vacant') {
                        shouldShow = item.dataset.status === 'vaga' || item.dataset.status === 'recrutamento';
                    } else if (filter === 'filled') {
                        shouldShow = item.dataset.status === 'ocupada';
                    } else if (filter === 'active') {
                        // This would need real status data
                        shouldShow = true;
                    } else if (filter === 'inactive') {
                        // This would need real status data
                        shouldShow = false;
                    }
                    
                    item.style.display = shouldShow ? '' : 'none';
                    if (shouldShow) visibleCount++;
                });
                
                // Update counter
                if (positionCount) {
                    positionCount.textContent = visibleCount;
                }
                
                // Update filter input placeholder
                if (filterInput) {
                    filterInput.placeholder = `Filtrar ${this.textContent.toLowerCase()}...`;
                    filterInput.value = '';
                }
            });
        });
        
        // Connect with main page filters
        const departamentoFilter = document.getElementById('departamentoFilter');
        const nivelFilter = document.getElementById('nivelFilter');
        const statusFilter = document.getElementById('statusFilter');
        
        if (departamentoFilter) {
            departamentoFilter.addEventListener('change', applyMainFilters);
        }
        
        if (nivelFilter) {
            nivelFilter.addEventListener('change', applyMainFilters);
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', applyMainFilters);
        }
        
        // Apply filters from main filter form
        function applyMainFilters() {
            const departmentId = departamentoFilter ? departamentoFilter.value : '';
            const levelId = nivelFilter ? nivelFilter.value : '';
            const status = statusFilter ? statusFilter.value : '';
            
            let visibleCount = 0;
            
            positionItems.forEach(item => {
                let shouldShow = true;
                
                // Filter by department if selected
                if (departmentId && item.dataset.department !== departmentId) {
                    shouldShow = false;
                }
                
                // Filter by level if selected
                if (levelId && item.dataset.level !== levelId) {
                    shouldShow = false;
                }
                
                // Filter by status if selected
                if (status && item.dataset.status !== status) {
                    shouldShow = false;
                }
                
                item.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });
            
            // Update counter
            if (positionCount) {
                positionCount.textContent = visibleCount;
            }
        }
        
        // Apply filters when form is submitted
        const filtroForm = document.getElementById('filtroEstruturaForm');
        if (filtroForm) {
            filtroForm.addEventListener('submit', function(e) {
                e.preventDefault();
                applyMainFilters();
            });
            
            // Reset filters when form is reset
            filtroForm.addEventListener('reset', function() {
                setTimeout(function() {
                    // Reset all positions to visible
                    positionItems.forEach(item => {
                        item.style.display = '';
                    });
                    
                    if (positionCount) {
                        positionCount.textContent = positionItems.length;
                    }
                }, 10); // Small delay to ensure form values are reset
            });
        }
    }

    // Helper function to adjust content heights for responsive layout
    function adjustContentHeights() {
        const windowHeight = window.innerHeight;
        const headerHeight = document.querySelector('.header')?.offsetHeight || 0;
        const navHeight = document.querySelector('.navbar')?.offsetHeight || 0;
        const footerHeight = document.querySelector('.footer')?.offsetHeight || 0;
        
        // Calculate available height
        const availableHeight = windowHeight - headerHeight - navHeight - footerHeight - 80; // Extra padding
        
        // Set minimum height for organogram container
        const orgChart = document.getElementById('organogramChart');
        if (orgChart) {
            orgChart.style.minHeight = `${Math.max(550, availableHeight)}px`;
        }
        
        // Set heights for sidebar content areas
        const sidebarLists = document.querySelectorAll('.unidades-list, .departamentos-list, .position-list');
        if (sidebarLists.length > 0) {
            const targetHeight = Math.max(300, (availableHeight - 200) / sidebarLists.length);
            
            sidebarLists.forEach(list => {
                list.style.maxHeight = `${targetHeight}px`;
            });
        }
    }

    // Load position data and update counters
    function loadPositions() {
        console.log('Loading positions');
        const positionCount = document.getElementById('positionCount');
        const positionItems = document.querySelectorAll('.position-item');
        
        if (positionCount && positionItems.length) {
            positionCount.textContent = positionItems.length;
            console.log(`Updated position count: ${positionItems.length}`);
        } else {
            console.warn('Position count elements not found', { positionCount, positionItems: positionItems?.length });
        }
        
        // Make sure view-profile buttons work
        document.querySelectorAll('.view-profile').forEach(button => {
            button.addEventListener('click', function() {
                const employeeId = this.dataset.employeeId;
                if (employeeId) {
                    showEmployeeProfile(employeeId);
                }
            });
        });
        
        // Add hover effect enhancement to position cards
        positionItems.forEach(item => {
            const card = item.querySelector('.card');
            if (card) {
                // Adiciona efeito sutil de hover
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            }
        });
        
        // Ensure all text is visible inside the cards
        adjustCardTextVisibility();
    }
    
    // Ensure text is fully visible in cards
    function adjustCardTextVisibility() {
        // Remove any text-truncate classes that might be causing issues
        document.querySelectorAll('.position-item .text-truncate').forEach(element => {
            element.classList.remove('text-truncate');
        });
        
        // Ensure badges are displaying properly
        document.querySelectorAll('.position-item .badge').forEach(badge => {
            badge.style.display = 'inline-block';
            badge.style.whiteSpace = 'normal';
            badge.style.maxWidth = '100%';
        });
    }

    // Helper function to get initials from name (implemented in PHP but duplicated for JS)
    function getInitials(name) {
        if (!name) return 'NA';
        
        const words = name.split(' ');
        if (words.length >= 2) {
            return (words[0].charAt(0) + words[words.length - 1].charAt(0)).toUpperCase();
        }
        return name.substring(0, 2).toUpperCase();
    }

    // Helper function to get color from name (implemented in PHP but duplicated for JS)
    function getColorFromName(name) {
        if (!name) return '#cccccc';
        
        const colors = [
            '#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e',
            '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
            '#f1c40f', '#e67e22', '#e74c3c', '#95a5a6', '#f39c12',
            '#d35400', '#c0392b', '#7f8c8d'
        ];
        
        // Simple hash function
        let hash = 0;
        for (let i = 0; i < name.length; i++) {
            hash = name.charCodeAt(i) + ((hash << 5) - hash);
        }
        
        return colors[Math.abs(hash) % colors.length];
    }
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 