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
     * @param JoinClause[] $joins
     */
    public function visitJoinClauses(array $joins);
    
    /**
     * @param Expression $whereCondition
     */
    public function visitWhereCondition(Expression $whereCondition = NULL);
    
    /**
     * @param Expression[] $groupByClause
     */
    public function visitGroupByClause(array $groupByClause);
    
    /**
     * @param Expression $havingCondition
     */
    public function visitHavingCondition(Expression $havingCondition = NULL);
    
    /**
     * @param Ordering[] $orderByClause
     */
    public function visitOrderByClause(array $orderByClause);
    
    /**
     * @param int $offset
     * @param int $limit
     */
    public function visitOffsetLimit($offset, $limit);
    
}
