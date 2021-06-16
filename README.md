# Fut Agenda 

Este repositório contém os arquivos de uma aplicação, chamada por 'Fut-Agenda', que pode cadastrar jogadores de futebol society e sortear equipes, baseado em um número fixo de jogadores permitidos por time, levando em consideração o nível de habilidade de cada atleta. Segue a descrição do desafio:

" Um grupo de amigos, desenvolvedores, resolveram jogar futebol toda semana em um campo Society de 
Poços de Caldas. 

Após montar um grupo no WhatsApp com 25 pessoas, perceberam duas coisas:

1. Em média 15 a 17 pessoas confirmavam presença no jogo.

2. Sempre perdiam 10 minutos de jogo para escolher os times com 5 jogadores de linha e 1 goleiro.
Logo ficou claro que poderiam desenvolver uma aplicação que sorteasse as equipes, com base nas 
habilidades de cada jogador e assim poupar tempo."

Foi utilizado o [Laravel Framework](https://laravel.com/) na versão 8 e o deploy da aplicação aconteceu na Heroku

[Clique aqui para ver](http://fut-agenda.herokuapp.com/login)

Seguem abaixo os requisitos e procedimentos para instalação do projeto em ambiente de desenvolvimento, e observações gerais:


## Requisitos de Ambiente

PHP >= 7.3 

MySql >= 5.7

Phpmyadmin (Recomendado para criar e acessar banco de dados de forma visual no navegador)
    
[WampServer](https://www.wampserver.com/en/) (Recomendado pois este faz a instalação do servidor Apache PHP, Mysql, Phpmyadmin)

[Composer](https://getcomposer.org/) 

## Como instalar o projeto 

<ul>
    <li>Clone este repositório, e coloque a pasta do projeto na pasta pública do servidor PHP. "C:\wamp64\www\*" caso utilizar o WampServer ou "C:\xampp\htdocs\*" caso utilizar o Xamp Server.</li>
    <li>Crie um banco de dados Mysql para o projeto</li>
    <li>Acesse a pasta do projeto através de algum terminal de comandos, e crie um arquivo .env para configurar as variáveis de ambiente, pelo comando: </li>
</ul>

    cp .env.example .env     
<ul>
    <li>Configure as seguintes variáveis do arquivo .env de acordo à seu ambiente, em algum editor de texto: </li>
</ul>

    APP_URL=http://localhost/fut-agenda/public/ (Url completa do projeto em seu ambiente)
    DB_HOST=127.0.0.1 (com o host banco de dados)
    DB_PORT=3306 (com a porta do host do banco de dados)
    DB_DATABASE=desafio (com o nome do banco de dados)
    DB_USERNAME=root (com o nome do usuário com acesso ao banco de dados) 
    DB_PASSWORD= (com a senha do usuário com acesso ao banco de dados) 
 <ul>
    <li>Instale as  dependências do LARAVEL pelo comando: </li>
 </ul> 
 
    composer install    
    
<ul>
    <li>Gere a chave da aplicação pelo comando: </li>
</ul>
    
    php artisan key:generate

<ul>  
    <li>Gere as tabelas do banco de dados executando o comando: </li>
</ul>    
    
    php artisan migrate

## Observações e Orientações

Antes de tudo, para o usuário começar a usar o Fut Agenda, ele precisa cadastrar-se e fazer o login.

Para sortear os times, é necessário que sejam cadastrados todos os jogadores primeiro. E isso pode ser feito no menu 'Jogadores'. Onde você pode cadastra-los por nome, nível de habilidade e se é goleiro.

<img src="/public/assets/criar-player.PNG"> 

Ao entrar no menu de 'Partidas', é possivel primeiro visualizar o histórico de partidas salvas por aquele usuário.

Para então sortear os times, o usuario precisa adicionar uma nova partida, descrevendo ela com nome, e definindo um número de jogadores por time. Depois, é necessário checar os jogadores que então marcaram a presença
 
<img src="/public/assets/criar.PNG">

## Validações esperadas ao sortear uma equipe

Caso não sejam preenchidos os dados obrigatórios, será retornado na tela via modal, as mensagens informando o que falta para concluir:

<img src="/public/assets/validacoes.PNG"> 

Para atender os requisitos do projeto, as validações foram criadas para atende-los e o retorno delas vai ser exibido neste mesmo modal 

Por exemplo, 'não permitir que um time tenha mais de 1 goleiro'

<img src="/public/assets/goleiros.PNG"> 

ou que os pesos das habilidades de cada time ficou desbalanceada

<img src="/public/assets/desbalanceado.PNG"> 

*Neste caso optei por mostrar dessa forma para ficar claro que o requisito de não gerar times muito fracos ou muito fortes foi atendido
, e quando isto acontecer, é necessário que o usuário clique em sortear novamente. O fator para considerar muito forte ou fraco, é a diferença percentual entre as equipe completadas, a mais fraca e forte, for superior à 25% de peso somatório das habilidades de seus integrantes. E quando isto ocorrer, é necessário ser sorteado novamente os times.

## Pré visualiação dos times sorteados 

É permitido ao usuário pré visualizar os times e sortear novamente, e caso queira deixar registrado no histórico, basta clicar em 'salvar'

<img src="/public/assets/gerado.PNG">  
