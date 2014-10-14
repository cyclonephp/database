<?php

namespace cyclonephp\database\model;

class RawExpressiontest extends \PHPUnit_Framework_TestCase {

    public function testConstructor() {
        $actual = new RawExpression('count(*)');
        $this->assertEquals('count(*)', $actual->getExpression());
    }

    public function testNullExpr() {
        $actual = new RawExpression(null);
        $this->assertEquals(RawExpression::NULL_LITERAL, $actual->getExpression());
    }
    
    public function testCompile() {
        $expr = new RawExpression("count(*)");
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $this->assertEquals('count(*)', $expr->compileSelf($compiler));
    }

}
