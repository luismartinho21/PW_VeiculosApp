<?php
namespace app\core;

use mysqli;

/**
 * Classe responsável pela conexão com a Base de Dados MySQL
 * e execução segura de queries preparadas (Prepared Statements).
 */
class Db {
  private $DBServer;
  private $DBName;
  private $conn;

  public function __construct() {
    $this->DBServer = 'localhost';
    $this->DBName   = 'vehiclesdb';

    // Suporta as credenciais da aula ('ecgm' / 'nenhuma') e o padrão do XAMPP ('root' / '')
    mysqli_report(MYSQLI_REPORT_OFF);
    $this->conn = @new mysqli($this->DBServer, 'ecgm', 'nenhuma', $this->DBName);
    if ($this->conn->connect_errno) {
      $this->conn = @new mysqli($this->DBServer, 'root', '', $this->DBName);
    }

    if ($this->conn->connect_errno) {
      die("Erro na ligação à base de dados MySQL (vehiclesdb): " . $this->conn->connect_error);
    }
    $this->conn->set_charset("utf8mb4");
  }

  private function setParameters($stmt, array $parameters) {
    if (count($parameters) >= 2 && !empty($parameters[0])) {
      $types = $parameters[0];
      $values = $parameters[1];
      $stmt->bind_param($types, ...$values);
    }
  }

  public function execQuery(string $sql, array $parameters = []) {
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
      die("Erro na preparação SQL: " . $this->conn->error . " (Query: $sql)");
    }

    $this->setParameters($stmt, $parameters);
    $stmt->execute();

    $trimmed = strtoupper(trim($sql));
    if (strpos($trimmed, 'SELECT') === 0) {
      $result = $stmt->get_result();
      return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    } elseif (strpos($trimmed, 'INSERT') === 0) {
      return ['insert_id' => $this->conn->insert_id];
    } elseif (strpos($trimmed, 'UPDATE') === 0 || strpos($trimmed, 'DELETE') === 0) {
      return ['affected_rows' => $stmt->affected_rows];
    }

    return null;
  }
}
