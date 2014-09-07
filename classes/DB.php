<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;

final class DB {
    
    /**
     * @return \cyclonephp\database\model\Select
     */
    public static function select() {
        $args = func_get_args();
        $rval = new Select;
        $rval->columnsArr($args);
        return $rval;
    }
    
    public static function selectDistinct() {
        $rval = new Select;
        return $rval->distinct();
    }
    
    private function __construct() {
        
    }
    
}