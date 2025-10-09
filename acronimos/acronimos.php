<?php
require 'claseAcronimo.php';

$acronimo = "";
$fraseOriginal = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["frase"])) {
    $fraseOriginal = trim($_POST["frase"]);
    $obj = new Acronimo($fraseOriginal);
    $acronimo = $obj->getAcronimo();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="acronimo.css">
    <title>Acrónimos</title>
</head>
<body>
    <h2>Generador de Acrónimos</h2>
    <form method="post">
        <label>Ingrese una frase:</label><br>
        <input type="text" name="frase" required>
        <button type="submit">Generar Acrónimo</button>
    </form>
    <?php 
    if ($acronimo != ""): 
    ?>
        <h2>Resultado:</h2>
        <p>
            <strong>Frase ingresada:</strong> 
            <?php 
            echo strtolower($fraseOriginal); 
            ?>
        </p>
        <p>
            <strong>Acrónimo:</strong> 
            <?php
            echo strtoupper($acronimo); 
            ?>
        </p>
    <?php 
    endif;
    ?>
    <a href="../index.html">Inicio</a>
</body>
</html>
