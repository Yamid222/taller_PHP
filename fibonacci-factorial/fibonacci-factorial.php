<?php
require 'clasFibonacci-factorial.php';

$resultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $operacion = $_POST['operacion'];

    $calculadora = new Calculadora($numero);

    if ($operacion == "fibonacci") {
        $resultado = $calculadora->calcularFibonacci();
    } elseif ($operacion == "factorial") {
        $resultado = $calculadora->calcularFactorial();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="fibonacci-factorial.css">
    <title>Calculadora de Fibonacci y Factorial</title>
</head>
<body>
    <h1>Calculadora de Fibonacci y Factorial</h1>
    <form method="post">
        <label>Ingrese un número:</label><br>
        <input type="number" name="numero" required min="1"><br><br>

        <label>Seleccione la operación:</label><br>
        <select name="operacion" required>
            <option value="fibonacci">Fibonacci</option>
            <option value="factorial">Factorial</option>
        </select><br><br>

        <button type="submit">Calcular</button>
    </form>
    <?php
    if ($resultado):
    ?>
        <h2>Resultado:</h2>
        <p><?php echo $resultado; ?></p>
    <?php endif; ?>
    <a href="../index.html">Inicio</a>
</body>
</html>
