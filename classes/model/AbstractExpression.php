<?php
namespace cyclonephp\database\model;

abstract class AbstractExpression implements Expression {

    public function alias($alias) {
        return new AliasedExpression($this, $alias);
    }
    
    public function between(Expression $lowerBound, Expression $higherBound) {
        return new BetweenExpression($this, $lowerBound, $higherBound);
    }
    
}
