<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$banco = 'aula';

//1. string de conexão
//2. usuário
//3. senha
$conexao = new \PDO("mysql:host=$host;dbname=$banco", $user, $pass);