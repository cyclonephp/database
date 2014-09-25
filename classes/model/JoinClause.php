<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class JoinClause {
    
    private $joinedRelation;
    
    private $joinCondition;
    
    private $joinType;
    
    public function __construct($joinedRelation, $joinType) {
        $this->joinedRelation = $joinedRelation;
        $this->joinType = $joinType;
    }
    
    public function joinCondition($joinCondition) {
        $this->joinCondition = $joinCondition;
    }
    
    public function addCondition($condition) {
        if ($this->joinCondition === null) {
            $this->joinCondition = $condition;
        } else {
            $this->joinCondition = DB::expr($this->joinCondition, Expression::OP_AND, $condition);
        }
    }    
    
}