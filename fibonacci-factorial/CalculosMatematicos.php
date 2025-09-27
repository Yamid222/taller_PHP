<?php


class CalculosMatematicos
{
   
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
    
    
    public function calculateFibonacciWithProcedure(int $n): array
    {
        if ($n < 0) {
            throw new InvalidArgumentException("El número debe ser positivo");
        }
        
        $procedure = [];
        $fibonacci = [];
        
        if ($n === 0) {
            $fibonacci = [0];
            $procedure[] = "0";
        } elseif ($n === 1) {
            $fibonacci = [0, 1];
            $procedure[] = "0, 1";
        } else {
            $fibonacci = [0, 1];
            $procedure[] = "0, 1";
            
            for ($i = 2; $i <= $n; $i++) {
                $prev1 = $fibonacci[$i - 1];
                $prev2 = $fibonacci[$i - 2];
                $current = $prev1 + $prev2;
                $fibonacci[] = $current;
                $procedure[] = $prev2 . "+" . $prev1 . "=" . $current;
            }
        }
        
        return [
            'sequence' => $fibonacci,
            'procedure' => $procedure
        ];
    }
    
   
    public function calculateFactorial(int $n): string
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
    
   
    public function calculateFactorialWithProcedure(int $n): array
    {
        if ($n < 0) {
            throw new InvalidArgumentException("El número debe ser positivo");
        }
        
        $procedure = [];
        $factorial = 1;
        
        if ($n === 0 || $n === 1) {
            $procedure[] = "1";
        } else {
            $steps = [];
            for ($i = $n; $i >= 1; $i--) {
                $steps[] = $i;
            }
            $procedure[] = implode("×", $steps) . "=" . $this->calculateFactorial($n);
        }
        
        return [
            'result' => $this->calculateFactorial($n),
            'procedure' => $procedure
        ];
    }
    
    
    public function isValidNumber($number): bool
    {
        return is_numeric($number) && $number >= 0 && $number == (int)$number;
    }
}
