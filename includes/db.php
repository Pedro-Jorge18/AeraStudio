<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $caminho_bd = __DIR__ . '/../db/aera_studio.sqlite';
    $ja_existia = file_exists($caminho_bd);

    $pdo = new PDO('sqlite:' . $caminho_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    if (!$ja_existia) {
        $schema = file_get_contents(__DIR__ . '/../db/schema.sql');
        $pdo->exec($schema);
    }

    return $pdo;
}

/** Converte um array de strings num JSON compacto, ou null se ficar vazio. */
function para_json(array $valores): ?string
{
    $valores = array_values(array_filter($valores, fn($v) => trim((string) $v) !== ''));
    return $valores ? json_encode($valores, JSON_UNESCAPED_UNICODE) : null;
}

/** Divide texto multi-linha em array de strings não vazias, sem espaços à volta. */
function linhas_para_array(string $texto): array
{
    $linhas = preg_split('/\r\n|\r|\n/', $texto) ?: [];
    $linhas = array_map('trim', $linhas);
    return array_values(array_filter($linhas, fn($l) => $l !== ''));
}

/** Inverso de para_json — devolve sempre um array (vazio se não houver nada). */
function de_json(?string $json): array
{
    if (!$json) {
        return [];
    }
    $valores = json_decode($json, true);
    return is_array($valores) ? $valores : [];
}
