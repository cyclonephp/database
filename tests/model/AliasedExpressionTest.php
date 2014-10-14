<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class AliasedExpressionTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelf() {
        $raw = DB::raw('count(1)');
        $aliased = $raw->alias('cnt');
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('cnt'))
                ->willReturn('"cnt"');
        $this->assertEquals('count(1) AS "cnt"', $aliased->compileSelf($compiler));
    }
    
}