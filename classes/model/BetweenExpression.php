<?php

namespace cyclonephp\database\model;

use cyclonephp\database\Compiler;

class BetweenExpression extends AbstractExpression {

    /**
     * @var Expression
     */
    private $subject;

    /**
     * @var Expression
     */
    private $lowerBound;

    /**
     * @var Expression
     */
    private $higherBound;

    function __construct(Expression $subject, Expression $lowerBound, Expression $higherBound) {
        $this->subject = $subject;
        $this->lowerBound = $lowerBound;
        $this->higherBound = $higherBound;
    }

    public function compileSelf(Compiler $compiler) {
        return $this->subject->compileSelf($compiler)
                . ' BETWEEN ('
                . $this->lowerBound->compileSelf($compiler)
                . ') AND ('
                . $this->higherBound->compileSelf($compiler) . ')';
    }

}
