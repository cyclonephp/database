<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class ParamExpression extends AbstractExpression {
    
    private $rawParameter;
    
    function __construct($rawParameter) {
        $this->rawParameter = $rawParameter;
    }
    
    public function compileSelf(Compiler $compiler) {
        return $compiler->escapeParameter($this->rawParameter);
    }
    
    function getRawParameter() {
        return $this->rawParameter;
    }
    
}