<?php
namespace cyclonephp\database;

class AbstractCompilerTest extends \PHPUnit_Framework_TestCase {
    
    public function testCompileSelect() {
        $query = DB::selectDistinct()
                ->from(DB::id('table1')->alias('a'))
                ->from(DB::id('table2')->alias('b'))
                ->join(DB::id('table3')->alias('c'))
                    ->on('b.id', '=', 'c.table2_id')
                ->leftJoin(DB::id('table4')->alias('d'))
                    ->on('c.id', '=', 'd.table3_id')
                ->where(DB::expr('a.x', '=', DB::param(25)))
                ->groupBy('c.name', 'd.description')
                ->having(DB::expr('a', '=', DB::raw(1)))
                ->orderBy('x.y')
                ->offset(10)
                ->limit(5);
        $actual = (new MockCompiler)->compileSelect($query);
        $this->assertNotNull($actual);
        $this->assertEquals('SELECT DISTINCT * FROM "table1" AS "a", "table2" AS "b" '
                . 'INNER JOIN "table3" AS "c" ON ("b"."id") = ("c"."table2_id") '
                . 'LEFT JOIN "table4" AS "d" ON ("c"."id") = ("d"."table3_id") '
                . 'WHERE ("a"."x") = (\'25\') '
                . 'GROUP BY "c"."name", "d"."description" '
                . 'HAVING ("a") = (1) '
                . 'ORDER BY "x"."y" ASC '
                . 'OFFSET 10 LIMIT 5', trim($actual));
    }
    
    
}