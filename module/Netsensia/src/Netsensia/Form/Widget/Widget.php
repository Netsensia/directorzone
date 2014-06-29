<?php
namespace Netsensia\Form\Widget;

use Zend\Form\Element;

abstract class Widget
{
    protected $serviceLocator;
    protected $element;
    
    public function __construct(
        Element $element,
        $serviceLocator
    ) 
    {
        $this->element = $element;
        $this->serviceLocator = $serviceLocator;
    }
    
    abstract function getPopulatedElement();
}

