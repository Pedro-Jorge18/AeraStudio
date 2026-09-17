# AERA Studio — Astro

Versão em **Astro + TypeScript** do projeto (migrado do PHP). A base de dados
continua a ser a mesma: SQLite em `db/aera_studio.sqlite`.

## Como correr

Precisas de Node 18+ (tu tens o 24).

```
npm install        # instala dependências (inclui better-sqlite3)
npm run dev        # servidor de desenvolvimento em http://localhost:4321
```

Para "produção" (build otimizado):

```
npm run build      # gera dist/
npm start          # corre o site a partir de dist/ (node ./dist/server/entry.mjs)
```

Verificação de tipos (TypeScript):

```
npm run check
```

## Estrutura

- `src/pages/index.astro` — landing page pública (a homepage da Luísa).
- `src/pages/painel.astro`, `locais`, `recomendacao`, `repeticao`,
  `registar_voo`, `registar_publicacao`, `documentos`, `painel_controlo` —
  o back-office (a antiga ferramenta interna).
- `src/layouts/OpsLayout.astro` — cabeçalho/menu partilhado do back-office.
- `src/lib/db.ts` — ligação ao SQLite (better-sqlite3) e helpers.
- `public/` — `site.css`, `site.js`, `estilo.css`, imagens.
- `db/aera_studio.sqlite` — a base de dados (com os dados reais já dentro).

## Notas

- A verificação de origem (CSRF) dos formulários está desligada em
  `astro.config.mjs` porque isto corre em localhost, tal como o PHP. Se um dia
  puseres o site público na internet, volta a pôr `security.checkOrigin: true`.
