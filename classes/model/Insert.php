<?php
namespace cyclonephp\database\model;

class Insert {
    
    /**
     *
     * @var Identifier
     */
    private $relation;
    
    /**
     * @var string[]
     */
    private $columns;
    
    /**
     * @var array
     */
    private $values = array();
    
    public function __construct(Identifier $relation) {
        $this->relation = $relation;
    }
    
    /**
     * @param array $columns a list of strings containing column names.
     * @return Insert
     */
    public function columns(array $columns) {
        $this->columns = $columns;
        return $this;
    }
    
    /**
     * 
     * @param Expression[] $rowData
     * @return Insert
     */
    public function values(array $rowData) {
        if ($this->columns === null) {
            $this->columns = array_keys($rowData);
        }
        $this->values []= $rowData;
        return $this;
    }
}