<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;
use cyclonephp\database\model\Identifier;
use cyclonephp\database\model\ParamExpression;

interface Compiler {

    public function compileSelect(Select $query);
    
    public function escapeIdentifier(Identifier $identifier);
    
    public function escapeParameter(ParamExpression $param);
    
}
