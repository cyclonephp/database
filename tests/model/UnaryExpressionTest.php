<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class UnaryExpressionTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelf() {
        $expr = new UnaryExpression('EXISTS', DB::raw(2));
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $this->assertEquals('EXISTS 2', $expr->compileSelf($compiler));
    }
    
}