<?php
$pageTitle = 'Adicionar veículo | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="form-section">
  <p class="eyebrow">Novo registo</p>
  <h1>Criar Novo Veículo</h1>

  <form class="vehicle-form" action="<?php echo $url_alias; ?>/veiculo/create" method="POST">
    <div class="form-field">
      <label for="marca">Marca:</label>
      <input type="text" id="marca" name="marca" required>
    </div>

    <div class="form-field">
      <label for="pais_origem">País de Origem:</label>
      <input type="text" id="pais_origem" name="pais_origem" required>
    </div>

    <div class="form-field">
      <label for="ano_fundacao">Ano de Fundação:</label>
      <input type="number" id="ano_fundacao" name="ano_fundacao" required>
    </div>

    <div class="form-field">
      <label for="categoria_id">Categoria:</label>
      <select id="categoria_id" name="categoria_id" required>
        <?php foreach ($data['categorias'] as $cat) { ?>
          <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['categoria']); ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="form-actions">
      <button class="button" type="submit">Criar Veículo</button>
      <a class="button button-secondary" href="<?php echo $url_alias; ?>/veiculo">Voltar</a>
    </div>
  </form>
</section>
<?php require 'app/views/layout/footer.php'; ?>
