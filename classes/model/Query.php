<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;
use cyclonephp\database\Compiler;

class Query extends AbstractExpression {
    
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

    /**
     * @var Expression[]
     */
    private $groupByClause = array();

    /**
     * @var Expression
     */
    private $havingCondition;

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

    /**
     * @var array
     */
    private $unions = array();
    
    public function accept(QueryVisitor $visitor) {
        $visitor->visitProjection($this->isDistinct, $this->projection);
        $visitor->visitFromClause($this->fromClause);
        $visitor->visitJoinClauses($this->joins);
        $visitor->visitWhereCondition($this->whereCondition);
        $visitor->visitGroupByClause($this->groupByClause);
        $visitor->visitHavingCondition($this->havingCondition);
        $visitor->visitOrderByClause($this->orderByClause);
        $visitor->visitOffsetLimit($this->offset, $this->limit);
    }

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
            $this->projection = array(DB::raw('*'));
        } else {
            $projection = array();
            foreach ($columns as $col) {
                $projection [] = $this->toExpression($col);
            }
            $this->projection = $projection;
        }
        return $this;
    }
    
    private function toExpression($rawExpr) {
        if ($rawExpr instanceof Expression)
            return $rawExpr;
        if (is_string($rawExpr)) {
            $segments = explode(' ', $rawExpr);
            if (count($segments) == 1)
                return DB::id($segments[0]);
            else
                return DB::id($segments[0])->alias($segments[1]);
        } else
            throw new \InvalidArgumentException("invalid expression: $rawExpr");
    }

    public function from($relation) {
        $this->fromClause [] = $this->toExpression($relation);
        return $this;
    }

    public function join($relation, $joinType = 'INNER') {
        $join = new JoinClause($this->toExpression($relation), $joinType);
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

    public function orderBy($orderingExpression, $direction = Ordering::ASCENDING) {
        if (!$orderingExpression instanceof Expression) {
            $orderingExpression = DB::expr($orderingExpression);
        }
        $this->orderByClause []= new Ordering($orderingExpression, $direction);
        return $this;
    }

    public function groupBy() {
        $args = func_get_args();
        foreach ($args as $arg) {
            if ($arg instanceof Expression) {
                $this->groupByClause []= $arg;
            } else {
                $this->groupByClause []= DB::expr($arg);
            }
        }
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
    
    public function compileSelf(Compiler $compiler) {
        return '(' . $compiler->compileQuery($this) . ')';
    }

}
