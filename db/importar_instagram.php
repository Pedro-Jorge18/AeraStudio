<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

// --- 1. Locais novos, encontrados no Instagram mas ainda não no catálogo ---
$locais_novos = [
    ['nome' => 'Couce, Valongo', 'tipo' => 'vila_historica', 'distrito' => 'Porto', 'concelho' => 'Valongo', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 30, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Aldeia de pedra entre duas serras, ponte romana quase intacta com quase 2000 anos. Perto do Parque das Serras do Porto.'],
    ['nome' => 'Jardim de João Chagas, Porto', 'tipo' => 'urbano', 'distrito' => 'Porto', 'concelho' => 'Porto', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 15, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Jardim pequeno, escondido, dentro da cidade do Porto.'],
];

$verificar_local = $pdo->prepare('SELECT id FROM locais WHERE nome = :nome');
$inserir_local = $pdo->prepare(
    'INSERT INTO locais (nome, tipo, distrito, concelho, dentro_distrito_porto, tempo_viagem_min, custo_estimado, requer_autorizacao_privada, notas)
     VALUES (:nome, :tipo, :distrito, :concelho, :dentro_distrito_porto, :tempo_viagem_min, :custo_estimado, :requer_autorizacao_privada, :notas)'
);

$locais_id = [];
foreach ($locais_novos as $l) {
    $verificar_local->execute(['nome' => $l['nome']]);
    $id = $verificar_local->fetchColumn();
    if (!$id) {
        $inserir_local->execute($l);
        $id = $pdo->lastInsertId();
        echo "Local novo criado: {$l['nome']}\n";
    }
    $locais_id[$l['nome']] = (int) $id;
}

// IDs dos locais que já existiam no seed original
$buscar_id = function (string $nome) use ($pdo): ?int {
    $stmt = $pdo->prepare('SELECT id FROM locais WHERE nome = :nome');
    $stmt->execute(['nome' => $nome]);
    $id = $stmt->fetchColumn();
    return $id ? (int) $id : null;
};
$locais_id['Poço Negro, Rio Mau'] = $buscar_id('Poço Negro, Rio Mau');
$locais_id['Parque das Serras do Porto'] = $buscar_id('Parque das Serras do Porto');
$locais_id['Peso da Régua'] = $buscar_id('Peso da Régua');
$locais_id['Ponte de Lima'] = $buscar_id('Ponte de Lima');

// --- 2. Voos: um por publicação com local identificável, data = data de publicação (aproximação, ajusta se souberes a data real do voo) ---
$voos_a_criar = [
    ['local' => 'Poço Negro, Rio Mau', 'data' => '2026-09-05', 'notas' => 'Data aproximada, inferida da publicação no Instagram.'],
    ['local' => 'Parque das Serras do Porto', 'data' => '2026-08-23', 'notas' => 'Data aproximada, inferida da publicação no Instagram (conta pessoal do Pedro).'],
    ['local' => 'Peso da Régua', 'data' => '2026-08-23', 'notas' => 'Assumido "Peso da Régua" pela legenda mencionar vinhas em socalcos sobre o Douro — confirma se era antes Pinhão.'],
    ['local' => 'Couce, Valongo', 'data' => '2026-08-21', 'notas' => 'Data aproximada, inferida da publicação no Instagram. Avós em cena no vídeo.'],
    ['local' => 'Ponte de Lima', 'data' => '2026-08-11', 'notas' => 'Data aproximada, inferida da publicação no Instagram.'],
    ['local' => 'Jardim de João Chagas, Porto', 'data' => '2026-08-03', 'notas' => 'Data aproximada, inferida da publicação no Instagram.'],
];

$verificar_voo = $pdo->prepare('SELECT id FROM voos WHERE local_id = :local_id AND data = :data');
$inserir_voo = $pdo->prepare('INSERT INTO voos (local_id, data, notas) VALUES (:local_id, :data, :notas)');

$voo_id_por_local_data = [];
foreach ($voos_a_criar as $v) {
    $local_id = $locais_id[$v['local']] ?? null;
    if (!$local_id) {
        echo "AVISO: local '{$v['local']}' não encontrado, voo não criado.\n";
        continue;
    }
    $verificar_voo->execute(['local_id' => $local_id, 'data' => $v['data']]);
    $id = $verificar_voo->fetchColumn();
    if (!$id) {
        $inserir_voo->execute(['local_id' => $local_id, 'data' => $v['data'], 'notas' => $v['notas']]);
        $id = $pdo->lastInsertId();
        echo "Voo novo criado: {$v['local']} em {$v['data']}\n";
    }
    $voo_id_por_local_data[$v['local']] = (int) $id;
}

// --- 3. Publicações: as 11 do Instagram ---
$publicacoes = [
    [
        'voo_local' => 'Poço Negro, Rio Mau',
        'data_publicacao' => '2026-09-05',
        'legenda' => "Hidden in Rio Mau, carved by water for centuries. Poço Negro. \u{1F5A4}",
        'hashtags' => ['#nature', '#mountains', '#djiportugal', '#porto', '#hiddengems'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 17,
        'comentarios' => 0,
    ],
    [
        'voo_local' => null,
        'data_publicacao' => '2026-09-05',
        'legenda' => "There's a world out there that we should see \u{1F3DE}\u{FE0F}\u{2728}",
        'hashtags' => [],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 21,
        'comentarios' => 0,
    ],
    [
        'voo_local' => null,
        'data_publicacao' => '2026-09-08',
        'legenda' => "Some views you climb for. Some you fly. I did both",
        'hashtags' => ['#nature', '#treeking', '#mountains', '#droneview', '#porto'],
        'formato' => 'pessoa_em_cena',
        'gostos_7d' => 9,
        'comentarios' => 0,
    ],
    [
        'voo_local' => 'Parque das Serras do Porto',
        'data_publicacao' => '2026-08-23',
        'legenda' => 'Serras do porto never disappoint.',
        'hashtags' => ['#parquedasserrasdoporto', '#porto', '#nature', '#moutain'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 12,
        'comentarios' => 0,
    ],
    [
        'voo_local' => 'Peso da Régua',
        'data_publicacao' => '2026-08-23',
        'legenda' => "Sunset over the Douro. The light does most of the work here you just have to be in the air when it happens. Terrace vineyards, a river that's carved this valley for centuries, and a few golden minutes that make every dead battery worth it.",
        'hashtags' => ['#dronevideography', '#portugal', '#porto', '#riodouro'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 12,
        'comentarios' => 0,
    ],
    [
        'voo_local' => 'Couce, Valongo',
        'data_publicacao' => '2026-08-21',
        'legenda' => "Flew the drone over Couce, a tiny stone village tucked between two mountains in Valongo with a nearly intact Roman bridge that makes parts of it almost 2,000 years old. And somehow my grandparents still ended up stealing the shot. They talked to the drone like it was just another neighbor passing by. Some things you can't plan for, only fly into.",
        'hashtags' => ['#couce', '#portugal', '#dronevideography', '#parquedasserrasdoporto', '#djilitox1'],
        'formato' => 'pessoa_em_cena',
        'gostos_7d' => 8,
        'comentarios' => 0,
    ],
    [
        'voo_local' => 'Ponte de Lima',
        'data_publicacao' => '2026-08-11',
        'legenda' => 'Spent last weekend in the Minho region, drone catching the bridge and the Rio Lima down below. There\'s always another spot worth exploring outside Porto',
        'hashtags' => ['#PonteDeLima', '#VisitPortugal', '#DroneVideography', '#NorthernPortugal', '#AerialView'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 10,
        'comentarios' => 0,
    ],
    [
        'voo_local' => 'Jardim de João Chagas, Porto',
        'data_publicacao' => '2026-08-03',
        'legenda' => 'Weekend plan: fly the drone, find something new. This time it was Jardim de João Chagas, a little garden hiding in plain sight in Porto.',
        'hashtags' => ['#VisitPorto', '#HiddenPorto', '#DroneVideography', '#AerialView', '#PortoTravel'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 10,
        'comentarios' => 0,
    ],
    [
        'voo_local' => null,
        'data_publicacao' => '2026-07-31',
        'legenda' => 'Unboxing time. Freewell ND filters going up in the air soon.',
        'hashtags' => ['#Freewell', '#NDFilters', '#DroneVideographer'],
        'formato' => null,
        'gostos_7d' => 10,
        'comentarios' => 1,
    ],
    [
        'voo_local' => null,
        'data_publicacao' => '2026-07-22',
        'legenda' => 'Gardens designed to be seen from every angle, even this one.',
        'hashtags' => ['#dronevideography', '#aerialview', '#gardens', '#portugal'],
        'formato' => 'reveal_paisagem',
        'gostos_7d' => 41,
        'comentarios' => 2,
    ],
    [
        'voo_local' => null,
        'data_publicacao' => '2026-07-20',
        'legenda' => "Every great journey starts with a first flight. We're AERA Studio, a couple, a drone, and the desire to show the world from a perspective most people never see. Based in Porto, Portugal but the sky has no borders. Thank you for being part of this journey with us from day one.",
        'hashtags' => ['#dronevideography', '#aerialcinematography', '#newbeginnings', '#dronevideographer', '#djiportugal'],
        'formato' => null,
        'gostos_7d' => 18,
        'comentarios' => 1,
    ],
];

$verificar_publicacao = $pdo->prepare(
    'SELECT id FROM publicacoes WHERE data_publicacao = :data AND legenda_usada = :legenda'
);
$inserir_publicacao = $pdo->prepare(
    'INSERT INTO publicacoes (voo_id, plataforma, data_publicacao, legenda_usada, idioma_legenda, hashtags, formato_conteudo, angulo_camara, gostos_7d, comentarios)
     VALUES (:voo_id, :plataforma, :data_publicacao, :legenda, :idioma, :hashtags, :formato, NULL, :gostos_7d, :comentarios)'
);

$criadas = 0;
foreach ($publicacoes as $p) {
    $verificar_publicacao->execute(['data' => $p['data_publicacao'], 'legenda' => $p['legenda']]);
    if ($verificar_publicacao->fetchColumn()) {
        continue;
    }
    $voo_id = $p['voo_local'] ? ($voo_id_por_local_data[$p['voo_local']] ?? null) : null;
    $inserir_publicacao->execute([
        'voo_id' => $voo_id,
        'plataforma' => 'instagram',
        'data_publicacao' => $p['data_publicacao'],
        'legenda' => $p['legenda'],
        'idioma' => 'EN',
        'hashtags' => para_json($p['hashtags']),
        'formato' => $p['formato'],
        'gostos_7d' => $p['gostos_7d'],
        'comentarios' => $p['comentarios'],
    ]);
    $criadas++;
}

echo "\nPublicações novas criadas: {$criadas} (de " . count($publicacoes) . " no total).\n";
echo "Nota: ângulo de câmara ficou por preencher em todas — não dá para saber pela legenda, só vendo o vídeo. Preenche à mão em cada uma se quiseres.\n";
echo "Nota: 4 publicações ficaram sem voo associado (local não identificável pela legenda, ou não é um voo) — associa-as manualmente se souberes o local certo.\n";
