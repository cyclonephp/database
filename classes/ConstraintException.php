<?php
namespace cyclonephp\database;

class ConstraintException extends DatabaseException {
    
    const UNIQUE = 'unique';
    
    const NOTNULL = 'notnull';
    
    const FOREIGNKEY = 'foreignkey';
    
    const CUSTOM = 'custom';
    
    /**
     * @return \cyclonephp\database\ConstraintExceptionBuilder
     */
    public static function builder() {
        return new ConstraintExceptionBuilder;
    }

    /**
     * @var string
     */
    private $constraintType;
    
    /**
     * @var string
     */
    private $constraintName;
    
    /**
     * @var string
     */
    private $column;
    
    /**
     * @var string
     */
    private $detail;
    
    /**
     * @var string
     */
    private $hint;
    
    /**
     * @param string $message
     * @param string $errorCode
     * @param string $constraintType
     * @param string $constraintName
     * @param string $column
     * @param string $detail
     * @param string $hint
     */
    public function __construct($message, $errorCode, $constraintType, $constraintName, $column, $detail, $hint) {
        parent::__construct($message, $errorCode, null);
        $this->constraintType = $constraintType;
        $this->constraintName = $constraintName;
        $this->column = $column;
        $this->detail = $detail;
        $this->hint = $hint;
    }
    
    /**
     * @return string
     */
    public function constraintType() {
        return $this->constraintType;
    }

    /**
     * @return string
     */
    public function constraintName() {
        return $this->constraintName;
    }

    /**
     * @return string
     */
    public function column() {
        return $this->column;
    }

    /**
     * @return string
     */
    public function detail() {
        return $this->detail;
    }

    /**
     * @return string
     */
    public function hint() {
        return $this->hint;
    }
    
};