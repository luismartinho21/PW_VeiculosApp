# VehiclesApp - Aplicação Web em PHP [POO + MVC]

Trabalho Prático #1 de **Programação Web** (3º Ano - 1º Semestre)  
**Curso:** Engenharia de Computação Gráfica e Multimédia (ECGM) - IPVC

## Descrição do Projeto
Aplicação web informativa sobre marcas e veículos motorizados de três meios fundamentais: **Terrestre**, **Aéreo** e **Marítimo**.
O projeto foi desenvolvido segundo a arquitetura **Model-View-Controller (MVC)** em PHP com **Programação Orientada a Objetos (POO)** e ligação a **MySQL** via driver **MySQLi**.

## Funcionalidades
- CRUD completo (Create, Read, Update, Delete) de veículos motorizados;
- Associação relacional entre veículos e as suas categorias (Terrestre, Aéreo, Marítimo);
- Front Controller com encaminhamento dinâmico de URLs através de `.htaccess` e classe `App`;
- Separação em camadas de responsabilidade: Models, Views, Controllers e Core.

## Configuração do Ambiente Local
1. Colocar o projeto na pasta do servidor web (ex: `C:/xampp/htdocs/PW/vehiclesapp`);
2. Iniciar os serviços **Apache** e **MySQL** no XAMPP;
3. Importar a base de dados localizada em `sql/vehiclesdb.sql`;
4. Aceder no browser a:
   `http://localhost/PW/vehiclesapp/`
