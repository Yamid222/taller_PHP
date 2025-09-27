<?php

require_once 'Acrointerface.php';
require_once 'EliminarTxt.php';
require_once 'AcronimoGenerador.php';

$result = '';
$error = '';
$inputData = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = $_POST['phrase'] ?? '';
    if (empty(trim($inputData))) {
        $error = 'Por favor, ingrese una frase válida.';
    } else {
        try {
            $textProcessor = new EliminarTxt();
            $acronymGenerator = new AcronimoGenerador($textProcessor);
            $result = $acronymGenerator->generateAcronym($inputData);
        } catch (Exception $e) {
            $error = 'Error al procesar la frase: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Acrónimos</title>
    <link rel="stylesheet" href="acronimo.css">
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
            <h2><i class="fas fa-font"></i> Generador de Acrónimos</h2>
            <p>Convierte una frase en su acrónimo. Los guiones son separadores de palabras.</p>
            
            <form method="POST">
                <div class="form-group">
                    <label for="phrase">Ingrese una frase:</label>
                    <input 
                        type="text" 
                        id="phrase" 
                        name="phrase"
                        value="<?php echo htmlspecialchars($inputData); ?>"
                        placeholder="Ej: Portable Network Graphics"
                        required
                    >
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-magic"></i> Generar Acrónimo
                </button>
            </form>
            
            <?php if (!empty($result)): ?>
                <div class="result-section">
                    <h3><i class="fas fa-check-circle"></i> Acrónimo generado:</h3>
                    <div class="result-value"><?php echo htmlspecialchars($result); ?></div>
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




