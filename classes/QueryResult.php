<?php
namespace cyclonephp\database;

interface QueryResult extends \Iterator, \Countable {
    
    public function indexBy($column);
    
    public function toArray();
    
    public function getSingleRow();
}

