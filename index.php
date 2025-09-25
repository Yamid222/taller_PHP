<?php

require_once 'AcronymGenerator.php';
require_once 'TextProcessor.php';
require_once 'MathCalculator.php';
require_once 'StatisticsCalculator.php';
require_once 'SetOperations.php';
require_once 'BinaryConverter.php';
require_once 'BinaryTreeBuilder.php';

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
            break;
            
        case 'statistics':
            $numbersInput = $_POST['numbers'] ?? '';
            if (empty(trim($numbersInput))) {
                $error = 'Por favor, ingrese al menos un número.';
            } else {
                try {
                    // Convertir string de números separados por comas a array
                    $numbers = array_map('trim', explode(',', $numbersInput));
                    $numbers = array_filter($numbers, function($n) { return $n !== ''; });
                    
                    if (empty($numbers)) {
                        $error = 'Por favor, ingrese números válidos.';
                    } else {
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
                    }
                } catch (Exception $e) {
                    $error = 'Error en el cálculo: ' . $e->getMessage();
                }
            }
            break;
            
        case 'sets':
            $setAInput = $_POST['setA'] ?? '';
            $setBInput = $_POST['setB'] ?? '';
            
            if (empty(trim($setAInput)) || empty(trim($setBInput))) {
                $error = 'Por favor, ingrese números en ambos conjuntos.';
            } else {
                try {
                    // Convertir strings a arrays
                    $setA = array_map('trim', explode(',', $setAInput));
                    $setB = array_map('trim', explode(',', $setBInput));
                    
                    $setA = array_filter($setA, function($n) { return !empty($n); });
                    $setB = array_filter($setB, function($n) { return !empty($n); });
                    
                    if (empty($setA) || empty($setB)) {
                        $error = 'Por favor, ingrese números válidos en ambos conjuntos.';
                    } else {
                        $setOperations = new SetOperations();
                        $operations = $setOperations->processSetOperations($setA, $setB);
                        
                        $inputData = "Conjunto A: " . $setOperations->formatNumbers($operations['setA']) . 
                                    "\nConjunto B: " . $setOperations->formatNumbers($operations['setB']);
                        
                        $result = "Unión (A ∪ B): " . $setOperations->formatNumbers($operations['union']) . "\n";
                        $result .= "Intersección (A ∩ B): " . $setOperations->formatNumbers($operations['intersection']) . "\n";
                        $result .= "Diferencia (A - B): " . $setOperations->formatNumbers($operations['differenceAB']) . "\n";
                        $result .= "Diferencia (B - A): " . $setOperations->formatNumbers($operations['differenceBA']);
                    }
                } catch (Exception $e) {
                    $error = 'Error en las operaciones de conjuntos: ' . $e->getMessage();
                }
            }
            break;
            
        case 'binary':
            $number = $_POST['number'] ?? '';
            
            if (empty($number)) {
                $error = 'Por favor, ingrese un número.';
            } else {
                try {
                    $binaryConverter = new BinaryConverter();
                    $conversion = $binaryConverter->processConversion($number);
                    
                    $inputData = $conversion['decimal'];
                    $result = "Número decimal: " . $conversion['decimal'] . "\n";
                    $result .= "Número binario: " . $conversion['binary'] . "\n";
                    $result .= "Longitud en binario: " . $conversion['binary_length'] . " bits\n";
                    $result .= "Hexadecimal: " . strtoupper($conversion['hexadecimal']) . "\n";
                    $result .= "Octal: " . $conversion['octal'];
                    
                    if ($conversion['is_power_of_2']) {
                        $result .= "\nEs una potencia de 2";
                    }
                } catch (Exception $e) {
                    $error = 'Error en la conversión: ' . $e->getMessage();
                }
            }
            break;
            
        case 'tree':
            $preorderInput = $_POST['preorder'] ?? '';
            $inorderInput = $_POST['inorder'] ?? '';
            $postorderInput = $_POST['postorder'] ?? '';
            
            // Convertir strings a arrays
            $preorder = !empty($preorderInput) ? array_map('trim', explode(',', $preorderInput)) : [];
            $inorder = !empty($inorderInput) ? array_map('trim', explode(',', $inorderInput)) : [];
            $postorder = !empty($postorderInput) ? array_map('trim', explode(',', $postorderInput)) : [];
            
            $preorder = array_filter($preorder, function($item) { return !empty($item); });
            $inorder = array_filter($inorder, function($item) { return !empty($item); });
            $postorder = array_filter($postorder, function($item) { return !empty($item); });
            
            if (count($preorder) + count($inorder) + count($postorder) < 2) {
                $error = 'Se necesitan al menos dos recorridos para construir el árbol.';
            } else {
                try {
                    $treeBuilder = new BinaryTreeBuilder();
                    $treeResult = $treeBuilder->processTreeConstruction($preorder, $inorder, $postorder);
                    
                    $inputData = "Método usado: " . $treeResult['method'];
                    $result = "Recorrido Preorden: " . implode(" → ", $treeResult['preorder']) . "\n";
                    $result .= "Recorrido Inorden: " . implode(" → ", $treeResult['inorder']) . "\n";
                    $result .= "Recorrido Postorden: " . implode(" → ", $treeResult['postorder']) . "\n\n";
                    $result .= "Estructura del árbol:\n" . $treeResult['visualization'];
                } catch (Exception $e) {
                    $error = 'Error al construir el árbol: ' . $e->getMessage();
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php if ($option === 'menu'): ?>
            <!-- Menú Principal -->
            <div class="menu" id="mainMenu">
                <header>
                    <h1><i class="fas fa-calculator"></i> Taller PHP - Aplicaciones Matemáticas</h1>
                    <p>Seleccione una de las siguientes aplicaciones:</p>
                </header>
                
                <div class="menu-options">
                    <a href="?option=acronym" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-font"></i>
                        </div>
                        <h3>Generador de Acrónimos</h3>
                        <p>Convierte frases largas en acrónimos. Ej: "Portable Network Graphics" → "PNG"</p>
                    </a>
                    
                    <a href="?option=math" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-superscript"></i>
                        </div>
                        <h3>Fibonacci y Factorial</h3>
                        <p>Calcula sucesión de Fibonacci o factorial de un número dado</p>
                    </a>
                    
                    <a href="?option=statistics" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3>Estadísticas</h3>
                        <p>Calcula promedio, mediana y moda de una serie de números</p>
                    </a>
                    
                    <a href="?option=sets" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h3>Operaciones de Conjuntos</h3>
                        <p>Calcula unión, intersección y diferencia de dos conjuntos</p>
                    </a>
                    
                    <a href="?option=binary" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-binary"></i>
                        </div>
                        <h3>Conversión a Binario</h3>
                        <p>Convierte números enteros a su representación binaria</p>
                    </a>
                    
                    <a href="?option=tree" class="menu-option">
                        <div class="option-icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <h3>Árbol Binario</h3>
                        <p>Construye árbol binario desde recorridos preorden, inorden y postorden</p>
                    </a>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Navegación -->
            <div class="nav">
                <a href="?option=menu" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver al Menú
                </a>
            </div>
            
            <?php if ($option === 'acronym'): ?>
                <!-- Generador de Acrónimos -->
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
                    
                    <div class="examples">
                        <h3><i class="fas fa-lightbulb"></i> Ejemplos de uso:</h3>
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
                
            <?php elseif ($option === 'statistics'): ?>
                <!-- Estadísticas -->
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
                                placeholder="Ej: 1,2,5,4,0"
                                required
                            ><?php echo htmlspecialchars($inputData); ?></textarea>
                            <small>Separe los números con comas SIN espacios. Ejemplo: 1,2,5,4,0</small>
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
                
            <?php elseif ($option === 'sets'): ?>
                <!-- Operaciones de Conjuntos -->
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
                
            <?php elseif ($option === 'binary'): ?>
                <!-- Conversión a Binario -->
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
                
            <?php elseif ($option === 'tree'): ?>
                <!-- Construcción de Árbol Binario -->
                <div class="form-section">
                    <h2><i class="fas fa-sitemap"></i> Construcción de Árbol Binario</h2>
                    <p>Construye un árbol binario a partir de sus recorridos. Ingrese al menos dos recorridos.</p>
                    
                    <form method="POST">
                        <div class="traversals-container">
                            <div class="traversal-group">
                                <h3>Recorrido Preorden</h3>
                                <div class="form-group">
                                    <label for="preorder">Elementos del recorrido preorden (separados por comas):</label>
                                    <textarea 
                                        id="preorder" 
                                        name="preorder"
                                        rows="2"
                                        placeholder="Ej: A, B, D, E, C"
                                    ><?php echo htmlspecialchars($_POST['preorder'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="traversal-group">
                                <h3>Recorrido Inorden</h3>
                                <div class="form-group">
                                    <label for="inorder">Elementos del recorrido inorden (separados por comas):</label>
                                    <textarea 
                                        id="inorder" 
                                        name="inorder"
                                        rows="2"
                                        placeholder="Ej: D, B, E, A, C"
                                    ><?php echo htmlspecialchars($_POST['inorder'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="traversal-group">
                                <h3>Recorrido Postorden</h3>
                                <div class="form-group">
                                    <label for="postorder">Elementos del recorrido postorden (separados por comas):</label>
                                    <textarea 
                                        id="postorder" 
                                        name="postorder"
                                        rows="2"
                                        placeholder="Ej: D, E, B, C, A"
                                    ><?php echo htmlspecialchars($_POST['postorder'] ?? ''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-tree"></i> Construir Árbol
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
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
