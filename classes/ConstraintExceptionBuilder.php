<?php

namespace cyclonephp\database;

class ConstraintExceptionBuilder {
    
    private $errorMessage;
    
    private $errorCode;

    private $constraintType;
    
    private $constraintName;
    
    private $column;
    
    private $detail;
    
    private $hint;
    
    /**
     * @param string $errorMessage
     * @return ConstraintExceptionBuilder
     */
    public function errorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @param string $constraintType
     * @return ConstraintExceptionBuilder
     */
    public function constraintType($constraintType) {
        $this->constraintType = $constraintType;
        return $this;
    }

    /**
     * @param string $constraintName
     * @return ConstraintExceptionBuilder
     */
    public function constraintName($constraintName) {
        $this->constraintName = $constraintName;
        return $this;
    }

    /**
     * @param string $errorCode
     * @return ConstraintExceptionBuilder
     */
    public function errorCode($errorCode) {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @param string $column
     * @return ConstraintExceptionBuilder
     */
    public function column($column) {
        $this->column = $column;
        return $this;
    }

    /**
     * @param string $detail
     * @return ConstraintExceptionBuilder
     */
    public function detail($detail) {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @param string $hint
     * @return ConstraintExceptionBuilder
     */
    public function hint($hint) {
        $this->hint = $hint;
        return $this;
    }

    /**
     * @return ConstraintException
     */
    public function build() {
        return new ConstraintException($this->errorMessage
                , $this->errorCode
                , $this->constraintType
                , $this->constraintName
                , $this->column
                , $this->detail
                , $this->hint);
    }

}
