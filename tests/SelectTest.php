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
    
}