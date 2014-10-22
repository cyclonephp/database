<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class SetExpression extends AbstractExpression {

    private $elements;

    public function __construct(array $elements) {
        $this->elements = $elements;
    }

    public function compileSelf(Compiler $compiler) {
        $compiledElems = [];
        foreach ($this->elements as $elem) {
            if ($elem instanceof Expression) {
                $compiledElems []= $elem->compileSelf($compiler);
            } else {
                $compiledElems []= $compiler->escapeParameter($elem);
            }
        }
        return '(' . implode(', ', $compiledElems) . ')';
    }

    public function elements() {
        return $this->elements;
    }

}
