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
    
    public function testCompileInsert() {
        $stmt = DB::insert('table')
                ->columns(['id', 'name', 'email'])
                ->values([10, 'foo', 'foo@bar.com'])
                ->values([20, 'bar', 'bar@foo.com']);
        $actual = (new MockCompiler)->compileInsert($stmt);
        $this->assertEquals('INSERT INTO "table" ("id", "name", "email") '
                . 'VALUES (\'10\', \'foo\', \'foo@bar.com\'), '
                . "('20', 'bar', 'bar@foo.com')", trim($actual));
    }
    
    public function testCompileInsertNoExplicitColumns() {
        $stmt = DB::insert('table')
                ->values(['id' => 10, 'name' => 'foo', 'email' => 'foo@bar.com'])
                ->values([20, 'bar', 'bar@foo.com']);
        $actual = (new MockCompiler)->compileInsert($stmt);
        $this->assertEquals('INSERT INTO "table" ("id", "name", "email") '
                . 'VALUES (\'10\', \'foo\', \'foo@bar.com\'), '
                . "('20', 'bar', 'bar@foo.com')", trim($actual));
    }
    
    public function testCompileInsertWithSubquery() {
        $stmt = DB::insert('table')
                ->values(['id' => DB::select('what')
                            ->from('ever')
                            ->limit(1),
                          'name' => 'foo']);
        $actual = (new MockCompiler)->compileInsert($stmt);
        $this->assertEquals('INSERT INTO "table" ("id", "name") '
                . 'VALUES ((SELECT "what" FROM "ever" LIMIT 1), \'foo\')'
                , trim($actual));
    }
    
    public function testCompileUpdate() {
        $stmt = DB::update('table')
                ->values([
                    'name' => 'foo',
                    'email' => 'foo@bar.com'
                ])
                ->where(DB::expr('id', '=', DB::param(1)));
        $actual = (new MockCompiler)->compileUpdate($stmt);
        $this->assertEquals('UPDATE "table" SET "name" = \'foo\', "email" = \'foo@bar.com\' '
                . 'WHERE ("id") = (\'1\')',
                trim($actual));
    }
    
    
}