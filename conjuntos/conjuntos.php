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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="conjuntos.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>🔢 Calculadora de Conjuntos</title>
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
                <h2>🔢 Calculadora de Conjuntos</h2>
                <p>Realiza operaciones matemáticas con conjuntos: unión, intersección, diferencia y más</p>
                
                <form method="post">
                    <div class="sets-container">
                        <div class="set-group">
                            <h3>Conjunto A</h3>
                            <div class="form-group">
                                <label for="conjuntoA">Elementos (separados por comas):</label>
                                <input type="text" id="conjuntoA" name="conjuntoA" required 
                                       placeholder="Ejemplo: 1, 2, 3, 4, 5"
                                       value="<?php echo isset($_POST['conjuntoA']) ? htmlspecialchars($_POST['conjuntoA']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="set-group">
                            <h3>Conjunto B</h3>
                            <div class="form-group">
                                <label for="conjuntoB">Elementos (separados por comas):</label>
                                <input type="text" id="conjuntoB" name="conjuntoB" required 
                                       placeholder="Ejemplo: 3, 4, 5, 6, 7"
                                       value="<?php echo isset($_POST['conjuntoB']) ? htmlspecialchars($_POST['conjuntoB']) : ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">
                        🧮 Calcular Operaciones
                    </button>
                </form>
                
                <?php if ($resultados): ?>
                <div class="result-section">
                    <h3>📊 Resultados de las Operaciones</h3>
                    <?php foreach ($resultados as $nombre => $conjunto): ?>
                        <div class="result-list">
                            <strong><?php echo htmlspecialchars($nombre); ?>:</strong><br>
                            { <?php echo htmlspecialchars(implode(", ", $conjunto)); ?> }
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>