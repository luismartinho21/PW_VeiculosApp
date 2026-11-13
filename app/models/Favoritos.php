<?php
namespace app\models;

use app\core\Db;

class Favoritos {
  public static function getIdsByUser(int $userId): array {
    $conn = new Db();
    $rows = $conn->execQuery(
      'SELECT veiculo_id FROM favoritos WHERE utilizador_id = ?',
      ['i', [$userId]]
    );
    return array_map(static fn($r) => (int)$r['veiculo_id'], $rows);
  }

  public static function toggle(int $userId, int $veiculoId): bool {
    $conn = new Db();
    $exists = $conn->execQuery(
      'SELECT 1 FROM favoritos WHERE utilizador_id = ? AND veiculo_id = ? LIMIT 1',
      ['ii', [$userId, $veiculoId]]
    );

    if (!empty($exists)) {
      $conn->execQuery(
        'DELETE FROM favoritos WHERE utilizador_id = ? AND veiculo_id = ?',
        ['ii', [$userId, $veiculoId]]
      );
      return false;
    } else {
      $conn->execQuery(
        'INSERT INTO favoritos (utilizador_id, veiculo_id) VALUES (?, ?)',
        ['ii', [$userId, $veiculoId]]
      );
      return true;
    }
  }
}
