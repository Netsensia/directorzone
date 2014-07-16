<?php
namespace Netsensia\Form\Widget;

use Zend\Db\Sql\Select;

class Geography extends Widget
{
    const STATE_ALL = 0;
    const STATE_SOME = 1;
    const STATE_NONE = 2;
    const STATE_DISABLED = 3;
    
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
        
        $continents = [];
        
        $geographyTable = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $geographyTable->select(['level' => 1])->toArray();
        
        foreach ($rows as $row) {
            $continents[] = [
                'id' => $row['geographyid'],
                'name' => $row['geography'],
                'state' => self::STATE_ALL,
                'expanded' => false, // will force a plus icon even though no children yet
            ];
        }
        
        $options->tree = [
            'items' =>
                [
                    [
                       'id' => 0,
                       'name' => 'Global',
                       'state' => self::STATE_ALL,
                       'expanded' => true,
                       'items' => $continents,
                    ],
                ],
        ];
        
        $elementValue = json_encode($options);
        
        $this->element->setValue($elementValue);
                
        return $this->element;
    }
}

