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
<?php } else { ?>
  <ul class="vehicle-grid">
    <?php foreach ($data['veiculos'] as $veiculo) { ?>
      <li class="vehicle-card">
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
<?php } ?>
<?php require 'app/views/layout/footer.php'; ?>
