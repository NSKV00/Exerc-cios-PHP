<!-- 1. Crie uma classe Livro
    * Implementar um método para exibir as informações do livro

2. Crie uma classe Celular
    * Implementar métodos ligar(), desligar() e usarBateria(%)

3. Crie a classe Agenda que guarda uma lista de Contatos (com nome e telefone)
    * Implementar métodos para adicionar e remover contatos

4. Crie a classe Veiculo
    * Crie a subclasse moto, carro e caminhão, cada uma com comportamentos específicos -->

<?php

class Livro {
    public string $titulo;
    public string $autor;
    public string $editora;
    public string $genero;
    public string $sintese;
    public int $paginas;
    public int $capitulos;
    public int $anoPublicacao;

    public function __construct(
        string $titulo,
        string $autor,
        string $editora,
        string $genero,
        string $sintese,
        int $paginas,
        int $capitulos,
        int $anoPublicacao
    ) {
        $this -> titulo = $titulo;
        $this -> autor = $autor;
        $this -> editora = $editora;
        $this -> genero = $genero;
        $this -> sintese = $sintese;
        $this -> paginas = $paginas;
        $this -> capitulos = $capitulos;
        $this -> anoPublicacao = $anoPublicacao;
    }
}

$livro = new Livro(
        'O Senhor dos Anéis',
        'J.R.R. Tolkien',
        'HarperCollins',
        'Fantasia Épica',
        'Uma aventura épica na Terra-média.',
        1216,
        22,
        1954
);

echo '<pre>';
print_r($livro);
echo '</pre>';
?>


<?php

class Celular {
    public string $marca;
    public string $modelo;
    public int $ano;
    public bool $ligado = false;
    public int $bateria = 100;

    public function __construct(string $marca, string $modelo, int $ano) {
        $this -> marca = $marca;
        $this -> modelo = $modelo;
        $this -> ano = $ano;
    }

    public function ligar() {
        if (!$this -> ligado) {
            $this -> ligado = true;
            echo "O celular está ligado . <br>";
        } else {
            echo "O celular já está ligado . <br>";
        }
    }

    public function desligar() {
        if ($this -> ligado) {
            $this -> ligado = false;
            echo "O celular está desligado . <br>";
        } else {
            echo "O celular já está desligado . <br>";
        }
    }

    public function usarBateria(int $percentual) {
        if ($percentual < 0 || $percentual > 100) {
            echo "Percentual inválido. Deve ser entre 0 e 100 . <br>";
            return;
        }
        if ($this -> bateria - $percentual < 0) {
            echo "Bateria insuficiente para essa operação . <br>";
            return;
        }
        $this -> bateria -= $percentual;
        echo "Bateria restante: {$this -> bateria}% <br>";
    }
}

$celular = new Celular(
    'Xiaomi', 
    '17 Pro', 
    2025
);

$celular -> ligar();
$celular -> usarBateria(20);
$celular -> desligar();
$celular -> ligar();
$celular -> usarBateria(50);
?>


<?php

class Contato {
    public string $nome;
    public string $telefone;

    public function __construct(string $nome, string $telefone) {
        $this -> nome = $nome;
        $this -> telefone = $telefone;
    }
}

class Agenda {
    public array $contatos = [];

    public function listarContatos() {
        if (empty($this -> contatos)) {
            echo "Nenhum contato na agenda . <br>";
            return;
        }
        foreach ($this -> contatos as $contato) {
            echo "Nome: " . $contato -> nome . " - Telefone: " . $contato -> telefone . "<br>";
        }
    }

    public function adicionarContato(Contato $contato) {
        $this -> contatos[] = $contato;
        echo "Contato adicionado: " . $contato -> nome . "<br>";
    }

    public function removerContato(string $nome) {
        foreach ($this -> contatos as $index => $contato) {
            if ($contato -> nome === $nome) {
                unset($this->contatos[$index]);
                echo "Contato removido: " . $nome . "<br>";
                $this->contatos = array_values($this -> contatos);
                return;
            }
        }
        echo "Contato não encontrado: " . $nome . "<br>";
    }
}

$agenda = new Agenda();

$agenda -> adicionarContato(new Contato("Maria", "99874-4566"));
$agenda -> adicionarContato(new Contato("João", "96661-2567"));
$agenda -> listarContatos();
$agenda -> removerContato("João");
$agenda -> listarContatos();

?>


<?php



