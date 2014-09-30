<?php

namespace cyclonephp\database;

use cyclonephp\database\model\Identifier;

class DBTest extends \PHPUnit_Framework_TestCase {

    public function testQualifiedIdentifier() {
        $actual = DB::id('rel.col');
        $this->assertInstanceOf('\\cyclonephp\\database\\model\\Identifier', $actual);
        $this->assertEquals('rel', $actual->getRelationName());
        $this->assertEquals('col', $actual->getColumnName());
    }

    public function testUnqualifiedIdentifier() {
        $actual = DB::id('col');
        $this->assertInstanceOf('\\cyclonephp\\database\\model\\Identifier', $actual);
        $this->assertEquals(null, $actual->getRelationName());
        $this->assertEquals('col', $actual->getColumnName());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage invalid identifier: 'a.b.c'
     */
    public function testInvalidIdentifier() {
        DB::id('a.b.c');
    }

    public function testCreateCustomExpr() {
        $actual = DB::raw('count(*)');
        $this->assertInstanceOf('cyclonephp\\database\\model\\RawExpression', $actual);
        $this->assertEquals('count(*)', $actual->getExpression());
    }

    public function testCreateNullExpr() {
        $actual = DB::raw(null);
        $this->assertInstanceOf('cyclonephp\\database\\model\\RawExpression', $actual);
        $this->assertEquals('NULL', $actual->getExpression());
    }

    public function testSetExpression() {
        $actual = DB::expr(array(DB::param(1), DB::param(2), DB::param(3)));
        $this->assertInstanceOf('cyclonephp\\database\\model\\SetExpression', $actual);
        foreach ($actual->elements() as $elem) {
            $this->assertInstanceOf('cyclonephp\\database\\model\\ParamExpression', $elem);
        }
    }

    public function testCreateBinaryExpr() {
        $actual = DB::expr('a', '=', 'b');
        $this->assertInstanceOf('cyclonephp\\database\\model\\BinaryExpression', $actual);
        $leftOp = $actual->leftOperand();
        $rightOp = $actual->rightOperand();
        $this->assertEquals(DB::id('a'), $leftOp);
        $this->assertEquals(DB::id('b'), $rightOp);
        $this->assertEquals('=', $actual->operator());
    }

    public function testComplexPredicate() {
        $rootExpr = DB::expr(DB::expr('a', '=', 'b'), 'AND', DB::expr(DB::param('1'), '=', 'rel2.col'));
        $this->assertBinaryExpr($rootExpr);
        $this->assertEquals('AND', $rootExpr->operator());
        $leftExpr = $rootExpr->leftOperand();
        $this->assertBinaryExpr($leftExpr);
        $this->assertEquals(DB::id('a'), $leftExpr->leftOperand());
        $this->assertEquals(DB::id('b'), $leftExpr->rightOperand());
        $rightExpr = $rootExpr->rightOperand();
        $this->assertEquals(DB::param('1'), $rightExpr->leftOperand());
        $this->assertEquals(DB::id('rel2.col'), $rightExpr->rightOperand());
    }

    private function assertBinaryExpr($actual) {
        $this->assertInstanceOf('cyclonephp\\database\\model\\BinaryExpression', $actual);
    }

    public function testParam() {
        $actual = DB::param('untrusted');
        $this->assertInstanceOf('cyclonephp\\database\\model\\ParamExpression', $actual);
        $this->assertEquals('untrusted', $actual->getRawParameter());
    }

}
