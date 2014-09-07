<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;

interface Compiler {

    public function compileSelect(Select $query);
    
}
