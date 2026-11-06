<?php
namespace app\models;

use app\core\Db;

class Categorias {
  public static function getAllCategorias() {
    $conn = new Db();
    return $conn->execQuery('SELECT id, categoria FROM categorias');
  }
}
