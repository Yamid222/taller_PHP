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
        if ($this->numero < 0) {
            return "Ingrese un número mayor o igual a 0.";
        }

        $secuencia = [];
        $a = 0;
        $b = 1;
        
        for ($i = 0; $i <= $this->numero; $i++) {
            if ($i == 0) {
                $secuencia[] = 0;
            } elseif ($i == 1) {
                $secuencia[] = 1;
            } else {
                $siguiente = $a + $b;
                $secuencia[] = $siguiente;
                $a = $b;
                $b = $siguiente;
            }
        }
        
        $resultado = "Secuencia de Fibonacci hasta el " . $this->numero . "º número:<br><br>";
        $resultado .= "Secuencia: ";
        for ($i = 0; $i < count($secuencia); $i++) {
            if ($i == $this->numero) {
                $resultado .= "<strong style='color: #4CAF50; font-size: 1.2em;'>" . $secuencia[$i] . "</strong>";
            } else {
                $resultado .= $secuencia[$i];
            }
            if ($i < count($secuencia) - 1) {
                $resultado .= ", ";
            }
        }
        
        $resultado .= "<br><br>El " . $this->numero . "º número de Fibonacci es: <strong style='color: #4CAF50; font-size: 1.3em;'>" . $secuencia[$this->numero] . "</strong>";
        
        return $resultado;
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
