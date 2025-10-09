<?php
require 'classBinarios.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="binarios.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>💾 Conversor Binario</title>
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
                <h2>💾 Conversor de Entero a Binario</h2>
                <p>Convierte números enteros a su representación binaria</p>
                
                <form method="post">
                    <div class="form-group">
                        <label for="numero">Ingrese un número entero:</label>
                        <input type="number" id="numero" name="numero" required 
                               placeholder="Ejemplo: 255"
                               value="<?php echo isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : ''; ?>">
                    </div>
                    
                    <button type="submit" class="btn">
                        🔄 Convertir a Binario
                    </button>
                </form>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $numero = intval($_POST["numero"]);
                    $conversor = new ConversorBinario($numero);
                    $resultado = $conversor->convertir();
                ?>
                    <div class="result-section">
                        <h3>✅ Resultado de la Conversión</h3>
                        <div class="result-value">
                            El número <strong><?php echo $numero; ?></strong> en binario es: <strong><?php echo $resultado; ?></strong>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>