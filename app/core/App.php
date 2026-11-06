<?php
namespace app\core;

/**
 * Classe principal do Routing MVC:
 * Responsável por decompor o URL e despachar para o respetivo Controller e Método.
 */
class App {
  private $controller;
  private $method;
  private $params;
  private $URLArray;
  private $startIndexFromUrl;
  private $pageNotFound;

  public function __construct() {
    $this->controller = 'Home';
    $this->method = 'index';
    $this->params = [];

    // Determina dinamicamente o índice inicial do URL consoante o caminho da pasta
    $baseDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $this->startIndexFromUrl = !empty($baseDir) ? count(explode('/', $baseDir)) : 0;

    $this->pageNotFound = false;
    $this->parseURL();
    $this->setController();
    $this->setMethodFromUrl();
    $this->setParamsFromUrl();

    // Invoca dinamicamente o método do controlador com os parâmetros
    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  private function parseURL() {
    $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $trimmed = trim($uriPath, '/');
    $this->URLArray = !empty($trimmed) ? explode('/', $trimmed) : [];
  }

  private function setController() {
    $controller = isset($this->URLArray[$this->startIndexFromUrl]) ? $this->URLArray[$this->startIndexFromUrl] : '';
    if (!empty($controller)) {
      $classCandidate = ucfirst($controller);
      if (file_exists('app/controllers/' . $classCandidate . '.php')) {
        $this->controller = $classCandidate;
      } else {
        $this->pageNotFound = true;
      }
    }
    require_once('app/controllers/' . $this->controller . '.php');
    $this->controller = new $this->controller();
  }

  private function setMethodFromUrl() {
    $url = $this->URLArray;
    $startIndex = $this->startIndexFromUrl + 1;

    if (isset($url[$startIndex]) && !empty($url[$startIndex])) {
      if (method_exists($this->controller, $url[$startIndex]) && !$this->pageNotFound) {
        $this->method = $url[$startIndex];
      } else {
        $this->method = 'pageNotFound';
      }
    }
  }

  private function setParamsFromUrl() {
    $url = $this->URLArray;
    $startIndex = $this->startIndexFromUrl + 2;
    if (count($url) > $startIndex) {
      $this->params = array_slice($url, $startIndex);
    }
  }
}
