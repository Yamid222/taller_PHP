<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#4CAF50">
    <meta name="description" content="Herramienta para reconstruir y recorrer árboles binarios a partir de recorridos.">
    <style>
        .form-section input {
            color: #000 !important;
            background: #fff !important;
            transition: none !important;
        }
        .form-section input::placeholder {
            color: #6c757d;
        }
        .form-section, .form-section * {
            animation: none !important;
            transition: none !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <a href="../index.html" class="btn btn-secondary btn-back">⬅ Volver</a>
        </nav>

        <section class="section form-section">
            <h2>🌳 Árbol Binario</h2>
            <p>Construye un árbol a partir de dos recorridos y visualiza sus recorridos resultantes.</p>

            <div class="examples">
                <h3>📌 Ejemplos (usa comas)</h3>
                <div class="example">Preorden= A,B,D,E,C</div>
                <div class="example">Inorden= D,B,E,A,C</div>
                <div class="example">Postorden= D,E,B,C,A</div>
            </div>

            <form method="POST" action="Arbolbinario.php" class="form-group">
                <div class="traversals-container">
                    <div class="traversal-group">
                        <h3>Preorden</h3>
                        <input type="text" name="preorden" placeholder="Ej: A,B,D,E,C">
                        <small>Usa comas para separar los valores.</small>
                    </div>
                    <div class="traversal-group">
                        <h3>Inorden</h3>
                        <input type="text" name="inorden" placeholder="Ej: D,B,E,A,C" required>
                        <small>Usa comas para separar los valores.</small>
                    </div>
                    <div class="traversal-group">
                        <h3>Postorden</h3>
                        <input type="text" name="postorden" placeholder="Ej: D,E,B,C,A">
                        <small>Usa comas para separar los valores.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Construir árbol</button>
            </form>

            
        </section>

    <?php
    include("clasArbolbinario.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pre = isset($_POST["preorden"]) ? $_POST["preorden"] : '';
        $in = isset($_POST["inorden"]) ? $_POST["inorden"] : '';
        $post = isset($_POST["postorden"]) ? $_POST["postorden"] : '';

        echo "<div class='result-section'>";
        
        if ($pre && $in) {
            $val = ArbolBinario::validarEntradas($pre, $in);
            if (!$val['ok']) {
                echo "<div class='error'><h3>⚠️ Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePreIn($pre, $in);
                if ($arbol === null) {
                    echo "<div class='error'><h3>⚠️ No se pudo construir el árbol</h3><p>Revisa que los recorridos correspondan al mismo árbol.</p></div>";
                } else {
                    echo "<h3>✅ Árbol reconstruido (Pre + In)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } elseif ($post && $in) {
            $val = ArbolBinario::validarEntradas($post, $in);
            if (!$val['ok']) {
                echo "<div class='error'><h3>⚠️ Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePostIn($post, $in);
                if ($arbol === null) {
                    echo "<div class='error'><h3>⚠️ No se pudo construir el árbol</h3><p>Revisa que los recorridos correspondan al mismo árbol.</p></div>";
                } else {
                    echo "<h3>✅ Árbol reconstruido (Post + In)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } else {
            echo "<div class='error'><h3>⚠️ Faltan datos</h3>";
            echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin: 10px 0;'>";
            echo "<p style='color: #721c24; margin-bottom: 10px;'>Para construir un árbol binario necesitas:</p>";
            echo "<ul style='color: #721c24; margin: 0; padding-left: 20px;'>";
            echo "<li><strong>Al menos 2 recorridos</strong> de los 3 disponibles</li>";
            echo "<li><strong>Uno de ellos debe ser INORDEN</strong> (esencial para determinar la estructura)</li>";
            echo "</ul>";
            echo "<p style='color: #721c24; margin-top: 10px; margin-bottom: 0;'><strong>💡 Recomendación:</strong> Usa <strong>Preorden + Inorden</strong> o <strong>Postorden + Inorden</strong> para mejores resultados.</p>";
            echo "</div></div>";
        }
        echo "</div>";
    }
    ?>
    
    <!-- Mensaje educativo permanente -->
    <div style="background: #e8f5e8; border: 1px solid #4CAF50; border-radius: 8px; padding: 20px; margin: 30px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h3 style="color: #2e7d32; margin-top: 0; display: flex; align-items: center;">
            <span style="margin-right: 10px;">📚</span>
            Información importante sobre recorridos
        </h3>
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 15px; margin: 15px 0;">
            <h4 style="color: #856404; margin-top: 0;">⚠️ Limitaciones de Preorden + Postorden</h4>
            <p style="color: #856404; margin-bottom: 10px;">La combinación <strong>Preorden + Postorden</strong> tiene limitaciones importantes:</p>
            <ul style="color: #856404; margin: 0; padding-left: 20px;">
                <li><strong>No es única:</strong> Múltiples árboles pueden generar los mismos recorridos pre y post</li>
                <li><strong>Solo funciona con árboles completos:</strong> Cada nodo debe tener 0 o exactamente 2 hijos</li>
                <li><strong>Falta información estructural:</strong> Sin inorden, no se puede determinar la estructura interna</li>
            </ul>
            <p style="color: #856404; margin-top: 10px; margin-bottom: 0;"><strong>💡 Recomendación:</strong> Usa <strong>Preorden + Inorden</strong> o <strong>Postorden + Inorden</strong> para una reconstrucción única y confiable.</p>
        </div>
        <div style="background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; padding: 15px;">
            <h4 style="color: #0c5460; margin-top: 0;">✅ Combinaciones recomendadas</h4>
            <ul style="color: #0c5460; margin: 0; padding-left: 20px;">
                <li><strong>Preorden + Inorden:</strong> Reconstrucción única y confiable</li>
                <li><strong>Postorden + Inorden:</strong> Reconstrucción única y confiable</li>
                <li><strong>Inorden es esencial:</strong> Proporciona la información estructural necesaria</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
