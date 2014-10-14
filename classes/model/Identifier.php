<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class Identifier extends AbstractExpression {
    
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
        $compiledColumn = $compiler->escapeIdentifier($this->columnName);
        if ($this->relationName === null) {
            return $compiledColumn;
        } else {
            return $compiler->escapeIdentifier($this->relationName)
                    . '.' . $compiledColumn;
        }
    }

}