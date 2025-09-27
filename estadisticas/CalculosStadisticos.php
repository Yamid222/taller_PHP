<?php


class CalculosStadisticos
{
   
    public function calculateAverage(array $numbers): float
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        $sum = array_sum($numbers);
        $count = count($numbers);
        
        return $sum / $count;
    }
    
  
    public function calculateMedian(array $numbers): float
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        sort($numbers);
        $count = count($numbers);
        
        if ($count % 2 === 0) {
            $mid1 = $numbers[($count / 2) - 1];
            $mid2 = $numbers[$count / 2];
            return ($mid1 + $mid2) / 2;
        } else {
            return $numbers[($count - 1) / 2];
        }
    }
    
    
    public function calculateMode(array $numbers): array
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("El array no puede estar vacío");
        }
        
        $stringNumbers = array_map('strval', $numbers);
        $frequency = array_count_values($stringNumbers);
        
        if (empty($frequency)) {
            return [];
        }
        
        $maxFrequency = max($frequency);
        
        if ($maxFrequency === 1) {
            return []; 
        }
        
        $modes = [];
        foreach ($frequency as $number => $freq) {
            if ($freq === $maxFrequency) {
                $modes[] = (float)$number; 
            }
        }
        
        return $modes;
    }
    
   
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
    
   
    public function formatNumbers(array $numbers): string
    {
        return implode(', ', $numbers);
    }
}
