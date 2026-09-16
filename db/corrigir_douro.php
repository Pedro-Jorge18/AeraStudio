<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

// Corrige a publicação "Sunset over the Douro" (23/8) — não foi em Peso da Régua, foi no Jardim do Morro.

$verificar_local = $pdo->prepare('SELECT id FROM locais WHERE nome = :nome');
$inserir_local = $pdo->prepare(
    'INSERT INTO locais (nome, tipo, distrito, concelho, dentro_distrito_porto, tempo_viagem_min, custo_estimado, requer_autorizacao_privada, notas)
     VALUES (:nome, :tipo, :distrito, :concelho, :dentro_distrito_porto, :tempo_viagem_min, :custo_estimado, :requer_autorizacao_privada, :notas)'
);

$verificar_local->execute(['nome' => 'Jardim do Morro']);
$jardim_morro_id = $verificar_local->fetchColumn();
if (!$jardim_morro_id) {
    $inserir_local->execute([
        'nome' => 'Jardim do Morro',
        'tipo' => 'urbano',
        'distrito' => 'Porto',
        'concelho' => 'Vila Nova de Gaia',
        'dentro_distrito_porto' => 1,
        'tempo_viagem_min' => 15,
        'custo_estimado' => '0',
        'requer_autorizacao_privada' => 0,
        'notas' => 'Jardim sobre o Douro, em frente ao Porto, junto à Ponte D. Luís I. Boas vistas para pôr do sol.',
    ]);
    $jardim_morro_id = $pdo->lastInsertId();
    echo "Local novo criado: Jardim do Morro\n";
} else {
    echo "Local 'Jardim do Morro' já existia.\n";
}

$verificar_local->execute(['nome' => 'Peso da Régua']);
$regua_id = $verificar_local->fetchColumn();

if ($regua_id) {
    $stmt = $pdo->prepare('UPDATE voos SET local_id = :novo, notas = :notas WHERE local_id = :antigo AND data = :data');
    $stmt->execute([
        'novo' => $jardim_morro_id,
        'notas' => 'Confirmado pelo Pedro: foi no Jardim do Morro, não em Peso da Régua.',
        'antigo' => $regua_id,
        'data' => '2026-08-23',
    ]);
    echo $stmt->rowCount() > 0
        ? "Voo de 2026-08-23 corrigido: agora aponta para Jardim do Morro.\n"
        : "Nenhum voo em Peso da Régua a 2026-08-23 foi encontrado para corrigir (talvez já estivesse certo).\n";
} else {
    echo "Local 'Peso da Régua' não encontrado — nada para corrigir.\n";
}
