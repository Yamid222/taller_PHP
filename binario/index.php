<?php

require_once 'BinarioConbertir.php';

$result = '';
$error = '';
$inputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = $_POST['number'] ?? '';
    
    if (empty($number)) {
        $error = 'Por favor, ingrese un número.';
    } else {
        try {
            $binaryConverter = new BinarioConbertir();
            $conversion = $binaryConverter->processConversion($number);
            
            $inputData = $conversion['decimal'];
            $result = "Número ingresado: " . $conversion['decimal'] . "\n";
            $result .= "Número binario: " . $conversion['binary'];
        } catch (Exception $e) {
            $error = 'Error en la conversión: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversión a Binario</title>
    <link rel="stylesheet" href="binario.css">
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
            <h2><i class="fas fa-binary"></i> Conversión a Binario</h2>
            <p>Convierte un número entero a su representación binaria.</p>
            
            <form method="POST">
                <div class="form-group">
                    <label for="number">Número entero:</label>
                    <input 
                        type="number" 
                        id="number" 
                        name="number"
                        value="<?php echo htmlspecialchars($inputData); ?>"
                        min="0"
                        placeholder="Ingrese un número entero positivo"
                        required
                    >
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-exchange-alt"></i> Convertir a Binario
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




