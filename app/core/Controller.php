<?php
namespace app\core;

/**
 * Superclasse base para todos os Controllers.
 */
class Controller {

  /**
   * Instancia dinamicamente uma classe Model
   */
  public function model($model) {
    require_once 'app/models/' . $model . '.php';
    $classe = 'app\\models\\' . $model;
    return new $classe();
  }

  /**
   * Carrega uma View e disponibiliza $data e $url_alias
   */
  public function view(string $view, $data = []) {
    $baseDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $url_alias = !empty($baseDir) ? '/' . $baseDir : '';
    require 'app/views/' . $view . '.php';
  }

  /**
   * Fallback de página não encontrada (404)
   */
  public function pageNotFound() {
    $this->view('erro404');
  }
}
