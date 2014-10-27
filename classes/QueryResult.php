<?php
namespace cyclonephp\database;

interface QueryResult extends \Iterator, \Countable {
    
    public function toArray();
    
}

