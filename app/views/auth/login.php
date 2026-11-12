<?php
$pageTitle = 'Iniciar Sessão | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="form-section auth-section">
  <p class="eyebrow">Área Reservada</p>
  <h1>Iniciar Sessão</h1>
  <p class="auth-subtitle">Acede à tua conta para adicionar, editar ou gerir veículos no catálogo.</p>

  <?php if (!empty($_SESSION['flash_notice'])) { ?>
    <p class="notice" role="status"><?php echo htmlspecialchars($_SESSION['flash_notice']); unset($_SESSION['flash_notice']); ?></p>
  <?php } ?>

  <?php if (!empty($data['error'])) { ?>
    <p class="notice notice-error" role="alert"><?php echo htmlspecialchars($data['error']); ?></p>
  <?php } ?>

  <form class="vehicle-form" action="<?php echo $url_alias; ?>/auth/login" method="POST">
    <div class="form-field">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>" placeholder="exemplo@ecgm.pt" required>
    </div>

    <div class="form-field">
      <label for="password">Palavra-passe:</label>
      <input type="password" id="password" name="password" placeholder="••••••" required>
    </div>

    <div class="form-actions">
      <button class="button" type="submit">Entrar</button>
      <a class="button button-secondary" href="<?php echo $url_alias; ?>/auth/register">Criar conta nova</a>
    </div>
  </form>
</section>
<?php require 'app/views/layout/footer.php'; ?>