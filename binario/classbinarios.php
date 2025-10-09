<?php
class ConversorBinario {
    private $numero;

    public function __construct($numero) {
        $this->numero = $numero;
    }

    public function convertir() {
        return decbin($this->numero);
    }
}
?>