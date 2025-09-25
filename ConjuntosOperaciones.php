<?php

class ConjuntosOperaciones
{
    
    public function validateNumbers(array $numbers): array
    {
        $validNumbers = [];
        
        foreach ($numbers as $number) {
            $number = trim($number);
            if (!empty($number) && is_numeric($number) && is_int($number + 0)) {
                $validNumbers[] = (int)$number;
            }
        }
        
        return $validNumbers;
    }
    
   
    public function removeDuplicates(array $numbers): array
    {
        return array_unique($numbers);
    }
    
    
    public function calculateUnion(array $setA, array $setB): array
    {
        $union = array_merge($setA, $setB);
        return $this->removeDuplicates($union);
    }
    
   
    public function calculateIntersection(array $setA, array $setB): array
    {
        return array_intersect($setA, $setB);
    }
  
    public function calculateDifference(array $setA, array $setB): array
    {
        return array_diff($setA, $setB);
    }
 
    public function formatNumbers(array $numbers): string
    {
        if (empty($numbers)) {
            return "∅ (conjunto vacío)";
        }
        
        sort($numbers);
        return "{" . implode(", ", $numbers) . "}";
    }

    public function processSetOperations(array $setA, array $setB): array
    {
        $validSetA = $this->removeDuplicates($this->validateNumbers($setA));
        $validSetB = $this->removeDuplicates($this->validateNumbers($setB));
        
        $union = $this->calculateUnion($validSetA, $validSetB);
        $intersection = $this->calculateIntersection($validSetA, $validSetB);
        $differenceAB = $this->calculateDifference($validSetA, $validSetB);
        $differenceBA = $this->calculateDifference($validSetB, $validSetA);
        
        return [
            'setA' => $validSetA,
            'setB' => $validSetB,
            'union' => $union,
            'intersection' => $intersection,
            'differenceAB' => $differenceAB,
            'differenceBA' => $differenceBA
        ];
    }
}

?>
