<?php
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
        <div class="menu" id="mainMenu">
            <header>
                <h1><i class="fas fa-calculator"></i> Taller PHP - Aplicaciones Matemáticas</h1>
                <p>Seleccione una de las siguientes aplicaciones:</p>
            </header>
            
            <div class="menu-options">
                <a href="acronimos/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-font"></i>
                    </div>
                    <h3>Generador de Acrónimos</h3>
                    <p>Convierte frases largas en acrónimos. Ej: "Portable Network Graphics" → "PNG"</p>
                </a>
                
                <a href="fibonacci-factorial/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-superscript"></i>
                    </div>
                    <h3>Fibonacci y Factorial</h3>
                    <p>Calcula sucesión de Fibonacci o factorial de un número dado</p>
                </a>
                
                <a href="estadisticas/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Estadísticas</h3>
                    <p>Calcula promedio, mediana y moda de una serie de números</p>
                </a>
                
                <a href="conjuntos/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3>Operaciones de Conjuntos</h3>
                    <p>Calcula unión, intersección y diferencia de dos conjuntos</p>
                </a>
                
                <a href="binario/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-binary"></i>
                    </div>
                    <h3>Conversión a Binario</h3>
                    <p>Convierte números enteros a su representación binaria</p>
                </a>
                
                <a href="arbol-binario/" class="menu-option">
                    <div class="option-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3>Árbol Binario</h3>
                    <p>Construye árbol binario desde recorridos preorden, inorden y postorden</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
