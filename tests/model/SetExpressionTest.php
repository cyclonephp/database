<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class SetExpressionTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelf() {
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeParameter')
                ->with($this->equalTo(1))
                ->willReturn("'1'");
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('a'))
                ->willReturn('"a"');
        $set = DB::expr([1, DB::id('a')]);
        $actual = $set->compileSelf($compiler);
        $this->assertEquals("('1', \"a\")", $actual);
    }
    
}