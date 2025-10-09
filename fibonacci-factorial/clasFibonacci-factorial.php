<?php

class Calculadora
{
    private $numero;

    public function __construct($numero)
    {
        $this->numero = intval($numero);
    }
    public function calcularFibonacci()
    {
        if ($this->numero < 1) {
            return "Ingrese un número mayor a 0.";
        }

        $resultado = [];
        $a = 0;
        $b = 1;

        for ($i = 1; $i <= $this->numero; $i++) {
            $resultado[] = "$a + $b = " . ($a + $b);
            $temp = $b;
            $b = $a + $b;
            $a = $temp;
        }
        return implode("<br>", $resultado);
    }
    public function calcularFactorial()
    {
        if ($this->numero < 1) {
            return "Ingrese un número mayor a 0.";
        }

        $factorial = 1;
        $cadena = [];

        for ($i = 1; $i <= $this->numero; $i++) {
            $factorial *= $i;
            $cadena[] = $i;
        }

        return implode(" x ", $cadena) . " = " . $factorial;
    }
}
?>
