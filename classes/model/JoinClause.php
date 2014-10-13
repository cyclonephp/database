<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class JoinClause {
    
    private $joinedRelation;
    
    private $joinCondition;
    
    private $joinType;
    
    public function __construct(Expression $joinedRelation, $joinType) {
        $this->joinedRelation = $joinedRelation;
        $this->joinType = $joinType;
    }
    
    public function joinCondition($joinCondition) {
        $this->joinCondition = $joinCondition;
        return $this;
    }
    
    public function addCondition($condition) {
        if ($this->joinCondition === null) {
            $this->joinCondition = $condition;
        } else {
            $this->joinCondition = DB::expr($this->joinCondition, 'AND', $condition);
        }
        return $this;
    }    
    
}