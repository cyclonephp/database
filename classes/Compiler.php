<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Query;
use cyclonephp\database\model\Identifier;
use cyclonephp\database\model\ParamExpression;

interface Compiler {

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
    
}
