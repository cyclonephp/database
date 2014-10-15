<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;

class BetweenExpressionTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelf() {
        $subject = DB::id('age')->between(DB::raw(18), DB::raw(99));
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('age'))
                ->willReturn('"age"');
        $this->assertEquals('"age" BETWEEN (18) AND (99)', $subject->compileSelf($compiler));
    }
    
}