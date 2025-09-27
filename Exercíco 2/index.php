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

4. Gere um número aleatório entre 1 e 50. Peça ao usuário para adivinhar.
- Enquanto ele errar, mostre dicas de "maior" ou "menor". Use do/while.

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

$numero = 1;

if ($method === 'GET'){

    if ($rota === '/atividade/1'){
        if ($numero < 0){
            echo ('negativo');
        } elseif ($numero > 0) {
            echo ('positivo');
        } else {
            echo ('0');
        }
    }
}



?>

</body>
</html>