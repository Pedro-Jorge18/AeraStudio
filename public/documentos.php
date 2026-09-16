<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();
$sucesso = false;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO documentos (tipo, nome, entidade_emissora, numero_referencia, data_emissao, data_validade, local_id, notas)
             VALUES (:tipo, :nome, :entidade, :numero, :data_emissao, :data_validade, :local_id, :notas)'
        );
        $stmt->execute([
            'tipo' => $_POST['tipo'],
            'nome' => trim($_POST['nome']),
            'entidade' => trim($_POST['entidade_emissora'] ?? '') ?: null,
            'numero' => trim($_POST['numero_referencia'] ?? '') ?: null,
            'data_emissao' => $_POST['data_emissao'] ?: null,
            'data_validade' => $_POST['data_validade'] ?: null,
            'local_id' => $_POST['local_id'] !== '' ? (int) $_POST['local_id'] : null,
            'notas' => trim($_POST['notas'] ?? '') ?: null,
        ]);
        $sucesso = true;
    } catch (Throwable $e) {
        $erro = 'Não foi possível guardar: ' . $e->getMessage();
    }
}

$tipos_rotulos = [
    'seguro' => 'Seguro de responsabilidade civil',
    'aan' => 'Autorização de Operador (AAN)',
    'licenca_piloto' => 'Licença de piloto remoto',
    'outro' => 'Outro',
];

$locais = $pdo->query('SELECT id, nome FROM locais ORDER BY nome ASC')->fetchAll();

$documentos = $pdo->query(
    "SELECT d.*, l.nome AS local_nome
     FROM documentos d
     LEFT JOIN locais l ON l.id = d.local_id
     ORDER BY (d.data_validade IS NULL), d.data_validade ASC, d.id DESC"
)->fetchAll();

$hoje = date('Y-m-d');
$limite_a_expirar = date('Y-m-d', strtotime('+30 days'));

function estado_documento(?string $data_validade, string $hoje, string $limite_a_expirar): array {
    if ($data_validade === null) {
        return ['sem_validade', 'Sem prazo'];
    }
    if ($data_validade < $hoje) {
        return ['expirado', 'Expirado'];
    }
    if ($data_validade <= $limite_a_expirar) {
        return ['a_expirar', 'A expirar'];
    }
    return ['valido', 'Válido'];
}

$titulo_pagina = 'Documentos';
require __DIR__ . '/../includes/layout_topo.php';
?>

<?php if ($sucesso): ?>
    <div class="mensagem-sucesso">Documento registado.</div>
<?php endif; ?>
<?php if ($erro): ?>
    <div class="mensagem-sucesso" style="border-color:var(--erro); color:var(--erro);"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="cartao">
    <h2>Novo documento</h2>
    <form method="post">
        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo" required>
            <?php foreach ($tipos_rotulos as $valor => $rotulo): ?>
                <option value="<?= htmlspecialchars($valor) ?>"><?= htmlspecialchars($rotulo) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="nome">Nome / descrição</label>
        <input type="text" name="nome" id="nome" placeholder="ex: Apólice Coverdrone 2026" required>

        <label for="entidade_emissora">Entidade emissora</label>
        <input type="text" name="entidade_emissora" id="entidade_emissora" placeholder="ex: Coverdrone, ANAC">

        <label for="numero_referencia">Número / referência</label>
        <input type="text" name="numero_referencia" id="numero_referencia">

        <label for="data_emissao">Data de emissão</label>
        <input type="date" name="data_emissao" id="data_emissao">

        <label for="data_validade">Válido até (deixa vazio se não expira)</label>
        <input type="date" name="data_validade" id="data_validade">

        <label for="local_id">Local (só se for uma autorização específica de um local)</label>
        <select name="local_id" id="local_id">
            <option value="">— Aplica-se a tudo (seguro, licença, etc.) —</option>
            <?php foreach ($locais as $l): ?>
                <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="notas">Notas</label>
        <textarea name="notas" id="notas"></textarea>

        <button type="submit">Guardar documento</button>
    </form>
</div>

<div class="cartao">
    <h2>Documentos registados</h2>
    <?php if (!$documentos): ?>
        <p class="vazio">Ainda não há documentos registados. Começa pelo seguro e pela AAN — são os que bloqueiam voos.</p>
    <?php else: ?>
        <table>
            <tr><th>Tipo</th><th>Nome</th><th>Local</th><th>Válido até</th><th>Estado</th></tr>
            <?php foreach ($documentos as $d): ?>
                <?php [$estado_classe, $estado_rotulo] = estado_documento($d['data_validade'], $hoje, $limite_a_expirar); ?>
                <tr>
                    <td class="texto-suave"><?= htmlspecialchars($tipos_rotulos[$d['tipo']] ?? $d['tipo']) ?></td>
                    <td><?= htmlspecialchars($d['nome']) ?></td>
                    <td class="texto-suave"><?= htmlspecialchars($d['local_nome'] ?? '— tudo —') ?></td>
                    <td class="texto-suave"><?= htmlspecialchars($d['data_validade'] ?? '— sem prazo —') ?></td>
                    <td>
                        <span class="etiqueta-estado etiqueta-<?= $estado_classe ?>"><?= htmlspecialchars($estado_rotulo) ?></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
