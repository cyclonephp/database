<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Query;
use cyclonephp\database\model\InsertStatement;
use cyclonephp\database\model\Identifier;
use cyclonephp\database\model\ParamExpression;

interface Compiler {

    /**
     * 
     * @param Query $query
     * @return string
     */
    public function compileSelect(Query $query);
    
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
    
}
