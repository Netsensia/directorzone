<?php
namespace Netsensia\Controller\Plugin\Widget;

abstract class Widget
{
    protected $widget;
    protected $serviceLocator;
    protected $parentModel;
    
    public function __construct(
        $serviceLocator,
        $value,
        $parentModel
    )
    {
        $this->serviceLocator = $serviceLocator;
        $this->parentModel = $parentModel;
        $this->widget = json_decode($value);
    }

    abstract public function process();
}

