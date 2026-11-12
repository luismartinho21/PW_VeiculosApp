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

  public function index() {
    $Veiculos = $this->model('Veiculos');
    $data = $Veiculos::getAllVeiculos();
    $this->view('veiculo/index', ['veiculos' => $data]);
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
      $this->view('veiculo/index', ['veiculos' => $data, 'info' => $newVeiculo, 'type' => 'INSERT']);
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
      $this->view('veiculo/index', ['veiculos' => $data, 'info' => $updatedData, 'type' => 'UPDATE']);
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
      $this->view('veiculo/index', ['veiculos' => $all, 'info' => $data[0] ?? ['marca' => 'Veículo'], 'type' => 'DELETE']);
    } else {
      $this->pageNotFound();
    }
  }
}