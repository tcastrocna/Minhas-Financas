<?php
// GATEWAY DE SEGURANÇA - APP FINANÇAS
// Este arquivo é apenas a ponte. Nenhuma senha ou lógica real fica aqui.

// Define que as respostas serão sempre em JSON
header('Content-Type: application/json; charset=utf-8');

// 1. Calcula o caminho dinâmico para a pasta modules
// __DIR__ é a pasta backend. Então ele entra direto na pasta modules.
$corePath = __DIR__ . '/modules/core.php';

// 2. Tenta carregar o core de forma protegida. 
// Se der erro, retorna JSON ao invés de expor erros na tela
if (file_exists($corePath)) {
    require_once $corePath;
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Erro interno de servidor. Arquivo central de lógica não encontrado.'
    ]);
    exit;
}
?>