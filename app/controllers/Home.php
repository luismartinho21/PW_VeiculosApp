<?php
use app\core\Controller;

class Home extends Controller {
  public function index() {
    $Veiculos = $this->model('Veiculos');
    $stats = $Veiculos::getStats();
    $this->view('home/index', ['stats' => $stats]);
  }

  public function autores() {
    $this->view('home/autores');
  }
}