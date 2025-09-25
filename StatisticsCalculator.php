<?php

/**
 * Clase para cálculos estadísticos: Promedio, Media y Moda
 */
class StatisticsCalculator
{
    /**
     * Calcula el promedio de un array de números
     * 
     * @param array $numbers Array de números
     * @return float El promedio
     */
    public function calculateAverage(array $numbers): float
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        $sum = array_sum($numbers);
        $count = count($numbers);
        
        return $sum / $count;
    }
    
    /**
     * Calcula la mediana de un array de números
     * 
     * @param array $numbers Array de números
     * @return float La mediana
     */
    public function calculateMedian(array $numbers): float
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        sort($numbers);
        $count = count($numbers);
        
        if ($count % 2 === 0) {
            // Número par de elementos
            $mid1 = $numbers[($count / 2) - 1];
            $mid2 = $numbers[$count / 2];
            return ($mid1 + $mid2) / 2;
        } else {
            // Número impar de elementos
            return $numbers[($count - 1) / 2];
        }
    }
    
    /**
     * Calcula la moda de un array de números
     * 
     * @param array $numbers Array de números
     * @return array Array con las modas (puede haber múltiples)
     */
    public function calculateMode(array $numbers): array
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        // Convertir números a strings para poder usar array_count_values
        $stringNumbers = array_map('strval', $numbers);
        $frequency = array_count_values($stringNumbers);
        
        if (empty($frequency)) {
            return [];
        }
        
        $maxFrequency = max($frequency);
        
        if ($maxFrequency === 1) {
            return []; // No hay moda si todos los números aparecen una vez
        }
        
        $modes = [];
        foreach ($frequency as $number => $freq) {
            if ($freq === $maxFrequency) {
                $modes[] = (float)$number; // Convertir de vuelta a float
            }
        }
        
        return $modes;
    }
    
    /**
     * Valida y limpia un array de números
     * 
     * @param array $numbers Array de números a validar
     * @return array Array de números válidos
     */
    public function validateNumbers(array $numbers): array
    {
        $validNumbers = [];
        
        foreach ($numbers as $number) {
            if (is_numeric($number)) {
                $validNumbers[] = (float)$number;
            }
        }
        
        if (empty($validNumbers)) {
            throw new InvalidArgumentException("No se encontraron números válidos");
        }
        
        return $validNumbers;
    }
    
    /**
     * Formatea un array de números para mostrar
     * 
     * @param array $numbers Array de números
     * @return string String formateado
     */
    public function formatNumbers(array $numbers): string
    {
        return implode(', ', $numbers);
    }
}
