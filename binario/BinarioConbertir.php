<?php

class BinarioConbertir
{

    public function isValidNumber($number): bool
    {
        return is_numeric($number) && is_int($number + 0) && $number >= 0;
    }
    
  
    public function convertToBinary(int $number): string
    {
        if ($number === 0) {
            return "0";
        }
        
        $binary = "";
        while ($number > 0) {
            $binary = ($number % 2) . $binary;
            $number = intval($number / 2);
        }
        
        return $binary;
    }
    
   
    public function convertToBinaryNative(int $number): string
    {
        return decbin($number);
    }
    
    
    public function getConversionInfo(int $number): array
    {
        $binary = $this->convertToBinary($number);
        $binaryNative = $this->convertToBinaryNative($number);
        
        return [
            'decimal' => $number,
            'binary' => $binary,
            'binary_native' => $binaryNative,
            'binary_length' => strlen($binary),
            'is_power_of_2' => ($number > 0) && (($number & ($number - 1)) === 0),
            'hexadecimal' => dechex($number),
            'octal' => decoct($number)
        ];
    }
    
    
    public function processConversion($input): array
    {
        if (!$this->isValidNumber($input)) {
            throw new InvalidArgumentException('Por favor, ingrese un número entero positivo válido.');
        }
        
        $number = (int)$input;
        
        if ($number > 1000000) {
            throw new InvalidArgumentException('El número es demasiado grande. Por favor, ingrese un número menor a 1,000,000.');
        }
        
        return $this->getConversionInfo($number);
    }
}

?>
