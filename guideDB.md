# Configuração da Base de Dados (vehiclesdb)
O ficheiro `vehiclesdb.sql`, disponibilizado na pasta `sql/`, deve ser importado para o MySQL.

## Estrutura da Base de Dados
A base de dados `vehiclesdb` é composta por 2 tabelas principais:
1. `categorias`: Meios de locomoção dos veículos (Terrestre, Aéreo, Marítimo);
2. `veiculos`: Informação das marcas de veículos motorizados (marca, país de origem, ano de fundação e categoria_id).

## Instruções de Importação:
No MySQL / phpMyAdmin ou via terminal:
```sql
SOURCE sql/vehiclesdb.sql;
```
