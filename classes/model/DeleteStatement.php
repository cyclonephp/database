<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class DeleteStatement {
    
    /**
     * @var Identifier
     */
    private $relation;
    
    /**
     * @var Expression
     */
    private $whereCondition;
    
    /**
     * @var Ordering[]
     */
    private $orderByClause;
    
    private $offset;
    
    private $limit;
    
    public function __construct(Identifier $relation) {
        $this->relation = $relation;
    }
    
    /**
     * @param Expression $whereCondition
     * @return DeleteStatement
     */
    public function where(Expression $whereCondition) {
        $this->whereCondition = $whereCondition;
        return $this;
    }
    
    public function orderBy($orderingExpression, $direction = Ordering::ASCENDING) {
        if (! $orderingExpression instanceof Expression) {
            $orderingExpression = DB::expr($orderingExpression);
        }
        $this->orderByClause []= new Ordering($orderingExpression, $direction);
        return $this;
    }
    
    /**
     * @param \cyclonephp\database\model\Expression $whereCondition
     * @return DeleteStatement
     */
    public function andWhere(Expression $whereCondition) {
        if ($this->whereCondition === null) {
            return $this->where($whereCondition);
        } else {
            return $this->where(DB::expr($this->whereCondition, 'AND', $whereCondition));
        }
    }
    
    /**
     * @param int $offset
     * @return DeleteStatement
     */
    public function offset($offset) {
        $this->offset = (int) $offset;
        return $this;
    }
    
    /**
     * @param int $limit
     * @return DeleteStatement
     */
    public function limit($limit) {
        $this->limit = (int) $limit;
        return $this;
    }
    
    /**
     * @return Identifier
     */
    public function getRelation() {
        return $this->relation;
    }

    /**
     * @return Expression
     */
    public function getWhereCondition() {
        return $this->whereCondition;
    }

    /**
     * @return Ordering[]
     */
    public function getOrderByClause() {
        return $this->orderByClause;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit() {
        return $this->limit;
    }


    
}