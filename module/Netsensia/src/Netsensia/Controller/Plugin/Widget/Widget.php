<?php
namespace Netsensia\Controller\Plugin\Widget;

abstract class Widget
{
    protected $widget;
    protected $serviceLocator;
    
    public function __construct($serviceLocator, $value)
    {
        $this->serviceLocator = $serviceLocator;

        echo ('<pre>');
        $this->widget = json_decode($value);
        
    }

    abstract public function process();
}

