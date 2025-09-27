<?php

class Node {
    public $data;
    public $left;
    public $right;

    public function __construct($data) {
        $this->data = $data;
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree {
    
    // Construcción desde Preorden + Inorden
    public function buildFromPreIn($preorden, $inorden) {
        if (empty($preorden) || empty($inorden)) return null;

        $raiz = array_shift($preorden);
        $node = new Node($raiz);

        $indice = array_search($raiz, $inorden);

        $izqIn = array_slice($inorden, 0, $indice);
        $derIn = array_slice($inorden, $indice + 1);

        $izqPre = array_slice($preorden, 0, count($izqIn));
        $derPre = array_slice($preorden, count($izqIn));

        $node->left = $this->buildFromPreIn($izqPre, $izqIn);
        $node->right = $this->buildFromPreIn($derPre, $derIn);

        return $node;
    }

    // Construcción desde Postorden + Inorden
    public function buildFromPostIn($postorden, $inorden) {
        if (empty($postorden) || empty($inorden)) return null;

        $raiz = array_pop($postorden);
        $node = new Node($raiz);

        $indice = array_search($raiz, $inorden);

        $izqIn = array_slice($inorden, 0, $indice);
        $derIn = array_slice($inorden, $indice + 1);

        $izqPost = array_slice($postorden, 0, count($izqIn));
        $derPost = array_slice($postorden, count($izqIn));

        $node->left = $this->buildFromPostIn($izqPost, $izqIn);
        $node->right = $this->buildFromPostIn($derPost, $derIn);

        return $node;
    }

    // Recorridos
    public function preorden($node, &$res) {
        if ($node == null) return;
        $res[] = $node->data;
        $this->preorden($node->left, $res);
        $this->preorden($node->right, $res);
    }

    public function inorden($node, &$res) {
        if ($node == null) return;
        $this->inorden($node->left, $res);
        $res[] = $node->data;
        $this->inorden($node->right, $res);
    }

    public function postorden($node, &$res) {
        if ($node == null) return;
        $this->postorden($node->left, $res);
        $this->postorden($node->right, $res);
        $res[] = $node->data;
    }

    // Dibujo mejorado del árbol con CSS
    public function dibujarArbol($node) {
        if ($node == null) return "";

        $html = "<div class='tree-container'>";
        $html .= $this->dibujarNodo($node, 0);
        $html .= "</div>";
        return $html;
    }

    private function dibujarNodo($node, $nivel) {
        if ($node == null) return "";

        $html = "<div class='node'>";
        $html .= "<div class='node-data'>{$node->data}</div>";
        
        if ($node->left || $node->right) {
            $html .= "<div class='children'>";
            if ($node->left) {
                $html .= "<div class='child left'>" . $this->dibujarNodo($node->left, $nivel + 1) . "</div>";
            }
            if ($node->right) {
                $html .= "<div class='child right'>" . $this->dibujarNodo($node->right, $nivel + 1) . "</div>";
            }
            $html .= "</div>";
        }
        
        $html .= "</div>";
        
        return $html;
    }


    public function obtenerInfo($raiz) {
        $info = [];
        
        // Preorden
        $preorden = [];
        $this->preorden($raiz, $preorden);
        $info['preorden'] = $preorden;
        
        // Inorden
        $inorden = [];
        $this->inorden($raiz, $inorden);
        $info['inorden'] = $inorden;
        
        // Postorden
        $postorden = [];
        $this->postorden($raiz, $postorden);
        $info['postorden'] = $postorden;
        
        return $info;
    }

    // Método para determinar qué recorridos se usaron para construir
    public function determinarMetodo($preorden, $inorden, $postorden) {
        if (!empty($preorden) && !empty($inorden)) {
            return "Preorden + Inorden";
        } elseif (!empty($postorden) && !empty($inorden)) {
            return "Postorden + Inorden";
        } else {
            return "Método no válido";
        }
    }
}
?>
