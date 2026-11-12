<?php
$pageTitle = 'Autores | Gestão de Veículos';
require 'app/views/layout/header.php';
?>
<section class="page-heading">
  <div>
    <p class="eyebrow">Projeto Programação Web</p>
    <h1>Autores</h1>
    <p>Elementos da equipa responsável pelo projeto.</p>
  </div>
</section>

<section class="author-grid" aria-label="Autores do projeto">
  <article class="author-card">
    <h2>Eduardo Oliveira</h2>
    <dl>
      <div><dt>Número de aluno</dt><dd>33137</dd></div>
      <div><dt>Curso</dt><dd>EXGM</dd></div>
    </dl>
  </article>
  <article class="author-card">
    <h2>Nome do autor</h2>
    <dl>
      <div><dt>Número de aluno</dt><dd>A preencher</dd></div>
      <div><dt>Curso</dt><dd>A preencher</dd></div>
    </dl>
  </article>
</section>
<?php require 'app/views/layout/footer.php'; ?>
