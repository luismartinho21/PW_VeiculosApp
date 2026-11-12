<?php
use app\core\Controller;

class Auth extends Controller {

  public function index() {
    $this->login();
  }

  public function login() {
    if (!empty($_SESSION['user'])) {
      $this->redirect('/veiculo');
    }

    $error = null;
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = trim($_POST['email'] ?? '');
      $password = $_POST['password'] ?? '';

      if ($email === '' || $password === '') {
        $error = 'Preenche o email e a palavra-passe.';
      } else {
        $Utilizadores = $this->model('Utilizadores');
        $user = $Utilizadores::findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
          session_regenerate_id(true);
          $_SESSION['user'] = [
            'id'    => $user['id'],
            'nome'  => $user['nome'],
            'email' => $user['email']
          ];
          $_SESSION['flash_notice'] = 'Bem-vindo de volta, ' . $user['nome'] . '!';
          $this->redirect('/veiculo');
        } else {
          $error = 'Email ou palavra-passe incorretos.';
        }
      }
    }

    $this->view('auth/login', ['error' => $error, 'email' => $email]);
  }

  public function register() {
    if (!empty($_SESSION['user'])) {
      $this->redirect('/veiculo');
    }

    $error = null;
    $nome = '';
    $email = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nome = trim($_POST['nome'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $password = $_POST['password'] ?? '';
      $passwordConfirm = $_POST['password_confirm'] ?? '';

      if (mb_strlen($nome) < 2) {
        $error = 'O nome deve ter pelo menos 2 caracteres.';
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Introduz um endereço de email válido.';
      } elseif (strlen($password) < 6) {
        $error = 'A palavra-passe deve ter pelo menos 6 caracteres.';
      } elseif ($password !== $passwordConfirm) {
        $error = 'As palavras-passe não coincidem.';
      } else {
        $Utilizadores = $this->model('Utilizadores');
        if ($Utilizadores::findByEmail($email)) {
          $error = 'Já existe uma conta registada com esse email.';
        } else {
          $res = $Utilizadores::createUser($nome, $email, $password);
          if (!empty($res['insert_id'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
              'id'    => $res['insert_id'],
              'nome'  => $nome,
              'email' => $email
            ];
            $_SESSION['flash_notice'] = 'Conta criada com sucesso! Bem-vindo, ' . $nome . '.';
            $this->redirect('/veiculo');
          } else {
            $error = 'Ocorreu um erro ao criar a conta. Tenta novamente.';
          }
        }
      }
    }

    $this->view('auth/register', [
      'error' => $error,
      'nome'  => $nome,
      'email' => $email
    ]);
  }

  public function logout() {
    $_SESSION = [];
    session_destroy();
    session_start();
    $_SESSION['flash_notice'] = 'Sessão terminada com sucesso.';
    $this->redirect('/auth/login');
  }

  private function redirect(string $path) {
    $baseDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
    $urlAlias = !empty($baseDir) ? '/' . $baseDir : '';
    header('Location: ' . $urlAlias . $path);
    exit;
  }
}