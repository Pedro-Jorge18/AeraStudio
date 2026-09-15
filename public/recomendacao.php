<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

$janela = $_GET['janela'] ?? '';
$so_por_filmar = isset($_GET['so_por_filmar']) ? true : false;

$sql = "SELECT l.*,
               (SELECT COUNT(*) FROM voos v WHERE v.local_id = l.id) AS num_voos,
               (SELECT MAX(v.data) FROM voos v WHERE v.local_id = l.id) AS ultima_vez_filmado
        FROM locais l";

$condicoes = [];
$parametros = [];

// Sexta à tarde: só locais com viagem curta (<60min ida), como definido no perfil de viagens.
if ($janela === 'sexta_tarde') {
    $condicoes[] = 'l.tempo_viagem_min IS NOT NULL AND l.tempo_viagem_min < 60';
}

if ($condicoes) {
    $sql .= ' WHERE ' . implode(' AND ', $condicoes);
}

$sql .= ' ORDER BY (ultima_vez_filmado IS NOT NULL), ultima_vez_filmado ASC, l.tempo_viagem_min ASC';

$todos = $pdo->query($sql)->fetchAll();

if ($so_por_filmar) {
    $todos = array_values(array_filter($todos, fn($l) => (int) $l['num_voos'] === 0));
}

$top3 = array_slice($todos, 0, 3);

$rotulos_tipo = [
    'serra' => 'Serra', 'parque' => 'Parque', 'vale_rio' => 'Vale/rio',
    'vila_historica' => 'Vila histórica', 'quinta' => 'Quinta', 'urbano' => 'Urbano', 'outro' => 'Outro',
];

$titulo_pagina = 'Próximo destino';
require __DIR__ . '/../includes/layout_topo.php';
?>

<div class="cartao">
    <h2>Que disponibilidade têm agora?</h2>
    <form method="get" style="display:flex; gap:14px; align-items:flex-end; flex-wrap:wrap;">
        <div>
            <label for="janela">Janela</label>
            <select name="janela" id="janela">
                <option value="">Qualquer</option>
                <option value="sexta_tarde" <?= $janela === 'sexta_tarde' ? 'selected' : '' ?>>Sexta à tarde (só locais &lt;1h)</option>
                <option value="sabado" <?= $janela === 'sabado' ? 'selected' : '' ?>>Sábado</option>
                <option value="domingo" <?= $janela === 'domingo' ? 'selected' : '' ?>>Domingo</option>
            </select>
        </div>
        <label class="checkbox" style="margin-bottom:14px;">
            <input type="checkbox" name="so_por_filmar" value="1" <?= $so_por_filmar ? 'checked' : '' ?>>
            Só locais nunca filmados
        </label>
        <button type="submit" style="margin-top:0;">Sugerir</button>
    </form>
</div>

<div class="cartao">
    <h2>Top 3 sugestões</h2>
    <?php if (!$top3): ?>
        <p class="vazio">Sem locais que cumpram estes critérios — tenta relaxar o filtro.</p>
    <?php else: ?>
        <?php foreach ($top3 as $i => $l): ?>
            <div style="padding: 12px 0; <?= $i > 0 ? 'border-top:1px solid var(--border);' : '' ?>">
                <strong>#<?= $i + 1 ?> — <?= htmlspecialchars($l['nome']) ?></strong>
                <?php if ((int) $l['num_voos'] === 0): ?> <span class="pilula aviso">nunca filmado</span><?php endif; ?>
                <div class="texto-suave" style="margin-top:4px;">
                    <?= htmlspecialchars($rotulos_tipo[$l['tipo']] ?? $l['tipo']) ?>
                    · <?= htmlspecialchars($l['concelho'] ?? '') ?>
                    · <?= $l['tempo_viagem_min'] ? $l['tempo_viagem_min'] . ' min de viagem' : 'tempo de viagem não definido' ?>
                    · custo: <?= htmlspecialchars($l['custo_estimado'] ?: '0') ?>
                    <?php if ($l['ultima_vez_filmado']): ?> · última vez: <?= htmlspecialchars($l['ultima_vez_filmado']) ?><?php endif; ?>
                </div>
                <?php if ($l['notas']): ?><div class="texto-suave" style="margin-top:4px; font-size:13px;"><?= htmlspecialchars($l['notas']) ?></div><?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
