<?php
namespace cyclonephp\database;

class QueryResultException extends DatabaseException {
    
    const NO_ROWS_FOUND = 0;
    
    const TOO_MANY_ROWS = 2;
    
    const INTERNAL_ERROR = 3;
    
}