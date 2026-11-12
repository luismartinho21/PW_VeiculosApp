<?php
namespace app\models;

use app\core\Db;

class Utilizadores {
  public static function findByEmail(string $email) {
    $conn = new Db();
    $result = $conn->execQuery(
      'SELECT id, nome, email, password_hash FROM utilizadores WHERE email = ? LIMIT 1',
      ['s', [$email]]
    );
    return $result[0] ?? null;
  }

  public static function createUser(string $nome, string $email, string $password) {
    $conn = new Db();
    $hash = password_hash($password, PASSWORD_DEFAULT);
    return $conn->execQuery(
      'INSERT INTO utilizadores (nome, email, password_hash) VALUES (?, ?, ?)',
      ['sss', [$nome, $email, $hash]]
    );
  }
}