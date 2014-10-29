<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class InsertStatement {
    
    /**
     *
     * @var Identifier
     */
    private $relation;
    
    /**
     * @var Identifier[]
     */
    private $columns;
    
    /**
     * @var Expression[][]
     */
    private $values = array();
    
    public function __construct(Identifier $relation) {
        $this->relation = $relation;
    }
    
    /**
     * @param array $columns a list of strings containing column names.
     * @return InsertStatement
     */
    public function columns(array $columns) {
        $this->columns = [];
        foreach ($columns as $colStr) {
            $this->columns []= new Identifier(null, $colStr);
        }
        return $this;
    }
    
    public function getRelation() {
        return $this->relation;
    }

    /**
     * @return Identifier[]
     */
    public function getColumns() {
        return $this->columns;
    }

    /**
     * 
     * @return Expression[][]
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * 
     * @param Expression[] $rowData
     * @return InsertStatement
     */
    public function values(array $rowData) {
        if ($this->columns === null) {
            $this->columns(array_keys($rowData));
        }
        $newRow = [];
        foreach ($rowData as $k => $val) {
            if ($val instanceof Expression) {
                $newRow[$k] = $val;
            } else {
                $newRow[$k] = DB::param($val);
            }
        }
        $this->values []= $newRow;
        return $this;
    }
}