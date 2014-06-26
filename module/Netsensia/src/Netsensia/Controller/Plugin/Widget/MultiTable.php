<?php
namespace Netsensia\Controller\Plugin\Widget;

class MultiTable extends Widget
{
    public function process()
    {
        $joinTableModel = $this->serviceLocator->get(
            $this->widget->jointablemodel . 'Model'
        );
        
        $widgetFields = [];
        foreach ($this->widget->fields as $field) {
            if ($field->name == 'select') {
                $widgetFields[] = $field->name . 'id';
            } else {
                $widgetFields[] = $field->name;
            }
        }
    }
}

