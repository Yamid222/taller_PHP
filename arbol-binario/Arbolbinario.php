<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="Arbolbinario.css">
</head>
<body>
    <section>
        <h1>🌳 Construcción de Árbol Binario</h1>
        <form method="POST" action="Arbolbinario.php">
            <label>Preorden:</label>
            <input type="text" name="preorden" placeholder="Ej: A B D E C">

            <label>Inorden:</label>
            <input type="text" name="inorden" placeholder="Ej: D B E A C">

            <label>Postorden:</label>
            <input type="text" name="postorden" placeholder="Ej: D E B C A">

            <button type="submit">Construir árbol</button>
        </form>
    </section>

    <?php
    include("clasArbolbinario.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pre = trim($_POST["preorden"]);
        $in = trim($_POST["inorden"]);
        $post = trim($_POST["postorden"]);

        echo "<div class='result'>";
        if ($pre && $in) {
            $arbol = ArbolBinario::desdePreIn($pre, $in);
            echo "<h2>✅ Árbol reconstruido (Pre + In)</h2>";
            ArbolBinario::mostrarRecorridos($arbol);
        } elseif ($post && $in) {
            $arbol = ArbolBinario::desdePostIn($post, $in);
            echo "<h2>✅ Árbol reconstruido (Post + In)</h2>";
            ArbolBinario::mostrarRecorridos($arbol);
        } else {
            echo "<p style='color:orange'>⚠️ Debes ingresar al menos dos recorridos, y uno debe ser INORDEN.</p>";
        }
        echo "</div>";
    }
    ?>
</body>
</html>
