<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

interface Expression {
    
    public function compileSelf(Compiler $compiler);
    
}
