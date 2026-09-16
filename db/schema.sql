CREATE TABLE IF NOT EXISTS locais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    tipo TEXT NOT NULL DEFAULT 'outro',
    distrito TEXT,
    concelho TEXT,
    dentro_distrito_porto INTEGER NOT NULL DEFAULT 0,
    tempo_viagem_min INTEGER,
    custo_estimado TEXT,
    requer_autorizacao_privada INTEGER NOT NULL DEFAULT 0,
    notas TEXT,
    criado_em TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS voos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    local_id INTEGER NOT NULL REFERENCES locais(id),
    data TEXT NOT NULL,
    hora_inicio TEXT,
    duracao_min INTEGER,
    condicoes_vento TEXT,
    bateria_usada_pct INTEGER,
    piloto TEXT,
    notas TEXT,
    criado_em TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS publicacoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    voo_id INTEGER REFERENCES voos(id),
    plataforma TEXT NOT NULL,
    data_publicacao TEXT NOT NULL,
    legenda_usada TEXT,
    idioma_legenda TEXT,
    hashtags TEXT,
    formato_conteudo TEXT,
    angulo_camara TEXT,
    gostos_24h INTEGER,
    gostos_7d INTEGER,
    comentarios INTEGER,
    criado_em TEXT NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE IF NOT EXISTS documentos (
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
);

CREATE INDEX IF NOT EXISTS idx_voos_local ON voos(local_id);
CREATE INDEX IF NOT EXISTS idx_publicacoes_voo ON publicacoes(voo_id);
CREATE INDEX IF NOT EXISTS idx_documentos_tipo ON documentos(tipo);
CREATE INDEX IF NOT EXISTS idx_documentos_local ON documentos(local_id);
