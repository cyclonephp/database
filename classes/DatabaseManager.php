<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Query;
use cyclonephp\database\model\InsertStatement;
use cyclonephp\database\model\UpdateStatement;
use cyclonephp\database\model\DeleteStatement;

interface DatabaseManager {
    
    public function execQuery(Query $query);
    
    public function execUpdate(UpdateStatement $updateStmt);
    
    public function execInsert(InsertStatement $insertStmt);
    
    public function execDelete(DeleteStatement $deleteStmt);
    
    public function startTransaction();
    
    public function commit();
    
    public function rollback();
    
}