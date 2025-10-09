<?php

class Conjunto
{
    private $A = [], $B = [];

    public function __construct($a, $b)
    {
        $this->setConjuntos($a, $b);
    }
    public function setConjuntos($a, $b)
    {
        $this->A = array_unique(array_map('intval', explode(',', $a)));
        $this->B = array_unique(array_map('intval', explode(',', $b)));
    }
    public function getUnion()
    {
        return array_unique(array_merge($this->A, $this->B));
    }
    public function getInterseccion()
    {
        return array_intersect($this->A, $this->B);
    }
    public function getDiferenciaA_B()
    {
        return array_diff($this->A, $this->B);
    }
    public function getDiferenciaB_A()
    {
        return array_diff($this->B, $this->A);
    }
    public function obtenerResultados()
    {
        return [
            "Conjunto A" => $this->A,
            "Conjunto B" => $this->B,
            "Unión (A U B)" => $this->getUnion(),
            "Intersección (A ∩ B)" => $this->getInterseccion(),
            "Diferencia (A - B)" => $this->getDiferenciaA_B(),
            "Diferencia (B - A)" => $this->getDiferenciaB_A()
        ];
    }
}
?>