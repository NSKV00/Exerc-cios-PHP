<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$banco = 'aula';

//1. string de conexão
//2. usuário
//3. senha
$conexao = new \PDO("mysql:host=$host;dbname=$banco", $user, $pass);

//$sql = "SELECT * FROM itens";

// if ($_GET['id']){
//     $id = $_GET['id'];
//     $sql .= " WHERE id = $id";
// }
//$id = 4;
// $nome = 'nome qualquer';
// $consulta = $conexao -> prepare('SELECT * FROM itens WHERE id = :id AND nome = :nome');
// $consulta -> bindParam(':id', $id);
// $consulta -> bindParam(':nome', $nome, PDO::PARAM_STR);

$consulta -> execute();

foreach ($consulta as $resultado) {
    echo '<pre>';
    print_r($resultado);
    echo '</pre>';
}
//$consulta = $conexao -> query($sql);
//$consulta = $conexao -> query("SELECT * FROM itens WHERE id=$id");

while ($linha = $consulta -> fetch(\PDO::FETCH_OBJ)) {
    echo '<pre>';
    print_r($linha);
    echo '</pre>';
}

echo '<pre>';
print_r($conexao); 
echo '</pre>';

$criacao = $conexao -> prepare('INSERT INTO itens (nome, tamanho_stack, quantidade_stack, tipo, durabilidade) VALUES 
(:nome, :tamanho_stack, :quantidade_stack, :tipo, :durabilidade)');

$criacao -> bindParam(':nome', $nome);
$criacao -> bindParam(':tamanho_stack', $tamanho_stack);
$criacao -> bindParam(':quantidade_stack', $quantidade_stack);
$criacao -> bindParam(':tipo', $tipo);
$criacao -> bindParam(':durabilidade', $durabilidade);

$nome = 'Espada de Ferro';
$tamanho_stack = 1;
$quantidade_stack = 1;
$tipo = 'Arma';
$durabilidade = 100;

$criacao -> execute();

$atualizacao = $conexao -> prepare('UPDATE itens SET nome = :nome, durabilidade = :durabilidade WHERE id = :id');
$atualizacao -> execute([
    'nome' => 'Espada de Diamante',
    'durabilidade' => 500,
    'id' => 11
]);
