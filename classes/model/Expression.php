<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

interface Expression {

    public function compileSelf(Compiler $compiler);
    
    /**
     * 
     * @param string $alias
     * @return Identifier
     */
    public function alias($alias);
    
    /**
     * 
     * @param Expression $lowerBound
     * @param Expression $higherBound
     * @return BetweenExpression
     */
    public function between(Expression $lowerBound, Expression $higherBound);
}
