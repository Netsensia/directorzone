<?php
namespace Netsensia\Form\Widget;

use Zend\Db\Sql\Select;

class Hierarchy extends Widget
{
    public function getPopulatedElement()
    {
        $options = json_decode($this->element->getValue());
        
        $gatewayName = $this->parentModel->getTableName() . 'TableGateway';
        
        $gateway = $this->serviceLocator->get($gatewayName);
        
        $rowset = $gateway->select(
            function (Select $select) {
                $select->where(
                    $this->parentModel->getPrimaryKey()
                );
            }
        );
        
        $results = $rowset->toArray();
        
        if (is_array($results) && count($results) != 0) {
            $options->value = $results[0][$options->name . 'id'];
        }
                        
        $this->element->setValue(json_encode($options));

    }
}

