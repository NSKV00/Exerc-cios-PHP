<?php
require_once 'formaGeometrica.php';
require_once 'formaInterface.php';

class Triangulo extends formaGeometrica implements formaInterface {

    public function calcularArea(float $base, float $altura){
        $this -> area = ($base * $altura) / 2;
    } 
}