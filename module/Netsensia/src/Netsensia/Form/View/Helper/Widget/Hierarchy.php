<?php
namespace Netsensia\Form\View\Helper\Widget;

class Hierarchy extends Widget
{
    public function render()
    {
        $options = json_decode($this->element->getValue());
        
        $optionsArray = $this->form->getOptionsArray(
            $options->name,
            $options->name . 'id',
            $options->name,
            true
        );
        
        //var_dump($optionsArray); die;
    }
}
