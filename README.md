![PHP and MySql](https://lh3.googleusercontent.com/proxy/BMVyXlyiejS30FP1hLSv0KsQM922f5DVi_uQ8NhcDs9IuJo45JSTg-1DTaD4jHv_wmiKyR-_cQ4vn-AP8MfUQoX0fkq6OmdqvnOiu24Ihr_Ske8giDn2yKGRee1ftsSYC1VDoC-X-w)
# API Hotelaria

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

>Esse projeto foi feito para uma matéria da faculdade ETEP, onde nosso grupo deveria desenvolver uma aplicação de gerenciamentos de hotel. Nosso desafio era integrar o front-end da aplicação em React, com um back-end em php. Então fiquei responsável de desenvolver a API para fazer a comunicação entre os dois! Escolhi fazer a API do zero para aprender o funcionamento pleno de uma API e suas aplicações.

Abaixo segue algumas informações sobre

| Funções | Descrição |
| ------ | ------ |
| Funcionário | Todas as funcionalidades dos funcionários está contida nessa parte |
| Quarto | Todas as funcionalidades dos quartos está contida nessa parte |
| Hotel | Todas as funcionalidades do hotel está contida nessa parte |


Lembrando que a API sempre retorna dois códigos:
- Código 1 - A solicitação ocorreu com sucesso.
- Código 0 - Ocorreu um erro na solicitação.



# Funcionário
Para acessar as informações funcionários é necessário utilizar:

```sh
$ .../API/funcionario/<...>.php
```

| Página | Entradas | Saídas |
| ------ | ------ | ------ |
| validateFunc.php | E-mail e senha | Code, id, name, mail e  menssage |
| includeFunc.php | Nome, e-mail e senha | Code e menssage |
| getInfoFunc.php | ID | Code, name, email, comission e message |
| deleteFunc.php | ID | Code e menssage |
| InsertComissionFunc.php | ID e Valor da comissão | Code e menssage |

# Quarto
Para acessar as informações funcionários é necessário utilizar:
```sh
$ .../API/quarto/<...>.php
```

| Página | Entradas | Saídas |
| ------ | ------ | ------ |
| getQuarto.php | ID | Tipo, valorDiária e lucroOp |
| includeQuarto.php | Tipo e valorDiária | Code e menssage |
| includeLucro.php | ID e valor do Lucro | Code e menssage |


