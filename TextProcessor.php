<?php

/**
 * Clase para procesar y limpiar texto
 */
class TextProcessor
{
    /**
     * Limpia el texto eliminando signos de puntuación excepto guiones
     * 
     * @param string $text El texto a limpiar
     * @return string El texto limpio
     */
    public function cleanText(string $text): string
    {
        // Eliminar signos de puntuación excepto guiones y espacios
        $cleaned = preg_replace('/[^\w\s\-]/', '', $text);
        
        // Normalizar espacios múltiples y guiones
        $cleaned = preg_replace('/[\s\-]+/', ' ', $cleaned);
        
        return trim($cleaned);
    }
    
    /**
     * Convierte guiones en espacios para tratarlos como separadores de palabras
     * 
     * @param string $text El texto a procesar
     * @return string El texto con guiones convertidos a espacios
     */
    public function normalizeSeparators(string $text): string
    {
        return str_replace('-', ' ', $text);
    }
    
    /**
     * Divide el texto en palabras
     * 
     * @param string $text El texto a dividir
     * @return array Array de palabras
     */
    public function splitIntoWords(string $text): array
    {
        return explode(' ', $text);
    }
}
