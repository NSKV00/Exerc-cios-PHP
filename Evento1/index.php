<?php

require 'carro.php';

$carro = new carro(
    4,
    4,
    100,
    'Fiat',
    'Uno',
    'Prata'
);

echo '<pre>';
print_r($carro);
echo '<br>';
print_r('Quantidade de rodas' . $carro -> qntRodas);
echo '<br>';
print_r('Quantidade de portas' . $carro -> qntPortas);
echo '<br>';
print_r('Chamando comportamento do carro:' . $carro -> ligar());
echo '<br>';
echo '</pre>';

//require 'Evento.php';

//$evento = new Evento (1, 'Evento teste', '2025-09-24', '2025-09-30');

//echo '<pre>';
//print_r($evento -> comprarIngresso(1, 'tipo'));
//print_r(Evento::fromArray());
//print_r($evento -> getDataTermino());
//echo '</pre>';
