<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Query;
use cyclonephp\database\model\InsertStatement;
use cyclonephp\database\model\UpdateStatement;
use cyclonephp\database\model\DeleteStatement;

class DefaultDatabaseManager implements DatabaseManager {
    
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Compiler
     */
    private $compiler;

    /**
     * @var Executor
     */
    private $executor;
    
    public function __construct(Connection $connection, Compiler $compiler, Executor $executor) {
        $this->connection = $connection;
        $this->compiler = $compiler;
        $this->executor = $executor;
    }
    
    public function execQuery(Query $query) {
        return $this->executor->execQuery($this->compiler->compileSelect($query));
    }
    
    public function execInsert(InsertStatement $insertStmt) {
        return $this->executor->execInsert($this->compiler->compileInsert($insertStmt));
    }

    public function execUpdate(UpdateStatement $updateStmt) {
        return $this->executor->execUpdate($this->compiler->compileUpdate($updateStmt));
    }
    
    public function execDelete(DeleteStatement $deleteStmt) {
        return $this->executor->execDelete($this->compiler->compileDelete($deleteStmt));
    }
    
    public function startTransaction() {
        $this->connection->startTransaction();
    }
    
    public function commit() {
        $this->connection->commit();
    }

    public function rollback() {
        $this->connection->rollback();
    }
    
}