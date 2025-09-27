<?php
$rota = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
if (!strpos($endpoint, 'caixa')){
    echo 'Rota inválida';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if ($_SERVER['REQUEST_URI'] === 'GET'){
        echo 'Estou buscando dados do caixa para fechamento';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ($_SERVER['REQUEST_URI'] === '/caixa/fechar'){
        echo 'Mandei fechar o caixa';
    }
}

echo '<pre>';
print_r($endpoint);
echo '</pre>';