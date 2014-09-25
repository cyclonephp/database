<?php

namespace cyclonephp\database\model;

class Identifier {
    
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
    
}