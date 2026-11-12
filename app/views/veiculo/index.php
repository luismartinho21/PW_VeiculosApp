<?php
$pageTitle = 'Veículos | Gestão de Veículos';
require 'app/views/layout/header.php';
$isLoggedIn = !empty($_SESSION['user']);
?>
<section class="page-heading">
  <div>
    <p class="eyebrow">Catálogo</p>
    <h1>Lista de Veículos</h1>
  </div>
  <?php if ($isLoggedIn) { ?>
    <a class="button with-icon" href="<?php echo $url_alias; ?>/veiculo/create">
      <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M5 12h14"/>
        <path d="M12 5v14"/>
      </svg>
      <span>Adicionar veículo</span>
    </a>
  <?php } else { ?>
    <a class="button button-secondary with-icon" href="<?php echo $url_alias; ?>/auth/login">
      <span>Inicia sessão para gerir veículos</span>
    </a>
  <?php } ?>
</section>

<?php
if (!empty($_SESSION['flash_notice'])) {
  echo '<p class="notice" role="status">' . htmlspecialchars($_SESSION['flash_notice']) . '</p>';
  unset($_SESSION['flash_notice']);
}

if (isset($data['info']) && isset($data['type'])) {
  $type = $data['type'];
  switch ($type) {
    case 'INSERT':
      echo '<p class="notice" role="status">Veículo - ' . htmlspecialchars($data['info']['marca']) . ' - inserido com sucesso.</p>';
      break;
    case 'UPDATE':
      echo '<p class="notice" role="status">A informação do veículo - ' . htmlspecialchars($data['info']['marca']) . ' - foi atualizada.</p>';
      break;
    case 'DELETE':
      echo '<p class="notice" role="status">O veículo - ' . htmlspecialchars($data['info']['marca']) . ' - foi eliminado.</p>';
      break;
  }
}
?>

<?php if (empty($data['veiculos'])) { ?>
  <p class="empty-state">Ainda não existem veículos no catálogo.</p>
<?php } else {
  $categoriasDisponiveis = [];
  foreach ($data['veiculos'] as $v) {
    if (!empty($v['categoria']) && !in_array($v['categoria'], $categoriasDisponiveis, true)) {
      $categoriasDisponiveis[] = $v['categoria'];
    }
  }
  sort($categoriasDisponiveis);
?>
  <section class="filter-bar" aria-label="Filtrar veículos">
    <div class="filter-group filter-search">
      <label for="search-veiculos" class="sr-only">Pesquisar veículos</label>
      <input
        type="search"
        id="search-veiculos"
        placeholder="Pesquisar por marca, país ou ano..."
        autocomplete="off"
      >
    </div>

    <div class="filter-group filter-category">
      <label for="filter-categoria" class="sr-only">Filtrar por categoria</label>
      <select id="filter-categoria">
        <option value="">Todas as categorias</option>
        <?php foreach ($categoriasDisponiveis as $catNome) { ?>
          <option value="<?php echo htmlspecialchars(mb_strtolower($catNome, 'UTF-8')); ?>">
            <?php echo htmlspecialchars($catNome); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <button type="button" id="clear-filters" class="button-secondary with-icon" hidden>
      <svg class="ui-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M18 6 6 18"/>
        <path d="m6 6 12 12"/>
      </svg>
      <span>Limpar filtros</span>
    </button>
  </section>

  <p id="results-counter" class="results-counter" aria-live="polite">
    A mostrar <?php echo count($data['veiculos']); ?> veículo(s)
  </p>

  <ul class="vehicle-grid" id="vehicle-grid">
    <?php foreach ($data['veiculos'] as $veiculo) {
      $searchText = mb_strtolower(
        $veiculo['marca'] . ' ' . $veiculo['pais_origem'] . ' ' . $veiculo['ano_fundacao'] . ' ' . $veiculo['categoria'],
        'UTF-8'
      );
      $categoriaValue = mb_strtolower($veiculo['categoria'], 'UTF-8');

      $catTheme = 'default';
      if (str_contains($categoriaValue, 'terrestre')) {
        $catTheme = 'terrestre';
      } elseif (str_contains($categoriaValue, 'mar') || str_contains($categoriaValue, 'aqu') || str_contains($categoriaValue, 'naut')) {
        $catTheme = 'maritimo';
      } elseif (str_contains($categoriaValue, 'aer') || str_contains($categoriaValue, 'aér') || str_contains($categoriaValue, 'av')) {
        $catTheme = 'aereo';
      }
    ?>
      <li
        class="vehicle-card"
        data-search="<?php echo htmlspecialchars($searchText); ?>"
        data-categoria="<?php echo htmlspecialchars($categoriaValue); ?>"
      >
        <div class="vehicle-card-banner theme-<?php echo $catTheme; ?>" aria-hidden="true">
          <?php if ($catTheme === 'maritimo') { ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1 .6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/>
              <path d="M19.38 20A11.6 11.6 0 0 0 21 14l-9-4-9 4c0 2.9.94 5.34 2.81 7.76"/>
              <path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/>
              <path d="M12 10v4"/>
              <path d="M12 2v3"/>
            </svg>
          <?php } elseif ($catTheme === 'aereo') { ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>
            </svg>
          <?php } else { ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
              <circle cx="7" cy="17" r="2"/>
              <path d="M9 17h6"/>
              <circle cx="17" cy="17" r="2"/>
            </svg>
          <?php } ?>
          <span class="category-badge badge-<?php echo $catTheme; ?>">
            <?php echo htmlspecialchars($veiculo['categoria']); ?>
          </span>
        </div>

        <div class="vehicle-card-content">
          <h2><?php echo htmlspecialchars($veiculo['marca']); ?></h2>
          <p><?php echo htmlspecialchars($veiculo['pais_origem']); ?> <span aria-hidden="true">·</span> <?php echo htmlspecialchars($veiculo['ano_fundacao']); ?></p>
        </div>

        <div class="card-actions">
          <a class="action-link with-icon" href="<?php echo $url_alias; ?>/veiculo/get/<?php echo $veiculo['id']; ?>">
            <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
            <span>Detalhes</span>
          </a>

          <?php if ($isLoggedIn) { ?>
            <a class="action-link with-icon" href="<?php echo $url_alias; ?>/veiculo/update/<?php echo $veiculo['id']; ?>">
              <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                <path d="m15 5 4 4"/>
              </svg>
              <span>Editar</span>
            </a>

            <a class="action-link delete-link with-icon" href="<?php echo $url_alias; ?>/veiculo/delete/<?php echo $veiculo['id']; ?>" data-confirm="Tens a certeza de que pretendes eliminar este veículo?">
              <svg class="ui-icon ui-icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 6h18"/>
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
              </svg>
              <span>Eliminar</span>
            </a>
          <?php } ?>
        </div>
      </li>
    <?php } ?>
  </ul>

  <div id="no-results-message" class="empty-state" hidden>
    <p>Nenhum veículo encontrado com os filtros aplicados.</p>
    <button type="button" id="reset-empty-filters" class="button-secondary">Mostrar todos os veículos</button>
  </div>
<?php } ?>
<?php require 'app/views/layout/footer.php'; ?>