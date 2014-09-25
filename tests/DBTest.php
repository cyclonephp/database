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
    
    public function testCreateBinaryExpr() {
        $actual = DB::expr(1, '=', 2);
    }
    
}