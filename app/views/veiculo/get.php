<?php
$pageTitle = 'Detalhes do veículo | Gestão de Veículos';
require 'app/views/layout/header.php';
if (empty($data['veiculos']) || count($data['veiculos']) == 0) {
?>
  <section class="empty-state">
    <h1>O veículo não existe na nossa base de dados.</h1>
    <a href="<?php echo $url_alias; ?>/veiculo">Voltar à lista</a>
  </section>
<?php
} else {
  $idCategoria = $data['veiculos'][0]['categoria_id'];
  $categoria = array_filter($data['categorias'], function ($cat) use ($idCategoria) {
      return $cat['id'] == $idCategoria;
  });
  $values = array_values($categoria);
  $categoria_descr = $values[0]['categoria'] ?? 'N/D';
?>
  <article class="detail-card">
    <p class="eyebrow">Detalhes do veículo</p>
    <h1><?php echo htmlspecialchars($data['veiculos'][0]['marca']); ?></h1>
    <dl class="detail-list">
      <div><dt>País de origem</dt><dd><?php echo htmlspecialchars($data['veiculos'][0]['pais_origem']); ?></dd></div>
      <div><dt>Ano de fundação</dt><dd><?php echo htmlspecialchars($data['veiculos'][0]['ano_fundacao']); ?></dd></div>
      <div><dt>Categoria</dt><dd><?php echo htmlspecialchars($categoria_descr); ?></dd></div>
    </dl>
  </article>
<?php
}
?>
<p class="back-link"><a href="<?php echo $url_alias; ?>/veiculo">Voltar à lista</a></p>
<?php require 'app/views/layout/footer.php'; ?>
