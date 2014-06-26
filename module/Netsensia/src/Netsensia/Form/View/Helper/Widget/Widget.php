<?php
namespace Netsensia\Form\View\Helper\Widget;

abstract class Widget
{
    protected $view;
    protected $form;
    protected $element;
    
    public function __construct($view, $form, $element)
    {
        $this->view = $view;
        $this->form = $form;
        $this->element = $element;
    }
    
    abstract public function render();
}

