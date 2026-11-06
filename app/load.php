<?php
/**
 * AUTOLOADER
 * Regista a função de carregamento automático de classes baseadas no namespace.
 */
spl_autoload_register(function ($filename) {
  $file = $filename . '.php';
  $file = str_replace('\\', '/', $file);
  if (file_exists($file)) {
    require_once $file;
  } else {
    echo "Debug: Erro na importação do ficheiro: " . htmlspecialchars($file);
  }
});
