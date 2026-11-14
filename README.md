# Gestão de Veículos (`PW_VeiculosApp`)

Aplicação web desenvolvida em **PHP nativo (arquitetura MVC)** e **MySQL** para gestão, pesquisa e catalogação histórica de marcas de veículos terrestres, marítimos e aéreos.

Projeto desenvolvido no âmbito da unidade curricular de **Programação Web** — Curso de **ECGM** (IPVC - ESTG).

---

## Links Rápidos de Acesso (Ambiente Local XAMPP)

| Recurso | Endereço / Link | Descrição |
| :--- | :--- | :--- |
| **Página Inicial (Dashboard)** | http://localhost/PW_VeiculosApp/ | Resumo estatístico em tempo real e atalhos rápidos |
| **Catálogo de Veículos** | http://localhost/PW_VeiculosApp/veiculo | Lista completa, pesquisa, filtros e favoritos |
| **Adicionar Veículo** | http://localhost/PW_VeiculosApp/veiculo/create | Formulário de criação (requer sessão iniciada) |
| **Iniciar Sessão** | http://localhost/PW_VeiculosApp/auth/login | Autenticação de utilizadores |
| **Registar Conta** | http://localhost/PW_VeiculosApp/auth/register | Criação de nova conta de utilizador |
| **Autores do Projeto** | http://localhost/PW_VeiculosApp/home/autores | Informação da equipa (ECGM) |
| **phpMyAdmin (Geral)** | http://localhost/phpmyadmin/ | Painel de gestão do servidor MySQL/MariaDB |
| **Base de Dados (`vehiclesdb`)** | http://localhost/phpmyadmin/index.php?route=/database/structure&db=vehiclesdb | Acesso direto às tabelas da aplicação |
| **Pasta Local do Projeto** | `C:\xampp\htdocs\PW_VeiculosApp` | Diretório raiz no servidor local |
| **Script SQL da BD** | `sql/vehiclesdb.sql` | Ficheiro de criação e povoamento da base de dados |

---

## Funcionalidades Principais

* **Catálogo Interativo:** Visualização em grelha responsiva com temas visuais por categoria (*Terrestre*, *Marítimo* e *Aéreo*) e cartões totalmente clicáveis para consulta de detalhes.
* **Dashboard de Estatísticas na Página Inicial:** Resumo dinâmico com total de marcas registadas, contagem por categoria, marca mais antiga do catálogo e atalhos diretos que aplicam pré-filtros no catálogo via URL (`?categoria=` e `?q=`).
* **Pesquisa e Filtragem em Tempo Real:** Pesquisa instantânea sem acentos por marca, país ou ano de fundação, combinada com filtro por categoria e filtro de favoritos.
* **Autenticação e Controlo de Acessos:** Registo e início de sessão seguros (`password_hash` / `password_verify` e gestão via `$_SESSION`), protegendo as operações de criação, edição e eliminação de veículos.
* **Sistema de Favoritos por Utilizador:** Gravação assíncrona (`Fetch API` / JSON) na tabela associativa `favoritos`, permitindo marcar e filtrar os veículos favoritos de cada utilizador autenticado.
* **Interface Moderna e Acessível:** Tema Claro / Escuro (*Dark Mode*) persistente em `localStorage`, modal de confirmação personalizado para eliminação, alertas (*toasts*) automáticos e validação de formulários no cliente.

---

## Tecnologias e Documentação Oficial

* **Servidor Local:** [XAMPP (Apache + MariaDB/MySQL + PHP 8+)](https://www.apachefriends.org/)
* **Linguagem Backend:** [PHP 8+ (arquitetura MVC própria com Front Controller e Prepared Statements)](https://www.php.net/docs.php)
* **Base de Dados:** [MySQL / MariaDB](https://dev.mysql.com/doc/) gerida via [phpMyAdmin](http://localhost/phpmyadmin/)
* **Frontend:** [HTML5 Semântico](https://developer.mozilla.org/pt-PT/docs/Web/HTML), [CSS3 (Variáveis CSS, Grid, Flexbox)](https://developer.mozilla.org/pt-PT/docs/Web/CSS) e [JavaScript ES6+ (`Fetch API`)](https://developer.mozilla.org/pt-PT/docs/Web/API/Fetch_API)

---

## Instalação e Configuração Local (XAMPP)

1. **Colocar o projeto** dentro da pasta `htdocs` do XAMPP:
   ```text
   C:\xampp\htdocs\PW_VeiculosApp