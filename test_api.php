<?php

/**
 * Archivo de prueba para demostrar el uso de la API
 * Este archivo muestra ejemplos de cómo usar cada una de las 6 aplicaciones
 */

echo "=== PRUEBAS DE LA API DE TALLER PHP ===\n\n";

// Función para hacer peticiones POST
function makePostRequest($option, $data) {
    $url = 'http://localhost/taller_PHP/index.php?option=' . $option;
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        return ['error' => 'Error al conectar con la API'];
    }
    
    return json_decode($result, true);
}

// 1. Prueba del Generador de Acrónimos
echo "1. GENERADOR DE ACRÓNIMOS\n";
echo "========================\n";
$acronymTest = makePostRequest('acronym', ['phrase' => 'Portable Network Graphics']);
echo "Entrada: Portable Network Graphics\n";
echo "Resultado: " . ($acronymTest['result'] ?? $acronymTest['error']) . "\n\n";

// 2. Prueba de Fibonacci y Factorial
echo "2. FIBONACCI Y FACTORIAL\n";
echo "=======================\n";
$mathTest = makePostRequest('math', ['number' => '8', 'operation' => 'fibonacci']);
echo "Entrada: Número 8, Operación Fibonacci\n";
echo "Resultado: " . ($mathTest['result'] ?? $mathTest['error']) . "\n\n";

// 3. Prueba de Estadísticas
echo "3. ESTADÍSTICAS\n";
echo "===============\n";
$statsTest = makePostRequest('statistics', ['numbers' => ['5', '2', '8', '2', '9', '2', '1']]);
echo "Entrada: [5, 2, 8, 2, 9, 2, 1]\n";
echo "Resultado: " . str_replace("\n", " | ", $statsTest['result'] ?? $statsTest['error']) . "\n\n";

// 4. Prueba de Operaciones de Conjuntos
echo "4. OPERACIONES DE CONJUNTOS\n";
echo "===========================\n";
$setsTest = makePostRequest('sets', [
    'setA' => ['1', '2', '3', '4', '5'],
    'setB' => ['4', '5', '6', '7', '8']
]);
echo "Entrada: A = {1,2,3,4,5}, B = {4,5,6,7,8}\n";
echo "Resultado: " . str_replace("\n", " | ", $setsTest['result'] ?? $setsTest['error']) . "\n\n";

// 5. Prueba de Conversión a Binario
echo "5. CONVERSIÓN A BINARIO\n";
echo "=======================\n";
$binaryTest = makePostRequest('binary', ['number' => '255']);
echo "Entrada: 255\n";
echo "Resultado: " . str_replace("\n", " | ", $binaryTest['result'] ?? $binaryTest['error']) . "\n\n";

// 6. Prueba de Construcción de Árbol Binario
echo "6. CONSTRUCCIÓN DE ÁRBOL BINARIO\n";
echo "================================\n";
$treeTest = makePostRequest('tree', [
    'preorder' => ['A', 'B', 'D', 'E', 'C'],
    'inorder' => ['D', 'B', 'E', 'A', 'C'],
    'postorder' => []
]);
echo "Entrada: Preorden = [A,B,D,E,C], Inorden = [D,B,E,A,C]\n";
echo "Resultado: " . str_replace("\n", " | ", $treeTest['result'] ?? $treeTest['error']) . "\n\n";

echo "=== FIN DE LAS PRUEBAS ===\n";

?>
