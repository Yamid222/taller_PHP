<?php

/**
 * Clase para cálculos matemáticos: Fibonacci y Factorial
 */
class MathCalculator
{
    /**
     * Calcula la sucesión de Fibonacci hasta el número dado
     * 
     * @param int $n Número hasta el cual calcular Fibonacci
     * @return array Array con la sucesión de Fibonacci
     */
    public function calculateFibonacci(int $n): array
    {
        if ($n < 0) {
            throw new InvalidArgumentException("El número debe ser positivo");
        }
        
        if ($n === 0) {
            return [0];
        }
        
        if ($n === 1) {
            return [0, 1];
        }
        
        $fibonacci = [0, 1];
        
        for ($i = 2; $i <= $n; $i++) {
            $fibonacci[] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
        }
        
        return $fibonacci;
    }
    
    /**
     * Calcula el factorial de un número
     * 
     * @param int $n Número para calcular factorial
     * @return int El factorial del número
     */
    public function calculateFactorial(int $n): int
    {
        if ($n < 0) {
            throw new InvalidArgumentException("El número debe ser positivo");
        }
        
        if ($n === 0 || $n === 1) {
            return 1;
        }
        
        $factorial = 1;
        for ($i = 2; $i <= $n; $i++) {
            $factorial *= $i;
        }
        
        return $factorial;
    }
    
    /**
     * Valida si un número es válido para los cálculos
     * 
     * @param mixed $number Número a validar
     * @return bool True si es válido, false si no
     */
    public function isValidNumber($number): bool
    {
        return is_numeric($number) && $number >= 0 && $number == (int)$number;
    }
}
