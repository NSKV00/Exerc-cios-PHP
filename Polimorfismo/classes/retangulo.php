<?php
require_once 'formaGeometrica.php';
require_once 'formaInterface.php';

class Retangulo extends formaGeometrica implements formaInterface {

    public function calcularArea(float $base, float $altura){
        $this -> area = $base * $altura;
    } 
}

    // public $base;
    // public $altura;

    // public function __construct($base, $altura) {
    //     $this -> base = $base;
    //     $this -> altura = $altura;
    // }

    // public function calcularArea(): string {
    //     $this -> area = $this -> base * $this -> altura;
    //     return 'A área do retângulo é: ' . $this -> area . ' cm²';
    // }
