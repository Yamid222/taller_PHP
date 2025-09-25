<?php

class BinaryTreeNode
{
    public $value;
    public $left;
    public $right;
    
    public function __construct($value)
    {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTreeBuilder
{
    private $preorder;
    private $inorder;
    private $postorder;
    private $inorderMap;
    
    /**
     * Valida que los recorridos tengan la misma longitud y elementos
     */
    public function validateTraversals(array $preorder, array $inorder, array $postorder): bool
    {
        // Filtrar arrays vacíos
        $nonEmptyArrays = array_filter([$preorder, $inorder, $postorder], function($arr) { return !empty($arr); });
        
        if (count($nonEmptyArrays) < 2) {
            return false;
        }
        
        // Verificar que todos tengan la misma longitud
        $lengths = array_map('count', $nonEmptyArrays);
        if (count(array_unique($lengths)) > 1) {
            return false;
        }
        
        // Verificar que todos tengan los mismos elementos
        $allElements = [];
        foreach ($nonEmptyArrays as $arr) {
            $allElements = array_merge($allElements, $arr);
        }
        $uniqueElements = array_unique($allElements);
        
        return count($uniqueElements) === count($nonEmptyArrays[0]);
    }
    
    /**
     * Construye el árbol binario desde preorden e inorden
     */
    public function buildFromPreorderInorder(array $preorder, array $inorder): ?BinaryTreeNode
    {
        if (empty($preorder) || empty($inorder)) {
            return null;
        }
        
        $this->inorderMap = array_flip($inorder);
        $this->preorder = $preorder;
        $this->inorder = $inorder;
        
        return $this->buildFromPreorderInorderHelper(0, 0, count($inorder) - 1);
    }
    
    private function buildFromPreorderInorderHelper(int $preStart, int $inStart, int $inEnd): ?BinaryTreeNode
    {
        if ($preStart >= count($this->preorder) || $inStart > $inEnd) {
            return null;
        }
        
        $rootValue = $this->preorder[$preStart];
        $root = new BinaryTreeNode($rootValue);
        
        $inRootIndex = $this->inorderMap[$rootValue];
        $leftSubtreeSize = $inRootIndex - $inStart;
        
        $root->left = $this->buildFromPreorderInorderHelper(
            $preStart + 1, 
            $inStart, 
            $inRootIndex - 1
        );
        
        $root->right = $this->buildFromPreorderInorderHelper(
            $preStart + $leftSubtreeSize + 1, 
            $inRootIndex + 1, 
            $inEnd
        );
        
        return $root;
    }
    
    /**
     * Construye el árbol binario desde postorden e inorden
     */
    public function buildFromPostorderInorder(array $postorder, array $inorder): ?BinaryTreeNode
    {
        if (empty($postorder) || empty($inorder)) {
            return null;
        }
        
        $this->inorderMap = array_flip($inorder);
        $this->postorder = $postorder;
        $this->inorder = $inorder;
        
        return $this->buildFromPostorderInorderHelper(count($postorder) - 1, 0, count($inorder) - 1);
    }
    
    private function buildFromPostorderInorderHelper(int $postEnd, int $inStart, int $inEnd): ?BinaryTreeNode
    {
        if ($postEnd < 0 || $inStart > $inEnd) {
            return null;
        }
        
        $rootValue = $this->postorder[$postEnd];
        $root = new BinaryTreeNode($rootValue);
        
        $inRootIndex = $this->inorderMap[$rootValue];
        $rightSubtreeSize = $inEnd - $inRootIndex;
        
        $root->right = $this->buildFromPostorderInorderHelper(
            $postEnd - 1, 
            $inRootIndex + 1, 
            $inEnd
        );
        
        $root->left = $this->buildFromPostorderInorderHelper(
            $postEnd - $rightSubtreeSize - 1, 
            $inStart, 
            $inRootIndex - 1
        );
        
        return $root;
    }
    
    /**
     * Realiza recorrido preorden
     */
    public function preorderTraversal(?BinaryTreeNode $root): array
    {
        $result = [];
        $this->preorderHelper($root, $result);
        return $result;
    }
    
    private function preorderHelper(?BinaryTreeNode $node, array &$result): void
    {
        if ($node !== null) {
            $result[] = $node->value;
            $this->preorderHelper($node->left, $result);
            $this->preorderHelper($node->right, $result);
        }
    }
    
    /**
     * Realiza recorrido inorden
     */
    public function inorderTraversal(?BinaryTreeNode $root): array
    {
        $result = [];
        $this->inorderHelper($root, $result);
        return $result;
    }
    
    private function inorderHelper(?BinaryTreeNode $node, array &$result): void
    {
        if ($node !== null) {
            $this->inorderHelper($node->left, $result);
            $result[] = $node->value;
            $this->inorderHelper($node->right, $result);
        }
    }
    
    /**
     * Realiza recorrido postorden
     */
    public function postorderTraversal(?BinaryTreeNode $root): array
    {
        $result = [];
        $this->postorderHelper($root, $result);
        return $result;
    }
    
    private function postorderHelper(?BinaryTreeNode $node, array &$result): void
    {
        if ($node !== null) {
            $this->postorderHelper($node->left, $result);
            $this->postorderHelper($node->right, $result);
            $result[] = $node->value;
        }
    }
    
    /**
     * Obtiene la representación visual del árbol
     */
    public function getTreeVisualization(?BinaryTreeNode $root): string
    {
        if ($root === null) {
            return "Árbol vacío";
        }
        
        $lines = [];
        $this->buildTreeLines($root, $lines, "", true);
        
        return implode("\n", $lines);
    }
    
    private function buildTreeLines(?BinaryTreeNode $node, array &$lines, string $prefix, bool $isLast): void
    {
        if ($node === null) {
            return;
        }
        
        $lines[] = $prefix . ($isLast ? "└── " : "├── ") . $node->value;
        
        $children = [];
        if ($node->left !== null) {
            $children[] = ['node' => $node->left, 'isLeft' => true];
        }
        if ($node->right !== null) {
            $children[] = ['node' => $node->right, 'isLeft' => false];
        }
        
        for ($i = 0; $i < count($children); $i++) {
            $child = $children[$i];
            $isLastChild = ($i === count($children) - 1);
            $newPrefix = $prefix . ($isLast ? "    " : "│   ");
            
            $this->buildTreeLines($child['node'], $lines, $newPrefix, $isLastChild);
        }
    }
    
    /**
     * Obtiene una representación ASCII del árbol
     */
    public function getAsciiTree(?BinaryTreeNode $root): string
    {
        if ($root === null) {
            return "Árbol vacío";
        }
        
        $lines = [];
        $this->buildAsciiTree($root, $lines, 0, 0);
        
        return implode("\n", $lines);
    }
    
    private function buildAsciiTree(?BinaryTreeNode $node, array &$lines, int $row, int $col): void
    {
        if ($node === null) {
            return;
        }
        
        // Asegurar que tenemos suficientes líneas
        while (count($lines) <= $row) {
            $lines[] = str_repeat(" ", 50); // Línea vacía con espacios
        }
        
        // Colocar el nodo en la posición correcta
        $value = str_pad($node->value, 3, " ", STR_PAD_BOTH);
        $currentLine = $lines[$row];
        $newLine = substr($currentLine, 0, $col) . $value . substr($currentLine, $col + 3);
        $lines[$row] = $newLine;
        
        // Agregar conexiones si hay hijos
        if ($node->left !== null || $node->right !== null) {
            $nextRow = $row + 1;
            while (count($lines) <= $nextRow) {
                $lines[] = str_repeat(" ", 50);
            }
            
            if ($node->left !== null) {
                $this->buildAsciiTree($node->left, $lines, $nextRow, $col - 2);
            }
            if ($node->right !== null) {
                $this->buildAsciiTree($node->right, $lines, $nextRow, $col + 2);
            }
        }
    }
    
    /**
     * Procesa la construcción del árbol
     */
    public function processTreeConstruction(array $preorder, array $inorder, array $postorder): array
    {
        // Limpiar arrays
        $preorder = array_filter($preorder, function($item) { return !empty(trim($item)); });
        $inorder = array_filter($inorder, function($item) { return !empty(trim($item)); });
        $postorder = array_filter($postorder, function($item) { return !empty(trim($item)); });
        
        if (count($preorder) + count($inorder) + count($postorder) < 2) {
            throw new InvalidArgumentException('Se necesitan al menos dos recorridos para construir el árbol.');
        }
        
        $root = null;
        $method = "";
        
        // Intentar construir con preorden e inorden
        if (!empty($preorder) && !empty($inorder)) {
            if ($this->validateTraversals($preorder, $inorder, [])) {
                $root = $this->buildFromPreorderInorder($preorder, $inorder);
                $method = "Preorden + Inorden";
            }
        }
        
        // Si no se pudo construir, intentar con postorden e inorden
        if ($root === null && !empty($postorder) && !empty($inorder)) {
            if ($this->validateTraversals([], $inorder, $postorder)) {
                $root = $this->buildFromPostorderInorder($postorder, $inorder);
                $method = "Postorden + Inorden";
            }
        }
        
        if ($root === null) {
            throw new InvalidArgumentException('No se pudo construir el árbol con los recorridos proporcionados.');
        }
        
        return [
            'root' => $root,
            'method' => $method,
            'preorder' => $this->preorderTraversal($root),
            'inorder' => $this->inorderTraversal($root),
            'postorder' => $this->postorderTraversal($root),
            'visualization' => $this->getTreeVisualization($root),
            'ascii_tree' => $this->getAsciiTree($root)
        ];
    }
}

?>
