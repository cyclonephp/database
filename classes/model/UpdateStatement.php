<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class UpdateStatement {
    
    /**
     * @var Identifier
     */
    private $relation;

    /**
     * @var Expression[]
     */
    private $values = [];

    /**
     * @var Expression
     */
    private $whereCondition;
    
    function __construct(Identifier $relation) {
        $this->relation = $relation;
    }
    
    /**
     * @param array $values
     * @return Update
     */
    public function values(array $values) {
        $newValues = [];
        foreach ($values as $col => $val) {
            if ($val instanceof Expression) {
                $newValues[$col] = $val;
            } else {
                $newValues[$col] = DB::param($val);
            }
        }
        $this->values = $newValues;
        return $this;
    }
    
    /**
     * 
     * @param Expression $whereCondition
     * @return Update
     */
    public function where(Expression $whereCondition) {
        $this->whereCondition = $whereCondition;
        return $this;
    }
    
    /**
     * @param Expression $whereCondition
     * @return Update
     */
    public function andWhere(Expression $whereCondition) {
        if ($this->whereCondition === null) {
            return $this->where($whereCondition);
        }
        return $this->where(DB::expr($this->whereCondition, 'AND', $whereCondition));
    }
    
    /**
     * @return Identifier
     */
    public function getRelation() {
        return $this->relation;
    }

    /**
     * @return Expression[]
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * @return Expression
     */
    public function getWhereCondition() {
        return $this->whereCondition;
    }
    
}
