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
            $allRowValues[] = [
                'value' => $row['geographyid'],
                'parents' => $this->getParents($row['geographyid'])
            ];
        }
        
        $options->rowValues = $allRowValues;
        
        $continents = [];
        
        $geographyTable = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $geographyTable->select(['level' => 1])->toArray();
        
        $numSelected = count($allRowValues);
        if ($numSelected == 0) {
            $globalState = self::STATE_ALL;
        } else {
            $globalState = self::STATE_SOME;
        }
        
        foreach ($rows as $row) {
            $continents[] = [
                'geographyid' => $row['geographyid'],
                'name' => $row['geography'],
                'state' => self::STATE_ALL,
                'loaded' => false,
                'haschildren' => true,
                'expanded' => false, // will force a plus icon even though no children yet
            ];
        }
        
        $options->tree = [
            'items' =>
                [
                    [
                       'geographyid' => 0,
                       'name' => 'Global',
                       'state' => $globalState,
                       'expanded' => true,
                       'haschildren' => true,
                       'loaded' => true,
                       'items' => $continents,
                    ],
                ],
        ];
        
        $elementValue = json_encode($options);
        
        $this->element->setValue($elementValue);
                
        return $this->element;
    }
    
    private function getParents($geographyId)
    {
        $parents = [];
        $gateway = $this->serviceLocator->get('GeographyTableGateway');
        
        $rows = $gateway->select(['geographyid' => $geographyId])->toArray();
        $row = $rows[0];
        $level = $row['level'];
        
        while ($level > 0) {
            $level --;
            $parents[$level] = $row['parentid'];
            
            if ($level > 0) {
                $rows = $gateway->select(['geographyid' => $row['parentid']])->toArray();
                $row = $rows[0];
            }

        }
        
        var_dump($parents); die;
        return $parents;
    }
}

