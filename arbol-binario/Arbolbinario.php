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
        } elseif ($pre && $post) {
            $val = ArbolBinario::validarEntradas($pre, $post);
            if (!$val['ok']) {
                echo "<div class='error'><h3>⚠️ Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePrePost($pre, $post);
                if ($arbol === null) {
                    echo "<div class='error'><h3>⚠️ No se pudo construir el árbol</h3><p>Pre + Post puede no ser único a menos que el árbol sea completo (cada nodo 0 o 2 hijos). Asegúrate que corresponda a un árbol completo.</p></div>";
                } else {
                    echo "<h3>✅ Árbol reconstruido (Pre + Post)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } else {
            echo "<div class='error'><h3>⚠️ Faltan datos</h3><p>Debes ingresar al menos dos recorridos, y uno debe ser INORDEN.</p></div>";
        }
        echo "</div>";
    }
    ?>
</div>
</body>
</html>
