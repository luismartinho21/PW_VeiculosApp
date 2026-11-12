<?php
$pageTitle = '404 | Página não encontrada';
require 'app/views/layout/header.php';
?>
<section class="not-found">
  <p class="eyebrow">Erro 404</p>
  <h1>Página não encontrada</h1>
  <p>A página ou recurso que procuras não existe ou foi removido.</p>
  <a class="button" href="<?php echo $url_alias; ?>/">Voltar ao início</a>
</section>
<?php require 'app/views/layout/footer.php'; ?>
