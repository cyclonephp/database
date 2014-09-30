<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class Select implements Expression {
    
    /**
     * If <code>TRUE</code> then the query will be compiled as a
     * <code>SELECT DISTINCT</code> query.
     *
     * @var boolean
     */
    private $isDistinct = false;

    /**
     * Sequence of columns to be selected. Every item of the array can be:
     * <ul>
     * <li>a string (column name)</li>
     * <li>an array that's 0th item is a column name, the 1st is a column alias</li>
     * <li>an array that's 0th item is a @c \cyclone\db\Expression instance, the 1st item
     *      is an alias</li>
     * </ul>
     *
     * @var array
     */
    private $projection = array();

    /**
     * @var array
     */
    private $fromClause = array();

    /**
     * @var array
     */
    private $joins = array();

    private $lastJoin;

    private $whereConditions = array();

    private $groupByClause = array();

    private $havingConditions = array();

    private $orderByClause = array();

    private $offset;

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

    public function where() {
        $this->whereConditions []= DB::createExpr(func_get_args());
        return $this;
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->orderByClause []= new Ordering($column, $direction);
        return $this;
    }

    public function groupBy() {
        $this->groupByClause = func_get_args();
        return $this;
    }

    public function having() {
        $this->havingConditions []= DB::createExpr(func_get_args());
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
