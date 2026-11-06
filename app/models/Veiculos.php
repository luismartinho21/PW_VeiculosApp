<?php
namespace app\models;

use app\core\Db;

class Veiculos {

  public static function getAllVeiculos() {
    $conn = new Db();
    $sql = 'SELECT v.id, v.marca, v.pais_origem, v.ano_fundacao, v.categoria_id, c.categoria
            FROM veiculos v
            INNER JOIN categorias c ON v.categoria_id = c.id
            ORDER BY v.id ASC';
    return $conn->execQuery($sql);
  }

  public static function findVeiculoById(int $id) {
    $conn = new Db();
    $sql = 'SELECT v.id, v.marca, v.pais_origem, v.ano_fundacao, v.categoria_id, c.categoria
            FROM veiculos v
            INNER JOIN categorias c ON v.categoria_id = c.id
            WHERE v.id = ?';
    return $conn->execQuery($sql, ['i', [$id]]);
  }

  public static function addVeiculo($data) {
    $conn = new Db();
    $sql = 'INSERT INTO veiculos (marca, pais_origem, ano_fundacao, categoria_id)
            VALUES (?, ?, ?, ?)';
    return $conn->execQuery($sql, [
      'ssii',
      [
        $data['marca'],
        $data['pais_origem'],
        $data['ano_fundacao'],
        $data['categoria_id']
      ]
    ]);
  }

  public static function updateVeiculo($id, $data) {
    $conn = new Db();
    $sql = 'UPDATE veiculos
            SET marca = ?, pais_origem = ?, ano_fundacao = ?, categoria_id = ?
            WHERE id = ?';
    return $conn->execQuery($sql, [
      'ssiii',
      [
        $data['marca'],
        $data['pais_origem'],
        $data['ano_fundacao'],
        $data['categoria_id'],
        $id
      ]
    ]);
  }

  public static function deleteVeiculo($id) {
    $conn = new Db();
    return $conn->execQuery('DELETE FROM veiculos WHERE id = ?', ['i', [$id]]);
  }
}
