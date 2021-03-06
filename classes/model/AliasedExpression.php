<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class AliasedExpression implements Expression {
    
    /**
     *
     * @var Expression
     */
    private $expression;
    
    /**
     *
     * @var string
     */
    private $alias;
    
    function __construct(Expression $expression, $alias) {
        $this->expression = $expression;
        $this->alias = $alias;
    }
    
    function expression() {
        return $this->expression;
    }

    function getAlias() {
        return $this->alias;
    }
    
    public function compileSelf(Compiler $compiler) {
        return $this->expression->compileSelf($compiler) . ' AS '
                . $compiler->escapeIdentifier($this->alias);
    }
    
    public function alias($alias) {
        throw new \Exception("already an alias expression");
    }

    public function between(Expression $lowerBound, Expression $higherBound) {
        throw new \Exception("aliased expressions cannot be used within between expressions");
    }

}