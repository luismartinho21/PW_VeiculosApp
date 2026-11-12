<?php
$pageTitle = 'Início | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="hero">
  <p class="eyebrow">Catálogo automóvel</p>
  <h1>Veículos ECGM</h1>
  <p>Explore e gira o catálogo de veículos num só lugar.</p>
  <div class="hero-actions">
    <a class="button" href="<?php echo $url_alias; ?>/veiculo">Ver veículos</a>
    <a class="button button-secondary" href="<?php echo $url_alias; ?>/veiculo/create">Adicionar veículo</a>
  </div>
</section>
<?php require 'app/views/layout/footer.php'; ?>
