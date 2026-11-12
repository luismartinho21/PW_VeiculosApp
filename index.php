<?php
/**
 * FRONT CONTROLLER
 * Ponto de entrada único da aplicação MVC.
 */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require './app/load.php';

use app\core\App;

$app = new App();