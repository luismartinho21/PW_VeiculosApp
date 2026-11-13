<?php
namespace app\models;

use app\core\Db;

class Veiculos {
  public static function getAllVeiculos() {
    $conn = new Db();
    return $conn->execQuery(
      'SELECT v.id, v.marca, v.pais_origem, v.ano_fundacao, v.categoria_id, c.categoria
       FROM veiculos v
       INNER JOIN categorias c ON v.categoria_id = c.id
       ORDER BY v.id ASC'
    );
  }

  public static function findVeiculoById(int $id) {
    $conn = new Db();
    return $conn->execQuery(
      'SELECT id, marca, pais_origem, ano_fundacao, categoria_id FROM veiculos WHERE id = ?',
      ['i', [$id]]
    );
  }

  public static function addVeiculo(array $data) {
    $conn = new Db();
    return $conn->execQuery(
      'INSERT INTO veiculos (marca, pais_origem, ano_fundacao, categoria_id) VALUES (?, ?, ?, ?)',
      ['ssii', [$data['marca'], $data['pais_origem'], (int)$data['ano_fundacao'], (int)$data['categoria_id']]]
    );
  }

  public static function updateVeiculo(int $id, array $data) {
    $conn = new Db();
    return $conn->execQuery(
      'UPDATE veiculos SET marca = ?, pais_origem = ?, ano_fundacao = ?, categoria_id = ? WHERE id = ?',
      ['ssiii', [$data['marca'], $data['pais_origem'], (int)$data['ano_fundacao'], (int)$data['categoria_id'], $id]]
    );
  }

  public static function deleteVeiculo(int $id) {
    $conn = new Db();
    return $conn->execQuery(
      'DELETE FROM veiculos WHERE id = ?',
      ['i', [$id]]
    );
  }

  public static function getStats(): array {
    $conn = new Db();

    $totais = $conn->execQuery('SELECT COUNT(*) AS total FROM veiculos');
    $totalVeiculos = (int)($totais[0]['total'] ?? 0);

    $porCategoria = $conn->execQuery(
      'SELECT c.categoria, COUNT(v.id) AS total
       FROM categorias c
       LEFT JOIN veiculos v ON v.categoria_id = c.id
       GROUP BY c.id, c.categoria
       ORDER BY c.id ASC'
    );

    $maisAntiga = $conn->execQuery(
      'SELECT marca, pais_origem, ano_fundacao
       FROM veiculos
       WHERE ano_fundacao IS NOT NULL
       ORDER BY ano_fundacao ASC, marca ASC
       LIMIT 1'
    );

    return [
      'total'         => $totalVeiculos,
      'por_categoria' => $porCategoria,
      'mais_antiga'   => $maisAntiga[0] ?? null
    ];
  }
}