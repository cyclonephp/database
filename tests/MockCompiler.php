<?php
namespace cyclonephp\database;

class MockCompiler extends AbstractCompiler {
    
    public function escapeIdentifier($identifier) {
        return '"' . $identifier . '"';
    }

    public function escapeParameter($param) {
        return "'" . $param . "'";
    }

}