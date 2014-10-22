<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;
use cyclonephp\database\model\Identifier;
use cyclonephp\database\model\ParamExpression;

interface Compiler {

    public function compileSelect(Select $query);
    
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
