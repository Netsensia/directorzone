<?php
namespace Netsensia\Form\Widget;

abstract class Widget
{
    protected $value;
    
    public function __construct($value) {
        $this->value = $value;
    }
    
    abstract function getValue();
}

