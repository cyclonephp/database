<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;
use cyclonephp\database\model\Identifier;

interface Compiler {

    public function compileSelect(Select $query);
    
    public function escapeIdentifier(Identifier $identifier);
    
}
