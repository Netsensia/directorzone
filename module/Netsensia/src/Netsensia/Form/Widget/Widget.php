<?php
namespace Netsensia\Form\Widget;

use Zend\Form\Element;
use Netsensia\Model\DatabaseTableModel;
use Zend\ServiceManager\ServiceManager;

abstract class Widget
{
    protected $serviceLocator;
    protected $parentModel;
    protected $element;
    
    public function __construct(
        Element $element,
        DatabaseTableModel $parentModel,
        ServiceManager $serviceLocator
    ) 
    {
        $this->element = $element;
        $this->parentModel = $parentModel;
        $this->serviceLocator = $serviceLocator;
    }
    
    abstract function getPopulatedElement();
}

