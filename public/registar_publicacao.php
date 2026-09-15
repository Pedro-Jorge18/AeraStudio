<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();
$sucesso = false;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO publicacoes (voo_id, plataforma, data_publicacao, legenda_usada, idioma_legenda, hashtags, formato_conteudo, angulo_camara, gostos_24h, gostos_7d, comentarios)
             VALUES (:voo_id, :plataforma, :data_publicacao, :legenda, :idioma, :hashtags, :formato, :angulo, :g24, :g7, :comentarios)'
        );
        $stmt->execute([
            'voo_id' => $_POST['voo_id'] !== '' ? (int) $_POST['voo_id'] : null,
            'plataforma' => $_POST['plataforma'],
            'data_publicacao' => $_POST['data_publicacao'],
            'legenda' => trim($_POST['legenda_usada'] ?? ''),
            'idioma' => $_POST['idioma_legenda'] ?: null,
            'hashtags' => para_json(linhas_para_array(str_replace(',', "\n", $_POST['hashtags'] ?? ''))),
            'formato' => $_POST['formato_conteudo'] ?: null,
            'angulo' => $_POST['angulo_camara'] ?: null,
            'g24' => $_POST['gostos_24h'] !== '' ? (int) $_POST['gostos_24h'] : null,
            'g7' => $_POST['gostos_7d'] !== '' ? (int) $_POST['gostos_7d'] : null,
            'comentarios' => $_POST['comentarios'] !== '' ? (int) $_POST['comentarios'] : null,
        ]);
        $sucesso = true;
    } catch (Throwable $e) {
        $erro = 'Não foi possível guardar: ' . $e->getMessage();
    }
}

$voos = $pdo->query(
    'SELECT v.id, v.data, l.nome AS local_nome
     FROM voos v JOIN locais l ON l.id = v.local_id
     ORDER BY v.data DESC, v.id DESC'
)->fetchAll();

$publicacoes_recentes = $pdo->query(
    'SELECT p.id, p.data_publicacao, p.plataforma, p.formato_conteudo, p.angulo_camara, l.nome AS local_nome
     FROM publicacoes p
     LEFT JOIN voos v ON v.id = p.voo_id
     LEFT JOIN locais l ON l.id = v.local_id
     ORDER BY p.data_publicacao DESC, p.id DESC LIMIT 8'
)->fetchAll();

$titulo_pagina = 'Registar publicação';
require __DIR__ . '/../includes/layout_topo.php';
?>

<?php if ($sucesso): ?>
    <div class="mensagem-sucesso">Publicação registada.</div>
<?php endif; ?>
<?php if ($erro): ?>
    <div class="mensagem-sucesso" style="border-color:var(--erro); color:var(--erro);"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="cartao">
    <h2>Novo vídeo publicado</h2>
    <form method="post">
        <label for="voo_id">Voo associado (opcional — deixa vazio se for material de arquivo)</label>
        <select name="voo_id" id="voo_id">
            <option value="">— sem voo associado —</option>
            <?php foreach ($voos as $v): ?>
                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['data'] . ' — ' . $v['local_nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="plataforma">Plataforma</label>
        <select name="plataforma" id="plataforma" required>
            <option value="instagram">Instagram</option>
            <option value="tiktok">TikTok</option>
            <option value="ambos">Ambos</option>
        </select>

        <label for="data_publicacao">Data de publicação</label>
        <input type="date" name="data_publicacao" id="data_publicacao" value="<?= date('Y-m-d') ?>" required>

        <label for="formato_conteudo">Formato de conteúdo</label>
        <select name="formato_conteudo" id="formato_conteudo">
            <option value="">—</option>
            <option value="reveal_paisagem">Reveal paisagem</option>
            <option value="dica_pilotagem">Dica de pilotagem</option>
            <option value="dica_edicao">Dica de edição</option>
            <option value="blooper_bts">Blooper / BTS</option>
            <option value="pessoa_em_cena">Pessoa em cena</option>
        </select>

        <label for="angulo_camara">Ângulo de câmara</label>
        <select name="angulo_camara" id="angulo_camara">
            <option value="">—</option>
            <option value="nadir">Nadir</option>
            <option value="baixo_orbita">Baixo / órbita</option>
            <option value="reveal_descendente">Reveal descendente</option>
            <option value="travelling_lateral">Travelling lateral</option>
            <option value="outro">Outro</option>
        </select>

        <label for="legenda_usada">Legenda usada</label>
        <textarea name="legenda_usada" id="legenda_usada"></textarea>

        <label for="idioma_legenda">Idioma da legenda</label>
        <select name="idioma_legenda" id="idioma_legenda">
            <option value="">—</option>
            <option value="PT">PT</option>
            <option value="EN">EN</option>
        </select>

        <label for="hashtags">Hashtags (separadas por vírgula)</label>
        <input type="text" name="hashtags" id="hashtags" placeholder="#drone, #portugal, #amarante">

        <fieldset>
            <legend>Métricas (opcional)</legend>
            <label for="gostos_24h">Gostos em 24h</label>
            <input type="number" name="gostos_24h" id="gostos_24h" min="0">
            <label for="gostos_7d">Gostos em 7 dias</label>
            <input type="number" name="gostos_7d" id="gostos_7d" min="0">
            <label for="comentarios">Comentários</label>
            <input type="number" name="comentarios" id="comentarios" min="0">
        </fieldset>

        <button type="submit">Guardar publicação</button>
    </form>
</div>

<div class="cartao">
    <h2>Últimas publicações</h2>
    <?php if (!$publicacoes_recentes): ?>
        <p class="vazio">Ainda não há publicações registadas.</p>
    <?php else: ?>
        <table>
            <tr><th>Data</th><th>Plataforma</th><th>Local</th><th>Formato</th><th>Ângulo</th></tr>
            <?php foreach ($publicacoes_recentes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['data_publicacao']) ?></td>
                    <td><?= htmlspecialchars($p['plataforma']) ?></td>
                    <td><?= htmlspecialchars($p['local_nome'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($p['formato_conteudo'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($p['angulo_camara'] ?? '—') ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
