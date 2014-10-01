<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class ParamExpression extends AbstractExpression {
    
    private $rawParameter;
    
    function __construct($rawParameter) {
        $this->rawParameter = $rawParameter;
    }
    
    public function compileSelf(Compiler $compiler) {
        
    }
    
    function getRawParameter() {
        return $this->rawParameter;
    }
    
}