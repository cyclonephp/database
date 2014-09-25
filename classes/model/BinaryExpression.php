<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class BinaryExpression implements Expression {
    
    public function compileSelf(Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }
    
}