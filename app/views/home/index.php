<?php
$pageTitle = 'Início | Gestão de Veículos';
require 'app/views/layout/header.php';

$stats = $data['stats'] ?? ['total' => 0, 'por_categoria' => [], 'mais_antiga' => null];
$totalVeiculos = (int)($stats['total'] ?? 0);
$porCategoria = $stats['por_categoria'] ?? [];
$maisAntiga = $stats['mais_antiga'] ?? null;
?>

<section class="hero hero-compact">
  <p class="eyebrow">Catálogo Automóvel e Transportes</p>
  <h1>Gestão de Veículos</h1>
  <p>Consulta, pesquisa, guarda favoritos e gere o catálogo histórico de marcas terrestres, marítimas e aéreas.</p>
  <div class="hero-actions">
    <a class="button with-icon" href="<?php echo $url_alias; ?>/veiculo">
      <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <rect width="7" height="7" x="3" y="3" rx="1"/>
        <rect width="7" height="7" x="14" y="3" rx="1"/>
        <rect width="7" height="7" x="14" y="14" rx="1"/>
        <rect width="7" height="7" x="3" y="14" rx="1"/>
      </svg>
      <span>Explorar catálogo</span>
    </a>
    <?php if (!empty($_SESSION['user'])) { ?>
      <a class="button-secondary with-icon" href="<?php echo $url_alias; ?>/veiculo/create">
        <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M5 12h14"/>
          <path d="M12 5v14"/>
        </svg>
        <span>Adicionar veículo</span>
      </a>
    <?php } else { ?>
      <a class="button-secondary" href="<?php echo $url_alias; ?>/auth/login">Iniciar sessão</a>
    <?php } ?>
  </div>
</section>

<section class="dashboard-section" aria-labelledby="dashboard-title">
  <div class="dashboard-header">
    <div>
      <p class="eyebrow">Resumo em Tempo Real</p>
      <h2 id="dashboard-title">Estatísticas do Catálogo</h2>
    </div>
    <a class="dashboard-all-link" href="<?php echo $url_alias; ?>/veiculo">Ver todos →</a>
  </div>

  <div class="stats-grid">
    <!-- Total de Veículos -->
    <a class="stat-card stat-primary" href="<?php echo $url_alias; ?>/veiculo">
      <div class="stat-top">
        <span class="stat-label">Total de Marcas</span>
        <span class="stat-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="7" height="7" x="3" y="3" rx="1"/>
            <rect width="7" height="7" x="14" y="3" rx="1"/>
            <rect width="7" height="7" x="14" y="14" rx="1"/>
            <rect width="7" height="7" x="3" y="14" rx="1"/>
          </svg>
        </span>
      </div>
      <p class="stat-value"><?php echo $totalVeiculos; ?></p>
      <p class="stat-meta">Registadas na base de dados</p>
    </a>

    <!-- Cartões dinâmicos por Categoria -->
    <?php foreach ($porCategoria as $cat) {
      $catNome = $cat['categoria'] ?? '';
      $catTotal = (int)($cat['total'] ?? 0);
      $catLower = mb_strtolower($catNome, 'UTF-8');

      $themeClass = 'stat-terrestre';
      if (str_contains($catLower, 'mar') || str_contains($catLower, 'aqu') || str_contains($catLower, 'naut')) {
        $themeClass = 'stat-maritimo';
      } elseif (str_contains($catLower, 'aer') || str_contains($catLower, 'aér') || str_contains($catLower, 'av')) {
        $themeClass = 'stat-aereo';
      }
    ?>
      <a class="stat-card <?php echo $themeClass; ?>" href="<?php echo $url_alias; ?>/veiculo?categoria=<?php echo urlencode($catLower); ?>">
        <div class="stat-top">
          <span class="stat-label"><?php echo htmlspecialchars($catNome); ?></span>
          <span class="stat-icon" aria-hidden="true">
            <?php if ($themeClass === 'stat-maritimo') { ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>
                <path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/>
                <path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/>
                <path d="M12 10v4"/><path d="M12 2v3"/>
              </svg>
            <?php } elseif ($themeClass === 'stat-aereo') { ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
              </svg>
            <?php } else { ?>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                <circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>
              </svg>
            <?php } ?>
          </span>
        </div>
        <p class="stat-value"><?php echo $catTotal; ?></p>
        <p class="stat-meta">Filtrar categoria →</p>
      </a>
    <?php } ?>

    <!-- Marca Mais Antiga -->
    <?php if ($maisAntiga) { ?>
      <a class="stat-card stat-highlight" href="<?php echo $url_alias; ?>/veiculo?q=<?php echo urlencode($maisAntiga['marca']); ?>">
        <div class="stat-top">
          <span class="stat-label">Marca Mais Antiga</span>
          <span class="stat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </span>
        </div>
        <p class="stat-value stat-value-text"><?php echo htmlspecialchars($maisAntiga['marca']); ?></p>
        <p class="stat-meta"><?php echo htmlspecialchars($maisAntiga['pais_origem']); ?> · Fundada em <?php echo htmlspecialchars($maisAntiga['ano_fundacao']); ?></p>
      </a>
    <?php } ?>
  </div>
</section>

<?php require 'app/views/layout/footer.php'; ?>