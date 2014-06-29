<?php
namespace Netsensia\Form\Widget;

class MultiTable extends Widget
{
    public function getPopulatedElement()
    {
        $options = json_decode($this->element->getValue());
        
        $modelName = $options->jointablemodel . 'Model';
        
        $model = $this->serviceLocator->get($modelName);
        
        return $this->element;
    }
}

