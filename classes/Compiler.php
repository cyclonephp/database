<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Query;
use cyclonephp\database\model\InsertStatement;
use cyclonephp\database\model\UpdateStatement;
use cyclonephp\database\model\DeleteStatement;

interface Compiler {

    /**
     * 
     * @param Query $query
     * @return string
     */
    public function compileQuery(Query $query);
    
    /**
     * @param string $identifier
     */
    public function escapeIdentifier($identifier);
    
    /**
     * 
     * @param string $param
     */
    public function escapeParameter($param);
    
    /**
     * 
     * @param InsertStatement $insertStmt
     * @return string
     */
    public function compileInsert(InsertStatement $insertStmt);

    /**
     * @param UpdateStatement $updateStmt
     * @return string
     */
    public function compileUpdate(UpdateStatement $updateStmt);
    
    /**
     * @param DeleteStatement $deleteStmt
     * @return string
     */
    public function compileDelete(DeleteStatement $deleteStmt);
    
}
