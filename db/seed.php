<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

$pdo = db();

$locais = [
    ['nome' => 'Amarante', 'tipo' => 'vila_historica', 'distrito' => 'Porto', 'concelho' => 'Amarante', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 45, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Ponte de São Gonçalo e o rio Tâmega — bom para reveals ao entardecer.'],
    ['nome' => 'Serra de Santa Justa', 'tipo' => 'serra', 'distrito' => 'Porto', 'concelho' => 'Valongo', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 30, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Rochedo e miradouro, bom para planos baixos/órbita.'],
    ['nome' => 'Parque das Serras do Porto', 'tipo' => 'parque', 'distrito' => 'Porto', 'concelho' => 'Santo Tirso', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 40, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Época da urze (heather) em ago/set — muito fotogénico.'],
    ['nome' => 'Poço Negro, Rio Mau', 'tipo' => 'vale_rio', 'distrito' => 'Porto', 'concelho' => 'Vila do Conde', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 35, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Poço natural escavado na rocha — bom contraste de água escura.'],
    ['nome' => 'Costa Nova, Ílhavo', 'tipo' => 'outro', 'distrito' => 'Aveiro', 'concelho' => 'Ílhavo', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 75, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Casinhas às riscas — icónico, mas cuidado com o vento costeiro.'],
    ['nome' => 'Aveiro (Ria)', 'tipo' => 'urbano', 'distrito' => 'Aveiro', 'concelho' => 'Aveiro', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 70, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Canais e moliceiros — bom para planos aéreos amplos.'],
    ['nome' => 'Guimarães', 'tipo' => 'vila_historica', 'distrito' => 'Braga', 'concelho' => 'Guimarães', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 50, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Centro histórico e castelo — confirmar restrições de voo no centro.'],
    ['nome' => 'Peso da Régua', 'tipo' => 'vale_rio', 'distrito' => 'Vila Real', 'concelho' => 'Peso da Régua', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 90, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Vinhas em socalcos sobre o Douro — melhor luz ao final da tarde.'],
    ['nome' => 'Pinhão', 'tipo' => 'vale_rio', 'distrito' => 'Vila Real', 'concelho' => 'Alijó', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 100, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Curvas do Douro, muito procurado mas ainda pouco filmado por nós.'],
    ['nome' => 'Gerês', 'tipo' => 'serra', 'distrito' => 'Braga', 'concelho' => 'Terras de Bouro', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 90, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Parque Nacional — confirmar zonas com restrição de voo antes de ir.'],
    ['nome' => 'Quinta da Aveleda', 'tipo' => 'quinta', 'distrito' => 'Porto', 'concelho' => 'Penafiel', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 35, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 1, 'notas' => 'Precisa de autorização da propriedade antes de agendar.'],
    ['nome' => 'Foz do Douro', 'tipo' => 'urbano', 'distrito' => 'Porto', 'concelho' => 'Porto', 'dentro_distrito_porto' => 1, 'tempo_viagem_min' => 15, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Foz do rio Douro e farol — bom para pôr do sol, perto de casa.'],
    ['nome' => 'Ponte de Lima', 'tipo' => 'vila_historica', 'distrito' => 'Viana do Castelo', 'concelho' => 'Ponte de Lima', 'dentro_distrito_porto' => 0, 'tempo_viagem_min' => 70, 'custo_estimado' => '0', 'requer_autorizacao_privada' => 0, 'notas' => 'Ponte romana e rio Lima — ainda por filmar.'],
];

$verificar = $pdo->prepare('SELECT COUNT(*) FROM locais WHERE nome = :nome');
$inserir = $pdo->prepare(
    'INSERT INTO locais (nome, tipo, distrito, concelho, dentro_distrito_porto, tempo_viagem_min, custo_estimado, requer_autorizacao_privada, notas)
     VALUES (:nome, :tipo, :distrito, :concelho, :dentro_distrito_porto, :tempo_viagem_min, :custo_estimado, :requer_autorizacao_privada, :notas)'
);

$inseridos = 0;
foreach ($locais as $l) {
    $verificar->execute(['nome' => $l['nome']]);
    if ((int) $verificar->fetchColumn() > 0) {
        continue;
    }
    $inserir->execute($l);
    $inseridos++;
}

echo "Locais inseridos: {$inseridos} (de " . count($locais) . " no total).\n";
