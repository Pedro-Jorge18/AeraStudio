<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

$rotulos_angulo = [
    'nadir' => 'Nadir', 'baixo_orbita' => 'Baixo/órbita', 'reveal_descendente' => 'Reveal descendente',
    'travelling_lateral' => 'Travelling lateral', 'outro' => 'Outro',
];
$rotulos_formato = [
    'reveal_paisagem' => 'Reveal paisagem', 'dica_pilotagem' => 'Dica de pilotagem',
    'dica_edicao' => 'Dica de edição', 'blooper_bts' => 'Blooper/BTS', 'pessoa_em_cena' => 'Pessoa em cena',
];

// Agrupa por local + ângulo de câmara: quando foi a última vez que usaram este ângulo neste local.
$combinacoes = $pdo->query(
    "SELECT l.nome AS local_nome, p.angulo_camara, MAX(p.data_publicacao) AS ultima_data, COUNT(*) AS vezes
     FROM publicacoes p
     JOIN voos v ON v.id = p.voo_id
     JOIN locais l ON l.id = v.local_id
     WHERE p.angulo_camara IS NOT NULL
     GROUP BY l.id, p.angulo_camara
     ORDER BY ultima_data ASC"
)->fetchAll();

function meses_desde(string $data): int
{
    $entao = new DateTime($data);
    $agora = new DateTime();
    $diff = $agora->diff($entao);
    return $diff->y * 12 + $diff->m;
}

// Últimas duas publicações (por ordem cronológica) — para o aviso de "formato repetido consecutivo".
$ultimas_duas = $pdo->query(
    'SELECT data_publicacao, formato_conteudo FROM publicacoes ORDER BY data_publicacao DESC, id DESC LIMIT 2'
)->fetchAll();

$aviso_consecutivo = null;
if (count($ultimas_duas) === 2
    && $ultimas_duas[0]['formato_conteudo']
    && $ultimas_duas[0]['formato_conteudo'] === $ultimas_duas[1]['formato_conteudo']) {
    $aviso_consecutivo = $rotulos_formato[$ultimas_duas[0]['formato_conteudo']] ?? $ultimas_duas[0]['formato_conteudo'];
}

$titulo_pagina = 'Alerta de repetição';
require __DIR__ . '/../includes/layout_topo.php';
?>

<?php if ($aviso_consecutivo): ?>
    <div class="mensagem-sucesso" style="border-color:var(--aviso); color:var(--aviso);">
        Atenção: as duas últimas publicações são ambas do formato "<?= htmlspecialchars($aviso_consecutivo) ?>". Considera variar no próximo vídeo.
    </div>
<?php endif; ?>

<div class="cartao">
    <h2>Há quanto tempo não repetem cada ângulo, por local</h2>
    <?php if (!$combinacoes): ?>
        <p class="vazio">Ainda não há publicações associadas a voos com ângulo de câmara definido.</p>
    <?php else: ?>
        <table>
            <tr><th>Local</th><th>Ângulo</th><th>Última vez</th><th>Há quanto tempo</th><th>Vezes usado</th></tr>
            <?php foreach ($combinacoes as $c): $m = meses_desde($c['ultima_data']); ?>
                <tr>
                    <td><?= htmlspecialchars($c['local_nome']) ?></td>
                    <td><?= htmlspecialchars($rotulos_angulo[$c['angulo_camara']] ?? $c['angulo_camara']) ?></td>
                    <td class="texto-suave"><?= htmlspecialchars($c['ultima_data']) ?></td>
                    <td>
                        <?php if ($m === 0): ?>
                            <span class="pilula aviso">este mês</span>
                        <?php else: ?>
                            <?= $m ?> mês<?= $m > 1 ? 'es' : '' ?>
                        <?php endif; ?>
                    </td>
                    <td class="texto-suave"><?= $c['vezes'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
