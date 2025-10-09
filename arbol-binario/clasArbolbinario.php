<?php
class Nodo {
    public $valor;
    public $izq;
    public $der;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->izq = null;
        $this->der = null;
    }
}

class ArbolBinario {

    // --- Construir desde Preorden e Inorden ---
    public static function desdePreIn($preorden, $inorden) {
        $pre = explode(" ", $preorden);
        $in = explode(" ", $inorden);
        return self::construirPreIn($pre, $in);
    }

    private static function construirPreIn(&$pre, $in) {
        if (empty($in)) return null;
        $valor = array_shift($pre);
        $nodo = new Nodo($valor);
        $pos = array_search($valor, $in);

        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);

        $nodo->izq = self::construirPreIn($pre, $izqIn);
        $nodo->der = self::construirPreIn($pre, $derIn);

        return $nodo;
    }

    // --- Construir desde Postorden e Inorden ---
    public static function desdePostIn($postorden, $inorden) {
        $post = explode(" ", $postorden);
        $in = explode(" ", $inorden);
        return self::construirPostIn($post, $in);
    }

    private static function construirPostIn(&$post, $in) {
        if (empty($in)) return null;
        $valor = array_pop($post);
        $nodo = new Nodo($valor);
        $pos = array_search($valor, $in);

        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);

        $nodo->der = self::construirPostIn($post, $derIn);
        $nodo->izq = self::construirPostIn($post, $izqIn);

        return $nodo;
    }

    // --- Recorridos ---
    private static function preorden($nodo) {
        if (!$nodo) return [];
        return array_merge([$nodo->valor], self::preorden($nodo->izq), self::preorden($nodo->der));
    }

    private static function inorden($nodo) {
        if (!$nodo) return [];
        return array_merge(self::inorden($nodo->izq), [$nodo->valor], self::inorden($nodo->der));
    }

    private static function postorden($nodo) {
        if (!$nodo) return [];
        return array_merge(self::postorden($nodo->izq), self::postorden($nodo->der), [$nodo->valor]);
    }

    // --- Mostrar recorridos ---
    public static function mostrarRecorridos($raiz) {
        echo "<p><b>Preorden:</b> " . implode(" → ", self::preorden($raiz)) . "</p>";
        echo "<p><b>Inorden:</b> " . implode(" → ", self::inorden($raiz)) . "</p>";
        echo "<p><b>Postorden:</b> " . implode(" → ", self::postorden($raiz)) . "</p>";
    }
}
?>
