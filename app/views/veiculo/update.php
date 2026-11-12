<?php
$pageTitle = 'Editar veículo | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="form-section">
  <p class="eyebrow">Atualizar registo</p>
  <h1>Editar Veículo</h1>
  <form class="vehicle-form" action="<?php echo $url_alias; ?>/veiculo/update/<?php echo $data['veiculo'][0]['id']; ?>" method="POST">
    <div class="form-field">
      <label for="marca">Marca:</label>
      <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($data['veiculo'][0]['marca']); ?>" required>
    </div>

    <div class="form-field">
      <label for="pais_origem">País de Origem:</label>
      <input type="text" id="pais_origem" name="pais_origem" value="<?php echo htmlspecialchars($data['veiculo'][0]['pais_origem']); ?>" required>
    </div>

    <div class="form-field">
      <label for="ano_fundacao">Ano de Fundação:</label>
      <input type="number" id="ano_fundacao" name="ano_fundacao" value="<?php echo htmlspecialchars($data['veiculo'][0]['ano_fundacao']); ?>" required>
    </div>

    <div class="form-field">
      <label for="categoria_id">Categoria:</label>
      <select id="categoria_id" name="categoria_id" required>
        <?php foreach ($data['categorias'] as $cat) {?>
          <option value="<?php echo $cat['id']; ?>" <?php echo ($data['veiculo'][0]['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($cat['categoria']); ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="form-actions">
      <button class="button" type="submit">Atualizar Veículo</button>
      <a class="button button-secondary" href="<?php echo $url_alias; ?>/veiculo">Voltar</a>
    </div>
  </form>
</section>
<?php require 'app/views/layout/footer.php'; ?>
