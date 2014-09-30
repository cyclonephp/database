<?php

namespace cyclonephp\database;

use cyclonephp\database\model\Select;
use cyclonephp\database\model\SetExpression;
use cyclonephp\database\model\UnaryExpression;
use cyclonephp\database\model\BinaryExpression;
use cyclonephp\database\model\RawExpression;
use cyclonephp\database\model\Expression;
use cyclonephp\database\model\ParamExpression;
use cyclonephp\database\model\Identifier;

final class DB {

    /**
     * 
     * @param string $identifier
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

    public static function expr() {
        $args = func_get_args();
        return self::createExpr($args);
    }

    public static function createExpr(array $args) {
        switch (count($args)) {
            case 1:
                if (is_array($args[0])) {
                    return new SetExpression($args[0]);
                }
                return self::id($args[0]);
            case 2:
                $operator = $args[0];
                return new UnaryExpression($operator, self::toExpression($operand));
            case 3:
                return new BinaryExpression(self::toExpression($args[0]), $args[1], self::toExpression($args[2]));
        }
    }

    private static function toExpression($expr) {
        if ($expr instanceof Expression)
            return $expr;
        return self::expr($expr);
    }

    public static function raw($arg) {
        return new RawExpression($arg);
    }

    public static function param($toBeEscaped) {
        return new ParamExpression($toBeEscaped);
    }

    private function __construct() {
        
    }

}
