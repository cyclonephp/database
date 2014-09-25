<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class Ordering {
    
    private $orderingExpression;
    
    private $direction;
    
    public function __construct($orderingExpression, $direction) {
        $this->orderingExpression = $orderingExpression;
        $this->direction = $direction;
    }
    
    public function orderingExpression() {
        return $this->orderingExpression;
    }
    
    public function direction() {
        return $this->direction;
    }
    
}