<?php
namespace cyclonephp\database\model;

use cyclonephp\database\DB;


class SelectTest extends \PHPUnit_Framework_TestCase {
    
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
    
    public function testVisitProjection() {
        $visitor = $this->getMock('cyclonephp\\database\\model\\SelectVisitor');
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
    
}