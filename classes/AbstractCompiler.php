<?php
namespace cyclonephp\database;

use cyclonephp\database\model\QueryVisitor;
use cyclonephp\database\model\Query;
use cyclonephp\database\model\JoinClause;
use cyclonephp\database\model\InsertStatement;
use cyclonephp\database\model\UpdateStatement;
use cyclonephp\database\model\DeleteStatement;
use cyclonephp\database\model\Expression;

abstract class AbstractCompiler implements Compiler, QueryVisitor {
    
    private $queryString;
    
    public function compileQuery(Query $query) {
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

    public function visitHavingCondition(Expression $havingCondition = null) {
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
    
    /**
     * 
     * @param int $offset
     * @param int $limit
     * @return string
     */
    private function compileOffsetLimit($offset, $limit) {
        $rval = '';
        if ($offset !== null) {
            $rval .= 'OFFSET ' . $offset . ' ';
        }
        if ($limit !== null) {
            $rval .= 'LIMIT ' . $limit;
        }
        return $rval;
    }

    public function visitOffsetLimit($offset, $limit) {
        $this->queryString .= $this->compileOffsetLimit($offset, $limit);
    }
    
    /**
     * @param array $orderByClause
     * @return string
     */
    private function compileOrderbyClause(array $orderByClause) {
        if (empty($orderByClause)) {
            return '';
        } else {
            $rval = 'ORDER BY ';
            $compiledOrderByEntries = [];
            foreach ($orderByClause as $orderByEntry) {
                $entry = $orderByEntry->orderingExpression()->compileSelf($this)
                        . ' ' . $orderByEntry->direction();
                $compiledOrderByEntries []= $entry;
            }
            $rval .= implode(', ', $compiledOrderByEntries) . ' ';
            return $rval;
        }
    }

    public function visitOrderByClause(array $orderByClause) {
        $this->queryString .= $this->compileOrderbyClause($orderByClause);
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
    
    /**
     * @param Expression $whereCondition
     * @return string
     */
    private function compileWhereCondition(Expression $whereCondition = null) {
        if ($whereCondition === null) {
            return '';
        } else {
            return 'WHERE ' . $whereCondition->compileSelf($this) . ' ';
        }
    }

    public function visitWhereCondition(Expression $whereCondition = null) {
        $this->queryString .= $this->compileWhereCondition($whereCondition);
    }
    
    public function compileInsert(InsertStatement $insertStmt) {
        $rval = 'INSERT INTO '
                . $insertStmt->getRelation()->compileSelf($this);
        $compiledColumns = [];
        foreach ($insertStmt->getColumns() as $col) {
            $compiledColumns []= $col->compileSelf($this);
        }
        $rval .= ' (' . implode(', ', $compiledColumns). ') VALUES ';
        $compiledRecords = [];
        foreach ($insertStmt->getValues() as $record) {
            $compiledValues = [];
            foreach ($record as $value) {
                $compiledValues []= $value->compileSelf($this);
            }
            $compiledRecords []= implode(', ', $compiledValues);
        }
        $rval .= '(' . implode('), (', $compiledRecords) . ')';
        return $rval;
    }
    
    public function compileUpdate(UpdateStatement $updateStmt) {
        $rval = 'UPDATE ' . $updateStmt->getRelation()->compileSelf($this) . ' SET ';
        $compiledParts = [];
        foreach ($updateStmt->getValues() as $columnName => $value) {
            $compiledParts []= $this->escapeIdentifier($columnName) .
                    ' = ' . $value->compileSelf($this);
        }
        $rval .= implode(', ', $compiledParts) . ' ';
        $rval .= $this->compileWhereCondition($updateStmt->getWhereCondition());
        return $rval;
    }
    
    public function compileDelete(DeleteStatement $deleteStmt) {
        $rval = 'DELETE FROM ' . $deleteStmt->getRelation()->compileSelf($this) . ' ';
        $rval .= $this->compileWhereCondition($deleteStmt->getWhereCondition());
        $rval .= $this->compileOrderbyClause($deleteStmt->getOrderByClause());
        $rval .= $this->compileOffsetLimit($deleteStmt->getOffset(), $deleteStmt->getLimit());
        return $rval;
    }
    
}