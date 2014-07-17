<?php
namespace Netsensia\Form\Widget;

use Zend\Db\Sql\Select;

class MultiTable extends Widget
{
    public function getPopulatedElement()
    {
        $elementValue = $this->element->getValue();
        
        $options = json_decode($elementValue);
        
        $columnNames = [];
        foreach ($options->fields as $field) {
            if ($field->type == 'select') {
                $columnName = $field->name . 'id';
            } else {
                $columnName = $field->name;
            }
            $columnNames[] = $columnName;
        }
        
        $gatewayName = $options->jointablemodel . 'TableGateway';
        
        $gateway = $this->serviceLocator->get($gatewayName);
        
        $rowset = $gateway->select(
            function (Select $select) use ($columnNames) {
                $select->where(
                    $this->parentModel->getPrimaryKey()
                )
                ->columns(
                    $columnNames
                );
            }
        );
        
        $results = $rowset->toArray();
        
        $allRowValues = [];
        
        foreach ($results as $row) {
            $thisRowValues = [];
            foreach ($row as $value) {
                $thisRowValues[] = $value;
            }
            $allRowValues[] = $thisRowValues;
        }
        
        $options->rowValues = $allRowValues;
        $elementValue = json_encode($options);
        
        $this->element->setValue($elementValue);
        
        return $this->element;
    }
}

