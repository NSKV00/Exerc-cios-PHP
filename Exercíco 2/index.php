<!-- * Exercícios de estruturas condicionais:

1. Digite um número e mostre se ele é positivo, negativo ou zero.

2.Digite um número de 1 a 7 e exiba o dia da semana correspondente (1 = Domingo, 2 = Segunda, etc.).
Se for fora desse intervalo, exiba "Dia inválido".

3. Se o valor da compra for:
- maior ou igual a 100 → desconto de 10%
- entre 50 e 99 → desconto de 5%
- menor que 50 → sem desconto
Mostre o valor final com desconto.

4. Verifique se um ano é bissexto:
- Divisível por 4 e não por 100
- Ou divisível por 400

5. Gere um número aleatório entre 1 e 10.
Peça para o usuário adivinhar.
Se acertar, exiba "Parabéns, você acertou!"
Se errar, exiba se o número sorteado era maior ou menor que o palpite.

* Exercícios de esturturas de repetição:

1. Calcule a soma dos números de 1 a 100 usando while.

2. Imprima todos os números pares de 1 a 50 usando for.

3. Peça um número ao usuário e calcule o fatorial dele usando while.

(não é preciso fazer) 4. Gere um número aleatório entre 1 e 50. Peça ao usuário para adivinhar.
- Enquanto ele errar, mostre dicas de "maior" ou "menor". Use do/while.)

5. Construa este padrão com um for duplo

*
**
***
****
*****

* Exercícios de Vetores e Matrizes

1. Leia um vetor de 10 números inteiros e exiba a soma de todos os elementos.

2. Leia um vetor de 8 números e informe qual o maior, o menor e suas posições no vetor.

3. Leia 5 números e mostre-os na ordem inversa de entrada.

4. Leia uma matriz 5x5 e mostre o maior elemento de cada linha. -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php

$method = $_SERVER['REQUEST_METHOD'];
$rota = $_SERVER['REQUEST_URI'];

$numero1 = 1;
$numero = 5;
$valorCompra = 80;
$ano = 1800;
$palpite = 7;

if ($method === 'GET'){

    if ($rota === '/atividade1/1'){
        if ($numero1 < 0){
            echo ('negativo');
        } elseif ($numero1 > 0) {
            echo ('positivo');
        } else {
            echo ('0');
        }
    }

    if ($rota === '/atividade1/2'){
        if ($numero == 1) echo "Domingo";
        elseif ($numero == 2) echo "Segunda";
        elseif ($numero == 3) echo "Terça";
        elseif ($numero == 4) echo "Quarta";
        elseif ($numero == 5) echo "Quinta";
        elseif ($numero == 6) echo "Sexta";
        elseif ($numero == 7) echo "Sábado";
        else echo "Dia inválido";
    }

    if ($rota === '/atividade1/3'){
        if ($valorCompra >= 100){
            $final = $valorCompra * 0.90;
        } elseif ($valorCompra >= 50){
            $final = $valorCompra * 0.95;
        } else {
            $final = $valorCompra;
        }
        echo "Valor final: R$ " . $final;
    }

    if ($rota === '/atividade1/4'){
        if (($ano % 4 == 0 && $ano % 100 != 0) || $ano % 400 == 0){
            echo "$ano é bissexto";
        } else {
            echo "$ano não é bissexto";
        }
    }

    if ($rota === '/atividade1/5'){
        $sorteado = rand(1,10);/*$palpite;*/;
        echo "Número sorteado: $sorteado<br>";

        if ($palpite == $sorteado){
            echo "Parabéns, você acertou!";
        } elseif ($palpite < $sorteado){
            echo "Você errou, o número sorteado é MAIOR.";
        } else {
            echo "Você errou, o número sorteado é MENOR.";
        }
    }
}

if ($method === 'GET'){

    if ($rota === '/atividade2/1'){
        $soma = 0;
        $i = 1;
        while ($i <= 100){
            $soma += $i;
            $i++;
        }
        echo "Soma dos números de 1 a 100: $soma";
    }

    if ($rota === '/atividade2/2'){
        echo "Números pares de 1 a 50:<br>";
        for ($i = 1; $i <= 50; $i++){
            if ($i % 2 == 0){
                echo $i . "<br>";
            }
        }
    }

    if ($rota === '/atividade2/3'){
        $i = 51;
        $soma = 1;
        while ($i > 0){
            $soma *= $i;
            $i--;
        }
        echo($soma);
    }

    if ($rota === '/atividade2/5'){
        for ($i = 1; $i <= 5000; $i++){
            for ($j = 1; $j <= $i; $j++){
                echo "*";
            }
            echo "<br>";
        }
    }
}

if ($method === 'GET'){

    if ($rota === '/atividade3/1'){
        $vetor = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29 ];
        $soma = 1;

        if (count($vetor) === 10){
            for ($i = 0; $i < count($vetor); $i++){
                $soma += $vetor[$i];
            }
            echo "Soma dos elementos do vetor: $soma";
        } else {
            echo "Vetor inválido";
        }
    }

    if ($rota === '/atividade3/2'){
        $vetor = [2, 3, 5, 7, 11, 13, 17, 19];
        $menor = null;
        $pmenor = 0;
        $maior = null;
        $pmaior = 0;

        if (count($vetor) === 8){
            for ($i = 0; $i < count($vetor); $i++){
                if ($menor === null || $vetor[$i] < $menor){
                    $menor = $vetor[$i];
                    $pmenor = $i;
                }
                if ($maior === null || $vetor[$i] > $maior){
                    $maior = $vetor[$i];
                    $pmaior = $i;
                }
            }
            echo "Menor: $menor, Posição: $pmenor<br>";
            echo "Maior: $maior, Posição: $pmaior<br>";
        } else {
            echo "Vetor inválido";
        }
    }

    if ($rota ==='/atividade3/3'){
        $numeros = [10, 20, 30, 40, 50];

        for ($i = count($numeros) - 1; $i >= 0; $i--){
            echo $numeros[$i] . "<br>";
        }
    }

    if ($rota === '/atividade3/4'){
        $matriz = [
            [2, 4, 6, 1, 3],
            [15, 4, 8, 23, 7],
            [9, 11, 5, 17, 13],
            [14, 22, 18, 10, 6],
            [3, 8, 12, 16, 20]
        ];

        for ($linha = 0; $linha < count($matriz); $linha++){
            $maior = null;
            for ($coluna = 0; $coluna < count($matriz[$linha]); $coluna++){
                $matriZ = $matriz[$linha];
                if ($maior < $matriZ[$coluna]){
                    $maior = $matriz[$linha][$coluna];
                }
            }
            echo($maior);
            echo "<br>";
        }
        exit;
    }
}

?>

</body>
</html>