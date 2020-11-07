![PHP and MySql](https://kroton.vteximg.com.br/arquivos/ids/156096-500-326/image-b041dffabd7b4dd5a3bda8c9a5cf5377.jpg?v=636003860955930000)
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
Para acessar as informações dos funcionários é necessário utilizar:

```sh
$ .../API/funcionario/<...>.php
```

| Página | Entradas | Saídas |
| ------ | ------ | ------ |
| validateFunc.php | E-mail(mail) e senha(password) | Code, id, name, mail e  menssage |
| includeFunc.php | Nome(name), e-mail(mail), senha(password) e ID do hotel(hotel_id) | Code e menssage |
| getInfoFunc.php | ID(id) | Code, name, email, comission e message |
| deleteFunc.php | ID(id) | Code e menssage |
| InsertComissionFunc.php | ID(id), Valor da comissão(value) e ID do hotel(hotel_id) | Code e menssage |

**Lembrando que é necessário ter um Hotel cadastrado no sistema, para atribuir ao funcionário**

# Quarto
Para acessar as informações dos quartos é necessário utilizar:
```sh
$ .../API/quarto/<...>.php
```

| Página | Entradas | Saídas |
| ------ | ------ | ------ |
| getQuarto.php | ID(id) | Tipo, valorDiária e lucroOp |
| includeQuarto.php | ID do hotel(hotel), tipo(tipo) e valorDiária(valorDiaria) | Code e menssage |
| includeLucro.php | ID do Quarto(id) e valor do Lucro(value) | Code e menssage |

**Lembrando que é necessário ter um Hotel cadastrado no sistema, para atribuir ao quarto**

# Hotel
Para acessar as informações do hotel é necessário utilizar:
```sh
$ .../API/hotel/<...>.php
```

| Página | Entradas | Saídas |
| ------ | ------ | ------ |
| getHotel.php | ID(id) | Code, id, receita, qtdeQuartos, lucro, comissaoGeral, quartosVendidos, nome |
| includeHotel.php | Nome(name) | Code e menssage |
| updateReceita.php | ID(id) e Valor da receita(value) | Code e menssage |
| updateLucro.php | ID(id) e Valor do Lucro(value) | Code e menssage |
| updateQuartosVendidos.php | ID(id) e Valor da quantidade de quartos vendidos(value) | Code e menssage |
| revPar.php | ID do hotel(id) | Code, menssage e value |
| netRevPar.php | ID do hotel(id) | Code, menssage e value |
| diariaMedia.php | ID do hotel(id) | Code, menssage e value |
| taxaOcupacao.php | ID do hotel(id) | Code, menssage e value |
