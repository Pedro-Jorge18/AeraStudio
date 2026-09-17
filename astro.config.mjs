// @ts-check
import { defineConfig } from 'astro/config';
import node from '@astrojs/node';

// SSR (renderização no servidor) para podermos ler/escrever no SQLite a cada pedido,
// tal como o PHP fazia. O adaptador Node corre o site com `node ./dist/server/entry.mjs`.
export default defineConfig({
  output: 'server',
  adapter: node({ mode: 'standalone' }),
  server: { port: 4321, host: true },
  // Ferramenta interna, corre em localhost. Desligamos a verificação de origem
  // (CSRF) para os formulários funcionarem sem 403 — tal como o PHP fazia.
  // Se um dia puseres isto público na internet, volta a pôr checkOrigin: true.
  security: { checkOrigin: false },
  vite: {
    // node:sqlite é um módulo embutido do Node — mantém-no externo ao bundle.
    ssr: { external: ['node:sqlite'] },
  },
});
