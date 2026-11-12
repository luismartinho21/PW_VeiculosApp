<?php
use app\core\Controller;

class Home extends Controller {
  // Invocação da view index.php de /home
  public function index() {
    $this->view('home/index');
  }

  public function autores() {
    $this->view('home/autores');
  }
}
