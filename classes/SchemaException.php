<?php
namespace cyclonephp\database;

class SchemaException extends DatabaseException {
    
    const RELATION = 'relation';
    
    const COLUMN = 'attribute';
    
    const FUNC = 'function';
    
    private $missingObjectType;
    
    private $missingObjectName;
    
    /**
     * @param string $missingObjectType
     * @param string $missingObjectName
     */
    public function __construct($missingObjectType, $missingObjectName) {
        $this->missingObjectType = $missingObjectType;
        $this->missingObjectName = $missingObjectName;
    }
    

    /**
     * @return string
     */
    public function missingObjectType() {
        return $this->missingObjectType;
    }

    /**
     * @return string
     */
    public function missingObjectName() {
        return $this->missingObjectName;
    }
    
};