<?php

/**
 * Interfaz para generar acrónimos a partir de frases
 */
interface AcronymGeneratorInterface
{
    /**
     * Genera un acrónimo a partir de una frase
     * 
     * @param string $phrase La frase a convertir en acrónimo
     * @return string El acrónimo generado
     */
    public function generateAcronym(string $phrase): string;
}
