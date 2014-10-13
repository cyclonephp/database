<?php
namespace cyclonephp\database\model;


interface SelectVisitor {
    
    /**
     * 
     * @param boolean $isDistinct
     * @param Expression[] $projection
     */
    public function visitProjection($isDistinct, array $projection);
    
    /**
     * @param Expression[] fromClause
     */
    public function visitFromClause(array $fromClause);
    
    /**
     * @param JoinClause[] $joinClauses
     */
    public function visitJoinClauses(array $joins);
    
    /**
     * @param Expression $whereCondition
     */
    public function visitWhereCondition(Expression $whereCondition = NULL);
    
}
