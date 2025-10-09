<?php
require 'classBinarios.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="binarios.css">
    <title>Binario</title>
</head>
<body>
    <h2>Conversor de Entero a Binario </h2>
    <form method="post">
        <label for="numero">Ingrese un número entero:</label>
        <input type="number" name="numero" id="numero" required>
        <button type="submit">Convertir</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numero = intval($_POST["numero"]);
        $conversor = new ConversorBinario($numero);
        $resultado = $conversor->convertir();
        echo "<h3>Resultado:</h3>";
        echo "<p>El número <strong>$numero</strong>
         en binario es:<strong>$resultado</strong></p>";
    }
    ?>
    <a href="../index.html">Inicio</a>
</body>
</html>