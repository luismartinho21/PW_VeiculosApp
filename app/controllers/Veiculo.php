<?php
use app\core\Controller;

class Veiculo extends Controller {

  private function requireAuth() {
    if (empty($_SESSION['user'])) {
      $_SESSION['flash_notice'] = 'Inicia sessão para criar, editar ou eliminar veículos.';
      $baseDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
      $urlAlias = !empty($baseDir) ? '/' . $baseDir : '';
      header('Location: ' . $urlAlias . '/auth/login');
      exit;
    }
  }

  private function getUserFavoritos(): array {
    if (empty($_SESSION['user']['id'])) {
      return [];
    }
    $Favoritos = $this->model('Favoritos');
    return $Favoritos::getIdsByUser((int)$_SESSION['user']['id']);
  }

  public function index() {
    $Veiculos = $this->model('Veiculos');
    $data = $Veiculos::getAllVeiculos();
    $favoritosIds = $this->getUserFavoritos();
    $this->view('veiculo/index', [
      'veiculos'     => $data,
      'favoritosIds' => $favoritosIds
    ]);
  }

  public function get($id = null) {
    if (is_numeric($id)) {
      $Veiculos = $this->model('Veiculos');
      $Categorias = $this->model('Categorias');
      $data = $Veiculos::findVeiculoById((int)$id);
      $categorias = $Categorias::getAllCategorias();
      $this->view('veiculo/get', ['veiculos' => $data, 'categorias' => $categorias]);
    } else {
      $this->pageNotFound();
    }
  }

  public function favorite($id = null) {
    header('Content-Type: application/json; charset=utf-8');

    if (empty($_SESSION['user']['id'])) {
      http_response_code(401);
      echo json_encode(['ok' => false, 'error' => 'Não autenticado']);
      exit;
    }

    if (!is_numeric($id)) {
      http_response_code(400);
      echo json_encode(['ok' => false, 'error' => 'ID inválido']);
      exit;
    }

    $Favoritos = $this->model('Favoritos');
    $isFavorito = $Favoritos::toggle((int)$_SESSION['user']['id'], (int)$id);

    echo json_encode([
      'ok'        => true,
      'favorited' => $isFavorito
    ]);
    exit;
  }

  public function create() {
    $this->requireAuth();
    $Veiculos = $this->model('Veiculos');
    $Categorias = $this->model('Categorias');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newVeiculo = [
        'marca'        => $_POST['marca'],
        'pais_origem'  => $_POST['pais_origem'],
        'ano_fundacao' => $_POST['ano_fundacao'],
        'categoria_id' => $_POST['categoria_id']
      ];
      $Veiculos::addVeiculo($newVeiculo);

      $data = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', [
        'veiculos'     => $data,
        'favoritosIds' => $this->getUserFavoritos(),
        'info'         => $newVeiculo,
        'type'         => 'INSERT'
      ]);
    } else {
      $categorias = $Categorias::getAllCategorias();
      $this->view('veiculo/create', ['categorias' => $categorias]);
    }
  }

  public function update($id = null) {
    $this->requireAuth();
    $Veiculos = $this->model('Veiculos');
    $Categorias = $this->model('Categorias');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedData = [
        'marca'        => $_POST['marca'],
        'pais_origem'  => $_POST['pais_origem'],
        'ano_fundacao' => $_POST['ano_fundacao'],
        'categoria_id' => $_POST['categoria_id']
      ];
      $Veiculos::updateVeiculo((int)$id, $updatedData);

      $data = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', [
        'veiculos'     => $data,
        'favoritosIds' => $this->getUserFavoritos(),
        'info'         => $updatedData,
        'type'         => 'UPDATE'
      ]);
    } else {
      $data = $Veiculos::findVeiculoById((int)$id);
      $categorias = $Categorias::getAllCategorias();
      $this->view('veiculo/update', ['veiculo' => $data, 'categorias' => $categorias]);
    }
  }

  public function delete($id = null) {
    $this->requireAuth();
    if (is_numeric($id)) {
      $Veiculos = $this->model('Veiculos');
      $data = $Veiculos::findVeiculoById((int)$id);
      $Veiculos::deleteVeiculo((int)$id);

      $all = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', [
        'veiculos'     => $all,
        'favoritosIds' => $this->getUserFavoritos(),
        'info'         => $data[0] ?? ['marca' => 'Veículo'],
        'type'         => 'DELETE'
      ]);
    } else {
      $this->pageNotFound();
    }
  }
}