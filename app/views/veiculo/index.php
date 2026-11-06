<meta charset="utf-8">
<h2>Lista de Veículos</h2>
<a href="<?php echo $url_alias;?>/veiculo/create">NOVO</a>

<?php
if (isset($data['info']) && isset($data['type'])) {
  $type = $data['type'];
  switch ($type) {
    case 'INSERT':
      echo '<h3>Veículo - ' . htmlspecialchars($data['info']['marca']) . ' - inserido com sucesso.</h3>';
      break;
    case 'UPDATE':
      echo '<h3>A informação do veículo - ' . htmlspecialchars($data['info']['marca']) . ' - foi atualizada.</h3>';
      break;
    case 'DELETE':
      echo '<h3>O veículo - ' . htmlspecialchars($data['info']['marca']) . ' - foi eliminado.</h3>';
      break;
  }
}
?>

<ul>
  <?php foreach ($data['veiculos'] as $veiculo) { ?>
    <li>
      <strong><?php echo htmlspecialchars($veiculo['marca']); ?></strong> 
      (<?php echo htmlspecialchars($veiculo['categoria']); ?> | <?php echo htmlspecialchars($veiculo['pais_origem']); ?> | <?php echo htmlspecialchars($veiculo['ano_fundacao']); ?>)
      <a href="<?php echo $url_alias;?>/veiculo/get/<?php echo $veiculo['id'];?>">Ver +</a> | 
      <a href="<?php echo $url_alias;?>/veiculo/update/<?php echo $veiculo['id'];?>">Editar</a> | 
      <a href="<?php echo $url_alias;?>/veiculo/delete/<?php echo $veiculo['id'];?>">Eliminar</a>
    </li>
  <?php } ?>
</ul>
