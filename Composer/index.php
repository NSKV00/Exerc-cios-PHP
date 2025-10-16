<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

?>

<?php
$rota = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$host = 'localhost';
$user = 'root';
$pass = '';
$banco = 'aula';

$conexao = new \PDO("mysql:host=$host; dbname=$banco", $user, $pass);

if ($rota === '/itens'){

    $consulta = $conexao -> prepare("SELECT * FROM itens");
    $consulta -> execute();

    $resultado = $consulta -> fetchAll(\PDO::FETCH_ASSOC);

    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('A' . $linha, $resultado[$linha - 1]['id']);
    }

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('B' . $linha, $resultado[$linha - 1]['nome']);
    }

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('C' . $linha, $resultado[$linha - 1]['tamanho_stack']);
    }

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('D' . $linha, $resultado[$linha - 1]['quantidade_stack']);
    }

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('E' . $linha, $resultado[$linha - 1]['tipo']);
    }

    for ($linha = 1; $linha < count($resultado); $linha++){
        $activeWorksheet -> setCellValue('F' . $linha, $resultado[$linha - 1]['durabilidade']);
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('GET-Item.xlsx');

}


