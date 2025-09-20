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
        // Verificar que todos tengan la misma longitud
        $lengths = [count($preorder), count($inorder), count($postorder)];
        if (count(array_unique($lengths)) > 1) {
            return false;
        }
        
        // Verificar que todos tengan los mismos elementos
        $elements = [array_unique($preorder), array_unique($inorder), array_unique($postorder)];
        $allElements = array_merge($elements[0], $elements[1], $elements[2]);
        $uniqueElements = array_unique($allElements);
        
        return count($uniqueElements) === count($elements[0]);
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
    public function getTreeVisualization(?BinaryTreeNode $root, int $level = 0): string
    {
        if ($root === null) {
            return "";
        }
        
        $result = str_repeat("  ", $level) . $root->value . "\n";
        
        if ($root->left !== null || $root->right !== null) {
            if ($root->left !== null) {
                $result .= $this->getTreeVisualization($root->left, $level + 1);
            } else {
                $result .= str_repeat("  ", $level + 1) . "null\n";
            }
            
            if ($root->right !== null) {
                $result .= $this->getTreeVisualization($root->right, $level + 1);
            } else {
                $result .= str_repeat("  ", $level + 1) . "null\n";
            }
        }
        
        return $result;
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
            'visualization' => $this->getTreeVisualization($root)
        ];
    }
}

?>
