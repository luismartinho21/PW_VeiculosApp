<?php
$pageTitle = 'Veículos | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="page-heading">
  <div>
    <p class="eyebrow">Catálogo</p>
    <h1>Lista de Veículos</h1>
  </div>
  <a class="button" href="<?php echo $url_alias; ?>/veiculo/create">Adicionar veículo</a>
</section>

<?php
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
  // Extrai automaticamente as categorias existentes nos veículos
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

    <button type="button" id="clear-filters" class="button-secondary" hidden>Limpar filtros</button>
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
    ?>
      <li
        class="vehicle-card"
        data-search="<?php echo htmlspecialchars($searchText); ?>"
        data-categoria="<?php echo htmlspecialchars($categoriaValue); ?>"
      >
        <div class="vehicle-card-content">
          <p class="eyebrow"><?php echo htmlspecialchars($veiculo['categoria']); ?></p>
          <h2><?php echo htmlspecialchars($veiculo['marca']); ?></h2>
          <p><?php echo htmlspecialchars($veiculo['pais_origem']); ?> <span aria-hidden="true">·</span> <?php echo htmlspecialchars($veiculo['ano_fundacao']); ?></p>
        </div>
        <div class="card-actions">
          <a href="<?php echo $url_alias; ?>/veiculo/get/<?php echo $veiculo['id']; ?>">Detalhes</a>
          <a href="<?php echo $url_alias; ?>/veiculo/update/<?php echo $veiculo['id']; ?>">Editar</a>
          <a class="delete-link" href="<?php echo $url_alias; ?>/veiculo/delete/<?php echo $veiculo['id']; ?>" data-confirm="Tens a certeza de que pretendes eliminar este veículo?">Eliminar</a>
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