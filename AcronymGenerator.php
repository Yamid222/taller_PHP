<?php

require_once 'AcronymGeneratorInterface.php';
require_once 'TextProcessor.php';

/**
 * Clase para generar acrónimos implementando la interfaz AcronymGeneratorInterface
 */
class AcronymGenerator implements AcronymGeneratorInterface
{
    private TextProcessor $textProcessor;
    
    /**
     * Constructor que inyecta la dependencia TextProcessor
     * 
     * @param TextProcessor $textProcessor Procesador de texto
     */
    public function __construct(TextProcessor $textProcessor)
    {
        $this->textProcessor = $textProcessor;
    }
    
    /**
     * Genera un acrónimo a partir de una frase
     * 
     * @param string $phrase La frase a convertir en acrónimo
     * @return string El acrónimo generado
     */
    public function generateAcronym(string $phrase): string
    {
        // Limpiar el texto eliminando signos de puntuación
        $cleanedPhrase = $this->textProcessor->cleanText($phrase);
        
        // Normalizar separadores (convertir guiones en espacios)
        $normalizedPhrase = $this->textProcessor->normalizeSeparators($cleanedPhrase);
        
        // Dividir en palabras
        $words = $this->textProcessor->splitIntoWords($normalizedPhrase);
        
        // Filtrar palabras vacías y generar acrónimo
        $acronym = '';
        foreach ($words as $word) {
            $word = trim($word);
            if (!empty($word)) {
                $acronym .= strtoupper($word[0]);
            }
        }
        
        return $acronym;
    }
}
