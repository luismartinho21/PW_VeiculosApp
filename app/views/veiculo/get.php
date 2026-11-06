<meta charset="utf-8">
<pre>
<?php 
// debug
// print_r($data);
?>
</pre>

<?php
if (empty($data['veiculos']) || count($data['veiculos']) == 0) {
?>
  <h1>O veículo não existe na nossa base de dados...</h1>
<?php 
} else {
  $idCategoria = $data['veiculos'][0]['categoria_id'];
  $categoria = array_filter($data['categorias'], function ($cat) use ($idCategoria) {
      return $cat['id'] == $idCategoria;
  });
  $values = array_values($categoria);
  $categoria_descr = $values[0]['categoria'] ?? 'N/D';
?>

  <div>
  <?php echo "Marca: " . htmlspecialchars($data['veiculos'][0]['marca']); ?>
  </div>

  <div>
  <?php echo "País de Origem: " . htmlspecialchars($data['veiculos'][0]['pais_origem']); ?>
  </div>

  <div>
  <?php echo "Ano de Fundação: " . htmlspecialchars($data['veiculos'][0]['ano_fundacao']); ?>
  </div>

  <div>
  <?php echo "Categoria: " . htmlspecialchars($categoria_descr); ?>
  </div>
<?php 
}
?>
<br>
<a href="<?php echo $url_alias;?>/veiculo">Voltar</a>
