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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fibonacci-factorial.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>🌀 Calculadora de Fibonacci y Factorial</title>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="../index.html" class="btn-back">
                ← Volver al inicio
            </a>
        </div>
        
        <div class="section">
            <div class="form-section">
                <h2>🌀 Calculadora de Fibonacci y Factorial</h2>
                <p>Calcula secuencias de Fibonacci o factoriales de números</p>
                
                <form method="post">
                    <div class="form-group">
                        <label for="numero">Ingrese un número:</label>
                        <input type="number" id="numero" name="numero" required min="1" 
                               placeholder="Ejemplo: 10"
                               value="<?php echo isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="operacion">Seleccione la operación:</label>
                        <select id="operacion" name="operacion" required>
                            <option value="fibonacci" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'fibonacci') ? 'selected' : ''; ?>>🌀 Secuencia de Fibonacci</option>
                            <option value="factorial" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'factorial') ? 'selected' : ''; ?>>❗ Factorial</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn">
                        🧮 Calcular
                    </button>
                </form>
                
                <?php if ($resultado): ?>
                <div class="result-section">
                    <h3>✅ Resultado</h3>
                    <div class="result-value">
                        <?php echo $resultado; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>