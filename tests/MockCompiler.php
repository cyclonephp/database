<?php
namespace cyclonephp\database;

class MockCompiler extends AbstractCompiler {
    
    public function escapeIdentifier($identifier) {
        return '"' . $identifier . '"';
    }

    public function escapeParameter(model\ParamExpression $param) {
        return "'" . $param->getRawParameter() . "'";
    }

}