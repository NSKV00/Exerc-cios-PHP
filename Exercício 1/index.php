<?php

$metodo = $_SERVER['REQUEST_METHOD'];
$rota = $_SERVER['REQUEST_URI'];

header('Content-Type: application/json');

if ($metodo === 'GET') {
    if (strpos($rota, '/evento?id=') == 0) {
        $id = $_GET['id'];

        $evento = acharEvento($id);

        if($evento !== null) {
            http_response_code(200);
            echo json_encode($evento);
            exit;
        }
        
        http_response_code(404);
        echo json_encode(['message' => 'Evento não encontrado']);
        exit;
    }
}

if ($metodo === 'POST') {
    if($rota === '/evento/comprar') {
        $corpo = json_decode(file_get_contents('php://input'), true);
        
        $id = $corpo['evento'];
        $tipo = $corpo['tipo_ingresso'];
        $quantidade = $corpo['quantidade'];

        $evento = acharEvento($id);

        if ($evento === null) {
            http_response_code(404);
            echo json_encode(['message' => 'Evento não encontrado']);
            exit;
        }

       foreach ($evento['ingressos'] as $index => $ingresso) {

            if ($ingresso['tipo'] == $tipo) {
                $ingresso['quantidade_disponivel'] = $ingresso['quantidade_disponivel'] - $quantidade;
                $ingresso['quantidade_vendida'] = $ingresso['quantidade_vendida'] + $quantidade;

                $evento['ingressos'][$index] = $ingresso;

                echo json_encode($evento);
                exit;
            }
        }
    }
}

function printBonitinho($dados) {
    echo '<pre>'; 
    print_r($dados);
    echo '</pre>'; 
}

function acharEvento(int $id): ?array 
{
    $eventos = [
    [
        'id' => 1,
        'nome' => 'Encontro de carros',
        'data_inicio' => '2025/10/31',
        'data_termino' => '2025/11/6',
        'ingressos' => [
            'valor' => 25.00,
            'tipo' => 'ingresso inteiro',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 2000,
        ],[
            'valor' => 12.50,
            'tipo' => 'meia entrada',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 1998,
        ]

    ],
    [
        'id' => 2,
        'nome' => 'Balonismo',
        'data_inicio' => '2025/12/28',
        'data_termino' => '2026/01/4',
        'ingressos' => [
            'valor' => 25.00,
            'tipo' => 'ingresso inteiro',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 2000,
        ],[
            'valor' => 12.50,
            'tipo' => 'meia entrada',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 1998,
        ]

    ],
    [
        'id' => 3,
        'nome' => 'Oktoberfest',
        'data_inicio' => '2025/10/15',
        'data_termino' => '2025/10/25',
        'ingressos' => [
            'valor' => 25.00,
            'tipo' => 'ingresso inteiro',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 2000,
        ],[
            'valor' => 12.50,
            'tipo' => 'meia entrada',
            'quantidade_disponivel' => 2899,
            'quantidade_vendidas' => 1998,
        ]

    ],
 ];

    foreach ($eventos as $item) {
        if ($item['id'] == $$id) return $item;
    }

    return null;
}