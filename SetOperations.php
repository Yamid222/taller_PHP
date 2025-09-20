<?php

class SetOperations
{
    /**
     * Valida que los números ingresados sean enteros válidos
     */
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
    
    /**
     * Elimina duplicados de un array
     */
    public function removeDuplicates(array $numbers): array
    {
        return array_unique($numbers);
    }
    
    /**
     * Calcula la unión de dos conjuntos
     */
    public function calculateUnion(array $setA, array $setB): array
    {
        $union = array_merge($setA, $setB);
        return $this->removeDuplicates($union);
    }
    
    /**
     * Calcula la intersección de dos conjuntos
     */
    public function calculateIntersection(array $setA, array $setB): array
    {
        return array_intersect($setA, $setB);
    }
    
    /**
     * Calcula la diferencia A - B (elementos en A que no están en B)
     */
    public function calculateDifference(array $setA, array $setB): array
    {
        return array_diff($setA, $setB);
    }
    
    /**
     * Formatea los números para mostrar
     */
    public function formatNumbers(array $numbers): string
    {
        if (empty($numbers)) {
            return "∅ (conjunto vacío)";
        }
        
        sort($numbers);
        return "{" . implode(", ", $numbers) . "}";
    }
    
    /**
     * Procesa las operaciones de conjuntos
     */
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
