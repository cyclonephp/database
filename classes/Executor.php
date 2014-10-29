<?php
namespace cyclonephp\database;

interface Executor {
    
    /**
     * @param string $queryString
     * @return QueryResult
     */
    public function execQuery($queryString);
    
    /**
     * @param string $insertStmt
     * @return int the number if inserted rows
     */
    public function execInsert($insertStmt);
    
    /**
     * @param string $updateStmt
     * @return int the number of updated rows
     */
    public function execUpdate($updateStmt);
    
    /**
     * @param string $deleteStmt
     * @return int the number of deleted rows
     */
    public function execDelete($deleteStmt);
    
}