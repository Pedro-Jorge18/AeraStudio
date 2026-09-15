<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

$locais = $pdo->query(
    "SELECT l.*,
            (SELECT COUNT(*) FROM voos v WHERE v.local_id = l.id) AS num_voos,
            (SELECT MAX(v.data) FROM voos v WHERE v.local_id = l.id) AS ultima_vez_filmado
     FROM locais l
     ORDER BY num_voos ASC, l.nome ASC"
)->fetchAll();

$rotulos_tipo = [
    'serra' => 'Serra', 'parque' => 'Parque', 'vale_rio' => 'Vale/rio',
    'vila_historica' => 'Vila histórica', 'quinta' => 'Quinta', 'urbano' => 'Urbano', 'outro' => 'Outro',
];

$titulo_pagina = 'Locais';
require __DIR__ . '/../includes/layout_topo.php';
?>

<div class="cartao">
    <h2>Catálogo de locais (<?= count($locais) ?>)</h2>
    <table>
        <tr>
            <th>Nome</th><th>Tipo</th><th>Distrito</th><th>Andante?</th><th>Tempo viagem</th><th>Voos</th><th>Última vez filmado</th>
        </tr>
        <?php foreach ($locais as $l): ?>
            <tr>
                <td><?= htmlspecialchars($l['nome']) ?><?= $l['requer_autorizacao_privada'] ? ' <span class="pilula aviso">autorização</span>' : '' ?></td>
                <td><?= htmlspecialchars($rotulos_tipo[$l['tipo']] ?? $l['tipo']) ?></td>
                <td class="texto-suave"><?= htmlspecialchars($l['distrito'] ?? '—') ?></td>
                <td><?= $l['dentro_distrito_porto'] ? 'Sim' : 'Não' ?></td>
                <td class="texto-suave"><?= $l['tempo_viagem_min'] ? $l['tempo_viagem_min'] . ' min' : '—' ?></td>
                <td>
                    <?php if ((int) $l['num_voos'] === 0): ?>
                        <span class="pilula aviso">por filmar</span>
                    <?php else: ?>
                        <span class="pilula"><?= $l['num_voos'] ?></span>
                    <?php endif; ?>
                </td>
                <td class="texto-suave"><?= htmlspecialchars($l['ultima_vez_filmado'] ?? '—') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
