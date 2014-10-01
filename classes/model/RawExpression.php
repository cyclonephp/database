<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class RawExpression extends AbstractExpression {
	
    const NULL_LITERAL = 'NULL';
    
    private $expression;
    
    function __construct($expression) {
        if ($expression === null) {
            $this->expression = self::NULL_LITERAL;
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
