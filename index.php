<?php
echo '<pre>';
print_r($_GET);
print_r($_POST);
echo '<pre>';

// variaveis globais

// - infotmações permanentes á requisição feita
// - informações do servidor
// - informações do ambiente

$inteiro = 90;
$float = 80.0;
$booleando = false;
$vetor = ['elemento1', 'elemento2', 'elemento3'];
$matriz = [
    ['Linha 1 coluna 1', 'Linha 1 coluna 2', 'Linha 1 coluna 3'],
    ['Linha 2 coluna 1', 'Linha 2 coluna 2', 'Linha 2 coluna 3'],
    ['Linha 3 coluna 1', 'Linha 3 coluna 2', 'Linha 3 coluna 3']
]

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo formulário</title>
</head>
<body>
    <h3>Formulário de exemplo</h3>
    <form action="form.php?login_mobile" method="POST">
        <label for="login">Login</label>
        <input type="text" name="login">
        <br>
        <label for="password">Senha</label>
        <input type="password" name="senha">
        <br>
        <button type="submit">Acessar</button>
    </form>

    <a href="form.php?login=teste&senha=1234">Clique aqui</a>
</body>
</html>