<?php
namespace cyclonephp\database\model;

abstract class AbstractExpression implements Expression {

    public function alias($alias) {
        return new ProjectionEntry($this, $alias);
    }
    
}
