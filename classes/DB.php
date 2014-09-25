<?php
namespace cyclonephp\database;

use cyclonephp\database\model\Select;
use cyclonephp\database\model\SetExpression;
use cyclonephp\database\model\UnaryExpression;
use cyclonephp\database\model\BinaryExpression;
use cyclonephp\database\model\RawExpression;
use cyclonephp\database\model\ParamExpression;
use cyclonephp\database\model\Identifier;


final class DB {
    
    const OP_OR = 'OR';
    
    const OP_AND = 'AND';
    
    const OP_NOT = 'NOT';
    
    /**
     * 
     * @param type $identifier
     * @return \cyclonephp\database\model\Identifier
     * @throws \InvalidArgumentException if $identifier contains more than one dot
     */
    public static function id($identifier) {
        $segments = explode('.', $identifier);
        switch (count($segments)) {
            case 1: 
                return new Identifier(null, $segments[0]);
            case 2:
                return new Identifier($segments[0], $segments[1]);
            default:
                throw new \InvalidArgumentException("invalid identifier: '{$identifier}'");
        }
    }
    
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
        $args = func_get_args();
        $rval = new Select;
        $rval->columnsArr($args);
        return $rval->distinct();
    }
    
    public function expr() {
        $args = func_get_args();
        return self::createExpr($args);
    }
    
    public function createExpr(array $args) {
        switch (count($args)) {
            case 1:
                if (is_array($args[0])) {
                    return new SetExpression($args[0]);
                }
                return new ParamExpression($args[0]);
            case 2:
                return new UnaryExpression($args[0], self::createNullExpr($args[1]));
            case 3:
                return new BinaryExpression(self::createNullExpr($args[0]), $args[1], self::createNullExpr($args[2]));
        }
    }
    
    public function raw($arg) {
        return new RawExpression($arg);
    }
    
    private function createNullExpr($arg) {
        if ($arg === null) {
            return new RawExpression('NULL');
        }
        return $arg;
    }
    
    
    private function __construct() {
        
    }
    
}