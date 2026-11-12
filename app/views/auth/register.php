<?php
$pageTitle = 'Criar Conta | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="form-section auth-section">
  <p class="eyebrow">Novo Utilizador</p>
  <h1>Criar Conta</h1>
  <p class="auth-subtitle">Regista-te gratuitamente para gerir o catálogo de veículos.</p>

  <?php if (!empty($data['error'])) { ?>
    <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($data['error']); ?></p>
  <?php } ?>

  <form class="vehicle-form" action="<?php echo $url_alias; ?>/auth/register" method="POST">
    <div class="form-field">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($data['nome'] ?? ''); ?>" placeholder="O teu nome" required>
    </div>

    <div class="form-field">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" placeholder="exemplo@ecgm.pt" required>
    </div>

    <div class="form-field">
      <label for="password">Palavra-passe (mín. 6 caracteres):</label>
      <input type="password" id="password" name="password" minlength="6" required>
    </div>

    <div class="form-field">
      <label for="password_confirm">Confirmar Palavra-passe:</label>
      <input type="password" id="password_confirm" name="password_confirm" minlength="6" required>
    </div>

    <div class="form-actions">
      <button class="button" type="submit">Registar Conta</button>
      <a class="button button-secondary" href="<?php echo $url_alias; ?>/auth/login">Já tenho conta</a>
    </div>
  </form>
</section>
<?php require 'app/views/layout/footer.php'; ?>