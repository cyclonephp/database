<?php
namespace cyclonephp\database\model;


interface SelectVisitor {
    
    
    public function visitProjection($isDistinct, array $projection);
    
}
