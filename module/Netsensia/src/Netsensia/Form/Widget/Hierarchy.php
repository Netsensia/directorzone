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
        
        $options->value = $results[0]['articlecategoryid'];
                        
        $this->element->setValue(json_encode($options));

    }
}

