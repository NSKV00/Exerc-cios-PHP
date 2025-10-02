<?php

 class Veiculo {
    public int $qntRodas ;
    public int $qntPortas ;
    protected int $potencia;
    protected string $marca ;
    public string $modelo ;
    private string $cor ;

    public function __construct(
        int $qntRodas,
        int $qntPortas,
        int $potencia,
        string $marca,
        string $modelo,
        string $cor,
    )
    {
        $this -> qntRodas = $qntRodas;
        $this -> qntPortas = $qntPortas;
        $this -> potencia = $potencia;
        $this -> marca = $marca;
        $this -> modelo = $modelo;
        $this -> cor = $cor;
    }

    public function getCor(): string {
        return $this -> cor;
    }

 }