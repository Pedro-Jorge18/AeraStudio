<?php
declare(strict_types=1);

// Painel de Controlo estratégico do projeto AERA Studio.
// Conteúdo narrativo (decisões, alertas, especialistas, roteiro) — não vem da base de dados.
// Traz-se aqui um resumo sempre que houver uma decisão nova (ver "Como manter isto atualizado").

$titulo_pagina = 'Painel de Controlo';
require __DIR__ . '/../includes/layout_topo.php';
?>

<div class="painel">
  <p class="lede">Projeto part-time por diversão e portefólio, não um negócio a escalar — os dois são devs de software, e é isso que continua a ser o "trabalho a sério". Vídeo e fotografia aérea com drone, conteúdo geral aberto ao público (Instagram + TikTok), aos fins de semana.</p>

  <div class="chips">
    <span class="chip">Fase: <b>hobby part-time, para sempre</b></span>
    <span class="chip">Ritmo: <b>1 vídeo/semana, fins de semana</b></span>
    <span class="chip">Conteúdo: <b>geral + dicas, aberto ao público</b></span>
    <span class="chip">Equipamento: <b>DJI Lito X1 + ND Freewell</b></span>
    <span class="chip">Atualizado em <b>02/08/2026</b></span>
  </div>

  <div class="callout">
    <p class="callout-titulo">Correção de rumo (02/08)</p>
    <p>O painel e os especialistas estavam a tratar isto como um negócio a escalar para full-time, com nicho fechado (imóveis de charme/turismo rural) e funil de vendas ativo. <strong>Não é isso</strong> — é um projeto part-time para sempre, de dois devs de 19 anos, por diversão e portefólio, aberto a um público geral com conteúdo tipo "dicas", em Instagram e TikTok, 1 vídeo/semana ao fim de semana. Trabalho pago é bem-vindo se aparecer, mas sem estratégia de vendas ativa nem pressão de crescer. O painel abaixo já reflete isto — o que ficou por baixo do nicho anterior mantém-se disponível como referência, não como plano ativo.</p>
  </div>

  <div class="callout">
    <p class="callout-titulo">Porquê fazem isto</p>
    <p>Divertirem-se — dinheiro é bónus, não objetivo. O que interessa a sério é o projeto ser bom, mostrar sítios fixes e coisas novas, e criar comunidade — pessoas a sentirem-se parte disto, não só a verem conteúdo. Qualquer sugestão futura (de mim ou de um especialista) devia servir isto antes de servir crescimento ou números.</p>
  </div>

  <div class="estado-tira">
    <div class="estado-cartao"><span class="estado-area">Técnico</span><span class="pilula info">Em progresso</span></div>
    <div class="estado-cartao"><span class="estado-area">Branding</span><span class="pilula redefine">A redefinir</span></div>
    <div class="estado-cartao"><span class="estado-area">Negócio</span><span class="pilula neutral">Em standby</span></div>
    <div class="estado-cartao"><span class="estado-area">Jurídico</span><span class="pilula warn">1 alerta (seguro)</span></div>
    <div class="estado-cartao"><span class="estado-area">Vendas</span><span class="pilula neutral">Em standby</span></div>
  </div>

  <h2 class="secao-titulo">⚠ Alertas e cruzamentos entre áreas</h2>
  <div class="alertas">
    <div class="alerta urgent">
      <span class="alerta-tag">Urgente</span>
      <div class="alerta-corpo"><strong>Seguro de responsabilidade civil</strong> — continua a ser o ponto mais importante, hobby ou não. Não é legalmente obrigatório para o Lito X1 (&lt;900g, Portaria 2/2021), mas a responsabilidade civil pessoal continua ilimitada mesmo sem apólice — isto não muda por ser part-time ou por diversão. Ação: pedir cotação a corretor especializado em drones (referência Coverdrone ~143€/ano).</div>
    </div>
    <div class="alerta ok">
      <span class="alerta-tag">Resolvido</span>
      <div class="alerta-corpo"><strong>Autorização da AAN</strong> — tratada. Já têm a autorização da AAN para captação de imagens aéreas. Falta só confirmar se cobre uso recorrente em várias localizações (Douro, Ponte de Lima, Porto) ou se é caso a caso (validade máxima de 30 dias por pedido).</div>
    </div>
    <div class="alerta info">
      <span class="alerta-tag">Nota</span>
      <div class="alerta-corpo">O vídeo do jardim continua a ser a melhor prova de que o formato <strong>"pessoa em cena"</strong> funciona. Isso não muda com o pivô — só deixa de ser justificado como "prova para pitch a agências" e passa a ser só um bom exemplo de conteúdo a repetir, para qualquer público.</div>
    </div>
    <div class="alerta ok">
      <span class="alerta-tag">Já resolvido</span>
      <div class="alerta-corpo"><strong>Estrutura fiscal:</strong> recibos verdes (ENI), regime simplificado, isenção de IVA (até 15.000€/ano) — continua a ser a estrutura certa SE aparecer trabalho pago pontual. Não é preciso ativar isto até haver mesmo um pagamento a receber. Mas atenção: mesmo um amigo a pagar 50€ por MBWay por um vídeo conta como rendimento — emitir recibo verde em 5 dias úteis; transferências não documentadas na conta são o padrão que levanta bandeiras às Finanças.</div>
    </div>
    <div class="alerta warn">
      <span class="alerta-tag">Novo — Jurídico</span>
      <div class="alerta-corpo">Conteúdo tipo <strong>"bloopers/quase-acidentes"</strong> pode criar incentivo a voar de forma mais arriscada para conseguir o clip. Se um incidente for percebido como manobra deliberada "para o vídeo", a seguradora pode recusar indemnização por negligência grosseira. Regra simples: nunca perseguir pessoa/veículo em movimento a baixa altitude só pelo efeito dramático. Nota extra: um "POV a perseguir alguém a correr" torna essa pessoa protagonista do vídeo, não figurante de fundo — precisa da autorização dela, é um regime diferente de filmar paisagem com gente ao longe.</div>
    </div>
  </div>

  <h2 class="secao-titulo">As cinco áreas</h2>
  <div class="areas">

    <article class="area-cartao">
      <div class="area-cabecalho"><span class="area-nome">Técnico de Drone &amp; Produção</span><span class="pilula info">Em progresso</span></div>
      <div>
        <p class="area-grupo-titulo">Decisões tomadas</p>
        <ul class="area-lista">
          <li>Equipamento (Lito X1 + ND Freewell) avaliado: bom para o que precisam agora — vídeo e fotografia aérea de conteúdo geral</li>
          <li>Definições de câmara fechadas (obturador 1/60, ISO 100, D-Log M, ND consoante a luz) — aplicam-se a qualquer tipo de conteúdo, não só imobiliário</li>
          <li>Plano de voo de treino entregue: local, checklist, 6 planos concretos, segurança e pós-voo (ver documento)</li>
          <li>Equipa confirmada: Pedro filma/pilota, Luísa trata da pós-produção/edição além de aparecer em câmara</li>
        </ul>
      </div>
      <div>
        <p class="area-grupo-titulo">Pendente / próximos passos</p>
        <ul class="area-lista">
          <li>Incluir fotografia aérea nos planos de voo, não só vídeo — ainda não há checklist específico para sessões de foto (disparar RAW+JPEG sempre)</li>
          <li>Gravar vertical (9:16) nativo quando o drone permitir, em vez de cortar depois — poupa qualidade e tempo de edição para Insta/TikTok</li>
          <li>Ativar a gravação assim que ligam o drone, não só no "take bom" — é aí que sai o material de bloopers</li>
          <li>Confirmar cobertura da autorização AAN por localização</li>
          <li>Seguro continua em aberto (ver alerta) — vale a pena resolver mesmo sendo hobby</li>
        </ul>
      </div>
      <div class="area-rodape">Última atualização: 02/08/2026</div>
    </article>

    <article class="area-cartao">
      <div class="area-cabecalho"><span class="area-nome">Branding &amp; Redes Sociais</span><span class="pilula redefine">A redefinir</span></div>
      <div>
        <p class="area-grupo-titulo">Decisões tomadas</p>
        <ul class="area-lista">
          <li>Pivô confirmado: conteúdo geral + dicas, aberto ao público, em vez de nicho fechado de imóveis de charme</li>
          <li>Plataformas: Instagram e TikTok, ambas ativas (antes só o Instagram tinha plano)</li>
          <li>Ritmo real: 1 vídeo/semana, aos fins de semana — corrige o plano anterior de 2 Reels/semana, que não era realista</li>
          <li>O formato "pessoa em cena" (validado pelo vídeo do jardim) continua a ser um bom recurso visual, agora sem obrigação de ligar a imóveis</li>
          <li>"Dicas" definido como mistura de tudo: pilotagem, edição, sítios bonitos, e vídeos engraçados/bloopers — banco de ideias entregue (ver documento)</li>
        </ul>
      </div>
      <div>
        <p class="area-grupo-titulo">Pendente / próximos passos</p>
        <ul class="area-lista">
          <li>Escolher a primeira ideia do banco para o vídeo deste fim de semana</li>
          <li>Rebrand da bio/categoria feito anteriormente pode precisar de ajuste para refletir o novo posicionamento mais aberto</li>
        </ul>
      </div>
      <div class="area-nota">
        <p class="area-nota-titulo">Documentos antigos (ainda existem, já não são o plano ativo)</p>
        Legendas/CTAs, hashtags e lista de 10 quintas de prospeção — continuam disponíveis se um dia quiserem fazer conteúdo de propriedades, mas deixaram de ser a estratégia principal.
      </div>
      <div class="area-nota">
        <p class="area-nota-titulo">Nota do branding</p>
        A métrica que importa agora não é conversão, é "ainda temos gozo nisto?". Vale a pena questionar se "AERA Studio" ainda é o tom certo, ou se um nome/bio mais descontraído (ex: "dois devs, um drone, fins de semana") encaixa melhor com bloopers ao lado de planos aéreos bonitos.
      </div>
      <div class="area-rodape">Última atualização: 02/08/2026</div>
    </article>

    <article class="area-cartao">
      <div class="area-cabecalho"><span class="area-nome">Negócio &amp; Gestão</span><span class="pilula neutral">Em standby</span></div>
      <div>
        <p class="area-grupo-titulo">Decisões tomadas</p>
        <ul class="area-lista">
          <li>Postura confirmada: aceitar trabalho pago se aparecer, sem correr atrás dele — sem funil de vendas ativo</li>
          <li>Estrutura fiscal de referência, se necessário: recibos verdes (ENI), regime simplificado, isenção de IVA (até 15.000€/ano)</li>
          <li>Sem preço fixo — varia consoante tipo de vídeo, local e tempo gasto; para já ficam baixos, por serem iniciantes. A tabela antiga (~120–130€ mínimo) fica só como referência de mercado, não como regra a seguir</li>
          <li>3 documentos continuam disponíveis se precisarem: acordo de colaboração, contrato-modelo, proposta comercial (ver ficheiros .docx)</li>
        </ul>
      </div>
      <div>
        <p class="area-grupo-titulo">Pendente / próximos passos</p>
        <ul class="area-lista">
          <li>Nada ativo por agora — só ativar (abrir atividade, validar CIRS 1519 com contabilista) se e quando aparecer um pagamento real a receber</li>
          <li>Contrato-modelo só precisa de revisão de advogado se e quando surgir um cliente pagante real</li>
        </ul>
      </div>
      <div class="area-rodape">Última atualização: 02/08/2026</div>
    </article>

    <article class="area-cartao">
      <div class="area-cabecalho"><span class="area-nome">Jurídico &amp; Direitos de Imagem</span><span class="pilula warn">1 alerta (seguro)</span></div>
      <div>
        <p class="area-grupo-titulo">Decisões tomadas</p>
        <ul class="area-lista">
          <li>Registo ANAC + certificado A1/A3 confirmados como corretos</li>
          <li>Autorização da AAN obtida ✅ (captação de imagens, separado do registo de voo)</li>
          <li>Seguro recomendado mesmo sem obrigatoriedade legal para &lt;900g — e mesmo sendo hobby, porque a responsabilidade civil pessoal não distingue "negócio" de "diversão"</li>
          <li>Riscos de privacidade mapeados (art. 79º/80º CC) — aplicam-se da mesma forma a conteúdo geral com pessoas identificáveis</li>
        </ul>
      </div>
      <div>
        <p class="area-grupo-titulo">Pendente / próximos passos</p>
        <ul class="area-lista">
          <li>Confirmar se a autorização AAN cobre várias localizações ou é caso a caso (30 dias)</li>
          <li>Pedir cotações de seguro — última peça em falta, independente do rumo do "negócio"</li>
        </ul>
      </div>
      <div class="area-rodape">Última atualização: 02/08/2026</div>
    </article>

    <article class="area-cartao" style="grid-column: 1 / -1;">
      <div class="area-cabecalho"><span class="area-nome">Vendas &amp; Fecho de Clientes</span><span class="pilula neutral">Em standby</span></div>
      <div>
        <p class="area-grupo-titulo">Decisões tomadas</p>
        <ul class="area-lista">
          <li>Sem campanha de outreach ativa — a lista de 10 quintas e os scripts de contacto continuam disponíveis, mas não são um plano em curso</li>
          <li>Postura: se uma oportunidade de colaboração ou trabalho pago aparecer organicamente (ex: alguém pede um vídeo), aceitam-na sem drama, sem negociação forçada</li>
        </ul>
      </div>
      <div>
        <p class="area-grupo-titulo">Pendente / próximos passos</p>
        <ul class="area-lista">
          <li>"Não fechar a porta" — 3 coisas leves a manter mesmo em standby: um contacto óbvio na bio para pedidos de orçamento, uma resposta-padrão pronta para quando alguém perguntar, e decidir agora, a frio, que trabalho aceitam ou recusam</li>
        </ul>
      </div>
      <div class="area-rodape">Última atualização: 02/08/2026</div>
    </article>

  </div>

  <h2 class="secao-titulo">Os especialistas</h2>
  <p class="lede" style="margin-bottom:20px;">Cinco conselheiros, um por área. Cada um é briefado com este mesmo painel — por isso partilham o tom (hobby part-time, sem pressão de crescer). Chamas qualquer um deles através do chat principal; eu passo-lhes o contexto e trago a resposta.</p>
  <div class="especialistas">

    <article class="esp-cartao">
      <div class="esp-cabecalho">
        <div class="esp-avatar">🚁</div>
        <div class="esp-titulos">
          <span class="esp-nome">Técnico de Drone &amp; Produção</span>
          <span class="esp-foco">Voo, câmara e captação</span>
        </div>
      </div>
      <div class="esp-corpo">
        <p class="esp-bloco-titulo">O que guarda</p>
        <p>Definições de câmara fechadas (<strong>1/60, ISO 100, D-Log M, ND consoante luz</strong>), checklist de voo, 6 planos de treino concretos, regras de segurança e pós-voo, e a divisão de equipa (Pedro pilota, Luísa edita).</p>
      </div>
      <div class="esp-chamar"><b>Chama-o quando:</b> tiveres dúvidas de gravação/definições, quiseres planear uma sessão, ou incluir fotografia aérea num voo.</div>
    </article>

    <article class="esp-cartao">
      <div class="esp-cabecalho">
        <div class="esp-avatar">🎬</div>
        <div class="esp-titulos">
          <span class="esp-nome">Branding &amp; Redes Sociais</span>
          <span class="esp-foco">Posicionamento, tom e conteúdo</span>
        </div>
      </div>
      <div class="esp-corpo">
        <p class="esp-bloco-titulo">O que guarda</p>
        <p>O pivô para <strong>conteúdo geral + dicas</strong> (Instagram + TikTok), o ritmo real de 1 vídeo/semana, o banco de ideias de conteúdo, o formato "pessoa em cena" validado, e a questão em aberto sobre a bio/tom.</p>
      </div>
      <div class="esp-chamar"><b>Chama-o quando:</b> quiseres escolher a ideia da semana, escrever legendas, ou decidir o tom da conta.</div>
    </article>

    <article class="esp-cartao">
      <div class="esp-cabecalho">
        <div class="esp-avatar">📊</div>
        <div class="esp-titulos">
          <span class="esp-nome">Negócio &amp; Gestão</span>
          <span class="esp-foco">Fiscal, preços e documentos</span>
        </div>
      </div>
      <div class="esp-corpo">
        <p class="esp-bloco-titulo">O que guarda</p>
        <p>A estrutura fiscal de referência (<strong>recibos verdes, regime simplificado, isenção de IVA até 15.000€</strong>), a tabela de preços de referência (só como baliza), e 3 documentos prontos: acordo de colaboração, contrato-modelo e proposta comercial.</p>
      </div>
      <div class="esp-chamar"><b>Chama-o quando:</b> aparecer trabalho pago real e for preciso faturar, precificar ou passar recibo.</div>
    </article>

    <article class="esp-cartao">
      <div class="esp-cabecalho">
        <div class="esp-avatar">⚖️</div>
        <div class="esp-titulos">
          <span class="esp-nome">Jurídico &amp; Direitos de Imagem</span>
          <span class="esp-foco">ANAC/AAN, seguro e privacidade</span>
        </div>
      </div>
      <div class="esp-corpo">
        <p class="esp-bloco-titulo">O que guarda</p>
        <p>Registo ANAC + certificado A1/A3, a autorização AAN obtida, os riscos de privacidade (art. 79º/80º CC), e a referência de seguro (<strong>Coverdrone ~143€/ano</strong>) — a peça ainda em falta.</p>
      </div>
      <div class="esp-chamar"><b>Chama-o quando:</b> tiveres dúvidas de legalidade, autorizações por local, ou direitos de imagem de quem aparece nos vídeos.</div>
    </article>

    <article class="esp-cartao" style="grid-column: 1 / -1;">
      <div class="esp-cabecalho">
        <div class="esp-avatar">🤝</div>
        <div class="esp-titulos">
          <span class="esp-nome">Vendas &amp; Fecho de Clientes</span>
          <span class="esp-foco">Oportunidades orgânicas (em standby)</span>
        </div>
      </div>
      <div class="esp-corpo">
        <p class="esp-bloco-titulo">O que guarda</p>
        <p>A postura de standby (sem outreach ativo), a lista de 10 quintas e os scripts de contacto arquivados, e as 3 coisas leves a manter mesmo sem procurar clientes: contacto na bio, resposta-padrão pronta, e decidir a frio que trabalho aceitam.</p>
      </div>
      <div class="esp-chamar"><b>Chama-o quando:</b> alguém pedir um orçamento organicamente e for preciso responder ou decidir se aceitam.</div>
    </article>

  </div>

  <h2 class="secao-titulo">Roteiro — sem pressão, sem marcos de crescimento</h2>
  <p class="lede" style="margin-bottom:20px;">Sem metas de faturação nem plano para escalar. Só o que faz sentido tratar, e o ritmo sustentável que já corrigiram.</p>
  <div class="roteiro">
    <div class="roteiro-bloco">
      <div class="roteiro-cabecalho"><span class="roteiro-titulo">Imediato</span><span class="roteiro-prazo">esta semana</span></div>
      <ul class="roteiro-lista">
        <li class="roteiro-item"><span class="roteiro-tag">Jurídico</span> Contratar o seguro de responsabilidade civil (~143€/ano) — vale a pena mesmo sendo hobby</li>
        <li class="roteiro-item"><span class="roteiro-tag">Jurídico</span> Confirmar se a autorização AAN cobre outras localizações além do Douro</li>
        <li class="roteiro-item"><span class="roteiro-tag">Branding</span> Publicar o material de Ponte de Lima</li>
      </ul>
    </div>
    <div class="roteiro-bloco">
      <div class="roteiro-cabecalho"><span class="roteiro-titulo">Curto prazo</span><span class="roteiro-prazo">próximas semanas</span></div>
      <ul class="roteiro-lista">
        <li class="roteiro-item"><span class="roteiro-tag">Branding</span> Decidir o que são os vídeos de "dicas" e montar um plano leve de conteúdo geral para Instagram + TikTok</li>
        <li class="roteiro-item"><span class="roteiro-tag">Técnico</span> Incluir fotografia aérea nos próximos voos, não só vídeo</li>
      </ul>
    </div>
    <div class="roteiro-bloco">
      <div class="roteiro-cabecalho"><span class="roteiro-titulo">Contínuo</span><span class="roteiro-prazo">sem prazo — é o ritmo normal</span></div>
      <ul class="roteiro-lista">
        <li class="roteiro-item"><span class="roteiro-tag">Branding</span> 1 vídeo/semana, aos fins de semana — sem pressão de aumentar cadência</li>
        <li class="roteiro-item"><span class="roteiro-tag">Negócio &amp; Vendas</span> Aceitar trabalho pago se aparecer, sem procurar ativamente; documentos e preços de referência ficam disponíveis para quando fizer falta</li>
        <li class="roteiro-item"><span class="roteiro-tag">Jurídico</span> Manter seguro e autorizações em dia enquanto continuarem a voar e a publicar</li>
      </ul>
    </div>
  </div>

  <div class="rodape-manter">
    <p class="callout-titulo" style="margin-bottom:12px;">Como manter isto atualizado</p>
    <ol>
      <li>Sempre que houver uma decisão nova, ou uma correção, traz um resumo ao chat principal.</li>
      <li>Este painel é atualizado, e o mesmo vale para qualquer briefing dado a um especialista novo — assim ninguém volta a tratar isto como mais sério do que é.</li>
      <li>O ritmo e o tom deste painel devem sempre refletir: hobby part-time para sempre, conteúdo geral, sem pressão.</li>
    </ol>
  </div>
</div>

<?php require __DIR__ . '/../includes/layout_fim.php'; ?>
