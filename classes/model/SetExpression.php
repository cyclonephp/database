<?php
namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class SetExpression implements Expression {
	
	private $elements;
	
	public function __construct(array $elements) {
		$this->elements = $elements;
	}
    
    public function compileSelf(Compiler $compiler) {
        throw new \Exception('not yet implemented');
    }
    
    public function elements() {
		return $this->elements;
	}
    
}
