<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();
$sucesso = false;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO voos (local_id, data, hora_inicio, duracao_min, condicoes_vento, bateria_usada_pct, piloto, notas)
             VALUES (:local_id, :data, :hora_inicio, :duracao_min, :condicoes_vento, :bateria, :piloto, :notas)'
        );
        $stmt->execute([
            'local_id' => (int) $_POST['local_id'],
            'data' => $_POST['data'],
            'hora_inicio' => $_POST['hora_inicio'] ?: null,
            'duracao_min' => $_POST['duracao_min'] !== '' ? (int) $_POST['duracao_min'] : null,
            'condicoes_vento' => trim($_POST['condicoes_vento'] ?? '') ?: null,
            'bateria' => $_POST['bateria_usada_pct'] !== '' ? (int) $_POST['bateria_usada_pct'] : null,
            'piloto' => trim($_POST['piloto'] ?? '') ?: null,
            'notas' => trim($_POST['notas'] ?? '') ?: null,
        ]);
        $sucesso = true;
    } catch (Throwable $e) {
        $erro = 'Não foi possível guardar: ' . $e->getMessage();
    }
}

// --- Fase 2: verificação de compliance (seguro e AAN válidos) ---
$hoje = date('Y-m-d');
$documentos_criticos = ['seguro' => 'Seguro de responsabilidade civil', 'aan' => 'Autorização de Operador (AAN)'];
$avisos_compliance = [];
foreach ($documentos_criticos as $tipo => $rotulo) {
    $stmt = $pdo->prepare(
        "SELECT data_validade FROM documentos
         WHERE tipo = :tipo AND (data_validade IS NULL OR data_validade >= :hoje)
         ORDER BY data_validade IS NULL, data_validade DESC LIMIT 1"
    );
    $stmt->execute(['tipo' => $tipo, 'hoje' => $hoje]);
    $valido = $stmt->fetchColumn();
    if ($valido === false) {
        $avisos_compliance[] = "{$rotulo} — sem registo válido (em falta ou expirado).";
    }
}

$locais = $pdo->query('SELECT id, nome FROM locais ORDER BY nome ASC')->fetchAll();

$voos_recentes = $pdo->query(
    'SELECT v.id, v.data, v.duracao_min, v.condicoes_vento, l.nome AS local_nome
     FROM voos v JOIN locais l ON l.id = v.local_id
     ORDER BY v.data DESC, v.id DESC LIMIT 8'
)->fetchAll();

$titulo_pagina = 'Registar voo';
require __DIR__ . '/../includes/layout_topo.php';
?>

<?php if ($sucesso): ?>
    <div class="mensagem-sucesso">Voo registado.</div>
<?php endif; ?>
<?php if ($erro): ?>
    <div class="mensagem-sucesso" style="border-color:var(--erro); color:var(--erro);"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if ($avisos_compliance): ?>
    <div class="cartao" style="border-color:var(--erro);">
        <h2 style="color:var(--erro);">⚠ Compliance em falta</h2>
        <ul>
            <?php foreach ($avisos_compliance as $aviso): ?>
                <li class="texto-suave"><?= htmlspecialchars($aviso) ?></li>
            <?php endforeach; ?>
        </ul>
        <p class="texto-suave">Podes continuar a registar o voo, mas confirma isto em <a href="documentos.php">Documentos</a> antes de voar.</p>
    </div>
<?php endif; ?>

<div class="cartao">
    <h2>Novo voo</h2>
    <?php if (!$locais): ?>
        <p class="vazio">Ainda não há locais no catálogo — corre <code>php db/seed.php</code> primeiro, ou vê <a href="locais.php">locais</a>.</p>
    <?php else: ?>
    <form method="post">
        <label for="local_id">Local</label>
        <select name="local_id" id="local_id" required>
            <?php foreach ($locais as $l): ?>
                <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="data">Data</label>
        <input type="date" name="data" id="data" value="<?= date('Y-m-d') ?>" required>

        <label for="hora_inicio">Hora de início (opcional)</label>
        <input type="time" name="hora_inicio" id="hora_inicio">

        <label for="duracao_min">Duração (minutos)</label>
        <input type="number" name="duracao_min" id="duracao_min" min="0">

        <label for="condicoes_vento">Condições de vento</label>
        <input type="text" name="condicoes_vento" id="condicoes_vento" placeholder="ex: fraco, 10-15 km/h">

        <label for="bateria_usada_pct">Bateria usada (%)</label>
        <input type="number" name="bateria_usada_pct" id="bateria_usada_pct" min="0" max="100">

        <label for="piloto">Piloto</label>
        <input type="text" name="piloto" id="piloto">

        <label for="notas">Notas</label>
        <textarea name="notas" id="notas"></textarea>

        <button type="submit">Guardar voo</button>
    </form>
    <?php endif; ?>
</div>

<div class="cartao">
    <h2>Últimos voos</h2>
    <?php if (!$voos_recentes): ?>
        <p class="vazio">Ainda não há voos registados.</p>
    <?php else: ?>
        <table>
            <tr><th>Data</th><th>Local</th><th>Duração</th><th>Vento</th></tr>
            <?php foreach ($voos_recentes as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v['data']) ?></td>
                    <td><?= htmlspecialchars($v['local_nome']) ?></td>
                    <td class="texto-suave"><?= $v['duracao_min'] ? $v['duracao_min'] . ' min' : '—' ?></td>
                    <td class="texto-suave"><?= htmlspecialchars($v['condicoes_vento'] ?? '—') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
