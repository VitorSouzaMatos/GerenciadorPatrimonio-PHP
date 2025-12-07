<?php
// includes/funcoes.php

session_start();

/**
 * Limpa e sanitiza entrada de dados
 */
function limpar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Verifica se usuário está logado
 */
function verificar_login() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /auth/login.php');
        exit();
    }
}

/**
 * Verifica se usuário é admin
 */
function verificar_admin() {
    verificar_login();
    if ($_SESSION['usuario_role'] !== 'admin') {
        header('Location: /index.php?erro=permissao');
        exit();
    }
}

/**
 * Redireciona com mensagem
 */
function redirecionar($url, $mensagem = '', $tipo = 'sucesso') {
    if ($mensagem) {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['mensagem_tipo'] = $tipo;
    }
    header("Location: $url");
    exit();
}

/**
 * Exibe mensagem da sessão
 */
function exibir_mensagem() {
    if (isset($_SESSION['mensagem'])) {
        $tipo = $_SESSION['mensagem_tipo'] ?? 'info';
        $classe_alerta = [
            'sucesso' => 'alert-success',
            'erro' => 'alert-danger',
            'aviso' => 'alert-warning',
            'info' => 'alert-info'
        ][$tipo] ?? 'alert-info';
        
        echo "<div class='alert $classe_alerta alert-dismissible fade show' role='alert'>";
        echo htmlspecialchars($_SESSION['mensagem']);
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
        
        unset($_SESSION['mensagem']);
        unset($_SESSION['mensagem_tipo']);
    }
}

/**
 * Formata valor monetário
 */
function formatar_moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

/**
 * Formata data BR
 */
function formatar_data($data) {
    if (empty($data) || $data == '0000-00-00') return '-';
    return date('d/m/Y', strtotime($data));
}

/**
 * Traduz status de objetos
 */
function traduzir_status_objeto($status) {
    $traducoes = [
        'ativo' => 'Ativo',
        'inativo' => 'Inativo',
        'manutencao' => 'Em Manutenção',
        'descartado' => 'Descartado'
    ];
    return $traducoes[$status] ?? $status;
}

/**
 * Traduz tipo de ocorrência
 */
function traduzir_tipo_ocorrencia($tipo) {
    $traducoes = [
        'manutencao' => 'Manutenção',
        'dano' => 'Dano',
        'perda' => 'Perda',
        'encontrado' => 'Encontrado'
    ];
    return $traducoes[$tipo] ?? $tipo;
}

/**
 * Traduz status de ocorrência
 */
function traduzir_status_ocorrencia($status) {
    $traducoes = [
        'aberta' => 'Aberta',
        'em_andamento' => 'Em Andamento',
        'resolvida' => 'Resolvida'
    ];
    return $traducoes[$status] ?? $status;
}

/**
 * Gera badge HTML baseado no status
 */
function badge_status_objeto($status) {
    $classes = [
        'ativo' => 'bg-success',
        'inativo' => 'bg-secondary',
        'manutencao' => 'bg-warning text-dark',
        'descartado' => 'bg-danger'
    ];
    $classe = $classes[$status] ?? 'bg-secondary';
    return "<span class='badge $classe'>" . traduzir_status_objeto($status) . "</span>";
}

/**
 * Gera badge HTML para status de ocorrência
 */
function badge_status_ocorrencia($status) {
    $classes = [
        'aberta' => 'bg-danger',
        'em_andamento' => 'bg-warning text-dark',
        'resolvida' => 'bg-success'
    ];
    $classe = $classes[$status] ?? 'bg-secondary';
    return "<span class='badge $classe'>" . traduzir_status_ocorrencia($status) . "</span>";
}
?>