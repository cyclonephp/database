<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class BinaryExpression extends AbstractExpression {

    private $leftOperand;
    
    private $operator;
    
    private $rightOperand;

    public function __construct(Expression $leftOperand, $operator, Expression $rightOperand) {
        $this->leftOperand = $leftOperand;
        $this->operator = $operator;
        $this->rightOperand = $rightOperand;
    }

    public function compileSelf(Compiler $compiler) {
        return '(' . $this->leftOperand->compileSelf($compiler). ') '
                . $this->operator
                . ' (' . $this->rightOperand->compileSelf($compiler) . ')';
    }

    public function leftOperand() {
        return $this->leftOperand;
    }

    public function operator() {
        return $this->operator;
    }

    public function rightOperand() {
        return $this->rightOperand;
    }

}
