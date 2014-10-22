<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class UnaryExpression extends AbstractExpression {
    
    private $operator;
    
    /**
     * @var Expression
     */
    private $operand;
    
    function __construct($operator, Expression $operand) {
        $this->operator = $operator;
        $this->operand = $operand;
    }
    
    public function compileSelf(Compiler $compiler) {
        return $this->operator . ' ' . $this->operand->compileSelf($compiler);
    }

}