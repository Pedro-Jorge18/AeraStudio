<?php
declare(strict_types=1);
$titulo_pagina = $titulo_pagina ?? 'AERA Studio Ops';
$pagina_atual = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo_pagina) ?> · AERA Studio Ops</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,600&display=swap">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<header class="topo">
    <a class="topo-marca" href="index.php">AERA <span>Studio</span></a>
    <nav>
        <a href="index.php" class="inicio-link<?= $pagina_atual === 'index.php' ? ' ativo' : '' ?>">Início</a>
        <a href="painel.php" <?= $pagina_atual === 'painel.php' ? 'class="ativo"' : '' ?>>Painel</a>
        <a href="registar_voo.php" <?= $pagina_atual === 'registar_voo.php' ? 'class="ativo"' : '' ?>>Registar voo</a>
        <a href="registar_publicacao.php" <?= $pagina_atual === 'registar_publicacao.php' ? 'class="ativo"' : '' ?>>Registar publicação</a>
        <a href="locais.php" <?= $pagina_atual === 'locais.php' ? 'class="ativo"' : '' ?>>Locais</a>
        <a href="recomendacao.php" <?= $pagina_atual === 'recomendacao.php' ? 'class="ativo"' : '' ?>>Próximo destino</a>
        <a href="repeticao.php" <?= $pagina_atual === 'repeticao.php' ? 'class="ativo"' : '' ?>>Alerta de repetição</a>
        <a href="documentos.php" <?= $pagina_atual === 'documentos.php' ? 'class="ativo"' : '' ?>>Documentos</a>
        <a href="painel_controlo.php" <?= $pagina_atual === 'painel_controlo.php' ? 'class="ativo"' : '' ?>>Painel de Controlo</a>
    </nav>
</header>
<main class="conteudo">
    <h1><?= htmlspecialchars($titulo_pagina) ?></h1>
