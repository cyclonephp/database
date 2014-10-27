<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;


class QueryTest extends \PHPUnit_Framework_TestCase {
    
    public function testBuilderAPI() {
        DB::select()
                ->columns('table1.a t1a', 'table2.a t2a', DB::expr('table2.b')->alias('t2b'))
                ->distinct()
                ->from('table')
                ->join('table2')->on('table.a', '=', 'table2.a')
                ->where(DB::expr('a', '=', 'b'))
                ->andWhere(DB::expr('a', '=', 'b'))
                ->orderBy('a')
                ->orderBy('a', 'desc')
                ->groupBy('a', 'b')
                ->having(DB::expr('a', '=', 'b'))
                ->andHaving(DB::expr('a', '=', 'b'));
    }
    
    private function mockVisitor() {
        return $this->getMock('cyclonephp\\database\\model\\QueryVisitor');
    }
    
    public function testVisitProjection() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitProjection')
                ->with($this->equalTo(false),
                       $this->equalTo([
                           DB::id('table1.a'),
                           DB::id('table1.b')->alias('t1b'),
                           DB::expr('table2.b')->alias('t2b')
                       ]));
        DB::select()->columns('table1.a', 'table1.b t1b', DB::expr('table2.b')->alias('t2b'))
                ->accept($visitor);
    }
    
    public function testVisitFromClause() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitFromClause')
                ->with($this->equalTo([
                    DB::id('table1')->alias('tbl1'),
                    DB::id('table2')
                ]));
        DB::select()->from('table1 tbl1')->from('table2')->accept($visitor);
    }
    
    public function testVisitJoinClauses() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitJoinClauses')
                ->with($this->equalTo([
                    (new JoinClause(DB::id('table2'), 'INNER'))
                        ->joinCondition(DB::expr('table1.id', '=', 'table2.table1_id')),
                    (new JoinClause(DB::id('table3'), 'LEFT'))
                        ->joinCondition(DB::expr('table2.id', '=', 'table3.table2_id'))
                ]));
        DB::select()->from('table1')
                ->join('table2')->on('table1.id', '=', 'table2.table1_id')
                ->leftJoin('table3')->on('table2.id', '=', 'table3.table2_id')
                ->accept($visitor);
    }
    
    public function testVisitWhereCondition() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitWhereCondition')
                ->with($this->equalTo(new BinaryExpression(DB::id('a'), '=', DB::id('b'))));
        DB::select()->where(DB::expr('a', '=', 'b'))->accept($visitor);
    }
    
    public function testVisitGroupByClause() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitGroupByClause')
                ->with($this->equalTo([
                    new Identifier('tbl1', 'a'),
                    new Identifier('tbl1', 'b')
                ]));
        DB::select()->groupBy('tbl1.a', DB::expr('tbl1.b'))->accept($visitor);
    }
    
    public function testVisitHavingCondition() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitHavingCondition')
                ->with($this->equalTo(new BinaryExpression(DB::id('a'), '=', DB::id('b'))));
        DB::select()->having(DB::expr('a', '=', 'b'))->accept($visitor);
    }
    
    public function testVisitOrderByClause() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitOrderByClause')
                ->with($this->equalTo([
                    new Ordering(DB::id('a'), 'ASC'),
                    new Ordering(DB::id('b'), 'DESC')
                ]));
        DB::select()->orderBy('a')->orderBy(DB::expr('b'), 'DESC')->accept($visitor);
    }
    
    public function testVisitOffsetLimit() {
        $visitor = $this->mockVisitor();
        $visitor->expects($this->once())
                ->method('visitOffsetLimit')
                ->with($this->equalTo(20), $this->equalTo(1));
        DB::select()->offset(20)->limit(true)->accept($visitor);
    }
    
    public function testCompileSelf() {
        $query = DB::select()->from('table');
        $compiler = $this->getMock('cyclonephp\\database\\Compiler');
        $compiler->expects($this->once())
                ->method('compileSelect')
                ->with($this->equalTo($query))
                ->willReturn('subquery');
        $this->assertEquals('(subquery)', $query->compileSelf($compiler));
    }
    
}