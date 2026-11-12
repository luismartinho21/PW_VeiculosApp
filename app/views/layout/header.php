<?php
$currentUri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
$basePath = rtrim($url_alias, '/');
$relativePath = '/' . ltrim(substr($currentUri, strlen($basePath)), '/');
if ($relativePath === '//') {
    $relativePath = '/';
}
$loggedUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Gestão de Veículos', ENT_QUOTES, 'UTF-8'); ?></title>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>
    <link rel="stylesheet" href="<?php echo $url_alias; ?>/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand with-icon" href="<?php echo $url_alias; ?>/">
                <svg class="ui-icon ui-icon-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                    <circle cx="7" cy="17" r="2"/>
                    <path d="M9 17h6"/>
                    <circle cx="17" cy="17" r="2"/>
                </svg>
                <span>Gestão de Veículos</span>
            </a>

            <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="primary-navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="navbar" id="primary-navigation" aria-label="Navegação principal">
                <a class="nav-link with-icon<?php echo ($relativePath === '/' || $relativePath === '/home' || $relativePath === '/home/index') ? ' is-active' : ''; ?>" href="<?php echo $url_alias; ?>/">
                    <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Início</span>
                </a>

                <a class="nav-link with-icon<?php echo ($relativePath === '/veiculo' || str_starts_with($relativePath, '/veiculo/get') || str_starts_with($relativePath, '/veiculo/update')) ? ' is-active' : ''; ?>" href="<?php echo $url_alias; ?>/veiculo">
                    <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="7" height="7" x="3" y="3" rx="1"/>
                        <rect width="7" height="7" x="14" y="3" rx="1"/>
                        <rect width="7" height="7" x="14" y="14" rx="1"/>
                        <rect width="7" height="7" x="3" y="14" rx="1"/>
                    </svg>
                    <span>Veículos</span>
                </a>

                <?php if ($loggedUser) { ?>
                    <a class="nav-link with-icon<?php echo str_starts_with($relativePath, '/veiculo/create') ? ' is-active' : ''; ?>" href="<?php echo $url_alias; ?>/veiculo/create">
                        <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M8 12h8"/>
                            <path d="M12 8v8"/>
                        </svg>
                        <span>Adicionar</span>
                    </a>
                <?php } ?>

                <?php if ($loggedUser) { ?>
                    <span class="user-pill" title="<?php echo htmlspecialchars($loggedUser['email']); ?>">
                        <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span><?php echo htmlspecialchars($loggedUser['nome']); ?></span>
                    </span>
                    <a class="nav-link logout-link with-icon" href="<?php echo $url_alias; ?>/auth/logout">
                        <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" x2="9" y1="12" y2="12"/>
                        </svg>
                        <span>Sair</span>
                    </a>
                <?php } else { ?>
                    <a class="nav-link with-icon<?php echo str_starts_with($relativePath, '/auth/login') ? ' is-active' : ''; ?>" href="<?php echo $url_alias; ?>/auth/login">
                        <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" x2="3" y1="12" y2="12"/>
                        </svg>
                        <span>Entrar</span>
                    </a>
                <?php } ?>

                <a class="nav-link with-icon<?php echo str_starts_with($relativePath, '/home/autores') ? ' is-active' : ''; ?>" href="<?php echo $url_alias; ?>/home/autores">
                    <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>Autores</span>
                </a>

                <button type="button" id="theme-toggle" class="theme-toggle-btn" aria-label="Alternar modo escuro" title="Alternar tema Claro/Escuro">
                    <svg class="ui-icon icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
                    </svg>
                    <svg class="ui-icon icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="4"/>
                        <path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                    </svg>
                </button>
            </nav>
        </div>
    </header>
    <main class="container main-content">