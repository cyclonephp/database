<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class RawExpression implements Expression {
    
    private $expression;
    
    function __construct($expression) {
        if ($expression === null) {
            $this->expression = 'NULL';
        } else {
            $this->expression = $expression;
        }
    }
    
    public function compileSelf(Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }
    
    function getExpression() {
        return $this->expression;
    }

}