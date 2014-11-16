<?php
namespace cyclonephp\database;

abstract class AbstractQueryResult implements QueryResult {
    
    /**
     * If this value is not <code>null</code>, then during processing the result,
     * the array keys will be the actual values in the current row specified by
     * this value (so it should be a column name in the query result).
     *
     * @var string
     */
    private $indexBy;

    /**
     * The index of the currently processed row.
     *
     * @var int
     */
    protected $index = -1;
    
    /**
     * The row that's currently processed (a cursor).
     *
     * @var array
     */
    protected $currentRow;
    
    /**
     * Sets the column of the database result to be used as index key during the
     * iteration.
     *
     * By default it's <code>null</code>. If it's <code>null</code>, then the
     * key will be the number of the currently processed row. It's useful to set
     * it to a primary key (if it's selected).
     *
     * @param string $column
     * @return AbstractQueryResult $this
     */
    public function indexBy($column) {
        $this->_indexBy = $column;
        return $this;
    }
    
    public function key() {
        if (is_null($this->indexBy))
            return $this->idx;
        
        return $this->_current_row[$this->_index_by];
    }
    
    public function getSingleRow() {
        $count = $this->count();
        switch ($count) {
            case 0:
                throw new QueryResultException('query returned 0 rows', QueryResultException::NO_ROWS_FOUND, null);
                break;
            case 1:
                $this->rewind();
                if ( ! $this->valid())
                    throw new QueryResultException('internal error: count() returned 1 but the iterator is not valid at position 0',
                    QueryResultException::INTERNAL_ERROR, null);
                return $this->current();
            default:
                throw new QueryResultException("query returned $count rows", ResultException::TOO_MANY_ROWS, null);
        }
    }
    
    
}