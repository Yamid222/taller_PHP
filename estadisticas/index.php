<?php

require_once 'CalculosStadisticos.php';

$result = '';
$error = '';
$inputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numbersInput = $_POST['numbers'] ?? '';
    if (empty(trim($numbersInput))) {
        $error = 'Por favor, ingrese al menos un número.';
    } else {
        try {
            $numbers = array_map('trim', explode(',', $numbersInput));
            $numbers = array_filter($numbers, function($n) { return $n !== ''; });
            
            if (empty($numbers)) {
                $error = 'Por favor, ingrese números válidos.';
            } else {
                $statsCalculator = new CalculosStadisticos();
                $validNumbers = $statsCalculator->validateNumbers($numbers);
                $inputData = $statsCalculator->formatNumbers($validNumbers);
                
                $average = $statsCalculator->calculateAverage($validNumbers);
                $median = $statsCalculator->calculateMedian($validNumbers);
                $modes = $statsCalculator->calculateMode($validNumbers);
                
                $result = "Promedio: " . number_format($average, 2) . "\n";
                $result .= "Mediana: " . number_format($median, 2) . "\n";
                
                if (empty($modes)) {
                    $result .= "Moda: No hay moda (todos los números aparecen una vez)";
                } else {
                    $result .= "Moda: " . implode(', ', $modes);
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
    <title>Estadísticas</title>
    <link rel="stylesheet" href="esta.css">
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
            <h2><i class="fas fa-chart-bar"></i> Estadísticas</h2>
            <p>Calcula promedio, mediana y moda de una serie de números.</p>
            
            <form method="POST">
                <div class="form-group">
                    <label for="numbers">Ingrese números separados por comas:</label>
                    <textarea 
                        id="numbers" 
                        name="numbers"
                        rows="4"
                        placeholder="Ej: 5, 2, 8, 2, 9, 2, 1"
                        required
                    ><?php echo htmlspecialchars($inputData); ?></textarea>
                    <small>Separe los números con comas. Ejemplo: 5, 2, 8, 2, 9, 2, 1</small>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-chart-line"></i> Calcular Estadísticas
                </button>
            </form>
            
            <?php if (!empty($result)): ?>
                <div class="result-section">
                    <h3><i class="fas fa-check-circle"></i> Resultados:</h3>
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




