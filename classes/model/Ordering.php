<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class Ordering {
    
    const ASCENDING = 'ASC';
    
    const DESCENDING = 'DESC';
    
    /**
     * @var Expression
     */
    private $orderingExpression;

    /**
     * @var string
     */
    private $direction;
    
    /**
     * @param Expression $orderingExpression
     * @param string $direction
     */
    public function __construct(Expression $orderingExpression, $direction) {
        $this->orderingExpression = $orderingExpression;
        $this->direction = $direction;
    }
    
    /**
     * @return Expression
     */
    public function orderingExpression() {
        return $this->orderingExpression;
    }
    
    /**
     * @return string
     */
    public function direction() {
        return $this->direction;
    }
    
}