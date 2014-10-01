<?php
namespace cyclonephp\database\model;

class ProjectionEntry {
    
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

    function alias() {
        return $this->alias;
    }
    
}