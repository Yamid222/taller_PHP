# Taller PHP - Aplicaciones Matemáticas

Este proyecto contiene 6 aplicaciones web desarrolladas en PHP para realizar diferentes operaciones matemáticas, de procesamiento de texto y estructuras de datos.

## Aplicaciones Implementadas

### 1. 🔤 Generador de Acrónimos
Convierte frases largas en acrónimos. Los guiones son separadores de palabras y se eliminan todos los demás signos de puntuación.

**Ejemplos:**
- "Portable Network Graphics" → "PNG"
- "As Soon As Possible" → "ASAP"
- "Liquid-crystal display" → "LCD"
- "Thank George It's Friday!" → "TGIF"

### 2. 🔢 Fibonacci y Factorial
Calcula la sucesión de Fibonacci o el factorial de un número dado.

**Características:**
- Sucesión de Fibonacci hasta el n-ésimo término
- Cálculo de factorial de números enteros positivos
- Validación de entrada

### 3. 📊 Estadísticas
Calcula el promedio, mediana y moda de una serie de números reales ingresados por el usuario.

**Métricas calculadas:**
- Promedio (media aritmética)
- Mediana (valor central)
- Moda (valor más frecuente)

### 4. 🔗 Operaciones de Conjuntos
Realiza operaciones entre dos conjuntos de números enteros.

**Operaciones disponibles:**
- Unión (A ∪ B)
- Intersección (A ∩ B)
- Diferencia (A - B)
- Diferencia (B - A)

### 5. 🔢 Conversión a Binario
Convierte números enteros a su representación binaria.

**Información adicional:**
- Número binario
- Longitud en bits
- Representación hexadecimal
- Representación octal
- Detección de potencias de 2

### 6. 🌳 Construcción de Árbol Binario
Construye un árbol binario a partir de sus recorridos (preorden, inorden, postorden).

**Características:**
- Construcción desde preorden + inorden
- Construcción desde postorden + inorden
- Validación de recorridos
- Visualización de la estructura del árbol

## Estructura del Proyecto

```
taller_PHP/
├── index.php                    # API principal
├── test_api.php                 # Archivo de pruebas
├── README.md                    # Documentación
├── AcronymGenerator.php         # Generador de acrónimos
├── AcronymGeneratorInterface.php # Interfaz para acrónimos
├── TextProcessor.php            # Procesador de texto
├── MathCalculator.php           # Calculadora matemática
├── StatisticsCalculator.php     # Calculadora estadística
├── SetOperations.php            # Operaciones de conjuntos
├── BinaryConverter.php          # Conversor a binario
└── BinaryTreeBuilder.php        # Constructor de árbol binario
```

## Uso de la API

### Endpoint Principal
```
POST /index.php?option={aplicacion}
```

### Aplicaciones Disponibles
- `acronym` - Generador de Acrónimos
- `math` - Fibonacci y Factorial
- `statistics` - Estadísticas
- `sets` - Operaciones de Conjuntos
- `binary` - Conversión a Binario
- `tree` - Construcción de Árbol Binario

### Ejemplo de Uso

```php
// Generar acrónimo
$data = ['phrase' => 'Portable Network Graphics'];
$response = file_get_contents('http://localhost/taller_PHP/index.php?option=acronym', 
    false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ])
);
$result = json_decode($response, true);
```

### Respuesta de la API
```json
{
    "option": "acronym",
    "result": "PNG",
    "error": "",
    "inputData": "Portable Network Graphics",
    "timestamp": "2024-01-15 10:30:45",
    "availableOptions": {
        "acronym": "Generador de Acrónimos",
        "math": "Fibonacci y Factorial",
        "statistics": "Estadísticas (Promedio, Mediana, Moda)",
        "sets": "Operaciones de Conjuntos",
        "binary": "Conversión a Binario",
        "tree": "Construcción de Árbol Binario"
    }
}
```

## Pruebas

Ejecuta el archivo `test_api.php` para probar todas las aplicaciones:

```bash
php test_api.php
```

## Requisitos

- PHP 7.0 o superior
- Servidor web (Apache, Nginx, etc.)
- Extensiones PHP: json, mbstring (recomendado)

## Instalación

1. Clona o descarga el proyecto
2. Coloca los archivos en tu servidor web (XAMPP, WAMP, etc.)
3. Accede a `index.php` o usa la API directamente
4. Para pruebas, ejecuta `test_api.php`

## Características Técnicas

- **Arquitectura**: API REST con respuestas JSON
- **Patrones de Diseño**: Strategy, Factory
- **Validación**: Entrada de datos robusta
- **Manejo de Errores**: Excepciones y mensajes descriptivos
- **Documentación**: Código autodocumentado