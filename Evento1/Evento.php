<?php

class Evento {
    public int $identificador ;
    protected string $nome ;
    private \DateTime $data_inicio ;
    private \DateTimeImmutable $data_termino ;

    public function __construct(
        int $identificadorConstrutor, 
        string $nomeConstrutor, 
        string $data_inicioConstrutor, 
        string $data_terminoConstrutor
    ){
        $this -> identificador = $identificadorConstrutor;
        $this -> nome = $nomeConstrutor;
        $this -> data_inicio = \DateTime::createFromFormat('Y-m-d', $data_inicioConstrutor);
        $this -> data_termino = \DateTimeImmutable::createFromFormat('Y-m-d', $data_terminoConstrutor);

        // $evento = new Evento(1, 'teste', '2025-09-12', '');
    }

    public function comprarIngresso (int $quantidade, string $tipo){
        return "Estou tentando comprar um ingresso nesse evento $quantidade $tipo";
    }

    public static function fromArray (): array {
        return[];
    }

    public function getDataTermino (): string {
        return $this -> data_termino -> format('Y-m-d');
    }

    public function setDataTermino (\DateTimeImmutable $dataTerminoNova =  new \DataTimeImmutavle()): void {
        $this -> data_termino = $dataTerminoNova;
    }

}

// 'id' => 1,
//         'nome' => 'Encontro de carros',
//         'data_inicio' => '2025/10/31',
//         'data_termino' => '2025/11/6',
//         'ingressos' => [
//             'valor' => 25.00,
//             'tipo' => 'ingresso inteiro',
//             'quantidade_disponivel' => 2899,
//             'quantidade_vendidas' => 2000,
//         ],[
//             'valor' => 12.50,
//             'tipo' => 'meia entrada',
//             'quantidade_disponivel' => 2899,
//             'quantidade_vendidas' => 1998,