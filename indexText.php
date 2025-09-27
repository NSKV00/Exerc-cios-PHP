

<?php echo "Hello word";?>

<?= "Qualquer coisa"?>

<h1>Teste de html</h1>

<h2>
    <?= "Mojang, danonão grosso";?>
</h2>

<?php

$Variavel1 = 'Teste 2';

$Variavel2 = 'mais um teste 2';

$numero = '01';
$numeroInt = (int) $numero;

var_dump($numero, $numeroInt);
echo '<br>';
print_r([$numeroInt]);

$numero2 = '03';
$numero2Int = 3;
$numero2Float = 3.00;
$numero2Bool = false;
?>

<h3>
    <?= $numero + $numero?>
</h3>

<h3>
    <?= $Variavel2?>

    <?= "$Variavel1 $Variavel2" ?>
</h3>

<?php
var_dump($_GET);
?>

    <a href="<?= $url ?>">Clique aqui</a>
    <form action="form.php" method="GET">
        
    </form>