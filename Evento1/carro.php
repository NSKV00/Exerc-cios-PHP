<?php 
require 'veiculo.php';

class carro extends Veiculo {
    public function ligar() {
        echo "Ligando o motor do carro...<br>";
        echo 'Este carro é da cor ' . $this -> getCor() . '<br>';
        echo 'Este carro tem' . $this -> qntRodas . ' rodas ';
        echo 'e ' . $this -> qntPortas . ' portas.<br>';
        echo 'Com potência de ' . $this -> potencia . ' cavalos.<br>';
        exit;
    }
}