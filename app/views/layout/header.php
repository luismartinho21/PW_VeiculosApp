<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Gestão de Veículos', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="<?php echo $url_alias; ?>/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="<?php echo $url_alias; ?>/">Gestão de Veículos</a>
            <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="primary-navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav class="navbar" id="primary-navigation" aria-label="Navegação principal">
                <a href="<?php echo $url_alias; ?>/">Início</a>
                <a href="<?php echo $url_alias; ?>/veiculo">Veículos</a>
                <a href="<?php echo $url_alias; ?>/veiculo/create">Adicionar Veículo</a>
                <a href="<?php echo $url_alias; ?>/home/autores">Autores</a>
            </nav>
        </div>
    </header>
    <main class="container main-content">