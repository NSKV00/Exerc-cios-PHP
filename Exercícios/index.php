<!-- POST /itens
1. json com todos os dados do item

2. Criar o registro do banco de dados

3. [opicional] Retornar o item criado com o ID gerado 

4. GET /item/:id ou /item?id=:id

5. PUT /item/:id ou /item?id=:id -->

<?php
$rota  = $_SERVER['REQUEST_URI'];
$metodo = $_SERVER['REQUEST_METHOD'];

$host = 'localhost';
$user = 'root';
$pass = '';
$banco = 'aula';

//1. string de conexão
//2. usuário
//3. senha
$conexao = new \PDO("mysql:host=$host;dbname=$banco", $user, $pass);


$consulta = $conexao -> prepare('SELECT * FROM itens');
$consulta -> execute();

// while ($linha = $consulta -> fetch(\PDO::FETCH_OBJ)) {
//     echo '<pre>';
//     print_r($linha);
//     echo '</pre>';
// }

// echo '<pre>';
// print_r($conexao); 
// echo '</pre>';

if ($metodo === 'POST'){
    if ($rota === '/itens'){
        $json = file_get_contents('php://input');
        if (!$json){
            throw new Exception('Dados não fornecidos');
        }
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE){
            throw new Exception('JSON inválido: ' . json_last_error_msg());
        }

        $campos_requeridos = ['nome', 'tamanho_stack', 'quantidade_stack', 'tipo', 'durabilidade'];
        $campos_erro = array_filter($campos_requeridos, fn($campos) => !isset($data[$campos]));
        if (!empty($campos_erro)){
            throw new Exception('campos obrigatórios faltando: ' . implode(', ', $campos_erro));
        }

        $criacao = $conexao -> prepare('INSERT INTO itens 
        (nome, 
        tamanho_stack, 
        quantidade_stack, 
        tipo, durabilidade) VALUES 
        (:nome, 
        :tamanho_stack, 
        :quantidade_stack, 
        :tipo, 
        :durabilidade)');

        $criacao -> execute([
            ':nome' => $data['nome'],
            ':tamanho_stack' => (int)$data['tamanho_stack'],
            ':quantidade_stack' => (int)$data['quantidade_stack'],
            ':tipo' => $data['tipo'],
            ':durabilidade' => (int)$data['durabilidade']
        ]);

        if ($id = $conexao -> lastInsertId() && $item_novo = $conexao -> query("SELECT * FROM itens WHERE id=$id")){
            http_response_code(201);
            echo json_encode(['mensagem'=>'Item criado', 'item'=>$item_novo]);
        } else {
            http_response_code(400);
            echo json_encode(['erro'=> 'erro ao criar', 'mensagem'=>$conexao->errorInfo()]);
            
        }
    }
}

if ($metodo === 'POST'){
    if ($rota === '/itens'){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['nome']) || !isset($data['tamanho_stack']) || !isset($data['quantidade_stack']) || !isset($data['tipo']) || !isset($data['durabilidade'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados incompletos']);
            exit;
        }

        $criacao = $conexao -> prepare('INSERT INTO itens (nome, tamanho_stack, quantidade_stack, tipo, durabilidade) VALUES 
        (:nome, :tamanho_stack, :quantidade_stack, :tipo, :durabilidade)');

        $criacao -> execute([
            ':nome' => $data['nome'],
            ':tamanho_stack' => $data['tamanho_stack'],
            ':quantidade_stack' => $data['quantidade_stack'],
            ':tipo' => $data['tipo'],
            ':durabilidade' => $data['durabilidade']
        ]);

        echo json_encode(['sucesso' => 'Item criado com sucesso', 'id' => $conexao->lastInsertId()]);
    }
}

if ($metodo ==='GET'){
    
}

if ($metodo === 'PUT'){
    
}
// if ($rota === '/itens' && $metodo === 'POST') {
//     if (
//         $data = json_decode(file_get_contents('php://input'), true);
//         $
//     )
// }