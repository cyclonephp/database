<?php
namespace cyclonephp\database\model;

class ParamExpressionTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelf() {
        $expr = new ParamExpression('10');
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeParameter')
                ->with($this->equalTo($expr->getRawParameter()))
                ->willReturn('"10"');
        $this->assertEquals('"10"', $expr->compileSelf($compiler));
    }
    
}