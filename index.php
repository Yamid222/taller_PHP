<?php

require_once 'AcronymGenerator.php';
require_once 'TextProcessor.php';
require_once 'MathCalculator.php';
require_once 'StatisticsCalculator.php';

// Obtener la opción seleccionada
$option = $_GET['option'] ?? 'menu';

// Variables para resultados
$result = '';
$error = '';
$inputData = '';

// Procesar formularios según la opción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($option) {
        case 'acronym':
            $inputData = $_POST['phrase'] ?? '';
            if (empty(trim($inputData))) {
                $error = 'Por favor, ingrese una frase válida.';
            } else {
                try {
                    $textProcessor = new TextProcessor();
                    $acronymGenerator = new AcronymGenerator($textProcessor);
                    $result = $acronymGenerator->generateAcronym($inputData);
                } catch (Exception $e) {
                    $error = 'Error al procesar la frase: ' . $e->getMessage();
                }
            }
            break;
            
        case 'math':
            $number = $_POST['number'] ?? '';
            $operation = $_POST['operation'] ?? '';
            
            if (empty($number) || empty($operation)) {
                $error = 'Por favor, complete todos los campos.';
            } else {
                try {
                    $mathCalculator = new MathCalculator();
                    
                    if (!$mathCalculator->isValidNumber($number)) {
                        $error = 'Por favor, ingrese un número entero positivo válido.';
                    } else {
                        $number = (int)$number;
                        $inputData = $number;
                        
                        if ($operation === 'fibonacci') {
                            $fibonacci = $mathCalculator->calculateFibonacci($number);
                            $result = implode(', ', $fibonacci);
                        } else {
                            $factorial = $mathCalculator->calculateFactorial($number);
                            $result = $factorial;
                        }
                    }
                } catch (Exception $e) {
                    $error = 'Error en el cálculo: ' . $e->getMessage();
                }
            }
            break;
            
        case 'statistics':
            $numbers = $_POST['numbers'] ?? [];
            $numbers = array_filter($numbers, function($n) { return !empty(trim($n)); });
            
            if (empty($numbers)) {
                $error = 'Por favor, ingrese al menos un número.';
            } else {
                try {
                    $statsCalculator = new StatisticsCalculator();
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
                } catch (Exception $e) {
                    $error = 'Error en el cálculo: ' . $e->getMessage();
                }
            }
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller PHP - Aplicaciones Matemáticas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if ($option === 'menu'): ?>
            <!-- Menú Principal -->
            <div class="menu">
                <h1>🧮 Taller PHP - Aplicaciones Matemáticas</h1>
                <p>Seleccione una de las siguientes opciones:</p>
                
                <div class="menu-options">
                    <a href="?option=acronym" class="menu-option">
                        <h3>🔤 Generador de Acrónimos</h3>
                        <p>Convierte frases largas en acrónimos. Ej: "Portable Network Graphics" → "PNG"</p>
                    </a>
                    
                    <a href="?option=math" class="menu-option">
                        <h3>🔢 Fibonacci y Factorial</h3>
                        <p>Calcula sucesión de Fibonacci o factorial de un número dado</p>
                    </a>
                    
                    <a href="?option=statistics" class="menu-option">
                        <h3>📊 Estadísticas</h3>
                        <p>Calcula promedio, mediana y moda de una serie de números</p>
                    </a>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Navegación -->
            <div class="nav">
                <a href="?option=menu">← Volver al Menú</a>
            </div>
            
            <?php if ($option === 'acronym'): ?>
                <!-- Generador de Acrónimos -->
                <div class="form-section">
                    <h2>🔤 Generador de Acrónimos</h2>
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
                        
                        <button type="submit" class="btn">Generar Acrónimo</button>
                    </form>
                    
                    <?php if (!empty($result)): ?>
                        <div class="result-section">
                            <h3>✅ Acrónimo generado:</h3>
                            <div class="result-value"><?php echo htmlspecialchars($result); ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="examples">
                        <h3>💡 Ejemplos de uso:</h3>
                        <div class="example">
                            <strong>As Soon As Possible</strong> → <strong>ASAP</strong>
                        </div>
                        <div class="example">
                            <strong>Liquid-crystal display</strong> → <strong>LCD</strong>
                        </div>
                        <div class="example">
                            <strong>Thank George It's Friday!</strong> → <strong>TGIF</strong>
                        </div>
                    </div>
                </div>
                
            <?php elseif ($option === 'math'): ?>
                <!-- Fibonacci y Factorial -->
                <div class="form-section">
                    <h2>🔢 Fibonacci y Factorial</h2>
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
                        
                        <button type="submit" class="btn">Calcular</button>
                    </form>
                    
                    <?php if (!empty($result)): ?>
                        <div class="result-section">
                            <h3>✅ Resultado:</h3>
                            <?php if ($_POST['operation'] ?? '' === 'fibonacci'): ?>
                                <div class="result-list"><?php echo htmlspecialchars($result); ?></div>
                            <?php else: ?>
                                <div class="result-value"><?php echo htmlspecialchars($result); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php elseif ($option === 'statistics'): ?>
                <!-- Estadísticas -->
                <div class="form-section">
                    <h2>📊 Estadísticas</h2>
                    <p>Calcula promedio, mediana y moda de una serie de números.</p>
                    
                    <form method="POST" id="statsForm">
                        <div class="numbers-input">
                            <label for="newNumber">Agregar número:</label>
                            <input 
                                type="number" 
                                id="newNumber" 
                                step="any"
                                placeholder="Ingrese un número"
                            >
                            <button type="button" class="add-number-btn" onclick="addNumber()">Agregar</button>
                        </div>
                        
                        <div class="numbers-list" id="numbersList">
                            <?php if (!empty($_POST['numbers'])): ?>
                                <?php foreach ($_POST['numbers'] as $index => $number): ?>
                                    <?php if (!empty(trim($number))): ?>
                                        <span class="number-item">
                                            <?php echo htmlspecialchars($number); ?>
                                            <button type="button" class="remove-number" onclick="removeNumber(<?php echo $index; ?>)">×</button>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        
                        <input type="hidden" name="numbers" id="numbersInput" value="<?php echo htmlspecialchars(implode(',', $_POST['numbers'] ?? [])); ?>">
                        
                        <button type="submit" class="btn">Calcular Estadísticas</button>
                    </form>
                    
                    <?php if (!empty($result)): ?>
                        <div class="result-section">
                            <h3>✅ Resultados:</h3>
                            <div class="result-list"><?php echo nl2br(htmlspecialchars($result)); ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="error">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <script>
                    let numbers = [];
                    
                    function addNumber() {
                        const input = document.getElementById('newNumber');
                        const number = parseFloat(input.value);
                        
                        if (!isNaN(number)) {
                            numbers.push(number);
                            updateNumbersList();
                            updateHiddenInput();
                            input.value = '';
                        }
                    }
                    
                    function removeNumber(index) {
                        numbers.splice(index, 1);
                        updateNumbersList();
                        updateHiddenInput();
                    }
                    
                    function updateNumbersList() {
                        const list = document.getElementById('numbersList');
                        list.innerHTML = '';
                        
                        numbers.forEach((number, index) => {
                            const span = document.createElement('span');
                            span.className = 'number-item';
                            span.innerHTML = number + '<button type="button" class="remove-number" onclick="removeNumber(' + index + ')">×</button>';
                            list.appendChild(span);
                        });
                    }
                    
                    function updateHiddenInput() {
                        document.getElementById('numbersInput').value = numbers.join(',');
                    }
                    
                    // Cargar números existentes
                    document.addEventListener('DOMContentLoaded', function() {
                        const existingNumbers = document.getElementById('numbersInput').value;
                        if (existingNumbers) {
                            numbers = existingNumbers.split(',').map(n => parseFloat(n)).filter(n => !isNaN(n));
                            updateNumbersList();
                        }
                    });
                </script>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
