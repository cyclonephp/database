<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class UnaryExpression implements Expression {
    
    public function compileSelf(Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }

}