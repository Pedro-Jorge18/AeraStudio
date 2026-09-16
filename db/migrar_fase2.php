<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';

// Migração Fase 2 — cria a tabela "documentos" (seguro, AAN, licença de piloto, etc.)
// numa base de dados já existente. Idempotente: seguro correr mais do que uma vez.

$pdo = db();

$pdo->exec(
    "CREATE TABLE IF NOT EXISTS documentos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        tipo TEXT NOT NULL,
        nome TEXT NOT NULL,
        entidade_emissora TEXT,
        numero_referencia TEXT,
        data_emissao TEXT,
        data_validade TEXT,
        local_id INTEGER REFERENCES locais(id),
        notas TEXT,
        criado_em TEXT NOT NULL DEFAULT (datetime('now'))
    )"
);
$pdo->exec("CREATE INDEX IF NOT EXISTS idx_documentos_tipo ON documentos(tipo)");
$pdo->exec("CREATE INDEX IF NOT EXISTS idx_documentos_local ON documentos(local_id)");

echo "Migração Fase 2 aplicada: tabela 'documentos' criada (ou já existia).\n";

$total = (int) $pdo->query('SELECT COUNT(*) FROM documentos')->fetchColumn();
echo "Documentos atualmente registados: {$total}.\n";

if ($total === 0) {
    echo "\nAinda sem nenhum documento. Vai a documentos.php e regista, por exemplo:\n";
    echo "  - Seguro de responsabilidade civil (drone)\n";
    echo "  - Autorização de Operador (AAN / ANAC)\n";
    echo "  - Licença de piloto remoto\n";
}
