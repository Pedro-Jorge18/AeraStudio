# AERA Studio Ops — Fase 1

Registo de voos & publicações, recomendação de próximo destino, e alerta de repetição de conteúdo. PHP puro + SQLite, sem framework, sem servidor externo.

## Como correr

Precisas só de PHP (8.1+) com a extensão `pdo_sqlite`, que vem ativada por omissão na maioria das instalações.

```bash
cd aera_studio
php -S localhost:8000 -t public
```

Depois abre `http://localhost:8000` no browser.

Na primeira vez que qualquer página for aberta, a base de dados `db/aera_studio.sqlite` é criada automaticamente a partir de `db/schema.sql` (não precisas de fazer nada manualmente).

## Popular locais (opcional)

O ficheiro `db/seed.php` deixa locais pré-carregados (os do perfil de viagens: Amarante, Serra de Santa Justa, Parque das Serras do Porto, Poço Negro em Rio Mau, Costa Nova, Guimarães, Régua, Pinhão, etc.). Para correr:

```bash
php db/seed.php
```

É seguro correr mais do que uma vez — só insere o que ainda não existe (por nome).

## Estrutura

```
aera_studio/
├── db/
│   ├── schema.sql       # definição das tabelas (locais, voos, publicacoes)
│   ├── seed.php         # popula locais iniciais
│   └── aera_studio.sqlite  # criado automaticamente na 1ª execução
├── includes/
│   ├── db.php           # ligação PDO + helpers de JSON
│   ├── layout_topo.php  # cabeçalho/nav comum
│   └── layout_fim.php   # fecho do HTML
└── public/               # documento root do servidor PHP
    ├── index.php               # painel — resumo + navegação
    ├── registar_voo.php        # Módulo 1a
    ├── registar_publicacao.php # Módulo 1b
    ├── locais.php               # catálogo de locais
    ├── recomendacao.php        # Módulo 2 — próximo destino
    ├── repeticao.php           # Módulo 3 — alerta de repetição
    └── estilo.css
```

## O que falta (por fases, conforme a spec)

- **Fase 2**: tabelas `Documentos` e `Consentimentos` + Módulo 5 (compliance — seguro/AAN a expirar, alerta ao agendar voo sem cobertura).
- **Fase 3**: tabela `Contactos` + Módulo 6 (pipeline outreach/inbound).
- **Fase 4**: Módulo 4 automatizado com API de meteo (Windy/Open-Meteo) — por agora não existe checklist pré-voo nenhum na app; usa o registo de `condicoes_vento` no formulário de voo como está, e confirma o mapa ANAC/AAN manualmente antes de cada saída.

Não construir nada disto antes de ser preciso — é a filosofia do projeto.
