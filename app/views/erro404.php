<!doctype html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Página Não Encontrada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
  <div class="container text-center py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <i class="bi bi-exclamation-triangle-fill text-warning display-1"></i>
        <h1 class="display-4 fw-bold mt-3">404</h1>
        <p class="lead text-muted">A página ou recurso que procuras não existe ou foi removido.</p>
        <a href="<?php echo $url_alias; ?>/" class="btn btn-primary px-4 py-2 mt-2">
          <i class="bi bi-house-door me-2"></i>Voltar ao Início
        </a>
      </div>
    </div>
  </div>
</body>
</html>
