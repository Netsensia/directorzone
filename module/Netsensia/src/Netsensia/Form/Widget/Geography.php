<?php
namespace Netsensia\Form\Widget;

use Zend\Db\Sql\Select;

class Geography extends Widget
{
    public function getPopulatedElement()
    {
        $elementValue = $this->element->getValue();
        
        $options = json_decode($elementValue);
        
        $gatewayName = $options->jointablemodel . 'TableGateway';
        
        $gateway = $this->serviceLocator->get($gatewayName);
        
        $rowset = $gateway->select(
            function (Select $select) {
                $select->where(
                    $this->parentModel->getPrimaryKey()
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

