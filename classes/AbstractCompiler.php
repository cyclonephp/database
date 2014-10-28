<?php
namespace cyclonephp\database;

use cyclonephp\database\model\QueryVisitor;
use cyclonephp\database\model\Query;
use cyclonephp\database\model\JoinClause;
use cyclonephp\database\model\Insert;

abstract class AbstractCompiler implements Compiler, QueryVisitor {
    
    private $queryString;
    
    public function compileSelect(Query $query) {
        $this->queryString = '';
        $query->accept($this);
        return $this->queryString;
    }
    
    public function visitFromClause(array $fromClause) {
        if (!empty($fromClause)) {
            $this->queryString .= 'FROM ';
            $compiledFromClauseEntries = [];
            foreach ($fromClause as $fromClauseEntry) {
                $compiledFromClauseEntries []= $fromClauseEntry->compileSelf($this);
            }
            $this->queryString .= implode(', ', $compiledFromClauseEntries) . ' ';
        }
    }

    public function visitGroupByClause(array $groupByClause) {
        if (!empty($groupByClause)) {
            $this->queryString .= 'GROUP BY ';
            $compiledGroupByExpressions = [];
            foreach ($groupByClause as $groupByExpr) {
                $compiledGroupByExpressions []= $groupByExpr->compileSelf($this);
            }
            $this->queryString .= implode(', ', $compiledGroupByExpressions) . ' ';
        }
    }

    public function visitHavingCondition(model\Expression $havingCondition = null) {
        if ($havingCondition !== null) {
            $this->queryString .= 'HAVING '
                    . $havingCondition->compileSelf($this) . ' ';
        }
    }

    public function visitJoinClauses(array $joins) {
        if (!empty($joins)) {
            $compiledJoins = [];
            foreach ($joins as $join) {
                $compiledJoins []= $this->compileJoin($join);
            }
            $this->queryString .= implode(' ', $compiledJoins) . ' ';
        }
    }
    
    private function compileJoin(JoinClause $joinClause) {
        $rval = $joinClause->getJoinType() . ' JOIN ';
        $rval .= $joinClause->getJoinedRelation()->compileSelf($this) . ' ON ';
        $rval .= $joinClause->getJoinCondition()->compileSelf($this);
        return $rval;
    }

    public function visitOffsetLimit($offset, $limit) {
        if ($offset !== null) {
            $this->queryString .= 'OFFSET ' . $offset . ' ';
        }
        if ($limit !== null) {
            $this->queryString .= 'LIMIT ' . $limit;
        }
    }

    public function visitOrderByClause(array $orderByClause) {
        if (!empty($orderByClause)) {
            $this->queryString .= 'ORDER BY ';
            $compiledOrderByEntries = [];
            foreach ($orderByClause as $orderByEntry) {
                $entry = $orderByEntry->orderingExpression()->compileSelf($this)
                        . ' ' . $orderByEntry->direction();
                $compiledOrderByEntries []= $entry;
            }
            $this->queryString .= implode(', ', $compiledOrderByEntries) . ' ';
        }
    }

    public function visitProjection($isDistinct, array $projection) {
        $this->queryString .= 'SELECT ';
        if ($isDistinct) {
            $this->queryString .= 'DISTINCT ';
        }
        $compiledProjectionEntries = [];
        foreach ($projection as $projEntry) {
            $compiledProjectionEntries []= $projEntry->compileSelf($this);
        }
        $this->queryString .= implode(', ', $compiledProjectionEntries) . ' ';
    }

    public function visitWhereCondition(model\Expression $whereCondition = NULL) {
        if ($whereCondition !== null) {
            $this->queryString .= 'WHERE ' . $whereCondition->compileSelf($this) . ' ';
        }
    }
    
    public function compileInsert(Insert $insertStmt) {
        $this->queryString = 'INSERT INTO '
                . $insertStmt->getRelation()->compileSelf($this);
        $compiledColumns = [];
        foreach ($insertStmt->getColumns() as $col) {
            $compiledColumns []= $col->compileSelf($this);
        }
        $this->queryString .= ' (' . implode(', ', $compiledColumns)
                . ') VALUES ';
        return $this->queryString;
    }
    
}