<?php
namespace cyclonephp\database\model;

class IdentifierTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileUnqualified() {
        $expr = new Identifier(null, 'col');
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('col'))
                ->willReturn('"col"');
        $this->assertEquals('"col"', $expr->compileSelf($compiler));
    }
    
    public function testCompileQualified() {
        $this->markTestSkipped('this mocking does not seem to work');
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('col'))
                ->willReturn('"col"');
        $compiler->expects($this->once())
                ->method('escapeIdentifier')
                ->with($this->equalTo('rel'))
                ->willReturn('"rel"');
        $expr = new Identifier('rel', 'col');
        $this->assertEquals('"rel"."col"', $expr->compileSelf($compiler));
    }
    
}