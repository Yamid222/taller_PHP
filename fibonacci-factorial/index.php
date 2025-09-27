<?php

require_once 'CalculosMatematicos.php';

$result = '';
$error = '';
$inputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'] ?? '';
    $operation = $_POST['operation'] ?? '';
    
    if (empty($number) || empty($operation)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        try {
            $mathCalculator = new CalculosMatematicos();
            
            if (!$mathCalculator->isValidNumber($number)) {
                $error = 'Por favor, ingrese un número entero positivo válido.';
            } else {
                $number = (int)$number;
                $inputData = $number;
                
                if ($operation === 'fibonacci') {
                    $fibonacciData = $mathCalculator->calculateFibonacciWithProcedure($number);
                    $result = "Sucesión de Fibonacci: " . implode(', ', $fibonacciData['sequence']) . "\n\n";
                    $result .= "Procedimiento paso a paso:\n";
                    $result .= implode("\n", $fibonacciData['procedure']);
                } else {
                    $factorialData = $mathCalculator->calculateFactorialWithProcedure($number);
                    $result = "Resultado: " . $factorialData['result'] . "\n\n";
                    $result .= "Procedimiento paso a paso:\n";
                    $result .= implode("\n", $factorialData['procedure']);
                }
            }
        } catch (Exception $e) {
            $error = 'Error en el cálculo: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci y Factorial</title>
    <link rel="stylesheet" href="f-f.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="../index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al Menú Principal
            </a>
        </div>
        
        <div class="form-section">
            <h2><i class="fas fa-superscript"></i> Fibonacci y Factorial</h2>
            <p>Calcula la sucesión de Fibonacci o el factorial de un número.</p>
            
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="number">Número:</label>
                        <input 
                            type="number" 
                            id="number" 
                            name="number"
                            value="<?php echo htmlspecialchars($inputData); ?>"
                            min="0"
                            placeholder="Ingrese un número"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="operation">Operación:</label>
                        <select id="operation" name="operation" required>
                            <option value="">Seleccione...</option>
                            <option value="fibonacci" <?php echo ($_POST['operation'] ?? '') === 'fibonacci' ? 'selected' : ''; ?>>Sucesión de Fibonacci</option>
                            <option value="factorial" <?php echo ($_POST['operation'] ?? '') === 'factorial' ? 'selected' : ''; ?>>Factorial</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Calcular
                </button>
            </form>
            
            <?php if (!empty($result)): ?>
                <div class="result-section">
                    <h3><i class="fas fa-check-circle"></i> Resultado:</h3>
                    <div class="result-list"><?php echo nl2br(htmlspecialchars($result)); ?></div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="error">
                    <h3><i class="fas fa-exclamation-triangle"></i> Error</h3>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>




