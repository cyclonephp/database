<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class Identifier implements Expression {
    
    private $relationName;
    
    private $columnName;
    
    function __construct($relationName, $columnName) {
        $this->relationName = $relationName;
        $this->columnName = $columnName;
    }
    
    function getRelationName() {
        return $this->relationName;
    }

    function getColumnName() {
        return $this->columnName;
    }

    public function compileSelf(Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }

}