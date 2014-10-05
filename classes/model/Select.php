<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class Select extends AbstractExpression {
    
    /**
     * If <code>TRUE</code> then the query will be compiled as a
     * <code>SELECT DISTINCT</code> query.
     *
     * @var boolean
     */
    private $isDistinct = false;

    /**
     * @var Expression[]
     */
    private $projection = array();

    /**
     * @var Expression[]
     */
    private $fromClause = array();

    /**
     * @var JoinClause[]
     */
    private $joins = array();

    /**
     * @var JoinClause
     */
    private $lastJoin;

    /**
     * @var Expression
     */
    private $whereCondition;

    private $groupByClause = array();

    /**
     * @var Expression
     */
    private $havingCondition = array();

    /**
     * @var Ordering[]
     */
    private $orderByClause = array();

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    private $unions = array();

    public function distinct($isDistinct = true) {
        $this->isDistinct = $isDistinct;
        return $this;
    }

    public function columns() {
        $this->columnsArr(func_get_args());
        return $this;
    }

    public function columnsArr($columns) {
        if (empty($columns)) {
            $this->projection = array(DB::expr('*'));
        } else {
            foreach ($columns as $col) {
                $this->projection [] = $col;
            }
        }
        return $this;
    }

    public function from($relation) {
        $this->fromClause [] = $relation;
        return $this;
    }

    public function join($relation, $joinType = 'INNER') {
        $join = new JoinClause($relation, $joinType);
        $this->joins []= $join;
        $this->lastJoin = $join;
        return $this;
    }

    public function leftJoin($relation) {
        return $this->join($relation, 'LEFT');
    }

    public function rightJoin($relation) {
        return $this->join($relation, 'RIGHT');
    }

    public function on() {
        $this->lastJoin->addCondition(DB::createExpr(func_get_args()));
        return $this;
    }
    
    public function where(Expression $whereCondition) {
        $this->whereCondition = $whereCondition;
        return $this;
    }

    public function andWhere(Expression $whereCondition) {
        if ($this->whereCondition === null) {
            return $this->where($whereCondition);
        } else {
            return $this->where(DB::expr($this->whereCondition, 'AND', $whereCondition));
        }
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->orderByClause []= new Ordering($column, $direction);
        return $this;
    }

    public function groupBy() {
        $this->groupByClause = func_get_args();
        return $this;
    }

    public function andHaving(Expression $havingCondition) {
        if ($this->havingCondition === null) {
            return $this->having($havingCondition);
        } else {
            return $this->having(DB::expr($this->havingCondition, 'AND', $havingCondition));
        }
    }
    
    public function having(Expression $havingCondition) {
        $this->havingCondition = $havingCondition;
        return $this;
    }

    public function offset($offset) {
        $this->offset = (int) $offset;
        return $this;
    }

    public function limit($limit) {
        $this->limit = (int) $limit;
        return $this;
    }

    public function union(Select $select, $all = TRUE){
        $this->unions[] = array(
            'select' => $select,
            'all' => $all
        );
        return $this;
    }
    
    public function compileSelf(\cyclonephp\database\Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }

}
