<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

// Remove locais que nunca foram filmados (0 voos associados) — eram palpites genéricos
// do catálogo inicial, agora substituídos pelos locais reais tirados do Instagram.

$candidatos = $pdo->query(
    "SELECT l.id, l.nome
     FROM locais l
     WHERE NOT EXISTS (SELECT 1 FROM voos v WHERE v.local_id = l.id)
     ORDER BY l.nome"
)->fetchAll();

if (!$candidatos) {
    echo "Nenhum local genérico por apagar — todos já têm pelo menos um voo.\n";
    exit;
}

echo "A apagar " . count($candidatos) . " locais sem voos associados:\n";
foreach ($candidatos as $c) {
    echo "  - {$c['nome']}\n";
}

$apagar = $pdo->prepare('DELETE FROM locais WHERE id = :id');
foreach ($candidatos as $c) {
    $apagar->execute(['id' => $c['id']]);
}

$restantes = (int) $pdo->query('SELECT COUNT(*) FROM locais')->fetchColumn();
echo "\nFeito. Ficam {$restantes} locais no catálogo, todos já filmados pelo menos uma vez.\n";
