<?php
require 'classCalculosStadisticos.php';

$resultado = "";
$numerosIngresados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numerosIngresados = htmlspecialchars($_POST['numeros']); // Guardamos lo ingresado
    $estadistica = new Estadistica($numerosIngresados);
    $resultado .= "<h2>Resultados:</h2>";
    $resultado .= "Números ingresados: " . $numerosIngresados . "<br>";
    $resultado .= "Promedio: " . $estadistica->calcularPromedio() . "<br>";
    $resultado .= "Mediana: " . $estadistica->calcularMediana() . "<br>";
    $resultado .= "Moda: " . $estadistica->calcularModa() . "<br>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="esta.css">
    <title>Calculadora Estadística</title>
</head>
<body>
    <h1>Calculadora de Promedio, Mediana y Moda</h1>
    <form method="post">
        <label>Ingrese números separados por comas:</label><br>
        <input type="text" name="numeros" required>
        <button type="submit">Calcular</button>
    </form>
    <div>
        <?php echo $resultado; ?>
    </div>
    <a href="../index.html">Inicio</a>
</body>
</html>