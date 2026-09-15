<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

$num_locais = (int) $pdo->query('SELECT COUNT(*) FROM locais')->fetchColumn();
$num_voos = (int) $pdo->query('SELECT COUNT(*) FROM voos')->fetchColumn();
$num_publicacoes = (int) $pdo->query('SELECT COUNT(*) FROM publicacoes')->fetchColumn();
$num_por_filmar = (int) $pdo->query(
    'SELECT COUNT(*) FROM locais l WHERE NOT EXISTS (SELECT 1 FROM voos v WHERE v.local_id = l.id)'
)->fetchColumn();

$ultimos_voos = $pdo->query(
    'SELECT v.data, l.nome AS local_nome FROM voos v JOIN locais l ON l.id = v.local_id ORDER BY v.data DESC, v.id DESC LIMIT 5'
)->fetchAll();

$ultimas_publicacoes = $pdo->query(
    'SELECT p.data_publicacao, p.plataforma, l.nome AS local_nome
     FROM publicacoes p LEFT JOIN voos v ON v.id = p.voo_id LEFT JOIN locais l ON l.id = v.local_id
     ORDER BY p.data_publicacao DESC, p.id DESC LIMIT 5'
)->fetchAll();

$ultimas_duas = $pdo->query(
    'SELECT data_publicacao, formato_conteudo FROM publicacoes ORDER BY data_publicacao DESC, id DESC LIMIT 2'
)->fetchAll();
$aviso_consecutivo = null;
if (count($ultimas_duas) === 2
    && $ultimas_duas[0]['formato_conteudo']
    && $ultimas_duas[0]['formato_conteudo'] === $ultimas_duas[1]['formato_conteudo']) {
    $aviso_consecutivo = $ultimas_duas[0]['formato_conteudo'];
}

$titulo_pagina = 'Painel';
require __DIR__ . '/../includes/layout_topo.php';
?>

<?php if ($aviso_consecutivo): ?>
    <div class="mensagem-sucesso" style="border-color:var(--aviso); color:var(--aviso);">
        As duas últimas publicações repetem o formato "<?= htmlspecialchars($aviso_consecutivo) ?>". Vê o <a href="repeticao.php">alerta de repetição</a> antes do próximo vídeo.
    </div>
<?php endif; ?>

<div class="grelha-resumo">
    <div class="cartao resumo-numero">
        <span class="numero"><?= $num_locais ?></span>
        <span class="rotulo">Locais no catálogo</span>
    </div>
    <div class="cartao resumo-numero">
        <span class="numero"><?= $num_voos ?></span>
        <span class="rotulo">Voos registados</span>
    </div>
    <div class="cartao resumo-numero">
        <span class="numero"><?= $num_publicacoes ?></span>
        <span class="rotulo">Publicações registadas</span>
    </div>
    <div class="cartao resumo-numero">
        <span class="numero"><?= $num_por_filmar ?></span>
        <span class="rotulo">Locais por filmar</span>
    </div>
</div>

<div class="grelha-resumo">
    <div class="cartao">
        <h2>Últimos voos</h2>
        <?php if (!$ultimos_voos): ?>
            <p class="vazio">Ainda não há voos registados.</p>
        <?php else: ?>
            <ul class="lista-simples">
                <?php foreach ($ultimos_voos as $v): ?>
                    <li><span class="texto-suave"><?= htmlspecialchars($v['data']) ?></span> — <?= htmlspecialchars($v['local_nome']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a class="ligacao-modulo" href="registar_voo.php">Registar novo voo →</a>
    </div>
    <div class="cartao">
        <h2>Últimas publicações</h2>
        <?php if (!$ultimas_publicacoes): ?>
            <p class="vazio">Ainda não há publicações registadas.</p>
        <?php else: ?>
            <ul class="lista-simples">
                <?php foreach ($ultimas_publicacoes as $p): ?>
                    <li><span class="texto-suave"><?= htmlspecialchars($p['data_publicacao']) ?></span> — <?= htmlspecialchars($p['local_nome'] ?? '—') ?> (<?= htmlspecialchars($p['plataforma']) ?>)</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a class="ligacao-modulo" href="registar_publicacao.php">Registar nova publicação →</a>
    </div>
</div>

<div class="grelha-resumo">
    <a class="cartao ligacao-cartao" href="locais.php">
        <h2>Locais</h2>
        <p class="texto-suave">Catálogo completo, com estado de "por filmar".</p>
    </a>
    <a class="cartao ligacao-cartao" href="recomendacao.php">
        <h2>Próximo destino</h2>
        <p class="texto-suave">Sugestão de top 3 locais consoante a disponibilidade.</p>
    </a>
    <a class="cartao ligacao-cartao" href="repeticao.php">
        <h2>Alerta de repetição</h2>
        <p class="texto-suave">Vê há quanto tempo não repetem cada ângulo, por local.</p>
    </a>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
