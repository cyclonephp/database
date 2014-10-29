<?php
namespace cyclonephp\database;

interface Connection {
    
    /**
     * @return Connection $this
     */
    public function connect();
    
    /**
     * @return Connection $this
     */
    public function disconnect();
    
    /**
     * @return Connection $this
     */
    public function startTransaction();
    
    /**
     * @return Connection $this
     */
    public function commit();
    
    /**
     * @return Connection $this
     */
    public function rollback();
    
}