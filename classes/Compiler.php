<?php
namespace cyclone\database;

use cyclone\database\model\Select;

interface Compiler {

    public function compileSelect(Select $query);
    
}
