<?php

require_once 'Binarios.php';

$result = '';
$error = '';
$inputData = '';
$arbolVisual = '';
$recorridos = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preorderInput = $_POST['preorder'] ?? '';
    $inorderInput = $_POST['inorder'] ?? '';
    $postorderInput = $_POST['postorder'] ?? '';
    
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
            $arbol = new BinaryTree();
            $raiz = null;
            $metodo = '';
            
            if (!empty($preorder) && !empty($inorder)) {
                $raiz = $arbol->buildFromPreIn($preorder, $inorder);
                $metodo = "Preorden + Inorden";
            } elseif (!empty($postorder) && !empty($inorder)) {
                $raiz = $arbol->buildFromPostIn($postorder, $inorder);
                $metodo = "Postorden + Inorden";
            } else {
                $error = 'Debes proporcionar al menos Preorden+Inorden o Postorden+Inorden.';
            }
            
            if ($raiz) {
                $recorridos = $arbol->obtenerInfo($raiz);
                $arbolVisual = $arbol->dibujarArbol($raiz);
                
                $result = "Método usado: " . $metodo . "\n\n";
                $result .= "Recorridos del árbol construido:\n";
                $result .= "Preorden: " . implode(" → ", $recorridos['preorden']) . "\n";
                $result .= "Inorden: " . implode(" → ", $recorridos['inorden']) . "\n";
                $result .= "Postorden: " . implode(" → ", $recorridos['postorden']);
            }
        } catch (Exception $e) {
            $error = 'Error al construir el árbol: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construcción de Árbol Binario</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="../index.html" class="btn-back">
                ← Volver al inicio
            </a>
        </div>
        
        <div class="form-section">
            <h2>🌳 Construcción de Árbol Binario</h2>
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
                
                <button type="submit" class="btn">
                    🌳 Construir Árbol
                </button>
            </form>
            
            <?php if (!empty($arbolVisual)): ?>
                <div class="result-section">
                    <h3>Árbol Binario Construido:</h3>
                    <?php echo $arbolVisual; ?>
                </div>
                
                <div class="traversal-results">
                    <h3>📋 Recorridos del Árbol:</h3>
                    <div class="traversal-item">
                        <strong>Preorden:</strong> <?php echo implode(" → ", $recorridos['preorden']); ?>
                    </div>
                    <div class="traversal-item">
                        <strong>Inorden:</strong> <?php echo implode(" → ", $recorridos['inorden']); ?>
                    </div>
                    <div class="traversal-item">
                        <strong>Postorden:</strong> <?php echo implode(" → ", $recorridos['postorden']); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($result)): ?>
                <div class="result-section">
                    <h3>ℹ️ Información:</h3>
                    <div class="result-list"><?php echo nl2br(htmlspecialchars($result)); ?></div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="error">
                    <h3>⚠️ Error</h3>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>