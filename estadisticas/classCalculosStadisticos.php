<?php

class Estadistica {
    private $numeros;

    public function __construct($numeros) {
        $this->setNumeros($numeros);
    }
    public function setNumeros($numeros) {
        $this->numeros = array_filter(array_map('floatval', explode(',', $numeros)), 'is_numeric');
    }
    public function calcularPromedio() {
        return count($this->numeros) > 0 ? array_sum($this->numeros) / count($this->numeros) : "N/A";
    }
    public function calcularMediana() {
        if (empty($this->numeros)) return "N/A";
        sort($this->numeros);
        $n = count($this->numeros);
        $medio = floor($n / 2);
        return ($n % 2 == 0) ? ($this->numeros[$medio - 1] + $this->numeros[$medio]) / 2 : $this->numeros[$medio];
    }
    public function calcularModa() {
        if (empty($this->numeros)) return "N/A";
        $frecuencias = array_count_values(array_map('strval', $this->numeros));
        $maxFrecuencia = max($frecuencias);
        $modas = array_keys($frecuencias, $maxFrecuencia);
        return (count($modas) == count($this->numeros)) ? "No hay moda" : implode(", ", $modas);
    }
}
?>