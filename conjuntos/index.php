<?php

require_once 'ConjuntosOperaciones.php';

$result = '';
$error = '';
$inputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setAInput = $_POST['setA'] ?? '';
    $setBInput = $_POST['setB'] ?? '';
    
    if (empty(trim($setAInput)) || empty(trim($setBInput))) {
        $error = 'Por favor, ingrese números en ambos conjuntos.';
    } else {
        try {
            $setA = array_map('trim', explode(',', $setAInput));
            $setB = array_map('trim', explode(',', $setBInput));
            
            $setA = array_filter($setA, function($n) { return !empty($n); });
            $setB = array_filter($setB, function($n) { return !empty($n); });
            
            if (empty($setA) || empty($setB)) {
                $error = 'Por favor, ingrese números válidos en ambos conjuntos.';
            } else {
                $setOperations = new ConjuntosOperaciones();
                $operations = $setOperations->processSetOperations($setA, $setB);
                
                $inputData = "Conjunto A: " . $setOperations->formatNumbers($operations['setA']) . 
                            "\nConjunto B: " . $setOperations->formatNumbers($operations['setB']);
                
                $result = "Conjuntos ingresados:\n";
                $result .= "Conjunto A: " . $setOperations->formatNumbers($operations['setA']) . "\n";
                $result .= "Conjunto B: " . $setOperations->formatNumbers($operations['setB']) . "\n\n";
                $result .= "Resultados de las operaciones:\n";
                $result .= "Unión (A ∪ B): " . $setOperations->formatNumbers($operations['union']) . "\n";
                $result .= "Intersección (A ∩ B): " . $setOperations->formatNumbers($operations['intersection']) . "\n";
                $result .= "Diferencia (A - B): " . $setOperations->formatNumbers($operations['differenceAB']) . "\n";
                $result .= "Diferencia (B - A): " . $setOperations->formatNumbers($operations['differenceBA']);
            }
        } catch (Exception $e) {
            $error = 'Error en las operaciones de conjuntos: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones de Conjuntos</title>
    <link rel="stylesheet" href="conjuntos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="../.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al Menú Principal
            </a>
        </div>
        
        <div class="form-section">
            <h2><i class="fas fa-project-diagram"></i> Operaciones de Conjuntos</h2>
            <p>Calcula unión, intersección y diferencia de dos conjuntos de números enteros.</p>
            
            <form method="POST">
                <div class="sets-container">
                    <div class="set-group">
                        <h3>Conjunto A</h3>
                        <div class="form-group">
                            <label for="setA">Números del conjunto A (separados por comas):</label>
                            <textarea 
                                id="setA" 
                                name="setA"
                                rows="3"
                                placeholder="Ej: 1, 2, 3, 4, 5"
                                required
                            ></textarea>
                        </div>
                    </div>
                    
                    <div class="set-group">
                        <h3>Conjunto B</h3>
                        <div class="form-group">
                            <label for="setB">Números del conjunto B (separados por comas):</label>
                            <textarea 
                                id="setB" 
                                name="setB"
                                rows="3"
                                placeholder="Ej: 4, 5, 6, 7, 8"
                                required
                            ></textarea>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Calcular Operaciones
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




