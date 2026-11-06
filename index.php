<?php
/**
 * FRONT CONTROLLER
 * Ponto de entrada único da aplicação MVC.
 */
require './app/load.php';

use app\core\App;

$app = new App();
