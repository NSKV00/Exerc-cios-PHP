<?php
require_once './classes/retangulo.php';
require_once './classes/formaGeometrica.php';
require_once './classes/triangulo.php';

$retangulo = new Retangulo();
$formaGeometrica = new formaGeometrica();  
$triangulo = new Triangulo();

// echo 'formaGeometrica';
// echo '<pre>';
// $formaGeometrica -> calcularArea(2, 2);
// var_dump($formaGeometrica);
// echo '<br>';

echo 'Retangulo';
echo '<pre>';
$retangulo -> calcularArea(2, 2);
var_dump($retangulo -> getArea());
echo '<br>';

echo 'Triangulo';
echo '<pre>';
$triangulo -> calcularArea(2, 2);
var_dump($triangulo);
echo '<br>';


function calcularAreaForma(formaGeometrica $forma) {
    $forma -> calcularArea(2, 2);
    return $forma -> getArea();
}

?>