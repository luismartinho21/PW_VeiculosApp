<meta charset="utf-8">
<h2>Criar Novo Veículo</h2>

<form action="<?php echo $url_alias;?>/veiculo/create" method="POST">
  <label for="marca">Marca:</label>
  <input type="text" id="marca" name="marca" required><br><br>

  <label for="pais_origem">País de Origem:</label>
  <input type="text" id="pais_origem" name="pais_origem" required><br><br>

  <label for="ano_fundacao">Ano de Fundação:</label>
  <input type="number" id="ano_fundacao" name="ano_fundacao" required><br><br>

  <label for="categoria_id">Categoria:</label>
  <select id="categoria_id" name="categoria_id" required>
    <?php foreach ($data['categorias'] as $cat) { ?>
      <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['categoria']); ?></option>
    <?php } ?>
  </select><br><br>

  <button type="submit">Criar Veículo</button>
</form>
<br>
<a href="<?php echo $url_alias;?>/veiculo">Voltar</a>
