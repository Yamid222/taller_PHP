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

    private static function normalizar($cadena) {
        if ($cadena === null) return [];
        $cadena = trim((string)$cadena);
        if ($cadena === '') return [];
        $partes = preg_split('/\s*,\s*/', $cadena);
        $partes = array_filter($partes, function($v) { return $v !== '' && $v !== null; });
        return array_values($partes);
    }

    public static function validarEntradas($orden1, $orden2) {
        $a = self::normalizar($orden1);
        $b = self::normalizar($orden2);

        if (empty($a) || empty($b)) {
            return [ 'ok' => false, 'mensaje' => 'Las entradas no pueden estar vacías.' ];
        }

        if (count($a) !== count($b)) {
            return [ 'ok' => false, 'mensaje' => 'Los recorridos deben tener la misma cantidad de nodos.' ];
        }

        $faltantesEnB = array_diff($a, $b);
        $faltantesEnA = array_diff($b, $a);
        if (!empty($faltantesEnB) || !empty($faltantesEnA)) {
            return [ 'ok' => false, 'mensaje' => 'Los recorridos no coinciden: deben contener exactamente los mismos valores.' ];
        }

        return [ 'ok' => true ];
    }

    public static function desdePreIn($preorden, $inorden) {
        $pre = self::normalizar($preorden);
        $in = self::normalizar($inorden);
        return self::construirPreIn($pre, $in);
    }

    private static function construirPreIn(&$pre, $in) {
        if (empty($in)) return null;
        $valor = array_shift($pre);
        $nodo = new Nodo($valor);
        $pos = array_search($valor, $in, true);
        if ($pos === false) {
            return null;
        }

        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);

        $nodo->izq = self::construirPreIn($pre, $izqIn);
        $nodo->der = self::construirPreIn($pre, $derIn);

        return $nodo;
    }

    public static function desdePostIn($postorden, $inorden) {
        $post = self::normalizar($postorden);
        $in = self::normalizar($inorden);
        return self::construirPostIn($post, $in);
    }

    public static function desdePrePost($preorden, $postorden) {
        $pre = self::normalizar($preorden);
        $post = self::normalizar($postorden);
        return self::construirPrePost($pre, $post);
    }

    private static function construirPrePost($pre, $post) {
        if (empty($pre) || empty($post)) return null;
        $raizValor = $pre[0];
        $raiz = new Nodo($raizValor);

        if (count($pre) == 1) {
            return $raiz; 
        }

        $izqRaizValor = $pre[1];
        $posIzqEnPost = array_search($izqRaizValor, $post, true);
        if ($posIzqEnPost === false) {
            return null; 
        }

        $tamIzq = $posIzqEnPost + 1;

        $preIzq = array_slice($pre, 1, $tamIzq);
        $preDer = array_slice($pre, 1 + $tamIzq);

        $postIzq = array_slice($post, 0, $tamIzq);
        $postDer = array_slice($post, $tamIzq, count($post) - $tamIzq - 1);

        $raiz->izq = self::construirPrePost($preIzq, $postIzq);
        $raiz->der = self::construirPrePost($preDer, $postDer);

        return $raiz;
    }

    private static function construirPostIn(&$post, $in) {
        if (empty($in)) return null;
        $valor = array_pop($post);
        $nodo = new Nodo($valor);
        $pos = array_search($valor, $in, true);
        if ($pos === false) {
            return null;
        }

        $izqIn = array_slice($in, 0, $pos);
        $derIn = array_slice($in, $pos + 1);

        $nodo->der = self::construirPostIn($post, $derIn);
        $nodo->izq = self::construirPostIn($post, $izqIn);

        return $nodo;
    }

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

    public static function mostrarRecorridos($raiz) {
        if ($raiz === null) {
            echo "<p style='color:#ffcc00'><b>No se pudo construir el árbol con las entradas dadas.</b></p>";
            return;
        }
        echo "<p><b>Preorden:</b> " . implode(" → ", self::preorden($raiz)) . "</p>";
        echo "<p><b>Inorden:</b> " . implode(" → ", self::inorden($raiz)) . "</p>";
        echo "<p><b>Postorden:</b> " . implode(" → ", self::postorden($raiz)) . "</p>";
    }

    public static function mostrarArbol($raiz) {
        if ($raiz === null) {
            return;
        }

        $dx = 90; 
        $dy = 90; 
        $margenX = 40;
        $margenY = 40;
        $radio = 18;

        $in = self::inorden($raiz);
        $columnaPorValor = [];
        foreach ($in as $idx => $val) {
            if (!isset($columnaPorValor[$val])) {
                $columnaPorValor[$val] = $idx;
            } else {
                $columnaPorValor[$val . "#" . $idx] = $idx;
            }
        }

        $profMax = 0;
        $nodos = [];
        $aristas = [];

        $asignar = function($nodo, $profundidad) use (&$asignar, &$nodos, &$aristas, &$profMax, $columnaPorValor, $dx, $dy, $margenX, $margenY, $radio) {
            if (!$nodo) return null;
            $profMax = max($profMax, $profundidad);

            $clave = $nodo->valor;
            if (!array_key_exists($clave, $columnaPorValor)) {
                $encontrado = false;
                foreach ($columnaPorValor as $k => $col) {
                    if (strpos($k, $clave . "#") === 0) { $clave = $k; $encontrado = true; break; }
                }
                if (!$encontrado) {
                    $columna = 0;
                } else {
                    $columna = $columnaPorValor[$clave];
                }
            } else {
                $columna = $columnaPorValor[$clave];
            }

            $x = $margenX + $columna * $dx;
            $y = $margenY + $profundidad * $dy;
            $id = spl_object_id($nodo);
            $nodos[$id] = [ 'x' => $x, 'y' => $y, 'valor' => $nodo->valor ];

            if ($nodo->izq) {
                $hId = $asignar($nodo->izq, $profundidad + 1);
                if ($hId) $aristas[] = [ $id, $hId ];
            }
            if ($nodo->der) {
                $hId = $asignar($nodo->der, $profundidad + 1);
                if ($hId) $aristas[] = [ $id, $hId ];
            }

            return $id;
        };

        $asignar($raiz, 0);

        $ancho = $margenX * 2 + max(1, count($in) - 1) * $dx;
        $alto = $margenY * 2 + ($profMax) * $dy;

        echo "<div style=\"overflow:auto; margin-top:20px;\">";
        echo "<svg width=\"$ancho\" height=\"$alto\" viewBox=\"0 0 $ancho $alto\" xmlns=\"http://www.w3.org/2000/svg\" style=\"background:#f8f9fa;border:1px solid #e9ecef;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.05)\">";

        foreach ($aristas as $e) {
            $a = $nodos[$e[0]]; $b = $nodos[$e[1]];
            echo "<line x1=\"{$a['x']}\" y1=\"{$a['y']}\" x2=\"{$b['x']}\" y2=\"{$b['y']}\" stroke=\"#90a4ae\" stroke-width=\"2\" />";
        }

        foreach ($nodos as $node) {
            echo "<g>
                    <circle cx=\"{$node['x']}\" cy=\"{$node['y']}\" r=\"$radio\" fill=\"#c8e6c9\" stroke=\"#2e7d32\" stroke-width=\"2\" />
                    <text x=\"{$node['x']}\" y=\"{$node['y']}\" text-anchor=\"middle\" dominant-baseline=\"central\" fill=\"#000\" font-family=\"Poppins,Segoe UI,Arial\" font-size=\"12\">" . htmlspecialchars($node['valor']) . "</text>
                </g>";
        }

        echo "</svg>";
        echo "</div>";
    }
}
?>
