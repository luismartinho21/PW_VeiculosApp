<?php
use app\core\Controller;

class Veiculo extends Controller {

  /**
   * Invocação da view index.php (Lista de veículos)
   */
  public function index() {
    $Veiculos = $this->model('Veiculos');
    $data = $Veiculos::getAllVeiculos();
    $this->view('veiculo/index', ['veiculos' => $data]);
  }

  /**
   * Invocação da view get.php (Detalhes de um veículo)
   */
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

  /**
   * Criação de um novo veículo
   */
  public function create() {
    $Veiculos = $this->model('Veiculos');
    $Categorias = $this->model('Categorias');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $newVeiculo = [
        'marca'        => $_POST['marca'],
        'pais_origem'  => $_POST['pais_origem'],
        'ano_fundacao' => $_POST['ano_fundacao'],
        'categoria_id' => $_POST['categoria_id']
      ];
      $info = $Veiculos::addVeiculo($newVeiculo);

      $data = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', ['veiculos' => $data, 'info' => $newVeiculo, 'type' => 'INSERT']);
    } else {
      $categorias = $Categorias::getAllCategorias();
      $this->view('veiculo/create', ['categorias' => $categorias]);
    }
  }

  /**
   * Edição de um veículo existente
   */
  public function update($id = null) {
    $Veiculos = $this->model('Veiculos');
    $Categorias = $this->model('Categorias');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $updatedData = [
        'marca'        => $_POST['marca'],
        'pais_origem'  => $_POST['pais_origem'],
        'ano_fundacao' => $_POST['ano_fundacao'],
        'categoria_id' => $_POST['categoria_id']
      ];
      $info = $Veiculos::updateVeiculo((int)$id, $updatedData);

      $data = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', ['veiculos' => $data, 'info' => $updatedData, 'type' => 'UPDATE']);
    } else {
      $data = $Veiculos::findVeiculoById((int)$id);
      $categorias = $Categorias::getAllCategorias();
      $this->view('veiculo/update', ['veiculo' => $data, 'categorias' => $categorias]);
    }
  }

  /**
   * Eliminação de um veículo
   */
  public function delete($id = null) {
    if (is_numeric($id)) {
      $Veiculos = $this->model('Veiculos');
      $data = $Veiculos::findVeiculoById((int)$id);
      $info = $Veiculos::deleteVeiculo((int)$id);

      $all = $Veiculos::getAllVeiculos();
      $this->view('veiculo/index', ['veiculos' => $all, 'info' => $data[0] ?? ['marca' => 'Veículo'], 'type' => 'DELETE']);
    } else {
      $this->pageNotFound();
    }
  }
}
