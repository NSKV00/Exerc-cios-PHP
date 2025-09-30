<?php

require 'Evento.php';

$evento = new Evento (1, 'Evento teste', '2025-09-24', '2025-09-30');

echo '<pre>';
print_r($evento -> comprarIngresso(1, 'tipo'));
print_r(Evento::fromArray());
print_r($evento -> getDataTermino());
echo '</pre>';
