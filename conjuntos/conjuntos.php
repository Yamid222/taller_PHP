<?php
require 'classConjuntos.php';

$resultados = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conjunto = new Conjunto($_POST['conjuntoA'], $_POST['conjuntoB']);
    $resultados = $conjunto->obtenerResultados();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="conjuntos.css">
    <title>Operaciones con Conjuntos</title>
</head>
<body>
    <h1>Calculadora de Conjuntos</h1>
    <form method="post">
        <label>Conjunto A (separado por comas):</label><br>
        <input type="text" name="conjuntoA" required><br><br>
        <label>Conjunto B (separado por comas):</label><br>
        <input type="text" name="conjuntoB" required><br><br>
        <button type="submit">Calcular</button>
    </form>

    <?php if ($resultados): ?>
        <h2>Resultados:</h2>
        <?php
        foreach ($resultados as $nombre => $conjunto):
        ?>
            <p>
                <strong>
                    <?php
                    echo $nombre;
                    ?>:
                </strong> 
                { 
                <?php
                echo implode(", ", $conjunto); 
                ?>
                }
            </p>
        <?php 
        endforeach; 
        ?>
    <?php
    endif;
    ?>
    <a href="../index.html">Inicio</a>
</body>
</html>
